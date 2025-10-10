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
}
