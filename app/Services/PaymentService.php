<?php

namespace App\Services;

use App\Models\Paiement;
use FedaPay\FedaPay;
use FedaPay\Transaction;
use Illuminate\Support\Str;

class PaymentService
{
    public function __construct()
    {
        FedaPay::setApiKey(config('fedapay.secret_key'));

        FedaPay::setEnvironment(config('fedapay.environment'));
    }

    public function createTransaction($user, $formation)
    {
        return Transaction::create([
            "description"  => "Paiement de la formation " . $formation->titre,
            "amount"       => $formation->price,
            "currency"     => ["iso" => "XOF"],
            "callback_url" => route('paiement.callback'),
            "customer"     => [
                "firstname"    => $user->nom,
                "lastname"     => $user->prenom,
                "email"        => $user->email
            ]
        ]);
    }

    public function getTransaction($transactionId)
    {
        return Transaction::retrieve($transactionId, [
            'expand' => ['currency', 'customer']
        ]);
    }



    public function createFrontendTransaction($user, $formation)
    {
        // Création de la transaction FedaPay
        $transaction = Transaction::create([
            "description"  => "Paiement de la formation " . $formation->titre,
            "amount"       => $formation->price,
            "currency"     => ["iso" => "XOF"],
            "callback_url" => route('paiement.callback'),
            "customer"     => [
                "firstname"    => $user->nom,
                "lastname"     => $user->prenom,
                "email"        => $user->email,
                "phone_number" => $user->telephone,
            ]
        ]);

        return $transaction;
    }
}
