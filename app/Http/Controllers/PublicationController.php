<?php


namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\PubCategory;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
     // Afficher la liste des publications et catégories
    public function index1(Request $request)
    {
        // Récupération de toutes les catégories avec le nombre de publications
        $categories = PubCategory::withCount('publications')->get();

        // Récupération des publications, triées par date décroissante
        $publications = Publication::with('category')
            ->where('status', 'publish') // optionnel : si tu as un statut
            ->orderBy('created_at', 'desc')
            ->paginate(6); // pagination 6 articles par page

        // Si filtrage par catégorie (optionnel)
       /* if ($request->has('category')) {
            $publication = Publication::with('category')
                ->whereHas('category', function ($query) use ($request) {
                    $query->where('id', $request->category);
                })
                ->orderBy('created_at', 'desc')
                ->paginate(6);
        }*/

        return view('layouts.blog.blog-list', compact('publications', 'categories'));
    }
    public function show($id)
    {
        $article = Publication::with('category')->findOrFail($id);
        return view('layouts.blog.blog-article', compact('article'));
    }

     // Afficher la liste des catégories
    public function categories()
    {
        $categories = PubCategory::withCount('publications')->get();
        return view('layouts.blog.blog-category', compact('categories'));
    }

    // Afficher les articles d'une catégorie
    public function articles($id)
    {
        $category = PubCategory::findOrFail($id);
        $articles = Publication::where('pub_category_id', $id)->where('status', 'publish')->latest()->get();
        return view('layouts.blog.blog-articles', compact('category', 'articles'));
    }

    // Afficher un article en particulier

    public function index()
    {
        $publications = Publication::with('category')->latest()->paginate(10);
        return view('admin.layout.blog.blog', compact('publications'));
    }

    public function create()
    {
        $categories = PubCategory::all();
        return view('admin.layout.blog.create-article', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
            'pub_category_id' => 'required|exists:pub_categories,id',
            'author' => 'required|string|max:100',
            'tags' => 'nullable|string',
            'status' => 'required|in:Publish,Draft,Pending',
        ]);

        $data = $request->only(['titre', 'content', 'pub_category_id', 'author', 'tags', 'status']);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('publications', 'public');
        }

        Publication::create($data);

        return redirect()->route('publications.index')->with('success', 'Publication ajoutée avec succès');
    }

    public function edit(Publication $publication)
    {
        $categories = PubCategory::all();
        return view('admin.layout.blog.create-article', compact('publication', 'categories'));
    }

    public function update(Request $request, Publication $publication)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
            'pub_category_id' => 'required|exists:pub_categories,id',
            'author' => 'required|string|max:100',
            'tags' => 'nullable|string',
            'status' => 'required|in:Publish,Draft,Pending',
        ]);

        $data = $request->only(['titre', 'content', 'pub_category_id', 'author', 'tags', 'status']);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('publications', 'public');
        }

        $publication->update($data);

        return redirect()->route('publications.index')->with('success', 'Publication mise à jour avec succès');
    }

    public function destroy(Publication $publication)
    {
        $publication->delete();
        return redirect()->route('publications.index')->with('success', 'Publication supprimée avec succès');
    }



    //Afficher la liste des catégories
    public function listCategories()
    {
        $categorie = PubCategory::all();
        return view('admin.layout.blog.category', compact('categorie'));
    }

    // Afficher le formulaire d’ajout
    public function createCategory()
    {
        return view('admin.add_cat');
    }

    // Enregistrer une catégorie
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:Pub_categories,name',
        ]);

        $cat = new PubCategory();
        $cat->name = $request->name;
        $cat->save();

        return redirect()->route('admin.listCategories')->with('success', 'Catégorie ajoutée avec succès ✅');
    }
        // Modifier une catégorie
    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:Pub_categories,name,' . $id,
            'description' => 'nullable|string|max:500',
        ]);

        $cat = PubCategory::findOrFail($id);
        $cat->name = $request->name;
        $cat->description = $request->description;
        $cat->save();

        return redirect()->route('admin.listCategories')->with('success', 'Catégorie modifiée avec succès ✅');
    }


    // Supprimer une catégorie
    public function deleteCategory($id)
    {
        $cat = PubCategory::findOrFail($id);
        $cat->delete();

        return redirect()->route('admin.listCategories')->with('success', 'Catégorie supprimée avec succès ');
    }

}
