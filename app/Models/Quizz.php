<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quizz extends Model
{
    use HasFactory;

    protected $table = 'quizzs';
    protected $fillable = ['titre', 'module_id'];

    // Un quizz appartient à un module
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    // Un quizz a plusieurs questions
    public function questions()
    {
        return $this->hasMany(Question::class, 'quizz_id');
    }

        public function users()
    {
        return $this->belongsToMany(User::class, 'user__quizzs')
                    ->withPivot('score')
                    ->withTimestamps();
    }
}
