@extends('master')

@section('content')

<style>
    :root {
        --primary-color: #2e7d32;
        --secondary-color: #7cb342;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: white;
        padding: 60px 0;
        margin-bottom: 40px;
    }

    .card {
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: transform 0.3s, box-shadow 0.3s;
        height: 100%;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .card-img-top {
        height: 250px;
        object-fit: cover;
        width: 100%;
    }

    .category-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 10;
        font-size: 0.75rem;
    }

    .stock-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 10;
        font-size: 0.75rem;
    }

    .product-price {
        color: var(--primary-color);
        font-weight: bold;
        font-size: 1.25rem;
    }

    .btn-add-cart {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }

    .btn-add-cart:hover {
        background-color: #1b5e20;
        border-color: #1b5e20;
        color: white;
    }

    .empty-products {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon {
        font-size: 5rem;
        color: #dee2e6;
    }
</style>

<div class="page-header text-center">
    <div class="container">
        <h1 class="display-4 fw-bold">Boutique Small Land</h1>
        <p class="lead">Découvrez notre sélection de produits pour l'agriculture et le jardinage</p>
    </div>
</div>

<div class="container py-4">
    <!-- Messages de session -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filtres -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('shop') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label fw-bold">
                            <i class="bi bi-funnel me-1"></i>Catégorie
                        </label>
                        <select name="category_id" class="form-select" onchange="this.form.submit()">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-5">
                        <label class="form-label fw-bold">
                            <i class="bi bi-sort-down me-1"></i>Trier par
                        </label>
                        <select name="sort" class="form-select" onchange="this.form.submit()">
                            <option value="">Pertinence</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                Prix croissant
                            </option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                Prix décroissant
                            </option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                                Nouveautés
                            </option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        @if(request('category_id') || request('sort'))
                            <a href="{{ route('shop') }}" class="btn btn-outline-secondary w-100">
                                <i class="bi bi-x-circle me-1"></i>Réinitialiser
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Nombre de résultats -->
    <div class="mb-3">
        <p class="text-muted">
            <strong>{{ $produits->total() }}</strong> produit(s) trouvé(s)
        </p>
    </div>

    <!-- Liste des produits -->
    <div class="row">
        @forelse($produits as $produit)
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card">
                    <div class="position-relative">
                        <!-- Badge catégorie -->
                        <span class="category-badge badge bg-primary">
                            {{ $produit->category->nom ?? 'Sans catégorie' }}
                        </span>
                        
                        <!-- Badge stock -->
                        @if($produit->qte > 10)
                            <span class="stock-badge badge bg-success">En stock</span>
                        @elseif($produit->qte > 0)
                            <span class="stock-badge badge bg-warning text-dark">Stock limité</span>
                        @else
                            <span class="stock-badge badge bg-danger">Rupture</span>
                        @endif

                        <!-- Image -->
                        @if($produit->path_img)
                            <img src="{{ asset('storage/' . $produit->path_img) }}" 
                                class="card-img-top" 
                                alt="{{ $produit->nom }}">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center">
                                <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">{{ Str::limit($produit->nom, 40) }}</h5>
                        <p class="card-text text-muted small">
                            {{ Str::limit($produit->description, 60) }}
                        </p>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="product-price">
                                {{ number_format($produit->prix, 0, ',', ' ') }} FCFA
                            </span>
                            <small class="text-muted">
                                <i class="bi bi-box-seam me-1"></i>{{ $produit->qte }} dispo
                            </small>
                        </div>

                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.produits.voir', $produit->id) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye me-1"></i>Voir détails
                            </a>

                            @auth
                                @if($produit->qte > 0)
                                    <form action="{{ route('cart.add', $produit->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="qte" value="1">
                                        <button type="submit" class="btn btn-add-cart btn-sm w-100">
                                            <i class="bi bi-cart-plus me-1"></i>Ajouter au panier
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary btn-sm w-100" disabled>
                                        <i class="bi bi-x-circle me-1"></i>Rupture de stock
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-add-cart btn-sm">
                                    <i class="bi bi-box-arrow-in-right me-1"></i>Connectez-vous
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-products">
                    <i class="bi bi-inbox empty-icon"></i>
                    <h4 class="mt-3">Aucun produit trouvé</h4>
                    <p class="text-muted">Essayez de modifier vos filtres ou revenez plus tard.</p>
                    @if(request('category_id') || request('sort'))
                        <a href="{{ route('shop') }}" class="btn btn-primary mt-3">
                            <i class="bi bi-arrow-clockwise me-2"></i>Réinitialiser les filtres
                        </a>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($produits->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $produits->appends(request()->query())->links() }}
        </div>
    @endif
</div>

@endsection