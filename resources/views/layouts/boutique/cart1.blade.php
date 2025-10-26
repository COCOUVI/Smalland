@extends('master')

@section('content')
    <style>
    /* (On garde exactement ton CSS tel quel ici) */
    </style>
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
            
            .navbar {
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            }
            
            .bg-primary {
                background-color: var(--primary-color) !important;
            }
            
            .btn-primary {
                background-color: var(--primary-color);
                border-color: var(--primary-color);
            }
            
            .btn-primary:hover {
                background-color: #1b5e20;
                border-color: #1b5e20;
            }
            
            .text-primary {
                color: var(--primary-color) !important;
            }
            
            .page-header {
                background-color: var(--primary-color);
                color: white;
                padding: 40px 0;
                margin-bottom: 40px;
            }
            
            .card {
                transition: transform 0.3s, box-shadow 0.3s;
                margin-bottom: 20px;
                border: none;
                box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            }
            
            .footer {
                background-color: var(--dark-color);
                color: white;
                padding: 40px 0;
            }
            
            .cart-item {
                padding: 20px 0;
                border-bottom: 1px solid #eee;
            }
            
            .cart-item:last-child {
                border-bottom: none;
            }
            
            .quantity-selector {
                width: 120px;
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
            
            .promo-code {
                background-color: #f8f9fa;
                border-left: 4px solid var(--primary-color);
                padding: 15px;
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
        </style>


    <div class="page-header text-center">
        <div class="container">
            <h1 class="display-5 fw-bold">Votre panier</h1>
            <p class="lead">Revoyez vos articles et procédez au paiement</p>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <!-- ✅ Partie gauche : Articles -->
            <div class="col-lg-8">
                @if(isset($cart) && $cart && $cart->items->count() > 0)
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title mb-4">
                                {{ $cart->items->count() }} article(s) dans votre panier
                            </h3>

                            @foreach($cart->items as $item)
                                <div class="cart-item">
                                    <div class="row align-items-center">
                                        <div class="col-3 col-md-2">
                                            <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                class="img-fluid rounded" 
                                                alt="{{ $item->product->name }}">
                                        </div>
                                        <div class="col-9 col-md-6">
                                            <h5 class="mb-1">{{ $item->product->name }}</h5>
                                            <p class="text-muted mb-2">{{ Str::limit($item->product->description, 60) }}</p>
                                            <div class="d-flex">
                                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i> Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 mt-3 mt-md-0">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="product-price">{{ number_format($item->price, 2, ',', ' ') }}€</span>
                                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline-flex quantity-selector">
                                                    @csrf
                                                    @method('PUT')
                                                    <button class="btn btn-outline-secondary" type="submit" name="action" value="decrease">-</button>
                                                    <input type="number" class="form-control text-center" name="quantity" value="{{ $item->quantity }}" min="1">
                                                    <button class="btn btn-outline-secondary" type="submit" name="action" value="increase">+</button>
                                                </form>
                                            </div>
                                            <div class="text-end">
                                                <strong>Sous-total : {{ number_format($item->price * $item->quantity, 2, ',', ' ') }}€</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-left me-2"></i>Continuer mes achats
                        </a>
                        <a href="" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise me-2"></i>Actualiser le panier
                        </a>
                    </div>
                @else
                    <div class="empty-cart">
                        <i class="bi bi-cart-x empty-cart-icon"></i>
                        <h4>Votre panier est vide</h4>
                        <p class="text-muted">Ajoutez des produits pour commencer vos achats.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Voir nos produits</a>
                    </div>
                @endif
            </div>

            <!-- ✅ Partie droite : Récapitulatif -->
            @if($cart && $cart->items->count() > 0)
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Récapitulatif de la commande</h4>
                            <div class="summary-item">
                                <span>Sous-total</span>
                                <span>{{ number_format($cart->items->sum(fn($i) => $i->price * $i->quantity), 2, ',', ' ') }}€</span>
                            </div>
                            <div class="summary-item">
                                <span>Frais d'expédition</span>
                                <span>4,90€</span>
                            </div>
                            <div class="summary-item total">
                                <span>Total TTC</span>
                                <span>{{ number_format($cart->items->sum(fn($i) => $i->price * $i->quantity) + 4.90, 2, ',', ' ') }}€</span>
                            </div>

                            <a href="" class="btn btn-primary btn-lg w-100 mt-3">
                                Procéder au paiement
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fonctionnalités interactives pour le panier
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion des quantités
            const quantityButtons = document.querySelectorAll('.quantity-selector .btn');
            quantityButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.parentNode.querySelector('input');
                    let value = parseInt(input.value);
                    
                    if (this.textContent === '+') {
                        input.value = value + 1;
                    } else if (this.textContent === '-' && value > 1) {
                        input.value = value - 1;
                    }
                    
                    // Ici, on pourrait recalculer le sous-total et le total
                    updateCartTotals();
                });
            });
            
            // Gestion de la suppression d'articles
            const deleteButtons = document.querySelectorAll('.btn-outline-danger');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const cartItem = this.closest('.cart-item');
                    cartItem.style.opacity = '0';
                    setTimeout(() => {
                        cartItem.remove();
                        updateCartTotals();
                    }, 300);
                });
            });
            
            // Simulation de la mise à jour des totaux
            function updateCartTotals() {
                // Dans une implémentation réelle, on calculerait les totaux
                console.log('Mise à jour des totaux du panier');
            }
        });
    </script>
@endsection
