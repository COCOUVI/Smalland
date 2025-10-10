<?php

namespace App\Http\Controllers;

use App\Models\Paiement;

class PaiementController extends Controller
{
    public function index()
    {
        $paiements = Paiement::with('user')->orderByDesc('id')->get();
        return view('admin.boutique.list_paiement', compact('paiements'));
    }
}
