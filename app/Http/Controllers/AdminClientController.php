<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminClientController extends Controller
{
    /**
     * Liste de tous les clients
     */
    public function index(Request $request)
    {
        $query = User::withCount(['orders', 'paiements']);

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->where('prenom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%");
            });
        }

        // Filtre par activité
        if ($request->filled('filter')) {
            switch ($request->filter) {
                case 'active':
                    $query->has('orders');
                    break;
                case 'inactive':
                    $query->doesntHave('orders');
                    break;
            }
        }

        // Tri
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        
        if ($sortBy === 'orders_count') {
            $query->orderBy('orders_count', $sortOrder);
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $clients = $query->paginate(20);

        // Statistiques
        $stats = [
            'total' => User::count(),
            'with_orders' => User::has('orders')->count(),
            'without_orders' => User::doesntHave('orders')->count(),
            'this_month' => User::whereMonth('created_at', date('m'))
                               ->whereYear('created_at', date('Y'))
                               ->count(),
        ];

        return view('admin.layout.boutique.clients.index', compact('clients', 'stats'));
    }

    /**
     * Détails d'un client
     */
    public function show($id)
    {
        $client = User::with([
            'orders' => function($query) {
                $query->with('products')->latest();
            },
            'paiements' => function($query) {
                $query->latest();
            }
        ])->findOrFail($id);

        // Statistiques du client
        $clientStats = [
            'total_commandes' => $client->orders->count(),
            'montant_total' => $client->orders->sum('price_total_order'),
            'commande_moyenne' => $client->orders->count() > 0 
                ? $client->orders->avg('price_total_order') 
                : 0,
            'derniere_commande' => $client->orders->first()?->created_at,
        ];

        return view('admin.layout.boutique.clients.show', compact('client', 'clientStats'));
    }

    /**
     * Exporter la liste des clients
     */
    public function export()
    {
        $clients = User::withCount('orders')->get();

        $filename = 'clients_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function() use ($clients) {
            $file = fopen('php://output', 'w');
            
            // En-têtes
            fputcsv($file, [
                'ID',
                'Nom',
                'Prenom',
                'Email',
                'Téléphone',
                'Nombre de commandes',
                'Date d\'inscription'
            ]);

            foreach ($clients as $client) {
                fputcsv($file, [
                    $client->id,
                    $client->nom,
                    $client->prenom,
                    $client->email,
                    $client->telephone ?? 'N/A',
                    $client->orders_count,
                    $client->created_at->format('d/m/Y')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}