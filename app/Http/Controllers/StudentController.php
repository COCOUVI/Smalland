<?php

namespace App\Http\Controllers;

use App\Models\user_formation;
use App\Models\UserLesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    //



    public function index(Request $request)
    {
        $userId = Auth::user()->id;

        $formations = user_formation::where('user_id', $userId);

        $totalFormations = $formations->count();
        $enCours = $formations->where('status', 'en_attente')->count();
        $termines = $formations->where('status', 'terminé')->count();

        // Récupère les certifications avec leur date (non nulles)
        $total_certifications = $formations->whereNotNull('path_attestation')->count();


        // Progression globale
        $totalLecons = UserLesson::where('user_id', $userId)->count(); // toutes les leçons associées
        $terminees = UserLesson::where('user_id', $userId)->where('terminee', true)->count();

        $progressGlobal = $totalLecons > 0 ? round(($terminees / $totalLecons) * 100) : 0;
        $formationsEnCours = user_formation::with('formation') // charger les infos de la formation
            ->where('user_id', $userId)
            ->where('status', 'en_attente')
            ->get();

        $formationsTerminees = user_formation::with('formation')
            ->where('user_id', Auth::id())
            ->where('status', 'termine') // ou 'terminé' selon ta base
            ->get();

        $user = Auth::user();

          // 🟢 Dernière leçon terminée
        $lastLesson = $user->lessons()
            ->wherePivot('terminee', true)
            ->orderByDesc('user_lessons.terminee_at')
            ->with(['module.formation']) // pour accéder à formation facilement
            ->first();

        // 🟢 Dernier quiz réussi
        $lastQuiz = $user->quizzs()
            ->orderByDesc('user__quizzs.created_at')
            ->with(['module.formation'])
            ->first();

        // 🟢 Dernière formation terminée
        $lastFormation = $user->formations()
            ->wherePivot('progression', 100)
            ->orderByDesc('user_formations.updated_at')
            ->first();

        // Regrouper les activités
        $activity = [
            'lesson' => $lastLesson,
            'quiz' => $lastQuiz,
            'formation' => $lastFormation,
        ];
        if ($request->ajax()) {
            return view('space-etudiant.layout.dashboard-section', compact(
                'totalFormations',
                'enCours',
                'termines',
                'total_certifications',
                'progressGlobal',
                'formationsEnCours',
                'formationsTerminees',
                'activity'
            ));
        }

        return view('space-etudiant.layout.dashboard', compact(
            'totalFormations',
            'enCours',
            'termines',
            'total_certifications',
            'progressGlobal',
            'formationsEnCours',
            'formationsTerminees',
            'activity'
        ));
    }
    public function ShowTranings(Request $request)
    {


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
