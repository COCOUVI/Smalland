<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    //



    public function index(Request $request)
    {
        if ($request->ajax()) {
            return view('space-etudiant.layout.dashboard-section');
        }

        return view('space-etudiant.layout.dashboard');
    }

public function ShowTranings(Request $request){


       $user = Auth::user();

    $formations = $user->formationsAchetees()
                       ->with('modules.lessons') // pour calcul durée ou leçons
                       ->paginate(6);

    // Si requête AJAX, on ne renvoie que le contenu de la section
    if ($request->ajax()) {
        return view('space-etudiant.layout.list-formation-section', compact('formations'));
    }

    // Sinon, page complète
    return view('space-etudiant.layout.list-formation-cours', compact('formations'));
    }

    
}
