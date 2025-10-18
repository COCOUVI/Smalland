<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    protected $fillable = ['titre', 'description', 'prix', 'duree',   'niveau',
        'price',
        'image_path'];

            protected $casts = [
        'price' => 'integer',
    ];

    // Une formation a plusieurs modules
    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    // Une formation a plusieurs objectifs
    public function objectifs()
    {
        return $this->hasMany(Objectif::class);
    }

    // Accesseur pour la durée totale
    public function getTotalDurationAttribute()
    {
        // somme de toutes les durées des leçons (en secondes)
        $totalSeconds = $this->modules->flatMap->lessons->sum('duree');

        // convertir en heures, minutes, secondes
        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);

        // format simple style Udemy
        if ($hours > 0) {
            return $hours . 'h ' . $minutes . 'm';
        } else {
            return $minutes . 'm';
        }
    }
    public function avis()
    {
        return $this->hasMany(Avis::class);
    }

        public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }
    
    public function averageRating()
    {
        return $this->avis()->avg('note'); // moyenne des notes
    }

    public function totalAvis()
    {
        return $this->avis()->count(); // nombre d'avis
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_formations')
              ->withPivot('progression') 
            ->withTimestamps();
    }

    public function totalInscriptions()
    {
        return $this->users()->count();
    }

    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, Module::class);
    }

    // Nombre total de leçons
    public function getTotalLessonsAttribute()
    {
        return $this->lessons()->count();
    }

    // Dans le modèle Formation
}
