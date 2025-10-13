<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';
    protected $fillable = ['content', 'quizz_id'];

    // Une question appartient à un quizz
    public function quizz()
    {
        return $this->belongsTo(Quizz::class, 'quizz_id');
    }

    // Une question a plusieurs réponses
    public function reponses()
    {
        return $this->hasMany(Reponse::class, 'question_id');
    }
}

