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
     * Liste des commandes de l'utilisateur connecté
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
                    ->with('products')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('layouts.boutique.orders.index', compact('orders'));
    }

    /**
     * Afficher les détails d'une commande
     */
    public function show($orderId)
    {
        $order = Order::with('products', 'paiement')->findOrFail($orderId);

        // Vérifier que la commande appartient à l'utilisateur
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé à cette commande.');
        }

        return view('layouts.boutique.orders.show', compact('order'));
    }

    /**
     * Annuler une commande (seulement si statut = pending ou confirmed)
     */
    public function cancel($orderId)
    {
        $order = Order::with('products')->findOrFail($orderId);

        // Vérifier que la commande appartient à l'utilisateur
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        // On ne peut annuler que les commandes en attente ou confirmées
        if (!$order->canBeCancelled()) {
            return back()->with('error', 'Cette commande ne peut plus être annulée (statut actuel : ' . $order->statusLabel . ')');
        }

        DB::transaction(function () use ($order) {
            // Remettre les produits en stock
            foreach ($order->products as $product) {
                $quantity = $product->pivot->qte_commander;
                $product->incrementStock($quantity);
            }

            // Mettre à jour le statut
            $order->update(['status' => 'cancelled']);
        });

        return back()->with('success', 'Commande annulée avec succès. Les produits ont été remis en stock.');
    }

    /**
     * Suivi de commande publique (accessible même sans connexion)
     */
    public function track(Request $request)
    {
        $order = null;
        
        if ($request->filled('order_code')) {
            $order = Order::where('order_code', $request->order_code)
                ->with(['products', 'user', 'paiement'])
                ->first();
                
            // Si l'utilisateur est connecté, vérifier que c'est bien sa commande
            // Sinon on peut afficher uniquement des infos limitées
            if ($order && Auth::check() && $order->user_id !== Auth::id()) {
                $order = null; // Ne pas afficher la commande d'un autre utilisateur
            }
        }
        
        return view('layouts.boutique.order-tracking', compact('order'));
    }

    /**
     * Télécharger la facture (optionnel - nécessite DomPDF)
     */
    public function downloadInvoice($orderId)
    {
        $order = Order::with('products', 'user', 'paiement')->findOrFail($orderId);

        // Vérifier que la commande appartient à l'utilisateur
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        // Pour l'instant, on retourne juste une vue
        // Plus tard, tu peux utiliser DomPDF pour générer un PDF
        return view('orders.invoice', compact('order'));
    }

    /**
     * Recherche de commande (pour l'utilisateur connecté)
     */
    public function search(Request $request)
    {
        $query = Order::where('user_id', Auth::id())->with('products');

        // Recherche par code de commande
        if ($request->filled('search')) {
            $query->where('order_code', 'like', '%' . $request->search . '%');
        }

        // Filtre par statut
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtre par date
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(10);

        return view('layouts.boutique.orders.index', compact('orders'));
    }
}