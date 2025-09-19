<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reponse extends Model
{
    use HasFactory;

    protected $table = 'reponses';
    protected $fillable = ['content', 'is_correct', 'question_id'];

    // Une réponse appartient à une question
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}

