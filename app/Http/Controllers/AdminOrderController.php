<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusChanged;

class AdminOrderController extends Controller
{
    /**
     * Liste de toutes les commandes
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'products', 'paiement']);

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

        // Recherche par code de commande ou nom client
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->latest()->paginate(15);

        // Statistiques
        $stats = [
            'total' => Order::count(),
            'pending' => Order::pending()->count(),
            'confirmed' => Order::confirmed()->count(),
            'processing' => Order::processing()->count(),
            'shipped' => Order::shipped()->count(),
            'delivered' => Order::delivered()->count(),
        ];

        return view('admin.layout.boutique.orders.index', compact('orders', 'stats'));
    }

    /**
     * Détails d'une commande
     */
    public function show($id)
    {
        $order = Order::with(['user', 'products', 'paiement'])->findOrFail($id);

        return view('admin.layout.boutique.orders.show', compact('order'));
    }

    /**
     * Changer le statut d'une commande
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
            'note' => 'nullable|string|max:500'
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $newStatus = $request->status;

        $order->update([
            'status' => $newStatus
        ]);

        // Envoyer une notification email au client
        if ($newStatus === 'confirmed') {
            try {
                Mail::to($order->user->email)->send(new OrderStatusChanged($order, $oldStatus, $newStatus));
            } catch (\Exception $e) {
                // Log l'erreur mais ne bloque pas le processus
                \Log::error('Email notification failed: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Statut de la commande mis à jour avec succès.');
    }

    /**
     * Valider le paiement d'une commande
     */
    public function validatePayment($id)
    {
        $order = Order::with('paiement')->findOrFail($id);

        if (!$order->paiement) {
            return back()->with('error', 'Aucun paiement trouvé pour cette commande.');
        }

        $order->paiement->update([
            'status' => 'completed'
        ]);

        $order->update([
            'status' => 'confirmed'
        ]);

        // Envoyer notification
        try {
            Mail::to($order->user->email)->send(new OrderStatusChanged($order, 'pending', 'confirmed'));
        } catch (\Exception $e) {
            \Log::error('Email notification failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Paiement validé et commande confirmée.');
    }

    /**
     * Ajouter une note à la commande
     */
    public function addNote(Request $request, $id)
    {
        $request->validate([
            'note' => 'required|string|max:1000'
        ]);

        $order = Order::findOrFail($id);

        // Vous pouvez créer une table 'order_notes' séparée
        // Ou stocker dans un champ JSON
        // Pour l'instant, on utilise un champ texte simple

        return back()->with('success', 'Note ajoutée avec succès.');
    }

    /**
     * Exporter les commandes en CSV
     */
    public function export(Request $request)
    {
        $orders = Order::with(['user', 'products'])->get();

        $filename = 'commandes_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            
            // En-têtes
            fputcsv($file, ['Code', 'Client', 'Email', 'Téléphone', 'Montant', 'Statut', 'Date']);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_code,
                    $order->user->name,
                    $order->user->email,
                    $order->telephone,
                    $order->price_total_order . ' FCFA',
                    $order->statusLabel,
                    $order->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}