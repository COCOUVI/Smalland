<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;




class ProductController extends Controller
{
   public function index()
    {
        $produits = Product::with('category')->paginate(10);
        $categories = Category::all(); // ✅ On charge toutes les catégories
        return view('admin.layout.boutique.list_produit', compact('produits', 'categories'));
    }



    public function create()
    {
        $categories = Category::all();
        return view('admin.layout.boutique.add_product', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required',
            'prix' => 'required|numeric',
            'qte' => 'required|integer',
            'statut_stock' => 'required',
            'path_img' => 'file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',

            'category_id' => 'required|exists:categories,id',
        ]);

        $imagePath = $request->file('path_img') ? $request->file('path_img')->store('produits', 'public') : null;

        Product::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
            'qte' => $request->qte,
            'statut_stock' => $request->statut_stock,
            'path_img' => $imagePath,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('admin.produits.index')->with('success', 'Produit ajouté avec succès');
    }
   


    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required',
            'prix' => 'required|numeric',
            'qte' => 'required|integer',
            'statut_stock' => 'required',
            'path_img' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Si une nouvelle image est uploadée
        if ($request->hasFile('path_img')) {
            // Supprimer l'ancienne image si elle existe
            if ($product->path_img && Storage::disk('public')->exists($product->path_img)) {
                Storage::disk('public')->delete($product->path_img);
            }

            // Enregistrer la nouvelle image
            $product->path_img = $request->file('path_img')->store('produits', 'public');
        }

        // Mettre à jour les autres champs
        $product->update([
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
            'qte' => $request->qte,
            'statut_stock' => $request->statut_stock,
            'category_id' => $request->category_id,
            'path_img' => $product->path_img,
        ]);

        return redirect()->route('admin.produits.index')->with('success', 'Produit mis à jour avec succès');
    }

    public function destroy(Product $product)
    {
        // Supprimer l'image si elle existe
        if ($product->path_img && Storage::disk('public')->exists($product->path_img)) {
            Storage::disk('public')->delete($product->path_img);
        }

        $product->delete();

        return redirect()->route('admin.produits.index')->with('success', 'Produit supprimé avec succès');
    }


    public function shop(Request $request)
{
    // Charger toutes les catégories
    $categories = Category::all();

    // Filtrer les produits en stock (qte > 0)
    $query = Product::with('category')->where('qte', '>', 0);

    // Si une catégorie est sélectionnée
    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }

    // Tri optionnel
    if ($request->filled('sort')) {
        if ($request->sort == 'price_asc') {
            $query->orderBy('prix', 'asc');
        } elseif ($request->sort == 'price_desc') {
            $query->orderBy('prix', 'desc');
        } elseif ($request->sort == 'newest') {
            $query->latest();
        }
    }

    $produits = $query->paginate(12);

    return view('layouts.boutique.product-list', compact('produits', 'categories'));
}

public function voir(Product $product)
{
    return view('layouts.boutique.product-detail', compact('product'));
}

}