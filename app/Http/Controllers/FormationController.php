<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\user_formation;
use App\Models\User_Quizz;
use App\Models\UserLesson;
use Illuminate\Support\Facades\Auth;

class FormationController extends Controller
{
    public function index()
    {
        $formations = Formation::with(['modules.lessons', 'modules.quizz'])
            ->whereHas('users', fn ($q) => $q->where('user_id', Auth::id()))
            ->get();

        foreach ($formations as $formation) {
            // Total des leçons
            $totalLessons = $formation->modules->sum(fn ($m) => $m->lessons->count());

            // Leçons terminées par l'utilisateur
            $completedLessons = UserLesson::where('user_id', Auth::id())
                ->whereIn('lesson_id', $formation->modules->flatMap(fn ($m) => $m->lessons->pluck('id')))
                ->where('terminee', true)
                ->count();

            // Progression leçons (70%)
            $lessonProgressPct = $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0;
            $lessonPart = $lessonProgressPct * 0.70;

            // Progression quizz (30%)
            $allQuizz = $formation->modules->pluck('quizz')->filter();
            $quizCount = $allQuizz->count();
            $quizPart = 0;

            if ($quizCount > 0) {
                $eachQuizWeight = 30 / $quizCount;

                foreach ($allQuizz as $quizz) {
                    $userQuizz = User_Quizz::where('user_id', Auth::id())
                        ->where('quizz_id', $quizz->id)
                        ->first();

                    if ($userQuizz && $userQuizz->termine == 1) {
                        $quizPart += $eachQuizWeight;
                    } elseif ($userQuizz) {
                        $quizPart += ($userQuizz->score / 100) * $eachQuizWeight;
                    }
                }
            }

            if ($quizPart > 30) {
                $quizPart = 30;
            }

            $progress = floor($lessonPart + $quizPart);
            $formation->calculated_progress = min($progress, 100); // max 100%

            // Vérifier attestation
            $userFormation = user_formation::where('user_id', Auth::id())
                ->where('formation_id', $formation->id)
                ->first();

            $formation->attestation_status = (
                $formation->calculated_progress == 100
                && $userFormation
                && $userFormation->path_attestation
            ) ? 'disponible' : 'non_disponible';
        }

        if (request()->ajax()) {
            return view('formations.index', compact('formations'));
        }

        // Sinon, on charge la vue complète
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

        // progression globale des leçons
        $totalLessons = $formation->modules->sum(fn ($m) => $m->lessons->count());
        $completedLessons = UserLesson::where('user_id', Auth::id())
            ->whereIn('lesson_id', $formation->modules->flatMap(fn ($m) => $m->lessons->pluck('id')))
            ->where('terminee', true)
            ->count();

        $lessonProgressPct = $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0;
        $lessonPart = $lessonProgressPct * 0.70;  // 70% du poids total

        // progression globale des quiz (30% du poids total)
        $allQuizz = $formation->modules->pluck('quizz')->filter();
        $quizCount = $allQuizz->count();
        $quizPart = 0;

        if ($quizCount > 0) {
            $eachQuizWeight = 30 / $quizCount;
            foreach ($allQuizz as $quizz) {
                $userQuizz = User_Quizz::where('user_id', Auth::id())
                    ->where('quizz_id', $quizz->id)
                    ->first();

                if ($userQuizz && $userQuizz->termine == 1) {
                    $quizPart += $eachQuizWeight;
                } elseif ($userQuizz) {
                    $quizPart += ($userQuizz->score / 100) * $eachQuizWeight;
                }
            }
        }
        if ($quizPart > 30) {
            $quizPart = 30;
        }

        $finalProgress = floor($lessonPart + $quizPart);
        if ($finalProgress > 100) {
            $finalProgress = 100;
        }

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
}
