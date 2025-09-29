<?php

namespace App\Services;

use Kkiapay\Kkiapay;
use App\Models\Paiement;
use Illuminate\Support\Str;

class PaymentService
{
    protected $kkiapay;

    public function __construct()
    {
        $this->kkiapay = new Kkiapay(
            env('KKIAPAY_PUBLIC_KEY'),
            env('KKIAPAY_PRIVATE_KEY'),
            env('KKIAPAY_SECRET'),
            env('KKIAPAY_SANDBOX', true)
            
        );
    }

    public function verifyTransaction($transactionId)
    {
        return $this->kkiapay->verifyTransaction($transactionId);
    }

    public function createPaiement($userId, $formationId, $amount, $method = null)
    {
        return Paiement::create([
            'user_id' => $userId,
            'formation_id' => $formationId,
            'montant_payé' => $amount,
            'moyen_de_paiment' => $method,
            'status' => 'pending',
            'transaction_id' => Str::uuid(), 
        ]);
    }
}
