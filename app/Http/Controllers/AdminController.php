<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Module;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\FormationRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreModuleRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateModuleRequest;
use App\Http\Requests\UpdateFormationRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Models\Paiement;
use App\Models\user_formation;
use Illuminate\Support\Facades\DB;
use App\Services\VideoService;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //

    public function AddFormationPage()
    {
        return view('admin.layout.add_formation');
    }

    // Stocke une nouvelle formation

    /**
     * @param \Illuminate\Http\Request $request
     */

    public function AddFormation(FormationRequest $request)
    {
        try {
            // Création d'une instance de Formation
            $formation = new Formation();
            $formation->titre = $request->input('title');
            $formation->description = $request->input('description');
            $formation->price = $request->input('price');
            $formation->niveau = $request->input('level', 'Non spécifié');

            // Gestion de l'image si fournie
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('formations', 'public');
                $formation->image_path = $imagePath;
            }

            // Sauvegarde de la formation d'abord
            $formation->save();

            // Gérer les objectifs dans la table objectifs séparée
            $objectives = $request->input('objectives', []);
            if (is_array($objectives) && !empty($objectives)) {
                foreach (array_filter($objectives) as $objectiveText) {
                    if (!empty(trim($objectiveText))) {
                        DB::table('objectifs')->insert([
                            'formation_id' => $formation->id,
                            'content' => trim($objectiveText),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            // Retour JSON pour AJAX
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Formation créée avec succès.',
                    'formation' => $formation
                ]);
            }

            return redirect()->back()->with('success', 'Formation créée avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur création formation: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la création: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Erreur lors de la création.');
        }
    }

    public function ShowFormations()
    {
        $formations = Formation::paginate(1);
        return view('admin.layout.formations.list_formations', compact('formations'));
    }

    public function GetOneFormation(Formation $formation)
    {
        return view('admin.layout.formations.detail_formation', compact('formation'));
    }

    public function Put_Page_Formation(Formation $formation)
    {
        return view('admin.layout.modifier_formation', compact('formation'));
    }


    /**
     * @param \Illuminate\Http\Request|\App\Http\Requests\UpdateFormationRequest $request
     */
    public function PutFormation(UpdateFormationRequest $request, Formation $formation)
    {
        try {
            $formation->titre = $request->input('titre');
            $formation->description = $request->input('description');
            $formation->price = $request->input('price');
            $formation->niveau = $request->input('level');

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('formations', 'public');
                $formation->image_path = $imagePath;
            }

            $formation->save();

            // Gérer les objectifs à supprimer
            if ($request->has('objectives_to_delete')) {
                DB::table('objectifs')
                    ->whereIn('id', $request->input('objectives_to_delete'))
                    ->delete();
            }

            // Mettre à jour les objectifs existants
            if ($request->has('objectives_existing')) {
                foreach ($request->input('objectives_existing') as $id => $content) {
                    if (!empty(trim($content))) {
                        DB::table('objectifs')
                            ->where('id', $id)
                            ->where('formation_id', $formation->id)
                            ->update([
                                'content' => trim($content),
                                'updated_at' => now()
                            ]);
                    }
                }
            }

            // Ajouter les nouveaux objectifs
            if ($request->has('objectives_new')) {
                foreach ($request->input('objectives_new') as $content) {
                    if (!empty(trim($content))) {
                        DB::table('objectifs')->insert([
                            'formation_id' => $formation->id,
                            'content' => trim($content),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Formation mise à jour avec succès.',
                    'formation' => $formation
                ]);
            }

            return redirect()->back()->with('success', 'Formation mise à jour avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur modification formation: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la modification: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Erreur lors de la modification.');
        }
    }


    public function DeleteFormation(Formation $formation, Request $request)
    {
        $formation->delete();

        // Retour JSON pour AJAX ou redirection classique
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Formation supprimée avec succès.'
            ]);
        }

        return redirect()->back()->with('success', 'Formation supprimée avec succès');
    }

    public function AddModule(Request $request, $formationId)
    {
        $request->validate([
            'modules_existing' => 'array',
            'modules_existing.*' => 'string|max:255',
            'modules_new' => 'array',
            'modules_new.*' => 'string|max:255',
            'modules_to_delete' => 'array',
            'modules_to_delete.*' => 'integer|exists:modules,id',
        ]);

        // Supprimer modules
        if ($request->has('modules_to_delete')) {
            Module::whereIn('id', $request->modules_to_delete)->delete();
        }

        // Mettre à jour les modules existants
        if ($request->has('modules_existing')) {
            foreach ($request->modules_existing as $id => $titre) {
                $module = Module::where('formation_id', $formationId)->find($id);
                if ($module) {
                    $module->update(['titre' => $titre]);
                }
            }
        }

        // Ajouter les nouveaux modules
        if ($request->has('modules_new')) {
            foreach ($request->modules_new as $titre) {
                if (trim($titre) !== '') {
                    Module::create([
                        'titre' => $titre,
                        'formation_id' => $formationId
                    ]);
                }
            }
        }

        return response()->json(['success' => 'Modules mis à jour avec succès ✅']);
    }

    public function getModules($formationId)
    {
        $modules = Module::where('formation_id', $formationId)->get();

        return response()->json($modules);
    }

    public function deleteModule($moduleId)
    {
        try {
            $module = Module::findOrFail($moduleId);
            $module->delete();

            return response()->json([
                'success' => true,
                'message' => 'Module supprimé avec succès.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du module.'
            ], 500);
        }
    }

    public function listModules()
    {
        $modules = Module::with('formation')->paginate(10);
        return view('admin.layout.modules.list_modules', compact('modules'));
    }



    public function updateModule(UpdateModuleRequest $request, Module $module)
    {
        Log::info('Début updateModule');
        Log::info('Données reçues:', $request->all());

        try {
            $validated = $request->validated();
            $module->titre = $validated['titre'];
            $module->save();

            $module->load('formation');

            return response()->json([
                'success' => true,
                'message' => 'Module mis à jour avec succès.',
                'module' => $module
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur updateModule: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du module.',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function addLesson(Request $request, $moduleId)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'video' => 'required|file|mimes:mp4,avi,mov,wmv|max:102400',
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        try {
            $module = Module::findOrFail($moduleId);

            $lesson = new Lesson();
            $lesson->titre = $request->input('titre');
            $lesson->module_id = $moduleId;

            // Gestion de l'upload vidéo
            if ($request->hasFile('video')) {
                $videoPath = $request->file('video')->store('lessons/videos', 'public');
                $lesson->video_url = $videoPath;

                // Récupérer la durée avec FFmpeg
                $fullPath = storage_path("app/public/" . $videoPath);
                $lesson->duree = VideoService::getVideoDuration($fullPath);
            }

            // Gestion de l'upload PDF
            if ($request->hasFile('pdf')) {
                $pdfPath = $request->file('pdf')->store('lessons/pdfs', 'public');
                $lesson->pdf_url = $pdfPath;
            }

            $lesson->save();

            $lessonsCount = $module->lessons()->count();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Leçon ajoutée avec succès !',
                    'lesson' => $lesson,
                    'lessonsCount' => $lessonsCount
                ]);
            }

            return redirect()->back()->with('success', 'Leçon ajoutée avec succès !');
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'ajout de la leçon: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de l\'ajout de la leçon: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Erreur lors de l\'ajout de la leçon.');
        }
    }


    public function listLessons()
    {
        $lessons = Lesson::with(['module.formation'])->paginate(10);
        return view('admin.layout.lessons.list_lessons', compact('lessons'));
    }

    /**
     * Obtenir les leçons d'un module
     */
    public function getLessons($moduleId)
    {
        $module = Module::with('lessons')->findOrFail($moduleId);

        return response()->json([
            'success' => true,
            'lessons' => $module->lessons,
            'module' => $module
        ]);
    }


    /**
     * Supprimer une leçon
     */
    public function deleteLesson($lessonId, Request $request)
    {
        try {
            $lesson = Lesson::findOrFail($lessonId);

            // Supprimer les fichiers du stockage
            if ($lesson->video_url && Storage::disk('public')->exists($lesson->video_url)) {
                Storage::disk('public')->delete($lesson->video_url);
            }

            if ($lesson->pdf_url && Storage::disk('public')->exists($lesson->pdf_url)) {
                Storage::disk('public')->delete($lesson->pdf_url);
            }

            $lesson->delete();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Leçon supprimée avec succès.'
                ]);
            }

            return redirect()->back()->with('success', 'Leçon supprimée avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression de la leçon: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la suppression de la leçon.'
                ], 500);
            }

            return redirect()->back()->with('error', 'Erreur lors de la suppression de la leçon.');
        }
    }
    public function updateLesson(UpdateLessonRequest $request, $lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);

        $data = $request->validated();

        // ⚡ Gestion de la vidéo (champ video_url)
        if ($request->hasFile('video_url')) {
            $videoPath = $request->file('video_url')->store('lessons/videos', 'public');
            $data['video_url'] = $videoPath;

            // Récupérer la durée si nécessaire
            $fullPath = storage_path("app/public/" . $videoPath);
            $lesson->duree = VideoService::getVideoDuration($fullPath);
        }

        // ⚡ Gestion du PDF (champ pdf_url)
        if ($request->hasFile('pdf_url')) {
            $pdfPath = $request->file('pdf_url')->store('lessons/pdfs', 'public');
            $data['pdf_url'] = $pdfPath;
        }

        // Mise à jour de la leçon
        $lesson->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Leçon mise à jour avec succès.',
            'lesson' => $lesson
        ]);
    }


    public function destroyLesson($lessonId)
    {
        $lesson = Lesson::find($lessonId);
        $lesson->delete();

        return response()->json([
            'success' => true,
            'message' => 'Leçon supprimée avec succès.'
        ]);
    }

    // public function getObjectives(Formation $formation)
    // {
    //     $objectives = DB::table('objectifs')->where('formation_id', $formation->id)->get();
    //     return response()->json($objectives);
    // }

    public function getObjectives(Formation $formation)
    {
        try {
            // Utilisez le modèle Objectif si vous en avez un, sinon utilisez DB
            $objectives = DB::table('objectifs')
                ->where('formation_id', $formation->id)
                ->orderBy('id', 'asc')
                ->get();

            return response()->json($objectives);
        } catch (\Exception $e) {
            Log::error('Erreur récupération objectifs: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }

    public function Showpaiements()
    {

        $paiements = Paiement::with(['user', 'formation'])
            ->paginate(10);

        return view('admin.layout.formations.list_paiements', compact("paiements"));
    }

    public function ShowCertifications()
    {

        $certifications = user_formation::with(['user', 'formation'])
            ->whereNotNull('path_attestation') // on affiche seulement celles qui ont une attestation générée
            ->latest()
            ->get();

        return view('admin.layout.formations.certifications', compact('certifications'));
    }
}
