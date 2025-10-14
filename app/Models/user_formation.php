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
        'path_attestation',
        'status'
    ];


    // Relation vers Formation
    public function formation()
    {
        return $this->belongsTo(Formation::class, 'formation_id');
    }

    // Relation vers User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
