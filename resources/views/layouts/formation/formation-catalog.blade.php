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
            padding: 60px 0;
            margin-bottom: 40px;
        }
        
        .card {
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
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
        
        .formation-level {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .level-beginner {
            background-color: #e8f5e9;
            color: #2e7d32;
        }
        
        .level-intermediate {
            background-color: #fff8e1;
            color: #f57f17;
        }
        
        .level-advanced {
            background-color: #ffebee;
            color: #c62828;
        }
        
        .filter-section {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .price-slider .noUi-connect {
            background-color: var(--primary-color);
        }
        
        .price-slider .noUi-handle {
            border: 2px solid var(--primary-color);
            border-radius: 50%;
            background: white;
        }
    </style>
  <!-- En-tête de page -->
    <div class="page-header">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Formations en Agronomie</h1>
            <p class="lead">Développez vos compétences avec nos formations expertes en agriculture durable</p>
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
                        <option>Permaculture</option>
                        <option>Agriculture Biologique</option>
                        <option>Gestion de l'eau</option>
                        <option>Sol et compost</option>
                        <option>Apiculture</option>
                    </select>
                </div>
                <div class="col-md-6 col-lg-3 mb-3">
                    <label class="form-label">Niveau</label>
                    <select class="form-select">
                        <option selected>Tous les niveaux</option>
                        <option>Débutant</option>
                        <option>Intermédiaire</option>
                        <option>Avancé</option>
                    </select>
                </div>
                <div class="col-md-6 col-lg-3 mb-3">
                    <label class="form-label">Durée</label>
                    <select class="form-select">
                        <option selected>Toutes les durées</option>
                        <option>Moins de 5 heures</option>
                        <option>5-10 heures</option>
                        <option>10-20 heures</option>
                        <option>Plus de 20 heures</option>
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
                    <span class="text-muted">12 formations trouvées</span>
                </div>
                <div>
                    <span class="me-2">Trier par :</span>
                    <select class="form-select form-select-sm d-inline-block w-auto">
                        <option>Pertinence</option>
                        <option>Prix croissant</option>
                        <option>Prix décroissant</option>
                        <option>Note</option>
                        <option>Nouveauté</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Liste des formations -->
        <div class="row">
            <!-- Formation 1 -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <span class="formation-level level-beginner position-absolute top-0 end-0 m-2">Débutant</span>
                    <img src="https://images.unsplash.com/photo-1518531933037-91b2f5f229cc?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Maraîchage">
                    <div class="card-body">
                        <h5 class="card-title">Maraîchage biologique intensif</h5>
                        <p class="card-text">Apprenez à maximiser votre production sur de petites surfaces avec des techniques écologiques.</p>
                        <div class="rating mb-2">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                            <span class="ms-1">(42)</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><i class="bi bi-clock me-1"></i> 8h de formation</span>
                            <span><i class="bi bi-collection-play me-1"></i> 24 leçons</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0 text-primary">89€</span>
                            <a href="formation-details.html" class="btn btn-primary">Voir détails</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Formation 2 -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <span class="formation-level level-beginner position-absolute top-0 end-0 m-2">Débutant</span>
                    <img src="https://images.unsplash.com/photo-1416879595882-3373a0480b5b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Apiculture">
                    <div class="card-body">
                        <h5 class="card-title">Initiation à l'apiculture</h5>
                        <p class="card-text">Découvrez les bases de l'apiculture et comment installer votre première ruche.</p>
                        <div class="rating mb-2">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star"></i>
                            <span class="ms-1">(28)</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><i class="bi bi-clock me-1"></i> 6h de formation</span>
                            <span><i class="bi bi-collection-play me-1"></i> 18 leçons</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0 text-primary">69€</span>
                            <a href="formation-details.html" class="btn btn-primary">Voir détails</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Formation 3 -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <span class="formation-level level-intermediate position-absolute top-0 end-0 m-2">Intermédiaire</span>
                    <img src="https://images.unsplash.com/photo-1593686340314-42f27a1e50c9?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Compostage">
                    <div class="card-body">
                        <h5 class="card-title">Maîtriser l'art du compostage</h5>
                        <p class="card-text">Transformez vos déchets en or noir pour votre jardin avec les techniques de compostage.</p>
                        <div class="rating mb-2">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <span class="ms-1">(56)</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><i class="bi bi-clock me-1"></i> 5h de formation</span>
                            <span><i class="bi bi-collection-play me-1"></i> 15 leçons</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0 text-primary">49€</span>
                            <a href="formation-details.html" class="btn btn-primary">Voir détails</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Formation 4 -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <span class="formation-level level-advanced position-absolute top-0 end-0 m-2">Avancé</span>
                    <img src="https://images.unsplash.com/photo-1595341888016-a392ef81b7de?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Design permaculture">
                    <div class="card-body">
                        <h5 class="card-title">Design en permaculture</h5>
                        <p class="card-text">Apprenez à concevoir des systèmes résilients inspirés des écosystèmes naturels.</p>
                        <div class="rating mb-2">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                            <span class="ms-1">(37)</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><i class="bi bi-clock me-1"></i> 12h de formation</span>
                            <span><i class="bi bi-collection-play me-1"></i> 32 leçons</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0 text-primary">129€</span>
                            <a href="formation-details.html" class="btn btn-primary">Voir détails</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Formation 5 -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <span class="formation-level level-intermediate position-absolute top-0 end-0 m-2">Intermédiaire</span>
                    <img src="https://images.unsplash.com/photo-1471194402529-8e0f5a675de6?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Semences">
                    <div class="card-body">
                        <h5 class="card-title">Production de semences biologiques</h5>
                        <p class="card-text">Apprenez à produire, sélectionner et conserver vos propres semences.</p>
                        <div class="rating mb-2">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star"></i>
                            <span class="ms-1">(24)</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><i class="bi bi-clock me-1"></i> 7h de formation</span>
                            <span><i class="bi bi-collection-play me-1"></i> 21 leçons</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0 text-primary">79€</span>
                            <a href="formation-details.html" class="btn btn-primary">Voir détails</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Formation 6 -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <span class="formation-level level-beginner position-absolute top-0 end-0 m-2">Débutant</span>
                    <img src="https://images.unsplash.com/photo-1590172205845-2441aae4bad4?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Irrigation">
                    <div class="card-body">
                        <h5 class="card-title">Gestion de l'eau au jardin</h5>
                        <p class="card-text">Techniques pour économiser l'eau et optimiser son utilisation au potager.</p>
                        <div class="rating mb-2">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                            <i class="bi bi-star"></i>
                            <span class="ms-1">(19)</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><i class="bi bi-clock me-1"></i> 4h de formation</span>
                            <span><i class="bi bi-collection-play me-1"></i> 12 leçons</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0 text-primary">59€</span>
                            <a href="formation-details.html" class="btn btn-primary">Voir détails</a>
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
                <li class="page-item">
                    <a class="page-link" href="#">Suivant</a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Section avant-footer -->
    <div class="bg-primary text-white py-5 mt-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <h3 class="mb-3">Vous souhaitez devenir formateur ?</h3>
                    <p class="mb-0">Partagez votre expertise en agronomie et rejoignez notre communauté de formateurs.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="#" class="btn btn-light btn-lg">Proposer une formation</a>
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
