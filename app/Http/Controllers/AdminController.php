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
        // Validation;

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

        // Redirection avec message de succès
        return redirect()->back()->with('success', 'Formation créée avec succès.');
    }
    public function ShowFormations()
    {

        $formations = Formation::paginate(5);

        return view('admin.layout.list_formations', compact('formations'));
    }

    public function GetOneFormation(Formation $formation)
    {

        return view('admin.layout.detail_formation', compact('formation'));
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
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('formations/'), $imageName);
            $formation->image_path = $imageName;
        }
        $formation->save();

        return redirect()->back()
            ->with('success', 'Formation mise à jour avec succès.');
    }
    public function DeleteFormation(Formation $formation)
    {
        $formation->delete();
        return redirect()->back()->with('success', 'formation supprimer avec succès');
    }

    public function  AddModule(StoreModuleRequest $request)
    {
        $module = new Module();
        $module->titre = $request->titre;
        $module->formation_id = $request->formation_id;
        $module->save();

        return response()->json(['success' => 'Module ajouté avec succès ✅']);
    }
}
