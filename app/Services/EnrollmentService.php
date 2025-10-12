<?php

namespace App\Services;

use App\Models\Formation;
use App\Models\Paiement;
use App\Models\user_formation;
use App\Models\UserFormation;
use Illuminate\Support\Facades\DB;

class EnrollmentService
{
    public function processEnrollment($transaction, $formationId, $userId)
    {
        return DB::transaction(function () use ($transaction, $formationId, $userId) {
            $formation = Formation::findOrFail($formationId);

            $this->validateEnrollment($userId, $formationId);
            $this->validateTransaction($transaction->id);
            
            $paiement = $this->createPaymentRecord($transaction, $userId, $formationId);
            $userFormation = $this->createEnrollment($userId, $formationId);

            return [
                'paiement' => $paiement,
                'formation' => $formation,
                'user_formation' => $userFormation
            ];
        });
    }

    private function validateEnrollment($userId, $formationId): void
    {
        if (user_formation::where('user_id', $userId)
            ->where('formation_id', $formationId)
            ->lockForUpdate()
            ->exists()) {
            throw new \Exception('USER_ALREADY_ENROLLED');
        }
    }

    private function validateTransaction($transactionId): void
    {
        if (Paiement::where('transaction_id', $transactionId)
            ->lockForUpdate()
            ->exists()) {
            throw new \Exception('TRANSACTION_ALREADY_PROCESSED');
        }
    }

    private function createPaymentRecord($transaction, $userId, $formationId): Paiement
    {
        return Paiement::create([
            'montant_payé' => $transaction->amount,
            'moyen_de_paiment' => $transaction->mode ?? 'fedapay',
            'status' => 'success',
            'user_id' => $userId,
            'formation_id' => $formationId,
            'transaction_id' => $transaction->id
        ]);
    }

    private function createEnrollment($userId, $formationId): user_formation
    {
        return user_formation::create([
            'user_id' => $userId,
            'formation_id' => $formationId,
            'progression' => 0,
            'path_attestation' => null,
        ]);
    }
}