<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\user_formation;
use App\Models\UserLesson;
use Illuminate\Support\Facades\Auth;

class FormationController extends Controller
{
    public function index()
    {
        $formations = Formation::with(['modules.lessons'])
            ->whereHas('users', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->get();

        foreach ($formations as $formation) {
            // Leçons totales de la formation
            $totalLessons = $formation->modules->sum(fn ($module) => $module->lessons->count());

            // Leçons terminées par l'utilisateur
            $completedLessons = UserLesson::where('user_id', Auth::id())
                ->whereIn('lesson_id', $formation->modules->flatMap(fn ($m) => $m->lessons->pluck('id')))
                ->where('terminee', true)
                ->count();

            // Calcul progression
            $progress = $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0;

            $formation->calculated_progress = round($progress, 2);
        }

        $firstFormation = $formations->first();

        return view('formations.index', compact('formations', 'firstFormation'));
    }

    public function show($id)
    {
        $formation = Formation::with([
            'objectifs',
            'modules.lessons',
            'modules.quizz.questions.reponses',
        ])->findOrFail($id);

        $userFormation = user_formation::where('user_id', Auth::id())
            ->where('formation_id', $id)
            ->first();

        if (! $userFormation) {
            return redirect()->route('formations.index')->with('error', 'Vous n\'êtes pas inscrit à cette formation.');
        }

        // Calculer la progression par module
        $modulesWithProgress = [];
        foreach ($formation->modules as $module) {
            $totalLessons = $module->lessons->count();
            $completedLessons = UserLesson::where('user_id', Auth::id())
                ->whereIn('lesson_id', $module->lessons->pluck('id'))
                ->where('terminee', true)
                ->count();

            $moduleProgress = $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0;

            $modulesWithProgress[] = [
                'module' => $module,
                'progress' => $moduleProgress,
                'completed_lessons' => $completedLessons,
                'total_lessons' => $totalLessons,
            ];
        }

        // Calcul progression globale (sur toute la formation)
        $totalLessonsFormation = $formation->modules->sum(fn ($module) => $module->lessons->count());

        $completedLessonsFormation = UserLesson::where('user_id', Auth::id())
            ->whereIn('lesson_id', $formation->modules->flatMap(fn ($m) => $m->lessons->pluck('id')))
            ->where('terminee', true)
            ->count();

        $globalProgress = $totalLessonsFormation > 0 ? ($completedLessonsFormation / $totalLessonsFormation) * 100 : 0;
        $globalProgress = round($globalProgress, 2);

        return view('formations.show', compact('formation', 'userFormation', 'modulesWithProgress', 'globalProgress'));
    }
}
