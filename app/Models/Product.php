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

    // Relations
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

    // ✅ AJOUTER CES MÉTHODES

    /**
     * Vérifier si le produit est en stock
     */
    public function isInStock($quantity = 1)
    {
        return $this->qte >= $quantity;
    }

    /**
     * Réduire le stock
     */
    public function decrementStock($quantity)
    {
        if ($this->isInStock($quantity)) {
            $this->decrement('qte', $quantity);
            $this->updateStockStatus();
            return true;
        }
        return false;
    }

    /**
     * Augmenter le stock (en cas d'annulation)
     */
    public function incrementStock($quantity)
    {
        $this->increment('qte', $quantity);
        $this->updateStockStatus();
    }

    /**
     * Mettre à jour le statut du stock automatiquement
     */
    public function updateStockStatus()
    {
        if ($this->qte == 0) {
            $this->status_stock = 'out_of_stock';
        } elseif ($this->qte <= 5) {
            $this->status_stock = 'low_stock';
        } else {
            $this->status_stock = 'in_stock';
        }
        $this->save();
    }
}