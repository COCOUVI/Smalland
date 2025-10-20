<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_Quizz extends Model
{
    // Autoriser l'affectation de masse pour ces champs
    protected $fillable = [
        'user_id',
        'quizz_id',
        'score',
        'termine',
        'reponses',
    ];

    // Relation avec l'utilisateur (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec le quiz (Quizz)
    public function quizz()
    {
        return $this->belongsTo(Quizz::class);
    }
}
