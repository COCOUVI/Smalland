<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    //
    protected $fillable = [
        'user_id',
        'formation_id',
        'montant_payé',
        'moyen_de_paiment',
        'status',
        'transaction_id'
    ];
}
