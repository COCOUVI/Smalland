<?php

namespace App\Services;

use App\Mail\PaiementConfirmeMail;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    public function sendPaymentConfirmation($user, $formation)
    {
        // Méthode qui fonctionne avec terminating()
        app()->terminating(function () use ($user, $formation) {
            Mail::to("cocouvialexandro74@gmail.com")
                ->send(new PaiementConfirmeMail($user, $formation));
        });
    }
}