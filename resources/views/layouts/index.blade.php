@extends('master')

@section('content')
<div>
<!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Bienvenue à Small Land</h1>
            <p class="lead mb-4">La première plateforme béninoise dédiée à l’innovation, à la formation et à la fourniture d’équipements et intrants dans les domaines de l’élevage et de l’agriculture.</p>
            <a href="#about" class="btn btn-primary btn-lg me-2">Notre Histoire </a>
            <a href="#feature" class="btn btn-light btn-lg">Nos activités</a>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4">
                    <img src="/assets/img/3.jpg" class="img-fluid rounded shadow" alt="Ferme familiale">
                </div>
                <div class="col-md-6">
                    <h2 class="section-title">Notre histoire</h2>
                    <p>Small Land est une petite ferme familiale créée en 2010 par la famille Dupont. Installés en pleine campagne, nous avons développé avec passion une ferme pédagogique où nous élevons des lapins et des poules en liberté.</p>
                    <p>Toute la famille participe aux activités : les enfants adorent nourrir les lapins et ramasser les œufs frais chaque matin. Nous avons également développé un incubateur artisanal pour faire naître nos poussins.</p>
                    <p>Notre philosophie : une agriculture respectueuse des animaux et de l'environnement, dans la joie et la simplicité.</p>
                    <a href="#" class="btn btn-primary mt-3">En savoir plus sur nous</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title text-center">Nos valeurs</h2>
            <div class="row text-center mt-4">
                <div class="col-md-4 mb-4">
                    <div class="p-4 bg-white rounded shadow-sm">
                        <i class="bi bi-heart-fill text-primary fs-1 mb-3"></i>
                        <h4>Amour des animaux</h4>
                        <p>Nos animaux sont élevés en plein air avec beaucoup d'attention et de soins.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="p-4 bg-white rounded shadow-sm">
                        <i class="bi bi-tree-fill text-primary fs-1 mb-3"></i>
                        <h4>Respect de la nature</h4>
                        <p>Nous pratiquons une agriculture durable qui préserve l'environnement.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="p-4 bg-white rounded shadow-sm">
                        <i class="bi bi-people-fill text-primary fs-1 mb-3"></i>
                        <h4>Partage familial</h4>
                        <p>Toute la famille participe avec joie aux activités de la ferme.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Activities Section -->
    <section id="features" class="py-5">
        <div class="container">
            <h2 class="section-title text-center">Nos activités</h2>
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <div class="module-icon">
                        <i class="bi bi-journal-text"></i>
                    </div>
                    <h3>Blog Agronomie</h3>
                    <p>Des articles experts sur les techniques agricoles modernes, l'écologie et le développement durable.</p>
                    <a href="blog-list.html" class="btn btn-outline-primary">Voir les articles</a>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="module-icon">
                        <i class="bi bi-mortarboard"></i>
                    </div>
                    <h3>Formations</h3>
                    <p>Des cours en ligne complets avec vidéos, ressources et certifications pour développer vos compétences.</p>
                    <a href="formations-catalog.html" class="btn btn-outline-primary">Découvrir les formations</a>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="module-icon">
                        <i class="bi bi-shop"></i>
                    </div>
                    <h3>Boutique</h3>
                    <p>Des outils, équipements et produits sélectionnés pour vos projets agricoles et votre jardin.</p>
                    <a href="products-catalog.html" class="btn btn-outline-primary">Visiter la boutique</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Derniers articles du blog -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">Derniers articles du blog</h2>
            <div class="row">
                <!-- Article 1 -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <span class="category-badge badge bg-primary">Permaculture</span>
                        <img src="https://images.unsplash.com/photo-1597848212624-e9d2c1e7a50d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Permaculture">
                        <div class="card-body">
                            <h5 class="card-title">Introduction à la permaculture</h5>
                            <p class="card-text">Découvrez les principes de base de la permaculture et comment les appliquer dans votre jardin.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">15 juin 2023</small>
                                <a href="blog-article.html" class="btn btn-sm btn-primary">Lire la suite</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Article 2 -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <span class="category-badge badge bg-success">Agriculture Bio</span>
                        <img src="https://images.unsplash.com/photo-1625246335525-8b5e7e723b64?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Agriculture Bio">
                        <div class="card-body">
                            <h5 class="card-title">Les bienfaits de l'agriculture biologique</h5>
                            <p class="card-text">Pourquoi et comment passer à une agriculture respectueuse de l'environnement.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">10 juin 2023</small>
                                <a href="blog-article.html" class="btn btn-sm btn-primary">Lire la suite</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Article 3 -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <span class="category-badge badge bg-info">Techniques</span>
                        <img src="https://images.unsplash.com/photo-1590172205845-2441aae4bad4?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Techniques agricoles">
                        <div class="card-body">
                            <h5 class="card-title">Nouvelles techniques d'irrigation</h5>
                            <p class="card-text">Optimisez votre consommation d'eau avec ces méthodes d'irrigation modernes et efficaces.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">5 juin 2023</small>
                                <a href="blog-article.html" class="btn btn-sm btn-primary">Lire la suite</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="blog-list.html" class="btn btn-primary">Voir tous les articles</a>
            </div>
        </div>
    </section>

    <!-- Formations populaires -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title">Formations populaires</h2>
            <div class="row">
                <!-- Formation 1 -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
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
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 mb-0 text-primary">89€</span>
                                <a href="formation-details.html" class="btn btn-primary">Voir détails</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Formation 2 -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
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
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 mb-0 text-primary">69€</span>
                                <a href="formation-details.html" class="btn btn-primary">Voir détails</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Formation 3 -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
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
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 mb-0 text-primary">49€</span>
                                <a href="formation-details.html" class="btn btn-primary">Voir détails</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="formations-catalog.html" class="btn btn-primary">Voir toutes les formations</a>
            </div>
        </div>
    </section>

    <!-- Produits populaires -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">Produits populaires</h2>
            <div class="row">
                <!-- Produit 1 -->
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card h-100">
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
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card h-100">
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
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card h-100">
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
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card h-100">
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
            </div>
            <div class="text-center mt-4">
                <a href="products-catalog.html" class="btn btn-primary">Voir tous les produits</a>
            </div>
        </div>
    </section>
     <!-- Farm Gallery Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title text-center">Notre Portfolio</h2>
            <div class="row g-3 mt-4">
                <div class="col-md-4">
                    <img src="http://static.photos/agriculture/320x240/1" class="img-fluid rounded shadow" alt="Enfants nourrissant les lapins">
                </div>
                <div class="col-md-4">
                    <img src="http://static.photos/agriculture/320x240/2" class="img-fluid rounded shadow" alt="Poulailler">
                </div>
                <div class="col-md-4">
                    <img src="http://static.photos/agriculture/320x240/3" class="img-fluid rounded shadow" alt="Incubateur artisanal">
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="#" class="btn btn-primary">Voir plus de photos</a>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h2 class="mb-3">Restez informé</h2>
                    <p class="mb-4">Inscrivez-vous à notre newsletter pour recevoir les derniers articles, nouvelles formations et offres spéciales.</p>
                    <form class="row g-3 justify-content-center">
                        <div class="col-md-6">
                            <input type="email" class="form-control form-control-lg" placeholder="Votre email">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-light btn-lg w-100">S'inscrire</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
    
@endsection
