<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Paiement;
use App\Models\user_formation;
use App\Services\PaymentService;
use FedaPay\FedaPay;
use FedaPay\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    //
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }





    public function callback(Request $request)
    {
        $transactionId = $request->get('id');
        $formationId = $request->get('formation_id');

        // Log les erreurs côté serveur pour le debug
        if (!$transactionId || !$formationId) {
            Log::warning('Callback paiement: données manquantes', [
                'transaction_id' => $transactionId,
                'formation_id' => $formationId,
                'user_id' => auth()->id(),
                'ip' => $request->ip()
            ]);

            // Message générique pour l'utilisateur
            return back()->with('error', 'Une erreur est survenue lors du traitement de votre paiement. Veuillez contacter le support.');
        }

        try {
            $transaction = $this->paymentService->getTransaction($transactionId);

            if ($transaction->status !== 'approved') {
                Log::info('Paiement non approuvé', [
                    'transaction_id' => $transactionId,
                    'status' => $transaction->status,
                    'user_id' => auth()->id()
                ]);

                // Message clair et utile pour l'utilisateur
                return back()->with('error', 'Votre paiement n\'a pas été validé. Aucun montant n\'a été débité.');
            }

            $userId = auth()->id();
            $formation = Formation::findOrFail($formationId);

            $existingUserFormation = user_formation::where('user_id', $userId)
                ->where('formation_id', $formationId)
                ->first();

            if ($existingUserFormation) {
                return redirect()->route('espace.etudiant')
                    ->with('info', 'Vous êtes déjà inscrit à cette formation');
            }

            DB::beginTransaction();

            try {
                Paiement::create([
                    'montant_payé' => $transaction->amount,
                    'moyen_de_paiment' => $transaction->mode ?? 'fedapay',
                    'status' => 'success',
                    'user_id' => $userId,
                    'formation_id' => $formationId,
                    'transaction_id' => $transaction->id
                ]);

                user_formation::create([
                    'user_id' => $userId,
                    'formation_id' => $formationId,
                    'progression' => 0,
                    'path_attestation' => null,
                ]);

                DB::commit();

                return redirect()->route('espace.etudiant')
                    ->with('success', 'Félicitations ! Votre inscription a été confirmée.');
            } catch (\Exception $e) {
                DB::rollBack();

                Log::error('Erreur insertion paiement/formation', [
                    'error' => $e->getMessage(),
                    'transaction_id' => $transactionId,
                    'user_id' => $userId
                ]);

                // Message générique
                return back()->with('error', 'Une erreur technique est survenue. Votre paiement sera vérifié par notre équipe.');
            }
        } catch (\Exception $e) {
            Log::error('Erreur récupération transaction FedaPay', [
                'error' => $e->getMessage(),
                'transaction_id' => $transactionId,
                'user_id' => auth()->id()
            ]);

            return back()->with('error', 'Impossible de vérifier votre paiement. Veuillez contacter le support si le problème persiste.');
        }
    }
  
}
