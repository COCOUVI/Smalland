<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objectif extends Model
{

        use HasFactory;

    protected $fillable = [
        'content',
        'formation_id'
    ];

    //objectif a une seul formation
    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }
}
