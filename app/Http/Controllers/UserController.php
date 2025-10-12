<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Paiement;
use App\Models\Product;
use App\Models\Quizz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();

        if ($user->role !== "admin") {
            return redirect()->route("accueil");
        }

        // 📊 Récupération dynamique des données
        $nbProduits = Product::count();
        $nbFormations = Formation::count();
        $nbQuiz = Quizz::count();
        $totalPaiements = Paiement::sum('montant_payé'); // Assure-toi que la colonne montant existe

        $cards = [
            [
                'title' => 'Produits',
                'value' => $nbProduits,
                'percent' => '+10%', // tu peux aussi le calculer dynamiquement si tu veux
                'percentColor' => 'col-green',
                'img' => 'assets/img/banner/shop.png',
            ],
            [
                'title' => 'Formations',
                'value' => $nbFormations,
                'percent' => '-5%',
                'percentColor' => 'col-orange',
                'img' => 'assets/img/banner/formations.png',
            ],
            [
                'title' => 'Quiz',
                'value' => $nbQuiz,
                'percent' => '+12%',
                'percentColor' => 'col-green',
                'img' => 'assets/img/banner/quizz.png',
            ],
            [
                'title' => 'Paiements',
                'value' => number_format($totalPaiements, 0, ',', ' ') . ' CFA',
                'percent' => '+42%',
                'percentColor' => 'col-green',
                'img' => 'assets/img/banner/paiements.png',
            ],
        ];

        return view('admin.layout.index', compact('cards'));
    }
}
