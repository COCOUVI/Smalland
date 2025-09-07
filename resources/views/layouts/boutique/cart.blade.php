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
<!-- En-tête de page -->
    <div class="page-header">
        <div class="container text-center">
            <h1 class="display-5 fw-bold">Votre panier</h1>
            <p class="lead">Revoyez vos articles et procédez au paiement</p>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="container">
        <!-- Panier avec articles -->
        <div class="row">
            <!-- Articles du panier -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title mb-4">3 articles dans votre panier</h3>
                        
                        <!-- Article 1 -->
                        <div class="cart-item">
                            <div class="row">
                                <div class="col-3 col-md-2">
                                    <img src="https://images.unsplash.com/photo-1595341888016-a392ef81b7de?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="img-fluid rounded" alt="Kit jardinage">
                                </div>
                                <div class="col-9 col-md-6">
                                    <h5 class="mb-1">Kit de jardinage débutant</h5>
                                    <p class="text-muted mb-2">Tout le nécessaire pour commencer votre potager.</p>
                                    <div class="rating small mb-2">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-half"></i>
                                        <span class="ms-1">(35)</span>
                                    </div>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i> Supprimer
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary ms-2">
                                            <i class="bi bi-heart"></i> Ajouter aux favoris
                                        </button>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 mt-3 mt-md-0">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="product-price">39,90€</span>
                                        <div class="input-group quantity-selector">
                                            <button class="btn btn-outline-secondary" type="button">-</button>
                                            <input type="number" class="form-control text-center" value="1" min="1">
                                            <button class="btn btn-outline-secondary" type="button">+</button>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <strong>Sous-total: 39,90€</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Article 2 -->
                        <div class="cart-item">
                            <div class="row">
                                <div class="col-3 col-md-2">
                                    <img src="https://images.unsplash.com/photo-1471194402529-8e0f5a675de6?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="img-fluid rounded" alt="Graines bio">
                                </div>
                                <div class="col-9 col-md-6">
                                    <h5 class="mb-1">Coffret graines bio</h5>
                                    <p class="text-muted mb-2">15 variétés de légumes et herbes aromatiques biologiques.</p>
                                    <div class="rating small mb-2">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <span class="ms-1">(47)</span>
                                    </div>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i> Supprimer
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary ms-2">
                                            <i class="bi bi-heart"></i> Ajouter aux favoris
                                        </button>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 mt-3 mt-md-0">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="product-price">24,90€</span>
                                        <div class="input-group quantity-selector">
                                            <button class="btn btn-outline-secondary" type="button">-</button>
                                            <input type="number" class="form-control text-center" value="2" min="1">
                                            <button class="btn btn-outline-secondary" type="button">+</button>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <strong>Sous-total: 49,80€</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Article 3 -->
                        <div class="cart-item">
                            <div class="row">
                                <div class="col-3 col-md-2">
                                    <img src="https://images.unsplash.com/photo-1596461404969-9b70b3e2a60d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="img-fluid rounded" alt="Arrosoir">
                                </div>
                                <div class="col-9 col-md-6">
                                    <h5 class="mb-1">Arrosoir écologique</h5>
                                    <p class="text-muted mb-2">Fabriqué à partir de matériaux recyclés, capacité 10L.</p>
                                    <div class="rating small mb-2">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-half"></i>
                                        <i class="bi bi-star"></i>
                                        <span class="ms-1">(18)</span>
                                    </div>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i> Supprimer
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary ms-2">
                                            <i class="bi bi-heart"></i> Ajouter aux favoris
                                        </button>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 mt-3 mt-md-0">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="product-price">32,50€</span>
                                        <div class="input-group quantity-selector">
                                            <button class="btn btn-outline-secondary" type="button">-</button>
                                            <input type="number" class="form-control text-center" value="1" min="1">
                                            <button class="btn btn-outline-secondary" type="button">+</button>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <strong>Sous-total: 32,50€</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Code promo -->
                <div class="card mt-4">
                    <div class="card-body promo-code">
                        <h5 class="card-title">Code promo</h5>
                        <p class="text-muted">Entrez votre code promo si vous en avez un.</p>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Votre code promo">
                            <button class="btn btn-primary">Appliquer</button>
                        </div>
                    </div>
                </div>
                
                <!-- Poursuite des achats -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="products-catalog.html" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-2"></i>Continuer mes achats
                    </a>
                    <button class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise me-2"></i>Actualiser le panier
                    </button>
                </div>
            </div>
            
            <!-- Récapitulatif -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Récapitulatif de la commande</h4>
                        
                        <div class="summary-item">
                            <span>Sous-total (3 articles)</span>
                            <span>122,20€</span>
                        </div>
                        
                        <div class="summary-item">
                            <span>Frais d'expédition</span>
                            <span>4,90€</span>
                        </div>
                        
                        <div class="summary-item">
                            <span>Remise</span>
                            <span class="text-success">-0,00€</span>
                        </div>
                        
                        <div class="summary-item total">
                            <span>Total TTC</span>
                            <span>127,10€</span>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label" for="terms">
                                J'accepte les <a href="#">conditions générales de vente</a>
                            </label>
                        </div>
                        
                        <a href="../formations/payment.html" class="btn btn-primary btn-lg w-100 mb-3">Procéder au paiement</a>
                        
                        <div class="text-center">
                            <small class="text-muted">En passant commande, vous acceptez les conditions générales de vente de Small Land</small>
                        </div>
                    </div>
                </div>
                
                <!-- Sécurité -->
                <div class="card mt-4">
                    <div class="card-body text-center">
                        <i class="bi bi-shield-check display-6 text-primary mb-3"></i>
                        <h5>Paiement sécurisé</h5>
                        <p class="text-muted">Vos données bancaires sont cryptées et sécurisées.</p>
                        <div class="d-flex justify-content-center">
                            <img src="https://via.placeholder.com/40" class="me-2" alt="Carte">
                            <img src="https://via.placeholder.com/40" class="me-2" alt="Carte">
                            <img src="https://via.placeholder.com/40" class="me-2" alt="Carte">
                            <img src="https://via.placeholder.com/40" alt="Carte">
                        </div>
                    </div>
                </div>
                
                <!-- Assistance -->
                <div class="card mt-4">
                    <div class="card-body text-center">
                        <i class="bi bi-headset display-6 text-primary mb-3"></i>
                        <h5>Besoin d'aide ?</h5>
                        <p class="text-muted">Notre équipe est là pour vous aider</p>
                        <a href="#" class="btn btn-outline-primary">Contactez-nous</a>
                    </div>
                </div>
            </div>
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
