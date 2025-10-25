<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Admin - Liste des produits
     */
    public function index()
    {
        $produits = Product::with('category')->paginate(10);
        $categories = Category::all();
        return view('admin.layout.boutique.list_produit', compact('produits', 'categories'));
    }

    /**
     * Admin - Formulaire de création
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.layout.boutique.add_product', compact('categories'));
    }

    /**
     * Admin - Enregistrement d'un nouveau produit
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required',
            'prix' => 'required|numeric|min:0',
            'qte' => 'required|integer|min:0',
            'path_img' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        $imagePath = null;
        if ($request->hasFile('path_img')) {
            $imagePath = $request->file('path_img')->store('produits', 'public');
        }

        // Déterminer automatiquement le statut du stock
        $statusStock = $this->determineStockStatus($request->qte);

        Product::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
            'qte' => $request->qte,
            'status_stock' => $statusStock,
            'path_img' => $imagePath,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('products.index')->with('success', 'Produit ajouté avec succès');
    }

    /**
     * Admin - Formulaire de modification
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.layout.boutique.edit_product', compact('product', 'categories'));
    }

    /**
     * Admin - Mise à jour d'un produit
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required',
            'prix' => 'required|numeric|min:0',
            'qte' => 'required|integer|min:0',
            'path_img' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Gestion de l'image
        if ($request->hasFile('path_img')) {
            // Supprimer l'ancienne image
            if ($product->path_img && Storage::disk('public')->exists($product->path_img)) {
                Storage::disk('public')->delete($product->path_img);
            }
            $product->path_img = $request->file('path_img')->store('produits', 'public');
        }

        // Déterminer le statut du stock
        $statusStock = $this->determineStockStatus($request->qte);

        // Mise à jour
        $product->update([
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
            'qte' => $request->qte,
            'status_stock' => $statusStock,
            'category_id' => $request->category_id,
            'path_img' => $product->path_img,
        ]);

        return redirect()->route('products.index')->with('success', 'Produit mis à jour avec succès');
    }

    /**
     * Admin - Suppression d'un produit
     */
    public function destroy(Product $product)
    {
        // Supprimer l'image
        if ($product->path_img && Storage::disk('public')->exists($product->path_img)) {
            Storage::disk('public')->delete($product->path_img);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produit supprimé avec succès');
    }

    /**
     * CLIENT - Liste des produits (Boutique)
     */
    public function shop(Request $request)
    {
        $categories = Category::all();

        // Filtrer les produits en stock
        $query = Product::with('category')->where('qte', '>', 0);

        // Filtre par catégorie
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Tri
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('prix', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('prix', 'desc');
                    break;
                case 'newest':
                    $query->latest();
                    break;
            }
        }

        $produits = $query->paginate(12);

        return view('layouts.boutique.product-list', compact('produits', 'categories'));
    }

    /**
     * CLIENT - Détails d'un produit
     */
    public function voir(Product $product)
    {
        return view('layouts.boutique.product-detail', compact('product'));
    }

    /**
     * Déterminer le statut du stock automatiquement
     */
    private function determineStockStatus($quantity)
    {
        if ($quantity == 0) {
            return 'out_of_stock';
        } elseif ($quantity <= 5) {
            return 'low_stock';
        } else {
            return 'in_stock';
        }
    }
}