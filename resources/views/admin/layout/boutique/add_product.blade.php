@extends('admin.master')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-3">Ajouter un produit</h4>

    <form action="{{ route('admin.produits.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
        @csrf
        <div class="col-md-6">
            <label class="form-label">Nom du produit</label>
            <input type="text" name="nom" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Prix (FCFA)</label>
            <input type="number" name="prix" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Quantité</label>
            <input type="number" name="qte" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Catégorie</label>
            <select name="category_id" class="form-select" required>
                <option value="">-- Sélectionnez --</option>
                @foreach($categories as $categorie)
                    <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-12">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>

        <div class="col-md-6">
            <label class="form-label">Statut du stock</label>
            <select name="statut_stock" class="form-select" required>
                <option value="disponible">Disponible</option>
                <option value="rupture">Rupture</option>
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Image du produit</label>
            <input type="file" name="path_img" class="form-control" accept="image/*">
        </div>

        <div class="col-12 text-end">
            <button type="submit" class="btn btn-success">Enregistrer</button>
        </div>
    </form>
</div>
@endsection
