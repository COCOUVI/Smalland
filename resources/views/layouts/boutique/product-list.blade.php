@extends('master')

@section('content')

    <!-- En-tête de page -->
    <div class="page-header">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Boutique Small Land</h1>
            <p class="lead">Découvrez notre sélection de produits pour l'agriculture et le jardinage</p>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="container">
        <!-- Filtres -->
        <div class="filter-section">
            <div class="row">
                <div class="col-md-6 col-lg-3 mb-3">
                    <label class="form-label">Catégorie</label>
                    <select class="form-select">
                        <option selected>Toutes les catégories</option>
                        <option>Outils de jardinage</option>
                        <option>Semences et plants</option>
                        <option>Équipements d'irrigation</option>
                        <option>Produits naturels</option>
                        <option>Serres et abris</option>
                    </select>
                </div>
                <div class="col-md-6 col-lg-3 mb-3">
                    <label class="form-label">Marque</label>
                    <select class="form-select">
                        <option selected>Toutes les marques</option>
                        <option>BioGarden</option>
                        <option>EcoTools</option>
                        <option>NaturePlus</option>
                        <option>GreenLife</option>
                    </select>
                </div>
                <div class="col-md-6 col-lg-3 mb-3">
                    <label class="form-label">Tri</label>
                    <select class="form-select">
                        <option selected>Pertinence</option>
                        <option>Prix croissant</option>
                        <option>Prix décroissant</option>
                        <option>Meilleures notes</option>
                        <option>Nouveautés</option>
                    </select>
                </div>
                <div class="col-md-6 col-lg-3 mb-3">
                    <label class="form-label">Prix</label>
                    <div id="price-slider" class="price-slider mt-2"></div>
                    <div class="d-flex justify-content-between">
                        <small>0€</small>
                        <small>200€</small>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <span class="text-muted">24 produits trouvés</span>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="stockOnly">
                    <label class="form-check-label" for="stockOnly">
                        Afficher seulement les produits en stock
                    </label>
                </div>
            </div>
        </div>

        <!-- Liste des produits -->
        <div class="row">
            <!-- Produit 1 -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card h-100">
                    <span class="category-badge badge bg-primary">Outils</span>
                    <span class="stock-badge badge bg-success">En stock</span>
                    <img src="https://images.unsplash.com/photo-1595341888016-a392ef81b7de?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Kit jardinage">
                    <div class="card-body">
                        <h5 class="card-title">Kit de jardinage débutant</h5>
                        <p class="card-text">Tout le nécessaire pour commencer votre potager.</p>
                        <div class="rating mb-2">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                            <span class="ms-1">(35)</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0 product-price">39,90€</span>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Produit 2 -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card h-100">
                    <span class="category-badge badge bg-info">Serres</span>
                    <span class="stock-badge badge bg-success">En stock</span>
                    <img src="https://images.unsplash.com/photo-1589923188937-cb64779f4abe?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Serre">
                    <div class="card-body">
                        <h5 class="card-title">Serre de balcon</h5>
                        <p class="card-text">Idéale pour cultiver en ville toute l'année.</p>
                        <div class="rating mb-2">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star"></i>
                            <span class="ms-1">(22)</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0 product-price">79,90€</span>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Produit 3 -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card h-100">
                    <span class="category-badge badge bg-success">Semences</span>
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
            
            <!-- Produit 4 -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card h-100">
                    <span class="category-badge badge bg-warning text-dark">Arrosage</span>
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
            
            <!-- Produit 5 -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card h-100">
                    <span class="category-badge badge bg-primary">Outils</span>
                    <span class="stock-badge badge bg-warning text-dark">Faible stock</span>
                    <img src="https://images.unsplash.com/photo-1593476550610-6bb97b1b38b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Plantoir">
                    <div class="card-body">
                        <h5 class="card-title">Plantoir à bulbes professionnel</h5>
                        <p class="card-text">Outil précis pour planter vos bulbes à la bonne profondeur.</p>
                        <div class="rating mb-2">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <span class="ms-1">(29)</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0 product-price">18,90€</span>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Produit 6 -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card h-100">
                    <span class="category-badge badge bg-info text-dark">Irrigation</span>
                    <span class="stock-badge badge bg-success">En stock</span>
                    <img src="https://images.unsplash.com/photo-1590172205845-2441aae4bad4?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Système irrigation">
                    <div class="card-body">
                        <h5 class="card-title">Kit d'irrigation goutte-à-goutte</h5>
                        <p class="card-text">Système économique pour arroser précisément vos plantes.</p>
                        <div class="rating mb-2">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star"></i>
                            <span class="ms-1">(31)</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0 product-price">45,00€</span>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Produit 7 -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card h-100">
                    <span class="category-badge badge bg-success">Semences</span>
                    <span class="stock-badge badge bg-success">En stock</span>
                    <img src="https://images.unsplash.com/photo-1416879595882-3373a0480b5b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Graines potagères">
                    <div class="card-body">
                        <h5 class="card-title">Collection de graines potagères</h5>
                        <p class="card-text">10 variétés de légumes faciles à cultiver pour débutants.</p>
                        <div class="rating mb-2">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                            <span class="ms-1">(42)</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0 product-price">19,90€</span>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Produit 8 -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card h-100">
                    <span class="category-badge badge bg-warning text-dark">Protection</span>
                    <span class="stock-badge badge bg-danger">Rupture</span>
                    <img src="https://images.unsplash.com/photo-1589923188937-cb64779f4abe?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Filet protection">
                    <div class="card-body">
                        <h5 class="card-title">Filet de protection anti-oiseaux</h5>
                        <p class="card-text">Protégez vos fruits et légumes des oiseaux et insectes.</p>
                        <div class="rating mb-2">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star"></i>
                            <span class="ms-1">(15)</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0 product-price">27,50€</span>
                            <button class="btn btn-sm btn-outline-secondary" disabled>
                                <i class="bi bi-cart-x"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation" class="mt-4">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Précédent</a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Suivant</a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Section avant-footer -->
    <div class="bg-light py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0 text-center">
                    <i class="bi bi-truck display-6 text-primary mb-3"></i>
                    <h5>Livraison rapide</h5>
                    <p class="text-muted">Expédition sous 24h pour les commandes avant 16h</p>
                </div>
                <div class="col-lg-4 mb-4 mb-lg-0 text-center">
                    <i class="bi bi-arrow-repeat display-6 text-primary mb-3"></i>
                    <h5>Retours faciles</h5>
                    <p class="text-muted">30 jours pour changer d'avis</p>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="bi bi-shield-check display-6 text-primary mb-3"></i>
                    <h5>Paiement sécurisé</h5>
                    <p class="text-muted">Vos données bancaires sont cryptées</p>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.0/nouislider.min.js"></script>
    <script>
        // Initialisation du slider de prix
        document.addEventListener('DOMContentLoaded', function() {
            var priceSlider = document.getElementById('price-slider');
            noUiSlider.create(priceSlider, {
                start: [0, 200],
                connect: true,
                range: {
                    'min': 0,
                    'max': 200
                },
                step: 10
            });
        });
    </script>
@endsection
