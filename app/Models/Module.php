<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model

{
    protected $fillable = ['titre', 'formation_id'];

    // Un module appartient à une formation
    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }


    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    /**
     * Obtenir le nombre de leçons du module
     */
    public function getLessonsCountAttribute()
    {
        return $this->lessons()->count();
    }
}
