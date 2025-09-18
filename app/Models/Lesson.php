<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'video_url',
        'pdf_url',
        'module_id'
    ];

    /**
     * Relation avec Module
     * Une leçon appartient à un module
     */
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Accessor pour obtenir le nom du fichier vidéo
     */
    public function getVideoFilenameAttribute()
    {
        if ($this->video_url) {
            return basename($this->video_url);
        }
        return null;
    }

    /**
     * Accessor pour obtenir le nom du fichier PDF
     */
    public function getPdfFilenameAttribute()
    {
        if ($this->pdf_url) {
            return basename($this->pdf_url);
        }
        return null;
    }

    /**
     * Scope pour récupérer les leçons d'un module
     */
    public function scopeForModule($query, $moduleId)
    {
        return $query->where('module_id', $moduleId);
    }
}
