<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'content',
        'image_path',
        'pub_category_id',
        'author',
        'tags',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(PubCategory::class, 'pub_category_id');
    }
}
