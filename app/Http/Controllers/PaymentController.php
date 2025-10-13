<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use App\Services\EnrollmentService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PaymentController extends Controller
{
    public function __construct(
        private PaymentService $paymentService,
        private EnrollmentService $enrollmentService,
        private NotificationService $notificationService
    ) {}

    public function callback(Request $request)
    {
        $transactionId = $request->get('id');
        $formationId = $request->get('formation_id');
        $user = auth()->user();

        if (!$this->isValidRequest($transactionId, $formationId)) {
            return back()->with('error', 'Données de paiement manquantes.');
        }

        try {
            // 1. Récupération transaction via VOTRE PaymentService
            $transaction = $this->getTransaction($transactionId);

            // 2. Validation statut
            if (!$this->isPaymentApproved($transaction)) {
                return back()->with('error', 'Votre paiement n\'a pas été validé.');
            }

            // 3. Traitement inscription
            $result = $this->enrollmentService->processEnrollment(
                $transaction, 
                $formationId, 
                $user->id
            );

            // 4. Notification
            $this->notificationService->sendPaymentConfirmation($user, $result['formation']);

            return redirect()->route('trainings.paid')
                ->with('success', 'Félicitations ! Votre inscription a été confirmée.');

        } catch (\Exception $e) {
            return $this->handleApplicationError($e);
        }
    }

    private function isValidRequest(?string $transactionId, ?int $formationId): bool
    {
        return !empty($transactionId) && !empty($formationId);
    }

    private function getTransaction(string $transactionId)
    {
        return Cache::remember(
            "fedapay_transaction_{$transactionId}",
            300,
            fn() => $this->paymentService->getTransaction($transactionId)
        );
    }

    private function isPaymentApproved($transaction): bool
    {
        return $transaction->status === 'approved';
    }

    private function handleApplicationError(\Exception $e)
    {
        return match ($e->getMessage()) {
            'USER_ALREADY_ENROLLED' => redirect()->route('espace.etudiant')
                ->with('info', 'Vous êtes déjà inscrit à cette formation'),
                
            'TRANSACTION_ALREADY_PROCESSED' => redirect()->route('espace.etudiant')
                ->with('info', 'Ce paiement a déjà été traité'),
                
            default => back()->with('error', 'Une erreur technique est survenue.')
        };
    }
}