<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\user_formation;
use App\Models\UserLesson;
use App\Models\User_Quizz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

            // Vérifier si tous les quizz sont à 100%
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

            // Calcul final de la progression
            $progress = ($lessonProgress == 100 && $quizzValid) ? 100 : floor($lessonProgress);
            $formation->calculated_progress = $progress;
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

        // Vérifie tous les quizz à 100%
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
}
