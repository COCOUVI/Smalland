<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\user_formation;
use App\Models\UserLesson;
use App\Models\User_Quizz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class FormationController extends Controller
{
    public function index()
    {
        $formations = Formation::with(['modules.lessons', 'modules.quizz'])
            ->whereHas('users', fn($q) => $q->where('user_id', Auth::id()))
            ->get();

        foreach ($formations as $formation) {
            $totalLessons = $formation->modules->sum(fn($m) => $m->lessons->count());
            $completedLessons = UserLesson::where('user_id', Auth::id())
                ->whereIn('lesson_id', $formation->modules->flatMap(fn($m) => $m->lessons->pluck('id')))
                ->where('terminee', true)
                ->count();

            $lessonProgress = $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0;

            $allQuizz = $formation->modules->pluck('quizz')->filter();
            $quizzValid = true;

            foreach ($allQuizz as $quizz) {
                $userQuizz = User_Quizz::where('user_id', Auth::id())
                    ->where('quizz_id', $quizz->id)
                    ->first();

                if (!$userQuizz || round($userQuizz->score) < 100) {
                    $quizzValid = false;
                    break;
                }
            }

            $progress = ($lessonProgress == 100 && $quizzValid) ? 100 : floor($lessonProgress);
            $formation->calculated_progress = $progress;

            // Attestation
            $userFormation = user_formation::where('user_id', Auth::id())
                ->where('formation_id', $formation->id)
                ->first();

            $formation->attestation_status = $progress == 100 && $userFormation && $userFormation->path_attestation
                ? 'disponible'
                : 'non_disponible';
        }

        return view('formations.index', compact('formations'));
    }

    public function show($id)
    {
        $formation = Formation::with(['objectifs', 'modules.lessons', 'modules.quizz'])->findOrFail($id);

        $userFormation = user_formation::firstOrCreate([
            'user_id' => Auth::id(),
            'formation_id' => $id,
        ]);

        $modulesWithProgress = [];
        foreach ($formation->modules as $module) {
            $total = $module->lessons->count();
            $completed = UserLesson::where('user_id', Auth::id())
                ->whereIn('lesson_id', $module->lessons->pluck('id'))
                ->where('terminee', true)
                ->count();

            $moduleProgress = $total > 0 ? ($completed / $total) * 100 : 0;

            $modulesWithProgress[] = [
                'module' => $module,
                'progress' => $moduleProgress,
                'completed_lessons' => $completed,
                'total_lessons' => $total,
            ];
        }

        // Progression globale
        $totalLessons = $formation->modules->sum(fn($m) => $m->lessons->count());
        $completedLessons = UserLesson::where('user_id', Auth::id())
            ->whereIn('lesson_id', $formation->modules->flatMap(fn($m) => $m->lessons->pluck('id')))
            ->where('terminee', true)
            ->count();

        $lessonProgress = $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0;

        $allQuizz = $formation->modules->pluck('quizz')->filter();
        $quizzValid = true;

        foreach ($allQuizz as $quizz) {
            $userQuizz = User_Quizz::where('user_id', Auth::id())
                ->where('quizz_id', $quizz->id)
                ->first();

            if (!$userQuizz || round($userQuizz->score) < 100) {
                $quizzValid = false;
                break;
            }
        }

        $finalProgress = ($lessonProgress == 100 && $quizzValid) ? 100 : floor($lessonProgress);
        $userFormation->progression = $finalProgress;
        $userFormation->status = ($finalProgress == 100) ? 'terminé' : 'en_attente';
        $userFormation->save();

        return view('formations.show', [
            'formation' => $formation,
            'userFormation' => $userFormation,
            'modulesWithProgress' => $modulesWithProgress,
            'globalProgress' => $finalProgress,
        ]);
    }

    public function generateAttestation($id)
    {
        $user = Auth::user();
        $formation = Formation::findOrFail($id);
        $userFormation = user_formation::where('user_id', $user->id)
            ->where('formation_id', $id)
            ->firstOrFail();

        if ($userFormation->progression < 100) {
            return back()->with('error', 'Attestation non disponible. Progression incomplète.');
        }

        if ($userFormation->path_attestation && Storage::disk('public')->exists($userFormation->path_attestation)) {
            return Storage::disk('public')->download($userFormation->path_attestation);
        }

        // Générer le PDF
        $pdf = Pdf::loadView('certificats.attestation', [
            'user' => $user,
            'formation' => $formation,
            'date' => now()->format('d/m/Y'),
        ]);

        $filename = 'attestation_' . $user->id . '_' . $formation->id . '.pdf';
        $path = 'attestations/' . $filename;

        Storage::disk('public')->put($path, $pdf->output());

        $userFormation->path_attestation = $path;
        $userFormation->save();

        return Storage::disk('public')->download($path);
    }
}
