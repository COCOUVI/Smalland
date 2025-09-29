<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Paiement;
use DragonCode\Contracts\Cashier\Config\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    //
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function initier(Formation $formation)
    {
        $user = auth()->user();

        // Crée le paiement en BDD avant d'afficher le widget KKiaPay
        $paiement = $this->paymentService->createPaiement(
            $user->id,
            $formation->id,
            $formation->price, // ou le montant que tu veux
            'momo' // méthode de paiement
        );

        // Passe les infos nécessaires au widget
        return view('layouts.formation.paiement', [
            'formation' => $formation,
            'publicKey' => env('KKIAPAY_PUBLIC_KEY'),
            'callbackUrl' => env('KKIAPAY_CALLBACK_URL'),
            'paiement' => $paiement, // transaction_id ou id du paiement
        ]);
    }


    public function callback(Request $request)
    {
        // On récupère le paiement via l'id passé dans data
        $paiementId = $request->input('paiement_id') ?? $request->query('paiement_id');

        if (!$paiementId) {
            return response()->json(['error' => 'Paiement ID manquant'], 400);
        }

        DB::transaction(function () use ($paiementId) {
            $paiement = Paiement::where('id', $paiementId)->lockForUpdate()->first();

            if (!$paiement) {
                return;
            }

            $data = $this->paymentService->verifyTransaction($paiement->transaction_id);

            $paiement->status = $data['status'] === 'success' ? 'success' : 'failed';
            $paiement->save();

            if ($paiement->status === 'success') {
                DB::table('user_formations')->updateOrInsert(
                    [
                        'user_id' => $paiement->user_id,
                        'formation_id' => $paiement->formation_id,
                    ],
                    [
                        'progression' => 0,
                        'path_attestation' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        });

        return response()->json(['status' => 'ok'], 200);
    }
}
