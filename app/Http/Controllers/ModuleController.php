<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\User_Quizz;
use App\Models\UserLesson;
use App\Models\user_formation;
use App\Models\Lesson;
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

            $this->updateFormationProgress($lessonId);
        }

        return redirect()->back();
    }

    private function updateFormationProgress($lessonId)
    {
        $lesson = Lesson::with('module.formation.modules.lessons')->find($lessonId);
        $module = $lesson->module;
        $formation = $module->formation;

        $allLessons = $formation->modules->flatMap->lessons;
        $totalLessons = $allLessons->count();

        $completedLessons = UserLesson::where('user_id', Auth::id())
            ->whereIn('lesson_id', $allLessons->pluck('id'))
            ->where('terminee', true)
            ->count();

        $progress = $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0;
        $progress = round($progress, 2);

        $userFormation = user_formation::firstOrCreate([
            'user_id' => Auth::id(),
            'formation_id' => $formation->id,
        ]);

        $userFormation->progression = $progress;

        // Statut logique : si quiz existe et score 100 et progression 100 → terminé
        $statut = 'en_attente';
        $quizz = $module->quizz;
        if ($quizz) {
            $userQuizz = User_Quizz::where('user_id', Auth::id())
                ->where('quizz_id', $quizz->id)
                ->first();
            if ($userQuizz && round($userQuizz->score) == 100 && $progress == 100) {
                $statut = 'terminé';
            }
        }
        $userFormation->status = $statut;

        $userFormation->save();
    }
}
