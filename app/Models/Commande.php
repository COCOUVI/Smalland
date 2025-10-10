<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mode_livraison',
        'date_commande',
        'statut',
        'address',
        'telephone_number',
        'price_total_order'
    ];

    /**
     * Relation : une commande appartient à un utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation : une commande contient plusieurs produits
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product')
                    ->withPivot('qte_commander')
                    ->withTimestamps();
    }

    /**
     * Relation : une commande peut avoir un paiement
     */
    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }
}
