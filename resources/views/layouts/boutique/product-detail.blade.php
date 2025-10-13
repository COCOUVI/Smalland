@extends('master')
@section('content')
    <!-- En-tête du produit -->
    <div class="product-header">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('accueil') }}">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('shop') }}">Boutique</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->nom }}</li>
                </ol>
            </nav>
            
            <div class="row">
                <!-- Image principale -->
                <div class="col-lg-6">
                    <div class="main-image mb-3">
                        <img src="{{ asset('storage/' . $product->path_img) }}" 
                            class="img-fluid rounded" 
                            alt="{{ $product->nom }}" 
                            id="mainImage">
                    </div>
                </div>
                
                <!-- Détails du produit -->
                <div class="col-lg-6">
                    <span class="badge {{ $product->statut_stock == 'disponible' ? 'bg-success' : 'bg-danger' }}">
                        {{ ucfirst($product->statut_stock) }}
                    </span>

                    <h1 class="display-5 fw-bold mt-2">{{ $product->nom }}</h1>

                    <div class="product-price display-6 mb-3">
                        {{ number_format($product->prix, 0, ',', ' ') }} FCFA
                    </div>

                    <p class="lead">{{ $product->description }}</p>

                    <div class="d-flex align-items-center mb-3">
                        <label class="me-3">Quantité :</label>
                        <div class="input-group quantity-selector">
                            <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity()">-</button>
                            <input type="number" class="form-control text-center" value="1" min="1" max="{{ $product->qte }}" id="quantity">
                            <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity()">+</button>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex mb-4">
                        <button class="btn btn-primary btn-lg flex-grow-1">
                            <i class="bi bi-cart-plus me-2"></i> Ajouter au panier
                        </button>
                        <button class="btn btn-outline-primary btn-lg">
                            <i class="bi bi-heart"></i>
                        </button>
                    </div>

                    <div class="d-flex flex-wrap">
                        <div class="me-4 mb-2">
                            <i class="bi bi-truck text-primary me-1"></i>
                            <span>Livraison gratuite</span>
                        </div>
                        <div class="me-4 mb-2">
                            <i class="bi bi-arrow-repeat text-primary me-1"></i>
                            <span>Retours gratuits</span>
                        </div>
                        <div class="mb-2">
                            <i class="bi bi-shield-check text-primary me-1"></i>
                            <span>Paiement sécurisé</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Description -->
    <div class="container py-5">
        <div class="card mb-5">
            <div class="card-body">
                <h3 class="section-title">Description du produit</h3>
                <p>{{ $product->description ?? 'Aucune description disponible.' }}</p>
            </div>
        </div>

        <a href="{{ route('shop') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour à la boutique
        </a>
    </div>

    <script>
        function increaseQuantity() {
            const quantityInput = document.getElementById('quantity');
            if (parseInt(quantityInput.value) < parseInt(quantityInput.max)) {
                quantityInput.value = parseInt(quantityInput.value) + 1;
            }
        }

        function decreaseQuantity() {
            const quantityInput = document.getElementById('quantity');
            if (parseInt(quantityInput.value) > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
            }
        }
    </script>
@endsection
