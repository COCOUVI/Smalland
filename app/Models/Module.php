<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    // Un module appartient à une formation
    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }
}
