<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;
use App\Models\Product;
use App\Models\Formation;
use App\Models\user_formation;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
   

    public function index()
    {
        $latestPublications = Publication::with('category')
            ->where('status', 'publish')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

            $produitsPopulaires = Product::where('qte', '>', 0)
            ->orderBy('prix', 'desc')
            ->limit(4)
            ->get();
        $formations =  Formation::latest()->take(3)->get();

        return view('layouts.index', compact('latestPublications', 'produitsPopulaires','formations'));
    }
  
    public function showFormations()
    {

        $formations = Formation::paginate(9);
        return view('layouts.formation.formation-catalog', compact('formations'));
    }
    public function ShowOneFormation(Formation $formation)
    {
        $formation->load([
            'modules.lessons',   // Modules + leurs leçons
            'avis',              // Avis (pour note moyenne + total avis)
            'users'              // Utilisateurs inscrits
        ]);

        // Clé publique pour FedaPay
        $user = Auth::user();
        $publicKey = config('fedapay.public_key');

        // Vérifier si l'utilisateur est déjà inscrit à cette formation
        $isEnrolled = false;
        if ($user) {
            $isEnrolled = user_formation::where('user_id', $user->id)
                ->where('formation_id', $formation->id)
                ->exists();
        }

        // ✅ Récupérer les 6 derniers avis avec les infos de l'utilisateur
        $avisRecents = $formation->avis()
            ->with('user')
            ->latest()
            ->take(6)
            ->get();

        return view('layouts.formation.formation-detail', compact(
            'formation',
            'publicKey',
            'user',
            'isEnrolled',
            'avisRecents' // 👉 On envoie les avis récents à la vue
        ));
    }
    public function AfficherTousLesAvis(Formation $formation)
    {
        $formation->load('avis.user');

        // ✅ Pagination (10 avis par page)
        $avis = $formation->avis()
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('formationS.avis', compact('formation', 'avis'));
    }
  
}




