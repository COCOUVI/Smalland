<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormationRequest;
use App\Http\Requests\StoreModuleRequest;
use App\Http\Requests\UpdateFormationRequest;
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

    public function PutFormation(UpdateFormationRequest $request, Formation $formation)
    {
        $formation->titre = $request->titre;
        $formation->description = $request->description;
        $formation->price = $request->price;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('formations', 'public');
            $formation->image_path = $imagePath;
        }

        $formation->save();

        // Retour JSON pour AJAX ou redirection classique
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

    public function AddModule(StoreModuleRequest $request)
    {
        $module = new Module();
        $module->titre = $request->titre;
        $module->formation_id = $request->formation_id;
        $module->save();

        return response()->json(['success' => 'Module ajouté avec succès ✅']);
    }
}
