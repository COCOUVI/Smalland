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
                </tr>
            </thead>
            <tbody>
                @foreach($produits as $produit)
                <tr>
                    <td>
                        <img src="{{ asset('storage/'.$produit->path_img) }}" width="60" class="rounded" alt="Image produit">
                    </td>
                    <td>{{ $produit->nom }}</td>
                    <td>{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</td>
                    <td>{{ $produit->qte }}</td>
                    <td>{{ $produit->category->nom ?? '—' }}</td>
                    <td>
                        <span class="badge {{ $produit->statut_stock == 'disponible' ? 'bg-success' : 'bg-danger' }}">
                            {{ ucfirst($produit->statut_stock) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $produits->links() }}
    </div>
</div>
@endsection
