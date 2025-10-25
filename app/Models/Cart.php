<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['total_price', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'cart_items')->withPivot('qte');
    }

    // Calculer le total du panier
    public function calculateTotal()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->product->prix * $item->qte;
        }
        $this->total_price = $total;
        $this->save();
        return $total;
    }

    // Vider le panier
    public function clear()
    {
        $this->items()->delete();
        $this->total_price = 0;
        $this->save();
    }

    // Compter les articles
    public function totalItems()
    {
        return $this->items->sum('qte');
    }
}
