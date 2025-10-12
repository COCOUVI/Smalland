<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    //
    protected $fillable = [
        'formation_id',
        'user_id',
        'note',
        'content'
    ];
    
     // Relation avec la formation
    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

     public function user()
    {
        return $this->belongsTo(User::class);
    }
}
