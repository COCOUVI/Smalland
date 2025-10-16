<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Question;
use App\Models\Quizz;
use App\Models\User_Quizz;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class QuizzController extends Controller
{
    // Affiche la page de gestion du quizz pour un module
    // public function manage(Module $module)
    // {
    //     $module->load('quizz.questions.reponses'); // charge quizz + questions + réponses
    //     return view('admin.layout.quiz.manage', compact('module'));
    // }

    public function manage(Module $module)
    {
        $module->load('quizz.questions.reponses');

        $response = response()->view('admin.layout.quiz.manage', compact('module'));

        return $response->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    // ✅ CORRIGÉ : Créer ou mettre à jour le quizz + ajouter des questions
    public function storeOrUpdate(Request $request, Module $module)
    {
        // ✅ Forcer la réponse JSON pour les requêtes AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return $this->handleAjaxStoreOrUpdate($request, $module);
        }

        // Traitement classique pour les requêtes non-AJAX (création quiz uniquement)
        try {
            // Validation pour création de quiz
            $request->validate([
                'titre' => 'required|string|max:255',
            ]);

            // 1️⃣ Créer le quizz si inexistant
            $quizz = $module->quizz ?? Quizz::create([
                'module_id' => $module->id,
                'titre' => $request->titre,
            ]);

            return redirect()->route('quizz.manage', $module->id)
                ->with('success', 'Quiz créé avec succès.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la création: '.$e->getMessage());
        }
    }

    // ✅ NOUVELLE MÉTHODE : Gérer spécifiquement les requêtes AJAX
    private function handleAjaxStoreOrUpdate(Request $request, Module $module)
    {
        try {
            // 1️⃣ Gérer la création de quiz seul
            if (! $request->filled('question') && $request->filled('titre')) {
                $request->validate([
                    'titre' => 'required|string|max:255',
                ]);

                $quizz = $module->quizz ?? Quizz::create([
                    'module_id' => $module->id,
                    'titre' => $request->titre,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Quiz créé avec succès!',
                    'quiz' => [
                        'id' => $quizz->id,
                        'titre' => $quizz->titre,
                    ],
                ], 200);
            }

            // 2️⃣ Gérer l'ajout de questions (code existant)
            if ($request->filled('question') && $request->filled('reponses')) {
                // Validation
                $request->validate([
                    'question' => 'required|string|max:255',
                    'reponses' => 'required|array|min:2|max:10',
                    'reponses.*' => 'required|string|max:255',
                    'correct_answers' => 'required|array|min:1',
                    'correct_answers.*' => 'integer|min:0',
                ], [
                    'question.required' => 'La question est obligatoire.',
                    'reponses.required' => 'Au moins deux réponses sont requises.',
                    'reponses.min' => 'Vous devez fournir au moins 2 réponses.',
                    'reponses.max' => 'Maximum 10 réponses autorisées.',
                    'correct_answers.required' => 'Vous devez sélectionner au moins une réponse correcte.',
                    'correct_answers.min' => 'Vous devez sélectionner au moins une réponse correcte.',
                ]);

                // S'assurer que le quiz existe
                $quizz = $module->quizz ?? Quizz::create([
                    'module_id' => $module->id,
                    'titre' => 'Quizz du module '.$module->titre,
                ]);

                // Créer la question
                $question = $quizz->questions()->create([
                    'content' => trim($request->question),
                ]);

                // Créer les réponses
                $reponses = [];
                foreach ($request->reponses as $key => $rep) {
                    if (! empty(trim($rep))) {
                        $reponse = $question->reponses()->create([
                            'content' => trim($rep),
                            'is_correct' => in_array($key, $request->correct_answers),
                        ]);

                        $reponses[] = [
                            'id' => $reponse->id,
                            'content' => $reponse->content,
                            'is_correct' => $reponse->is_correct,
                        ];
                    }
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Question ajoutée avec succès!',
                    'question' => [
                        'id' => $question->id,
                        'content' => $question->content,
                        'reponses' => $reponses,
                    ],
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Données manquantes',
            ], 400);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            Log::error('Erreur AJAX: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur interne du serveur: '.$e->getMessage(),
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
                'correct_reponses' => 'required|array|min:1',
            ], [
                'question_content.required' => 'Le contenu de la question est obligatoire.',
                'reponses.min' => 'Au moins 2 réponses sont requises.',
                'correct_reponses.required' => 'Vous devez sélectionner au moins une réponse correcte.',
                'correct_reponses.min' => 'Vous devez sélectionner au moins une réponse correcte.',
            ]);

            // Mettre à jour le contenu de la question
            $question->update([
                'content' => trim($request->question_content),
            ]);

            // Supprimer toutes les anciennes réponses
            $question->reponses()->delete();

            // Créer les nouvelles réponses
            $updatedReponses = [];
            $correctReponses = [];

            foreach ($request->reponses as $reponseId => $content) {
                if (! empty(trim($content))) {
                    $newReponse = $question->reponses()->create([
                        'content' => trim($content),
                        'is_correct' => in_array($reponseId, $request->correct_reponses),
                    ]);

                    $updatedReponses[$newReponse->id] = $newReponse->content;

                    if ($newReponse->is_correct) {
                        $correctReponses[] = (string) $newReponse->id;
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Question modifiée avec succès',
                'reponses' => $updatedReponses,
                'correct_reponses' => $correctReponses,
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la modification de question: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur interne: '.$e->getMessage(),
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
                'message' => 'Question supprimée avec succès',
            ], 200);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression de question: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression: '.$e->getMessage(),
            ], 500);
        }
    }

    // Ajouter ces méthodes à votre QuizzController

    /**
     * Modifier le titre du quizz
     */
    public function updateTitle(Request $request, Quizz $quizz)
    {
        try {
            // Validation
            $request->validate([
                'titre' => 'required|string|max:255',
            ], [
                'titre.required' => 'Le titre est obligatoire.',
                'titre.max' => 'Le titre ne peut pas dépasser 255 caractères.',
            ]);

            // Mise à jour du titre
            $quizz->update([
                'titre' => trim($request->titre),
            ]);

            // Réponse selon le type de requête
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Titre du quizz modifié avec succès',
                    'titre' => $quizz->titre,
                ], 200);
            }

            return redirect()->route('quizz.manage', $quizz->module_id)
                ->with('success', 'Titre du quizz modifié avec succès.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $e->errors(),
                ], 422);
            }

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (\Exception $e) {
            Log::error('Erreur lors de la modification du titre du quizz: '.$e->getMessage());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur interne: '.$e->getMessage(),
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Erreur lors de la modification: '.$e->getMessage());
        }
    }

    /**
     * Supprimer complètement le quizz et toutes ses questions/réponses
     */
    public function destroy(Request $request, Quizz $quizz)
    {
        try {
            $moduleId = $quizz->module_id;

            // Supprimer toutes les réponses via les questions (cascade)
            foreach ($quizz->questions as $question) {
                $question->reponses()->delete();
            }

            // Supprimer toutes les questions
            $quizz->questions()->delete();

            // Supprimer le quizz
            $quizz->delete();

            // Réponse selon le type de requête
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Quizz supprimé avec succès',
                    'redirect_url' => route('quizz.manage', $moduleId),
                ], 200);
            }

            return redirect()->route('quizz.manage', $moduleId)
                ->with('success', 'Quizz supprimé avec succès.');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression du quizz: '.$e->getMessage());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la suppression: '.$e->getMessage(),
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression: '.$e->getMessage());
        }
    }

    // Mes routes a moi

    public function show($quizzId)
    {
        $quizz = Quizz::with('questions.reponses')->findOrFail($quizzId);

        $userQuizz = User_Quizz::where('user_id', Auth::id())
            ->where('quizz_id', $quizzId)
            ->first();

        $canResubmit = true;

        if ($userQuizz && $userQuizz->updated_at) {
            $canResubmit = Carbon::now()->diffInHours($userQuizz->updated_at) >= 24;
        }

        return view('quizz.show', compact('quizz', 'userQuizz', 'canResubmit'));
    }

    public function submit(Request $request, $quizzId)
    {
        $userId = Auth::id();

        $quizz = Quizz::with('questions.reponses', 'module.formation')->findOrFail($quizzId);

        $userQuizz = User_Quizz::where('user_id', $userId)
            ->where('quizz_id', $quizzId)
            ->first();

        // Vérifie que l'utilisateur n'a pas soumis le quiz il y a moins de 24h
        if ($userQuizz && $userQuizz->updated_at && now()->diffInHours($userQuizz->updated_at) < 24) {
            return redirect()->back()->with('error', 'Vous devez attendre 24 heures avant de pouvoir refaire ce quiz.');
        }

        $score = 0;
        $totalQuestions = $quizz->questions->count();

        foreach ($quizz->questions as $question) {
            $userAnswer = $request->input('question_'.$question->id);
            $correctAnswer = $question->reponses->where('is_correct', true)->first();

            if ($correctAnswer && $userAnswer == $correctAnswer->id) {
                $score++;
            }
        }

        $finalScore = $totalQuestions > 0 ? ($score / $totalQuestions) * 100 : 0;

        // Met à jour ou crée l'entrée dans user_quizz
        User_Quizz::updateOrCreate(
            [
                'user_id' => $userId,
                'quizz_id' => $quizzId,
            ],
            [
                'score' => $finalScore,
                'updated_at' => now(),
            ]
        );

        // Maintenant on met à jour la progression et le statut dans user_formations
        $formationId = $quizz->module->formation->id;

        // Récupérer tous les quizzes liés à la formation pour l'utilisateur
        $quizzIds = Quizz::whereHas('module', function ($query) use ($formationId) {
            $query->where('formation_id', $formationId);
        })->pluck('id');

        $userQuizzScores = User_Quizz::where('user_id', $userId)
            ->whereIn('quizz_id', $quizzIds)
            ->pluck('score');

        // Vérifier si tous les scores sont à 100%
        $allQuizzesPerfect = $userQuizzScores->count() === $quizzIds->count() && $userQuizzScores->every(fn ($score) => $score == 100);

        $progression = $allQuizzesPerfect ? 100 : ($userQuizzScores->avg() ?? 0);

        $status = $allQuizzesPerfect ? 'terminé' : 'en attente';

        // Mettre à jour ou créer la progression dans user_formations
        User_Formation::updateOrCreate(
            [
                'user_id' => $userId,
                'formation_id' => $formationId,
            ],
            [
                'progression' => $progression,
                'status' => $status,
                'updated_at' => now(),
            ]
        );

        return redirect()->back()->with([
            'success' => 'Quiz terminé ! Votre score : '.round($finalScore).'%',
            'score' => $finalScore,
        ]);
    }
}
