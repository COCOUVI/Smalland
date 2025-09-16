<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    // Une formation a plusieurs modules
    public function modules()
    {
        return $this->hasMany(Module::class);
    }
}
