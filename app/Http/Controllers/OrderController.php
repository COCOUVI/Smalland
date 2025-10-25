<?php


namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Afficher la page de checkout
     */
    public function create()
    {
        $cart = Cart::where('user_id', Auth::id())->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $total = $cart->items->sum(fn($item) => $item->product->price * $item->qte);

        return view('checkout.create', compact('cart', 'total'));
    }

    /**
     * Enregistrer la commande
     */
    public function store(Request $request)
    {
        $request->validate([
            'mode_livraison' => 'required',
            'addresse' => 'required|string',
            'telephone' => 'required|string',
        ]);

        DB::transaction(function () use ($request) {
            $cart = Cart::where('user_id', Auth::id())->with('items.product')->first();

            $total = $cart->items->sum(fn($item) => $item->product->price * $item->qte);

            $order = Order::create([
                'user_id' => Auth::id(),
                'mode_livraison' => $request->mode_livraison,
                'addresse' => $request->addresse,
                'telephone' => $request->telephone,
                'status' => 'En attente',
                'price_total_order' => $total,
            ]);

            foreach ($cart->items as $item) {
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'qte_commander' => $item->qte,
                ]);
            }

            $cart->items()->delete(); // vider le panier après commande
        });

        return redirect()->route('orders.index')->with('success', 'Commande passée avec succès !');
    }

    /**
     * Liste des commandes de l'utilisateur
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * Détails d'une commande
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order); // facultatif : sécurité
        $order->load('products');
        return view('orders.show', compact('order'));
    }
}
