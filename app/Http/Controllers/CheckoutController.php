<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\PaymentService;

class CheckoutController extends Controller
{
    public function __construct(private PaymentService $paymentService)
    {
    }
    /**
     * Afficher la page de checkout
     */
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        // Vérifier la disponibilité de tous les produits
        foreach ($cart->items as $item) {
            if (!$item->product->isInStock($item->qte)) {
                return redirect()->route('cart.index')
                    ->with('error', "Le produit '{$item->product->nom}' n'a plus assez de stock.");
            }
        }

        $subtotal = $cart->total_price;
        $shippingFee = $this->calculateShipping($subtotal);
        $total = $subtotal + $shippingFee;

        return view('layouts.boutique.checkout.index', compact('cart', 'subtotal', 'shippingFee', 'total'));
    }

    /**
     * Traiter la commande
     */
    public function process(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:500',
            'telephone' => 'required|string|max:20',
            'mode_livraison' => 'required|in:standard,express,retrait'
        ]);

        $cart = Cart::where('user_id', Auth::id())->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        // Vérifier à nouveau le stock avant de créer la commande
        foreach ($cart->items as $item) {
            if (!$item->product->isInStock($item->qte)) {
                return back()->with('error', "Le produit '{$item->product->nom}' n'est plus disponible en quantité suffisante.");
            }
        }

        try {
            DB::beginTransaction();

            // Calculer le total avec frais de livraison
            $subtotal = $cart->total_price;
            $shippingFee = $this->calculateShipping($subtotal, $request->mode_livraison);
            $totalOrder = $subtotal + $shippingFee;

            // Créer la commande
            $order = Order::create([
                'user_id' => Auth::id(),
                'mode_livraison' => $request->mode_livraison,
                'status' => 'pending',
                'addresse' => $request->addresse,
                'telephone' => $request->telephone,
                'price_total_order' => $totalOrder,
                'paiement_id' => null // À implémenter selon votre système de paiement
            ]);

            // Ajouter les produits à la commande et réduire le stock
            foreach ($cart->items as $item) {
                // Créer l'entrée order_product
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'qte_commander' => $item->qte
                ]);

                // Réduire le stock
                $item->product->decrementStock($item->qte);
            }

            // Vider le panier
            $cart->clear();

            DB::commit();

            // Initier le paiement FedaPay
            return $this->initiatePayment($order);
            
            // OU si paiement à la livraison :
            // return redirect()->route('checkout.success', $order->id)
            //     ->with('success', 'Commande passée avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Afficher l'erreur complète pour déboguer
            return back()->with('error', 'Erreur lors de la création de la commande : ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Page de confirmation après commande
     */
    public function success($orderId)
    {
        $order = Order::with('products')->findOrFail($orderId);

        // Vérifier que la commande appartient à l'utilisateur connecté
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        return view('checkout.success', compact('order'));
    }

    /**
     * Calculer les frais de livraison
     */
    private function calculateShipping($subtotal, $mode = 'standard')
    {
        // Livraison gratuite au-dessus de 50 000 FCFA
        if ($subtotal >= 50000) {
            return 0;
        }

        // Frais selon le mode de livraison
        switch ($mode) {
            case 'express':
                return 3000; // Livraison express
            case 'retrait':
                return 0; // Retrait en magasin gratuit
            case 'standard':
            default:
                return 1500; // Livraison standard
        }
    }

    /**
     * API pour obtenir les frais de livraison en temps réel
     */
    public function getShippingFee(Request $request)
    {
        $request->validate([
            'mode_livraison' => 'required|in:standard,express,retrait',
            'subtotal' => 'required|numeric|min:0'
        ]);

        $shippingFee = $this->calculateShipping($request->subtotal, $request->mode_livraison);
        $total = $request->subtotal + $shippingFee;

        return response()->json([
            'shipping_fee' => $shippingFee,
            'total' => $total
        ]);
    }
}