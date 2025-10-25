@extends('admin.master')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Liste des Produits</h4>
        <a href="{{ route('admin.produits.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Ajouter un produit
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Image</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Catégorie</th>
                    <th>Statut</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produits as $produit)
                <tr>
                    
                        <td><img src="{{ asset('storage/'.$produit->path_img) }}" width="60" class="rounded"></td>
                        <td>{{ $produit->nom }}</td>
                        <td>{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</td>
                        <td>{{ $produit->qte }}</td>
                        <td>{{ $produit->category->nom ?? '—' }}</td>
                                                <td>
                            @if($produit->qte >= 5)
                                <span class="badge bg-success">Disponible</span>
                            @elseif($produit->qte > 0)
                                <span class="badge bg-warning text-dark">Limite</span>
                            @else
                                <span class="badge bg-danger">Rupture</span>
                            @endif
                        </td>

                        <td>
                            <!-- Boutons -->
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $produit->id }}">
                                <i class="bi bi-pencil"></i>
                            </button>

                            <form action="{{ route('admin.produits.destroy', $produit->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce produit ?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal d'édition -->
                    <div class="modal fade" id="editModal{{ $produit->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $produit->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <form action="{{ route('admin.produits.update', $produit->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Modifier le produit : {{ $produit->nom }}</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nom</label>
                                <input type="text" name="nom" class="form-control" value="{{ $produit->nom }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3">{{ $produit->description }}</textarea>
                            </div>
                            <div class="mb-3 row">
                                <div class="col">
                                <label class="form-label">Prix (FCFA)</label>
                                <input type="number" name="prix" class="form-control" value="{{ $produit->prix }}">
                                </div>
                                <div class="col">
                                <label class="form-label">Quantité</label>
                                <input type="number" name="qte" class="form-control" value="{{ $produit->qte }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Catégorie</label>
                                <select name="category_id" class="form-select">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $produit->category_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->nom }}
                                    </option>
                                @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Statut</label>
                                <select name="statut_stock" class="form-select">
                                <option value="in_stock" {{ $produit->statut_stock == 'in_stock' ? 'selected' : '' }}>Disponible</option>
                                <option value="low_stock" {{ $produit->statut_stock == 'low_stock' ? 'selected' : '' }}>Quantité faible</option>
                                <option value="out_of_stock" {{ $produit->statut_stock == 'out_of_stock' ? 'selected' : '' }}>Rupture de stock</option>
                                 
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Image</label>
                                <input type="file" name="path_img" class="form-control">
                                @if($produit->path_img)
                                <img src="{{ asset('storage/'.$produit->path_img) }}" width="100" class="mt-2 rounded">
                                @endif
                            </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </form>
                        </div>
                    </div>
                    </div>

                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $produits->links() }}
    </div>
</div>
@endsection
