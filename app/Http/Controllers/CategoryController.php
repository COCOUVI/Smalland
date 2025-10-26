<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.layout.boutique.list_categorie', compact('categories'));
    }

    public function create()
    {
        return view('admin.layout.boutique.add_categorie');
    }

    public function store(Request $request)
    {
        $request->validate(['nom' => 'required|string|max:255']);
        Category::create(['nom' => $request->nom]);
        return redirect()->route('admin.categories.index')->with('success', 'Catégorie ajoutée avec succès');
    }
    public function edit($id)
{
    $category = Category::findOrFail($id);
    return response()->json($category);
}

public function update(Request $request, $id)
{
    $request->validate([
        'nom' => 'required|string|max:255'
    ]);

    $category = Category::findOrFail($id);
    $category->update(['nom' => $request->nom]);

    return response()->json(['success' => 'Catégorie mise à jour']);
}


public function destroy($id)
{
    $category = Category::findOrFail($id);
    $category->delete();
    return redirect()->route('admin.categories.index')->with('success', 'Catégorie supprimée avec succès');
}

}
