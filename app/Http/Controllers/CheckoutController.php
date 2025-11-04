<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\PaymentService;
use GuzzleHttp\Client;


class CheckoutController extends Controller
{
    public function __construct(private PaymentService $paymentService) {}
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
            'mode_livraison' => 'required|in:standard,express,retrait',
            'id' => 'required|string' // transaction id
        ]);

        $cart = Cart::where('user_id', Auth::id())->with('items.product')->first();
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        foreach ($cart->items as $item) {
            if (!$item->product->isInStock($item->qte)) {
                return back()->with('error', "Le produit '{$item->product->nom}' n'est plus disponible.");
            }
        }

        try {
            DB::beginTransaction();

            $subtotal = $cart->total_price;
            $shippingFee = $this->calculateShipping($subtotal, $request->mode_livraison);
            $totalOrder = $subtotal + $shippingFee;

            // Création de la commande
            $order = Order::create([
                'user_id' => Auth::id(),
                'mode_livraison' => $request->mode_livraison,
                'status' => 'paid',
                'addresse' => $request->address,
                'telephone' => $request->telephone,
                'price_total_order' => $totalOrder,
            ]);

            // Produits de la commande
            foreach ($cart->items as $item) {
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'qte_commander' => $item->qte
                ]);
                $item->product->decrementStock($item->qte);
            }

            // ✅ Récupération de la transaction via PaymentService
            $transaction = $this->paymentService->getTransaction($request->id);

            // ✅ Enregistrement du paiement
            $paiement = Paiement::create([
                'montant_payé' => $transaction->amount,
                'moyen_de_paiment' => $transaction->mode ,
                'status' => $transaction->status=== 'approved' ? 'success':'failed',
                'user_id' => Auth::id(),
                'transaction_id'=>$request->id,
                'order_id' => $order->id, //success
            ]);

            // ✅ Mise à jour de la commande selon
            $order->status = $paiement->status === 'approved' ? 'paid' : 'pending';
            $order->save();

            // ✅ Vider le panier
            $cart->clear();

            DB::commit();

            return redirect()->route('checkout.success', $order->id)
                ->with('success', 'Commande et paiement enregistrés avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur : ' . $e->getMessage())->withInput();
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
