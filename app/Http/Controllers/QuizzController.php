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
                'question'       => 'required|string',
                'reponses'       => 'required|array|min:2',
                'correct_answers' => 'required|array|min:1', // ✅ Au moins une réponse correcte
            ], [
                'correct_answers.required' => 'Vous devez sélectionner au moins une réponse correcte.',
                'correct_answers.min' => 'Vous devez sélectionner au moins une réponse correcte.'
            ]);

            $question = $quizz->questions()->create([
                'content' => $request->question,
            ]);

            foreach ($request->reponses as $key => $rep) {
                $question->reponses()->create([
                    'content'    => $rep,
                    'is_correct' => in_array($key, $request->correct_answers), // ✅ Vérifier si l'index est dans le tableau
                ]);
            }
        }

        return redirect()->route('quizz.manage', $module->id)
                         ->with('success', 'Quizz et questions mis à jour avec succès.');
    }

    // ✅ MÉTHODE MODIFIÉE : Modifier une question avec support multiple correct answers
    public function updateQuestion(Request $request, $questionId)
    {
        try {
            $question = Question::with('reponses')->findOrFail($questionId);

            $request->validate([
                'question_content' => 'required|string',
                'reponses' => 'required|array|min:2',
                'correct_reponses' => 'required|array|min:1' // ✅ Au moins une réponse correcte
            ], [
                'correct_reponses.required' => 'Vous devez sélectionner au moins une réponse correcte.',
                'correct_reponses.min' => 'Vous devez sélectionner au moins une réponse correcte.'
            ]);

            // Mettre à jour le contenu de la question
            $question->update([
                'content' => $request->question_content
            ]);

            // Supprimer toutes les anciennes réponses
            $question->reponses()->delete();

            // Créer les nouvelles réponses
            $updatedReponses = [];
            $correctReponses = [];

            foreach ($request->reponses as $reponseId => $content) {
                $newReponse = $question->reponses()->create([
                    'content' => $content,
                    'is_correct' => in_array($reponseId, $request->correct_reponses) // ✅ Vérifier si dans le tableau
                ]);

                $updatedReponses[$newReponse->id] = $content;

                if ($newReponse->is_correct) {
                    $correctReponses[] = (string)$newReponse->id;
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Question modifiée avec succès',
                'reponses' => $updatedReponses,
                'correct_reponses' => $correctReponses
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation échouée: ' . implode(' ', $e->errors()['correct_reponses'] ?? ['Erreur de validation'])
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
        }
    }

    // ✅ MÉTHODE INCHANGÉE : Supprimer une question
    public function deleteQuestion($questionId)
    {
        try {
            $question = Question::findOrFail($questionId);

            // Supprimer d'abord les réponses (cascade devrait le faire automatiquement)
            $question->reponses()->delete();

            // Supprimer la question
            $question->delete();

            return response()->json(['success' => true, 'message' => 'Question supprimée avec succès']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
        }
    }
}
