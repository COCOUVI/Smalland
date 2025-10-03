<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class user_formation extends Model
{
    //
     protected $fillable = [
        'user_id',
        'formation_id',
        'progression',
        'path_attestation'
    ];
    
}
