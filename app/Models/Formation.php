<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    protected $fillable = ['titre', 'description', 'prix', 'duree']; 
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
}
