@extends('master')

@section('content')
<style>
.card-img-top {
    height: 220px; /* tu peux ajuster ici */
    object-fit: cover;
    width: 100%;
    border-top-left-radius: 0.5rem;
    border-top-right-radius: 0.5rem;
}
</style>

<div class="page-header text-center py-5 bg-light">
    <h1 class="display-5 fw-bold">Boutique Small Land</h1>
    <p class="lead">Découvrez notre sélection de produits pour l'agriculture et le jardinage</p>
</div>

<div class="container py-4">
    <!-- Filtres -->
    <form method="GET" action="{{ route('shop') }}" class="mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Catégorie</label>
                <select name="category_id" class="form-select" onchange="this.form.submit()">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Trier par</label>
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="">Pertinence</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Nouveautés</option>
                </select>
            </div>
        </div>
    </form>

    <!-- Liste des produits -->
    <div class="row">
        @forelse($produits as $produit)
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <span class="category-badge badge bg-primary position-absolute m-2">
                        {{ $produit->category->nom ?? 'Sans catégorie' }}
                    </span>
                    <span class="stock-badge badge {{ $produit->statut_stock == 'disponible' ? 'bg-success' : 'bg-warning text-dark' }} position-absolute end-0 m-2">
                        {{ ucfirst($produit->statut_stock) }}
                    </span>

                    <img src="{{ asset('storage/'.$produit->path_img) }}" class="card-img-top" alt="{{ $produit->nom }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $produit->nom }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($produit->description, 60) }}</p>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold h5 text-primary">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</span>

                            <td>
                                <a href="{{ route('admin.produits.voir', $produit->id) }}" class="btn btn-info btn-sm">
                                    <i class="bi bi-eye"></i> Voir
                                </a>
                            </td>

                            <button class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted">Aucun produit trouvé.</p>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $produits->links() }}
    </div>
</div>
@endsection
