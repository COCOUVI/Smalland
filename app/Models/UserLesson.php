<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLesson extends Model
{
    //

    protected $fillable = ['user_id', 'lesson_id', 'terminee', 'terminee_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
