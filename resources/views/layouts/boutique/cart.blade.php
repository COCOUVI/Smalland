@extends('master')

@section('content')

<style>
    :root {
        --primary-color: #2e7d32;
        --secondary-color: #7cb342;
        --accent-color: #ffd54f;
        --light-color: #f5f5f5;
        --dark-color: #263238;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8f9fa;
    }

    .bg-primary { background-color: var(--primary-color) !important; }
    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    .btn-primary:hover {
        background-color: #1b5e20;
        border-color: #1b5e20;
    }

    .page-header {
        background-color: var(--primary-color);
        color: white;
        padding: 40px 0;
        margin-bottom: 40px;
    }

    .card {
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        margin-bottom: 20px;
    }

    .cart-item {
        padding: 20px 0;
        border-bottom: 1px solid #eee;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .quantity-selector {
        max-width: 150px;
    }

    .quantity-input {
        border-left: none !important;
        border-right: none !important;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .total {
        font-weight: bold;
        font-size: 1.2rem;
        border-top: 2px solid #eee;
        padding-top: 10px;
        margin-top: 10px;
    }

    .empty-cart {
        text-align: center;
        padding: 60px 0;
    }

    .empty-cart-icon {
        font-size: 5rem;
        color: #dee2e6;
        margin-bottom: 20px;
    }

    .product-price {
        font-weight: bold;
        color: var(--primary-color);
    }

    .stock-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .stock-low {
        background-color: #fff3cd;
        color: #856404;
    }

    .stock-ok {
        background-color: #d1e7dd;
        color: #0f5132;
    }
</style>

<div class="page-header text-center">
    <div class="container">
        <h1 class="display-5 fw-bold">Votre panier</h1>
        <p class="lead">Revoyez vos articles et procédez au paiement</p>
    </div>
</div>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Articles du panier -->
        <div class="col-lg-8">
            @if(isset($cartItems) && $cartItems->count() > 0)
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title mb-4">
                            <i class="bi bi-cart3 me-2"></i>
                            {{ $cartItems->count() }} article(s) dans votre panier
                        </h3>

                        @foreach($cartItems as $item)
                            <div class="cart-item">
                                <div class="row align-items-center">
                                    <!-- Image du produit -->
                                    <div class="col-3 col-md-2">
                                        @if($item->product->path_img)
                                            <img src="{{ asset('storage/' . $item->product->path_img) }}" 
                                                class="img-fluid rounded" 
                                                alt="{{ $item->product->nom }}"
                                                style="max-height: 100px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                style="height: 100px;">
                                                <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Informations du produit -->
                                    <div class="col-9 col-md-6">
                                        <h5 class="mb-1">{{ $item->product->nom }}</h5>
                                        <p class="text-muted mb-2 small">
                                            {{ Str::limit($item->product->description, 80) }}
                                        </p>
                                        
                                        <!-- Statut du stock -->
                                        @if($item->product->qte > 10)
                                            <span class="stock-badge stock-ok">
                                                <i class="bi bi-check-circle me-1"></i>En stock ({{ $item->product->qte }} disponibles)
                                            </span>
                                        @elseif($item->product->qte > 0)
                                            <span class="stock-badge stock-low">
                                                <i class="bi bi-exclamation-triangle me-1"></i>Stock limité ({{ $item->product->qte }} restants)
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="bi bi-x-circle me-1"></i>Rupture de stock
                                            </span>
                                        @endif

                                        <!-- Bouton supprimer -->
                                        <div class="mt-2">
                                            <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash"></i> Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Prix et quantité -->
                                    <div class="col-12 col-md-4 mt-3 mt-md-0">
                                        <div class="mb-2">
                                            <span class="product-price">
                                                {{ number_format($item->product->prix, 0, ',', ' ') }} FCFA
                                            </span>
                                            <span class="text-muted small">/unité</span>
                                        </div>
                                        
                                        <!-- Formulaire de mise à jour de quantité -->
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="update-cart-form">
                                            @csrf
                                            @method('PUT')
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <label class="form-label mb-0 small">Quantité :</label>
                                                <div class="input-group quantity-selector">
                                                    <button class="btn btn-outline-secondary btn-sm" type="button" onclick="changeQuantity(this, -1, {{ $item->product->qte }})">
                                                        <i class="bi bi-dash"></i>
                                                    </button>
                                                    <input type="number" 
                                                        name="qte" 
                                                        class="form-control form-control-sm text-center quantity-input" 
                                                        value="{{ $item->qte }}" 
                                                        min="1" 
                                                        max="{{ $item->product->qte }}"
                                                        style="width: 60px;">
                                                    <button class="btn btn-outline-secondary btn-sm" type="button" onclick="changeQuantity(this, 1, {{ $item->product->qte }})">
                                                        <i class="bi bi-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-primary w-100">
                                                <i class="bi bi-arrow-clockwise me-1"></i>Mettre à jour
                                            </button>
                                        </form>

                                        <!-- Sous-total -->
                                        <div class="text-end mt-2">
                                            <strong class="text-primary">
                                                Sous-total : {{ number_format($item->product->prix * $item->qte, 0, ',', ' ') }} FCFA
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="d-flex justify-content-between mt-4 flex-wrap gap-2">
                    <a href="{{ route('shop') }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-2"></i>Continuer mes achats
                    </a>
                    <form action="{{ route('cart.clear') }}" method="POST" class="d-inline" 
                        onsubmit="return confirm('Êtes-vous sûr de vouloir vider complètement le panier ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="bi bi-trash me-2"></i>Vider le panier
                        </button>
                    </form>
                </div>
            @else
                <!-- Panier vide -->
                <div class="empty-cart">
                    <i class="bi bi-cart-x empty-cart-icon"></i>
                    <h4>Votre panier est vide</h4>
                    <p class="text-muted">Ajoutez des produits pour commencer vos achats.</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary mt-3">
                        <i class="bi bi-shop me-2"></i>Découvrir nos produits
                    </a>
                </div>
            @endif
        </div>

        <!-- Récapitulatif de la commande -->
        @if(isset($cartItems) && $cartItems->count() > 0)
            <div class="col-lg-4">
                <div class="card sticky-top" style="top: 20px;">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Récapitulatif de la commande</h4>

                        <div class="summary-item">
                            <span>Sous-total ({{ $cartItems->count() }} articles)</span>
                            <span><strong>{{ number_format($total, 0, ',', ' ') }} FCFA</strong></span>
                        </div>

                        <div class="summary-item">
                            <span>Frais de livraison</span>
                            <span class="text-muted">Calculés au checkout</span>
                        </div>

                        <hr>

                        <div class="summary-item total">
                            <span>Total estimé</span>
                            <span class="text-primary">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                        </div>

                        <!-- Bouton de paiement -->
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg w-100 mt-3">
                            <i class="bi bi-credit-card me-2"></i>Procéder au paiement
                        </a>

                        <div class="mt-3 text-center">
                            <small class="text-muted">
                                <i class="bi bi-shield-check me-1"></i>
                                Paiement 100% sécurisé
                            </small>
                        </div>

                        <!-- Info livraison gratuite -->
                        @if($total < 50000)
                            @php
                                $remaining = 50000 - $total;
                            @endphp
                            <div class="alert alert-info mt-3 py-2">
                                <small>
                                    <i class="bi bi-info-circle me-1"></i>
                                    Plus que <strong>{{ number_format($remaining, 0, ',', ' ') }} FCFA</strong> 
                                    pour la livraison gratuite !
                                </small>
                            </div>
                        @else
                            <div class="alert alert-success mt-3 py-2">
                                <small>
                                    <i class="bi bi-gift me-1"></i>
                                    <strong>Félicitations !</strong> Vous bénéficiez de la livraison gratuite.
                                </small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
/**
 * Gérer l'incrémentation/décrémentation de la quantité
 */
function changeQuantity(btn, change, maxStock) {
    const input = btn.parentElement.querySelector('.quantity-input');
    const currentValue = parseInt(input.value);
    const newValue = currentValue + change;
    
    if (newValue >= 1 && newValue <= maxStock) {
        input.value = newValue;
    } else if (newValue > maxStock) {
        alert('Stock insuffisant. Maximum disponible : ' + maxStock);
    } else if (newValue < 1) {
        alert('La quantité minimale est 1');
    }
}

/**
 * Animation de suppression
 */
document.addEventListener('DOMContentLoaded', function() {
    const deleteForms = document.querySelectorAll('form[action*="cart/remove"]');
    
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const cartItem = this.closest('.cart-item');
            if (cartItem) {
                cartItem.style.transition = 'opacity 0.3s, transform 0.3s';
                cartItem.style.opacity = '0';
                cartItem.style.transform = 'translateX(20px)';
            }
        });
    });
});
</script>

@endsection