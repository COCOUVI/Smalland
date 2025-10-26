@extends('master')

@section('content')

<style>
    :root {
        --primary-color: #2e7d32;
        --secondary-color: #7cb342;
    }

    .product-header {
        padding: 40px 0;
    }

    .main-image img {
        max-height: 500px;
        width: 100%;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .product-price {
        color: var(--primary-color);
        font-weight: bold;
    }

    .quantity-selector {
        max-width: 150px;
    }

    .stock-badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 500;
        display: inline-block;
    }

    .stock-in { background-color: #d1e7dd; color: #0f5132; }
    .stock-low { background-color: #fff3cd; color: #856404; }
    .stock-out { background-color: #f8d7da; color: #842029; }

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

    .feature-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .feature-icon {
        width: 40px;
        height: 40px;
        background-color: #e8f5e9;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        color: var(--primary-color);
    }
</style>

<div class="product-header">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('accueil') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shop') }}">Boutique</a></li>
                @if($product->category)
                    <li class="breadcrumb-item">
                        <a href="{{ route('shop', ['category_id' => $product->category->id]) }}">
                            {{ $product->category->nom }}
                        </a>
                    </li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $product->nom }}</li>
            </ol>
        </nav>

        <!-- Messages -->
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

        <div class="row">
            <!-- Image principale -->
            <div class="col-lg-6">
                <div class="main-image mb-3">
                    @if($product->path_img)
                        <img src="{{ asset('storage/' . $product->path_img) }}" 
                            class="img-fluid" 
                            alt="{{ $product->nom }}" 
                            id="mainImage">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                            style="height: 500px;">
                            <i class="bi bi-image text-muted" style="font-size: 5rem;"></i>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Détails du produit -->
            <div class="col-lg-6">
                <!-- Badge stock -->
                @if($product->qte > 10)
                    <span class="stock-badge stock-in">
                        <i class="bi bi-check-circle me-1"></i>En stock ({{ $product->qte }} disponibles)
                    </span>
                @elseif($product->qte > 0)
                    <span class="stock-badge stock-low">
                        <i class="bi bi-exclamation-triangle me-1"></i>Stock limité ({{ $product->qte }} restants)
                    </span>
                @else
                    <span class="stock-badge stock-out">
                        <i class="bi bi-x-circle me-1"></i>Rupture de stock
                    </span>
                @endif

                <!-- Titre -->
                <h1 class="display-5 fw-bold mt-3 mb-2">{{ $product->nom }}</h1>

                <!-- Catégorie -->
                @if($product->category)
                    <p class="text-muted mb-3">
                        <i class="bi bi-tag me-1"></i>
                        <a href="{{ route('shop', ['category_id' => $product->category->id]) }}" 
                            class="text-decoration-none">
                            {{ $product->category->nom }}
                        </a>
                    </p>
                @endif

                <!-- Prix -->
                <div class="product-price display-6 mb-4">
                    {{ number_format($product->prix, 0, ',', ' ') }} FCFA
                </div>

                <!-- Description -->
                <p class="lead mb-4">{{ $product->description ?? 'Aucune description disponible.' }}</p>

                <hr class="my-4">

                <!-- Formulaire d'ajout au panier -->
                @auth
                    @if($product->qte > 0)
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" id="addToCartForm">
                            @csrf
                            <div class="mb-4">
                                <label for="quantity" class="form-label fw-bold">
                                    <i class="bi bi-123 me-1"></i>Quantité
                                </label>
                                <div class="input-group quantity-selector">
                                    <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity()">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <input type="number" 
                                        class="form-control text-center" 
                                        id="quantity" 
                                        name="qte" 
                                        value="1" 
                                        min="1" 
                                        max="{{ $product->qte }}" 
                                        required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity()">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex mb-4">
                                <button type="submit" class="btn btn-add-cart btn-lg flex-grow-1">
                                    <i class="bi bi-cart-plus me-2"></i>Ajouter au panier
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-warning mb-4">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Ce produit est actuellement en rupture de stock.
                        </div>
                    @endif
                @else
                    <div class="alert alert-info mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        Veuillez <a href="{{ route('login') }}" class="alert-link">vous connecter</a> 
                        pour ajouter ce produit au panier.
                    </div>
                    <div class="d-grid">
                        <a href="{{ route('login') }}" class="btn btn-add-cart btn-lg">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                        </a>
                    </div>
                @endauth

                <hr class="my-4">

                <!-- Avantages -->
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div>
                        <strong>Livraison gratuite</strong>
                        <p class="text-muted mb-0 small">Pour les commandes supérieures à 50 000 FCFA</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>
                    <div>
                        <strong>Retours gratuits</strong>
                        <p class="text-muted mb-0 small">Sous 14 jours</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div>
                        <strong>Paiement sécurisé</strong>
                        <p class="text-muted mb-0 small">Transactions 100% sécurisées</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Description complète -->
<div class="container py-5">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <h3 class="mb-4">
                <i class="bi bi-info-circle me-2"></i>Description détaillée
            </h3>
            <p class="lead">{{ $product->description ?? 'Aucune description disponible.' }}</p>
        </div>
    </div>

    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('shop') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Retour à la boutique
        </a>
        
        @if($product->category)
            <a href="{{ route('shop', ['category_id' => $product->category->id]) }}" class="btn btn-outline-primary">
                <i class="bi bi-grid me-2"></i>Voir plus dans {{ $product->category->nom }}
            </a>
        @endif
    </div>
</div>

<script>
const maxQuantity = {{ $product->qte }};

function increaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const currentValue = parseInt(quantityInput.value);
    if (currentValue < maxQuantity) {
        quantityInput.value = currentValue + 1;
    } else {
        alert('Stock maximum atteint : ' + maxQuantity);
    }
}

function decreaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const currentValue = parseInt(quantityInput.value);
    if (currentValue > 1) {
        quantityInput.value = currentValue - 1;
    }
}

// Validation avant soumission
document.getElementById('addToCartForm')?.addEventListener('submit', function(e) {
    const quantity = parseInt(document.getElementById('quantity').value);
    if (quantity < 1 || quantity > maxQuantity) {
        e.preventDefault();
        alert('Quantité invalide. Veuillez choisir entre 1 et ' + maxQuantity);
    }
});
</script>

@endsection