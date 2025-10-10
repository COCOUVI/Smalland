<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', 'description', 'prix', 'qte',
        'status_stock', 'path_img', 'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_items')->withPivot('qte');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products')->withPivot('qte_commander');
    }
}
