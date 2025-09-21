<?php

namespace App\Http\Controllers;

use App\Models\Quizz;
use App\Models\Module;
use App\Models\Reponse;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuizzController extends Controller
{
    // Affiche la page de gestion du quizz pour un module
    public function manage(Module $module)
    {
        $module->load('quizz.questions.reponses'); // charge quizz + questions + réponses
        return view('admin.layout.quiz.manage', compact('module'));
    }

    // ✅ CORRIGÉ : Créer ou mettre à jour le quizz + ajouter des questions
    public function storeOrUpdate(Request $request, Module $module)
    {
        // ✅ Forcer la réponse JSON pour les requêtes AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return $this->handleAjaxStoreOrUpdate($request, $module);
        }

        // Traitement classique pour les requêtes non-AJAX
        try {
            // 1️⃣ Créer le quizz si inexistant
            $quizz = $module->quizz ?? Quizz::create([
                'module_id' => $module->id,
                'titre' => $request->titre ?? 'Quizz du module ' . $module->titre,
            ]);

            return redirect()->route('quizz.manage', $module->id)
                             ->with('success', 'Quizz créé avec succès.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la création: ' . $e->getMessage());
        }
    }

    // ✅ NOUVELLE MÉTHODE : Gérer spécifiquement les requêtes AJAX
    private function handleAjaxStoreOrUpdate(Request $request, Module $module)
    {
        try {
            // Validation
            $request->validate([
                'question'       => 'required|string|max:255',
                'reponses'       => 'required|array|min:2|max:10',
                'reponses.*'     => 'required|string|max:255',
                'correct_answers' => 'required|array|min:1',
                'correct_answers.*' => 'integer|min:0'
            ], [
                'question.required' => 'La question est obligatoire.',
                'reponses.required' => 'Au moins deux réponses sont requises.',
                'reponses.min' => 'Vous devez fournir au moins 2 réponses.',
                'reponses.max' => 'Maximum 10 réponses autorisées.',
                'correct_answers.required' => 'Vous devez sélectionner au moins une réponse correcte.',
                'correct_answers.min' => 'Vous devez sélectionner au moins une réponse correcte.'
            ]);

            // 1️⃣ Créer le quizz si inexistant
            $quizz = $module->quizz ?? Quizz::create([
                'module_id' => $module->id,
                'titre' => $request->titre ?? 'Quizz du module ' . $module->titre,
            ]);

            // 2️⃣ Créer la question
            $question = $quizz->questions()->create([
                'content' => trim($request->question),
            ]);

            // 3️⃣ Créer les réponses
            $reponses = [];
            foreach ($request->reponses as $key => $rep) {
                if (!empty(trim($rep))) { // Vérifier que la réponse n'est pas vide
                    $reponse = $question->reponses()->create([
                        'content'    => trim($rep),
                        'is_correct' => in_array($key, $request->correct_answers),
                    ]);

                    $reponses[] = [
                        'id' => $reponse->id,
                        'content' => $reponse->content,
                        'is_correct' => $reponse->is_correct
                    ];
                }
            }

            // ✅ Retourner une réponse JSON structurée
            return response()->json([
                'success' => true,
                'message' => 'Question ajoutée avec succès!',
                'question' => [
                    'id' => $question->id,
                    'content' => $question->content,
                    'reponses' => $reponses
                ]
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'ajout de question: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur interne du serveur: ' . $e->getMessage()
            ], 500);
        }
    }

    // ✅ MÉTHODE CORRIGÉE : Modifier une question
    public function updateQuestion(Request $request, $questionId)
    {
        try {
            $question = Question::with('reponses')->findOrFail($questionId);

            $request->validate([
                'question_content' => 'required|string|max:255',
                'reponses' => 'required|array|min:2|max:10',
                'correct_reponses' => 'required|array|min:1'
            ], [
                'question_content.required' => 'Le contenu de la question est obligatoire.',
                'reponses.min' => 'Au moins 2 réponses sont requises.',
                'correct_reponses.required' => 'Vous devez sélectionner au moins une réponse correcte.',
                'correct_reponses.min' => 'Vous devez sélectionner au moins une réponse correcte.'
            ]);

            // Mettre à jour le contenu de la question
            $question->update([
                'content' => trim($request->question_content)
            ]);

            // Supprimer toutes les anciennes réponses
            $question->reponses()->delete();

            // Créer les nouvelles réponses
            $updatedReponses = [];
            $correctReponses = [];

            foreach ($request->reponses as $reponseId => $content) {
                if (!empty(trim($content))) {
                    $newReponse = $question->reponses()->create([
                        'content' => trim($content),
                        'is_correct' => in_array($reponseId, $request->correct_reponses)
                    ]);

                    $updatedReponses[$newReponse->id] = $newReponse->content;

                    if ($newReponse->is_correct) {
                        $correctReponses[] = (string)$newReponse->id;
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Question modifiée avec succès',
                'reponses' => $updatedReponses,
                'correct_reponses' => $correctReponses
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la modification de question: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur interne: ' . $e->getMessage()
            ], 500);
        }
    }

    // ✅ MÉTHODE CORRIGÉE : Supprimer une question
    public function deleteQuestion($questionId)
    {
        try {
            $question = Question::findOrFail($questionId);

            // Supprimer les réponses (cascade devrait le faire automatiquement)
            $question->reponses()->delete();

            // Supprimer la question
            $question->delete();

            return response()->json([
                'success' => true,
                'message' => 'Question supprimée avec succès'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression de question: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], 500);
        }
    }
}
