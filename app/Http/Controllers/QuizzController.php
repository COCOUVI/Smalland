<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Quizz;
use App\Models\Question;
use App\Models\Reponse;
use Illuminate\Http\Request;

class QuizzController extends Controller
{
    // Affiche la page de gestion du quizz pour un module
    public function manage(Module $module)
    {
        $module->load('quizz.questions.reponses'); // charge quizz + questions + réponses
        return view('admin.layout.quiz.manage', compact('module'));
    }

    // Créer ou mettre à jour le quizz + ajouter des questions
    public function storeOrUpdate(Request $request, Module $module)
    {
        // 1️⃣ Créer le quizz si inexistant
        $quizz = $module->quizz ?? Quizz::create([
            'module_id' => $module->id,
            'titre' => $request->titre ?? 'Quizz du module ' . $module->titre,
        ]);

        // 2️⃣ Ajouter une question si présente
        if ($request->filled('question') && $request->filled('reponses')) {
            $request->validate([
                'question'   => 'required|string',
                'reponses'   => 'required|array|min:2',
                'is_correct' => 'required|integer',
            ]);

            $question = $quizz->questions()->create([
                'content' => $request->question,
            ]);

            foreach ($request->reponses as $key => $rep) {
                $question->reponses()->create([
                    'content'    => $rep,
                    'is_correct' => ($key == $request->is_correct),
                ]);
            }
        }

        return redirect()->route('quizz.manage', $module->id)
                         ->with('success', 'Quizz et questions mis à jour avec succès.');
    }
}
