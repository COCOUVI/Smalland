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
        
        .product-header {
            background-color: white;
            padding: 40px 0;
            margin-bottom: 40px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
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
        
        .section-title {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: var(--secondary-color);
        }
        
        .rating {
            color: #ffc107;
        }
        
        .product-price {
            font-weight: bold;
            color: var(--primary-color);
        }
        
        .quantity-selector {
            width: 120px;
        }
        
        .main-image {
            border-radius: 8px;
            overflow: hidden;
        }
        
        .thumbnail {
            cursor: pointer;
            border: 2px solid transparent;
            border-radius: 5px;
            transition: all 0.3s;
        }
        
        .thumbnail:hover, .thumbnail.active {
            border-color: var(--primary-color);
        }
        
        .feature-list {
            list-style: none;
            padding: 0;
        }
        
        .feature-list li {
            margin-bottom: 10px;
            padding-left: 30px;
            position: relative;
        }
        
        .feature-list li:before {
            content: '\F26E';
            font-family: 'bootstrap-icons';
            position: absolute;
            left: 0;
            color: var(--primary-color);
        }
        
        .tab-pane {
            padding: 20px 0;
        }
        
        .stock-badge {
            position: absolute;
            top: 15px;
            right: 15px;
        }
    </style>
       <!-- En-tête du produit -->
    <div class="product-header">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../index.html">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="products-catalog.html">Boutique</a></li>
                    <li class="breadcrumb-item"><a href="products-catalog.html">Outils de jardinage</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Kit de jardinage débutant</li>
                </ol>
            </nav>
            
            <div class="row">
                <!-- Galerie d'images -->
                <div class="col-lg-6">
                    <div class="main-image mb-3">
                        <img src="https://images.unsplash.com/photo-1595341888016-a392ef81b7de?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" class="img-fluid rounded" alt="Kit de jardinage débutant" id="mainImage">
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <img src="https://images.unsplash.com/photo-1595341888016-a392ef81b7de?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="img-fluid thumbnail active" alt="Vue 1" onclick="changeImage(this)">
                        </div>
                        <div class="col-3">
                            <img src="https://images.unsplash.com/photo-1574323347407-f5e1ad6d020b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="img-fluid thumbnail" alt="Vue 2" onclick="changeImage(this)">
                        </div>
                        <div class="col-3">
                            <img src="https://images.unsplash.com/photo-1593476550610-6bb97b1b38b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="img-fluid thumbnail" alt="Vue 3" onclick="changeImage(this)">
                        </div>
                        <div class="col-3">
                            <img src="https://images.unsplash.com/photo-1596461404969-9b70b3e2a60d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="img-fluid thumbnail" alt="Vue 4" onclick="changeImage(this)">
                        </div>
                    </div>
                </div>
                
                <!-- Détails du produit -->
                <div class="col-lg-6">
                    <span class="badge bg-success mb-2">En stock</span>
                    <h1 class="display-5 fw-bold">Kit de jardinage débutant</h1>
                    <div class="rating mb-2">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                        <span class="ms-1">4.5 (35 avis)</span>
                    </div>
                    <div class="product-price display-4 mb-3">39,90€</div>
                    <p class="lead">Tout le nécessaire pour commencer votre potager et entretenir vos plantes avec des outils de qualité.</p>
                    
                    <div class="d-flex align-items-center mb-3">
                        <label class="me-3">Quantité:</label>
                        <div class="input-group quantity-selector">
                            <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity()">-</button>
                            <input type="number" class="form-control text-center" value="1" min="1" max="10" id="quantity">
                            <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity()">+</button>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex mb-4">
                        <button class="btn btn-primary btn-lg flex-grow-1">
                            <i class="bi bi-cart-plus me-2"></i>Ajouter au panier
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

    <!-- Contenu principal -->
    <div class="container">
        <!-- Description détaillée -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-5">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="productTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">Description</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button" role="tab">Caractéristiques</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">Avis (35)</button>
                            </li>
                        </ul>
                        
                        <div class="tab-content" id="productTabsContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel">
                                <h3 class="section-title">Description du produit</h3>
                                <p>Notre kit de jardinage débutant a été spécialement conçu pour ceux qui souhaitent se lancer dans le jardinage sans se ruiner. Il contient tous les outils essentiels pour entretenir vos plantes, que vous ayez un grand jardin ou simplement quelques pots sur un balcon.</p>
                                
                                <p>Fabriqué à partir de matériaux durables et respectueux de l'environnement, ce kit vous accompagnera pendant de nombreuses années. Les manches en bois de hêtre sont ergonomiques et confortables, tandis que les têtes en acier inoxydable résistent à la rouille.</p>
                                
                                <h4>Idéal pour :</h4>
                                <ul>
                                    <li>Les débutants en jardinage</li>
                                    <li>Les petits espaces (balcons, terrasses)</li>
                                    <li>Les cadeaux pour amateurs de plantes</li>
                                    <li>Les activités jardinage avec enfants</li>
                                </ul>
                                
                                <h4>Avantages :</h4>
                                <ul>
                                    <li>Matériaux durables et écologiques</li>
                                    <li>Design ergonomique pour un confort d'utilisation</li>
                                    <li>Range-outil pratique inclus</li>
                                    <li>Garantie 2 ans</li>
                                </ul>
                            </div>
                            
                            <div class="tab-pane fade" id="specs" role="tabpanel">
                                <h3 class="section-title">Caractéristiques techniques</h3>
                                
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th>Contenu du kit</th>
                                                <td>1 transplantoir, 1 petite griffe, 1 cultivateur, 1 plantoir, 1 range-outil</td>
                                            </tr>
                                            <tr>
                                                <th>Matériaux</th>
                                                <td>Manches en hêtre, têtes en acier inoxydable</td>
                                            </tr>
                                            <tr>
                                                <th>Dimensions</th>
                                                <td>30 x 20 x 8 cm (range-outil fermé)</td>
                                            </tr>
                                            <tr>
                                                <th>Poids</th>
                                                <td>1,2 kg</td>
                                            </tr>
                                            <tr>
                                                <th>Couleur</th>
                                                <td>Naturel (bois) et acier inoxydable</td>
                                            </tr>
                                            <tr>
                                                <th>Garantie</th>
                                                <td>2 ans</td>
                                            </tr>
                                            <tr>
                                                <th>Entretien</th>
                                                <td>Nettoyage à l'eau après utilisation, séchage complet avant rangement</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="tab-pane fade" id="reviews" role="tabpanel">
                                <h3 class="section-title">Avis clients</h3>
                                
                                <div class="row mb-4">
                                    <div class="col-md-4 text-center">
                                        <div class="display-4 text-primary">4.5</div>
                                        <div class="rating mb-2">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-half"></i>
                                        </div>
                                        <div class="text-muted">35 avis</div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="mb-2">
                                            <div class="d-flex align-items-center">
                                                <span class="me-2">5</span>
                                                <div class="progress flex-grow-1" style="height: 8px;">
                                                    <div class="progress-bar" style="width: 60%;"></div>
                                                </div>
                                                <span class="ms-2">21</span>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <div class="d-flex align-items-center">
                                                <span class="me-2">4</span>
                                                <div class="progress flex-grow-1" style="height: 8px;">
                                                    <div class="progress-bar" style="width: 25%;"></div>
                                                </div>
                                                <span class="ms-2">9</span>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <div class="d-flex align-items-center">
                                                <span class="me-2">3</span>
                                                <div class="progress flex-grow-1" style="height: 8px;">
                                                    <div class="progress-bar" style="width: 10%;"></div>
                                                </div>
                                                <span class="ms-2">3</span>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <div class="d-flex align-items-center">
                                                <span class="me-2">2</span>
                                                <div class="progress flex-grow-1" style="height: 8px;">
                                                    <div class="progress-bar" style="width: 3%;"></div>
                                                </div>
                                                <span class="ms-2">1</span>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <div class="d-flex align-items-center">
                                                <span class="me-2">1</span>
                                                <div class="progress flex-grow-1" style="height: 8px;">
                                                    <div class="progress-bar" style="width: 3%;"></div>
                                                </div>
                                                <span class="ms-2">1</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Avis 1 -->
                                <div class="border-bottom pb-3 mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-4.0.3&auto=format&fit=crop&w=50&q=80" alt="Avatar" class="rounded-circle me-2" width="40">
                                        <div>
                                            <div>Sophie L.</div>
                                            <div class="rating small">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h5>Parfait pour débuter</h5>
                                    <p>J'ai acheté ce kit pour commencer mon petit potager sur mon balcon. Les outils sont de très bonne qualité, ergonomiques et solides. Le range-outil est très pratique pour garder tout organisé. Je recommande !</p>
                                    <small class="text-muted">Publié il y a 2 semaines</small>
                                </div>
                                
                                <!-- Avis 2 -->
                                <div class="border-bottom pb-3 mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=50&q=80" alt="Avatar" class="rounded-circle me-2" width="40">
                                        <div>
                                            <div>Pierre D.</div>
                                            <div class="rating small">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-half"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h5>Bon rapport qualité-prix</h5>
                                    <p>Des outils solides et bien finis. Le manche en bois est agréable en main. Seul bémol : le range-outil est un peu juste pour ranger tous les outils, il faut les positionner précisément.</p>
                                    <small class="text-muted">Publié il y a 1 mois</small>
                                </div>
                                
                                <a href="#" class="btn btn-outline-primary">Voir tous les avis</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Produits similaires -->
                <div class="card">
                    <div class="card-body">
                        <h3 class="section-title">Produits similaires</h3>
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <span class="stock-badge badge bg-success">En stock</span>
                                    <img src="https://images.unsplash.com/photo-1596461404969-9b70b3e2a60d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Arrosoir">
                                    <div class="card-body">
                                        <h5 class="card-title">Arrosoir écologique</h5>
                                        <p class="card-text">Fabriqué à partir de matériaux recyclés, capacité 10L.</p>
                                        <div class="rating mb-2">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-half"></i>
                                            <i class="bi bi-star"></i>
                                            <span class="ms-1">(18)</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="h5 mb-0 product-price">32,50€</span>
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-cart-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <span class="stock-badge badge bg-success">En stock</span>
                                    <img src="https://images.unsplash.com/photo-1471194402529-8e0f5a675de6?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Graines bio">
                                    <div class="card-body">
                                        <h5 class="card-title">Coffret graines bio</h5>
                                        <p class="card-text">15 variétés de légumes et herbes aromatiques biologiques.</p>
                                        <div class="rating mb-2">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <span class="ms-1">(47)</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="h5 mb-0 product-price">24,90€</span>
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-cart-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Livraison et retours -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Livraison et retours</h5>
                        
                        <div class="d-flex mb-3">
                            <i class="bi bi-truck text-primary me-3 fs-4"></i>
                            <div>
                                <h6>Livraison standard</h6>
                                <p class="text-muted mb-0">Gratuite à partir de 50€ d'achat<br>Délai : 2-3 jours ouvrés</p>
                            </div>
                        </div>
                        
                        <div class="d-flex mb-3">
                            <i class="bi bi-arrow-repeat text-primary me-3 fs-4"></i>
                            <div>
                                <h6>Retours gratuits</h6>
                                <p class="text-muted mb-0">30 jours pour changer d'avis<br>Retours simples et gratuits</p>
                            </div>
                        </div>
                        
                        <div class="d-flex">
                            <i class="bi bi-shield-check text-primary me-3 fs-4"></i>
                            <div>
                                <h6>Paiement sécurisé</h6>
                                <p class="text-muted mb-0">Vos données bancaires sont cryptées</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Garantie -->
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <i class="bi bi-award display-6 text-primary mb-3"></i>
                        <h5>Garantie 2 ans</h5>
                        <p class="text-muted">Ce produit est garanti 2 ans contre tout défaut de fabrication.</p>
                    </div>
                </div>
                
                <!-- Support -->
                <div class="card">
                    <div class="card-body text-center">
                        <i class="bi bi-headset display-6 text-primary mb-3"></i>
                        <h5>Une question ?</h5>
                        <p class="text-muted">Notre équipe est là pour vous aider</p>
                        <a href="#" class="btn btn-outline-primary">Contactez-nous</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Changement d'image principale
        function changeImage(element) {
            const mainImage = document.getElementById('mainImage');
            mainImage.src = element.src;
            
            // Mettre à jour la classe active
            document.querySelectorAll('.thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
            });
            element.classList.add('active');
        }
        
        // Gestion de la quantité
        function increaseQuantity() {
            const quantityInput = document.getElementById('quantity');
            if (parseInt(quantityInput.value) < 10) {
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
