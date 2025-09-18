<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormationRequest;
use App\Http\Requests\StoreModuleRequest;
use App\Http\Requests\UpdateFormationRequest;
use App\Http\Requests\UpdateModuleRequest;
use App\Models\Formation;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        // Création d'une instance de Formation
        $formation = new Formation();
        $formation->titre = $request->input('title');
        $formation->description = $request->input('description');
        $formation->price = $request->input('price');

        // Gestion de l'image si fournie
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('formations', 'public');
            $formation->image_path = $imagePath;
        }

        // Sauvegarde dans la base
        $formation->save();

        // Retour JSON pour AJAX ou redirection classique
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Formation créée avec succès.',
                'formation' => $formation
            ]);
        }

        // Redirection avec message de succès (fallback)
        return redirect()->back()->with('success', 'Formation créée avec succès.');
    }

    public function ShowFormations()
    {
        $formations = Formation::paginate(5);
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
        $formation->titre = $request->input('titre');
        $formation->description = $request->input('description');
        $formation->price = $request->input('price');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('formations', 'public');
            $formation->image_path = $imagePath;
        }

        $formation->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Formation mise à jour avec succès.',
                'formation' => $formation
            ]);
        }

        return redirect()->back()
            ->with('success', 'Formation mise à jour avec succès.');
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

    // public function deleteModule($moduleId)
    // {
    //     $module = Module::findOrFail($moduleId);
    //     $module->delete();

    //     return response()->json(['success' => true]);
    // }


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
        $validated = $request->validated();

        $module->titre = $validated['titre'];
        $module->ordre = $validated['ordre'] ?? $module->ordre;
        $module->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Module mis à jour avec succès.',
                'module' => $module
            ]);
        }

        return redirect()->back()
            ->with('success', 'Module mis à jour avec succès.');
    }
}
