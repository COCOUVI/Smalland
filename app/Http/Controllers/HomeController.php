<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\user_formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    public function index()
    {

        $formations =  Formation::latest()->take(3)->get();
        return view('layouts.index', compact('formations'));
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

        return view('layouts.formation.formation-detail', compact('formation', 'publicKey', 'user', 'isEnrolled'));
    }
}
