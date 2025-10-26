<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Afficher le panier de l'utilisateur
     */
    public function index()
    {
        $cart = $this->getOrCreateCart();
        $cartItems = $cart->items()->with('product')->get();
        $total = $cart->calculateTotal();

        return view('layouts.boutique.cart', compact('cart', 'cartItems', 'total'));
    }

    /**
     * Ajouter un produit au panier
     */
    public function add(Request $request, $productId)
    {
        $request->validate([
            'qte' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($productId);
        $quantity = $request->qte;

        // Vérifier le stock
        if (!$product->isInStock($quantity)) {
            return back()->with('error', 'Stock insuffisant pour ce produit.');
        }

        $cart = $this->getOrCreateCart();

        // Vérifier si le produit existe déjà dans le panier
        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('product_id', $productId)
                            ->first();

        if ($cartItem) {
            // Mettre à jour la quantité
            $newQte = $cartItem->qte + $quantity;
            
            if (!$product->isInStock($newQte)) {
                return back()->with('error', 'Stock insuffisant. Stock disponible: ' . $product->qte);
            }

            $cartItem->update(['qte' => $newQte]);
        } else {
            // Créer un nouvel article dans le panier
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'qte' => $quantity
            ]);
        }

        // Recalculer le total
        $cart->calculateTotal();

        return back()->with('success', 'Produit ajouté au panier avec succès !');
    }

    /**
     * Mettre à jour la quantité d'un article
     */
    public function update(Request $request, $cartItemId)
    {
        $request->validate([
            'qte' => 'required|integer|min:1'
        ]);

        $cartItem = CartItem::findOrFail($cartItemId);
        
        // Vérifier que cet article appartient bien au panier de l'utilisateur
        if ($cartItem->cart->user_id !== Auth::id()) {
            return back()->with('error', 'Action non autorisée.');
        }

        $product = $cartItem->product;
        $newQte = $request->qte;

        // Vérifier le stock
        if (!$product->isInStock($newQte)) {
            return back()->with('error', 'Stock insuffisant. Stock disponible: ' . $product->qte);
        }

        $cartItem->update(['qte' => $newQte]);
        $cartItem->cart->calculateTotal();

        return back()->with('success', 'Quantité mise à jour.');
    }

    /**
     * Supprimer un article du panier
     */
    public function remove($cartItemId)
    {
        $cartItem = CartItem::findOrFail($cartItemId);

        // Vérifier que cet article appartient bien au panier de l'utilisateur
        if ($cartItem->cart->user_id !== Auth::id()) {
            return back()->with('error', 'Action non autorisée.');
        }

        $cart = $cartItem->cart;
        $cartItem->delete();
        $cart->calculateTotal();

        return back()->with('success', 'Produit retiré du panier.');
    }

    /**
     * Vider complètement le panier
     */
    public function clear()
    {
        $cart = $this->getOrCreateCart();
        $cart->clear();

        return back()->with('success', 'Panier vidé avec succès.');
    }

    /**
     * Récupérer ou créer le panier de l'utilisateur connecté
     */
    private function getOrCreateCart()
    {
        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id()],
            ['total_price' => 0]
        );

        return $cart;
    }

    /**
     * Obtenir le nombre d'articles dans le panier (pour le header)
     */
    public function count()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        $count = $cart ? $cart->totalItems() : 0;

        return response()->json(['count' => $count]);
    }
}