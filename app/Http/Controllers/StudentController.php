<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\user_formation;
use App\Models\UserLesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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

    public function Showcertfication(Request $request)
    {
        $user = Auth::user();

        $certificats = $user->formationsAchetees()
            ->wherePivotNotNull('path_attestation')
            ->select('formations.id', 'formations.titre', 'formations.image', 'formations.created_at')
            ->withPivot('path_attestation', 'updated_at')
            ->orderByDesc('user_formations.updated_at')
            ->paginate(6);

        if ($request->ajax()) {
            return view('space-etudiant.layout.certificat-section', compact('certificats'));
        }

        return view('space-etudiant.layout.certificat-list', compact('certificats'));
    }

    public function ShowFacturations(Request $request)
    {

        $user = Auth::user();

        // Récupérer les paiements réussis avec formation
        $paiements = Paiement::where('user_id', $user->id)
            ->where('status', 'success')
            ->with('formation') // Assurez-vous que la relation est définie
            ->paginate(6);

        if ($request->ajax()) {
            return view('space-etudiant.layout.list-paiements-section', compact('paiements'));
        }

        return view('space-etudiant.layout.list-paiements', compact('paiements'));
    }

    public function Showhelp(Request $request){

        if ($request->ajax()) {
            return view('space-etudiant.layout.help-section'); // section partielle
        }

        return view('space-etudiant.layout.help'); // page com
    }

    public function sendMail(Request $request)
    {
         $request->validate([
            'message' => 'required|string|min:5',
        ]);

        Mail::raw($request->message, function ($msg) {
            $msg->to('cocouvilaeaxndro74@gmail.com')
                ->subject('Nouveau message d’aide');
        });

        return response()->json(['success' => 'Votre message a été envoyé avec succès ✅']);
    }

    public function ShowSettings(Request $request){

        $user = Auth::user();

        if ($request->ajax()) {
            return view('space-etudiant.layout.parametre-section', compact('user'));
        }

        return view('space-etudiant.layout.parametre', compact('user'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Auth::user();
        $user->update($request->only('nom', 'prenom', 'email'));

        return response()->json(['success' => 'Vos informations ont été mises à jour avec succès ✅']);
    }
}
