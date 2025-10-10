<?php

namespace App\Http\Controllers;

use App\Models\Commande;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::with('user')
            ->orderByDesc('date_commande')
            ->paginate(10); // Choose the number of items per page
        return view('admin.layout.boutique.list_commandes', compact('commandes'));
    }

}
