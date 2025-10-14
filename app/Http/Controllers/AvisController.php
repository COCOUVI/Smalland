<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvisController extends Controller
{
    // Enregistrement d'un avis
    public function store(Request $request, Formation $formation)
    {
        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'content_avis' => 'required|string|max:1000',
        ]);

        $existingAvis = Avis::where('formation_id', $formation->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingAvis) {
            return redirect()->back()->with('error', 'Vous avez déjà donné un avis pour cette formation.');
        }

        Avis::create([
            'note' => $request->note,
            'content_avis' => $request->content_avis,
            'formation_id' => $formation->id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Merci pour votre avis !');
    }

    // Formulaire d'édition
    public function edit(Formation $formation)
    {
        $avis = Avis::where('formation_id', $formation->id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Récupère la première formation suivie par l'utilisateur
        $firstFormation = Auth::user()->formations()->orderBy('pivot_created_at')->first();

        return view('avis.edit', compact('avis', 'formation', 'firstFormation'));
    }

    // Mise à jour
    public function update(Request $request, Formation $formation)
    {
        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'content_avis' => 'required|string|max:1000',
        ]);

        $avis = Avis::where('formation_id', $formation->id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $avis->update([
            'note' => $request->note,
            'content_avis' => $request->content_avis,
        ]);

        return redirect()->back()->with('success', 'Votre avis a été mis à jour.');
    }

    // Suppression
    public function destroy(Formation $formation)
    {
        $avis = Avis::where('formation_id', $formation->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($avis) {
            $avis->delete();

            return redirect()->back()->with('success', 'Votre avis a été supprimé.');
        }

        return redirect()->back()->with('error', 'Avis introuvable.');
    }
}
