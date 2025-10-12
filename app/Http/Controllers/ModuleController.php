<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\User_Quizz;
use App\Models\UserLesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    public function show($formationId, $moduleId)
    {
        $module = Module::with([
            'lessons',
            'quizz.questions.reponses',
            'formation',
        ])->findOrFail($moduleId);

        $userProgress = [];
        foreach ($module->lessons as $lesson) {
            $userLesson = UserLesson::where('user_id', Auth::id())
                ->where('lesson_id', $lesson->id)
                ->first();

            $userProgress[$lesson->id] = $userLesson ? $userLesson->terminee : false;
        }

        $userQuizz = User_Quizz::where('user_id', Auth::id())
            ->where('quizz_id', $module->quizz->id ?? null)
            ->first();

        return view('modules.show', compact('module', 'userProgress', 'userQuizz'));
    }

    public function completeLesson(Request $request, $lessonId)
    {
        $userLesson = UserLesson::firstOrCreate([
            'user_id' => Auth::id(),
            'lesson_id' => $lessonId,
        ]);

        if (! $userLesson->terminee) {
            $userLesson->update([
                'terminee' => true,
                'terminee_at' => now(),
            ]);

            // Mettre à jour la progression globale de la formation
            $this->updateFormationProgress($lessonId);
        }

        return response()->json(['success' => true]);
    }

    private function updateFormationProgress($lessonId)
    {
        $lesson = \App\Models\Lesson::with('module.formation')->find($lessonId);
        $formation = $lesson->module->formation;

        $totalLessons = $formation->modules->flatMap->lessons->count();
        $completedLessons = UserLesson::where('user_id', Auth::id())
            ->whereIn('lesson_id', $formation->modules->flatMap->lessons->pluck('id'))
            ->where('terminee', true)
            ->count();

        $progress = $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0;

        $userFormation = \App\Models\UserFormation::where('user_id', Auth::id())
            ->where('formation_id', $formation->id)
            ->first();

        if ($userFormation) {
            $userFormation->update(['progression' => $progress]);
        }
    }
}
