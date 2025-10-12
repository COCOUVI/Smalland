<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Objectif extends Model
{
    //objectif a une seul formation
    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }
}
