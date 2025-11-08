@extends('master')

@section('content')
<style>
.card-img-top {
    height: 220px; /* tu peux ajuster ici */
    object-fit: cover;
    width: 100%;
    border-top-left-radius: 0.5rem;
    border-top-right-radius: 0.5rem;
}
</style>
 <style>
            .product-card {
                transition: transform 0.3s, box-shadow 0.3s;
            }

            .product-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
            }

            .section-title {
                font-weight: bold;
                position: relative;
                display: inline-block;
            }

            .section-title::after {
                content: '';
                position: absolute;
                bottom: -10px;
                left: 50%;
                transform: translateX(-50%);
                width: 60px;
                height: 3px;
                background-color: #0f5132;
            }
        </style>
<div>
<!-- Hero Section -->
    <section class="hero-section text-center ">
        <div class="container py-3">
            <h1 class="display-4 fw-bold mb-5">Bienvenue à Small Land </h1>
            <p class="lead mb-4">La première plateforme béninoise dédiée à l’innovation, à la formation et à la fourniture d’équipements et intrants dans les domaines de l’élevage et de l’agriculture.</p>
            <a href="#about" class="btn btn-primary btn-lg me-2">Notre Histoire </a>
            <a href="#featureS" class="btn btn-light btn-lg">Nos activités</a>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4">
                    <img src="/assets/img/5.jpg" class="img-fluid rounded shadow" alt="Ferme familiale">
                </div>
                <div class="col-md-6">
                    <h2 class="section-title">Notre histoire</h2>
                    <p>
                    Small Land est une plateforme béninoise spécialisée dans les domaines de l'agriculture et de l'elevage.
                </p>
                <p>
                    Fondée avec la passion de l'agriculture, de l'elevage et le désir d'accompagner les agriculteurs et des eleveurs.
                    Nous sommes une initiative portée par l'<span class="text-primary"><strong>Établissement Sakoul Entreprises</strong></span>, spécialisée dans la fabrication d’incubateurs automatiques performants et adaptés aux besoins des éleveurs, la commercialisation d’œufs fertiles de volailles pour une reproduction de qualité, la fourniture d’équipements pour la fabrication de couveuses et autres matériels d’élevage et la mise à disposition d’équipements agricoles pour accompagner les producteurs dans la modernisation et la rentabilité de leurs activités.

                </p>
                <p>
                    Notre mission est de rendre l'agriculture et l'elevage accessible et productive pour tous, en offrant 
                    des équipements fiables à des prix compétitifs, tout en assurant un service client de qualité.
                </p>
                <a href="{{ route('about') }}" class="btn btn-primary mt-3">En savoir plus sur nous</a>
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
                    <a href="{{ route('blog.list') }}" class="btn btn-outline-primary">Voir les articles</a>
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
                    <a href="{{ route('shop') }}" class="btn btn-outline-primary">Visiter la boutique</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Derniers articles du blog -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">Derniers articles du blog</h2>
            <div class="row">
                @forelse ($latestPublications as $publication)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <span class="category-badge badge bg-primary">
                                {{ $publication->category->name ?? 'Catégorie inconnue' }}
                            </span>

                            @if($publication->image_path)
                                <img src="{{ asset('storage/'.$publication->image_path) }}"
                                    class="card-img-top"
                                    alt="{{ $publication->title }}">
                            @else
                                <img src="{{ asset('images/default.jpg') }}" class="card-img-top" alt="Image par défaut">
                            @endif

                            <div class="card-body">
                                <h5 class="card-title">{{ $publication->title }}</h5>
                                <p class="card-text">
                                    {{ Str::limit(strip_tags($publication->content), 100) }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">{{ $publication->created_at->format('d M Y') }}</small>
                                    <a href="{{ route('publications.show', $publication->id) }}"
                                    class="btn btn-sm btn-primary">
                                    Lire la suite
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center">Aucune publication disponible pour le moment.</p>
                @endforelse
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('blog.list') }}" class="btn btn-primary">Voir tous les articles</a>
            </div>
        </div>
    </section>


    <!-- Formations populaires -->
        <section class="py-5">
            <div class="container">
                <h2 class="section-title">Formations populaires</h2>
                <div class="row">
                    @forelse($formations as $formation)
                        @php
                            $averageRating = round($formation->averageRating(), 1); // arrondi à 1 décimale
                            $totalAvis = $formation->totalAvis(); // nombre total d'avis
                        @endphp

                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <!-- Image -->
                                <img src="/storage/{{ $formation->image_path ?? 'https://via.placeholder.com/500x300' }}"
                                    class="card-img-top" alt="{{ $formation->titre }}">

                                <div class="card-body">
                                    <!-- Titre -->
                                    <h5 class="card-title">{{ $formation->titre }}</h5>

                                    <!-- Niveau -->
                                    @php
                                        $levelColors = [
                                            'debutant' => 'success',
                                            'intermediaire' => 'warning',
                                            'expert' => 'danger',
                                        ];
                                    @endphp
                                    <p class="badge bg-{{ $levelColors[$formation->niveau] ?? 'secondary' }} mb-2">
                                        Niveau : {{ ucfirst($formation->niveau) }}
                                    </p>

                                    <!-- Description -->
                                    <p class="card-text">
                                        {{ Str::limit($formation->description, 100) }}
                                    </p>

                                    <!-- Note moyenne dynamique -->
                                    <div class="rating mb-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= floor($averageRating))
                                                <i class="bi bi-star-fill text-warning"></i>
                                            @elseif ($i - $averageRating < 1)
                                                <i class="bi bi-star-half text-warning"></i>
                                            @else
                                                <i class="bi bi-star text-warning"></i>
                                            @endif
                                        @endfor
                                        <span class="ms-1">
                                            ({{ $totalAvis }} avis{{ $totalAvis > 1 ? '' : '' }})
                                        </span>
                                    </div>

                                    <!-- Prix + lien -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 mb-0 text-primary">
                                            {{ $formation->price ?? 'Gratuit' }} FCFA
                                        </span>
                                        <a href="{{ route('formations.show', $formation->id) }}" class="btn btn-primary">
                                            Voir détails
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Aucune formation disponible pour le moment.</p>
                    @endforelse
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('formation-list') }}" class="btn btn-primary">Voir toutes les formations</a>
                </div>
            </div>
        </section>
    <!-- Produits populaires -->
        <section class="py-5 bg-light">
            <div class="container">
                <h2 class="section-title text-center mb-5">
                    <i class="bi bi-star-fill text-warning me-2"></i>Produits populaires
                </h2>
                
                <div class="row">
                    @forelse($produitsPopulaires as $produit)
                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="card h-100 shadow-sm border-0 product-card">
                                <!-- Badge stock -->
                                <div class="position-relative">
                                    @if($produit->qte > 10)
                                        <span class="badge bg-success position-absolute top-0 end-0 m-2">
                                            En stock
                                        </span>
                                    @elseif($produit->qte > 0)
                                        <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2">
                                            Stock limité
                                        </span>
                                    @endif

                                    <!-- Image -->
                                    @if($produit->path_img)
                                        <img src="{{ asset('storage/' . $produit->path_img) }}" 
                                            class="card-img-top" 
                                            alt="{{ $produit->nom }}"
                                            style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" 
                                            style="height: 200px;">
                                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ Str::limit($produit->nom, 40) }}</h5>
                                    <p class="card-text text-muted small flex-grow-1">
                                        {{ Str::limit($produit->description, 60) }}
                                    </p>

                                    <!-- Prix -->
                                    <div class="mb-3">
                                        <span class="h5 mb-0 product-price text-success fw-bold">
                                            {{ number_format($produit->prix, 0, ',', ' ') }} FCFA
                                        </span>
                                    </div>

                                    <!-- Boutons -->
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.produits.voir', $produit->id) }}" 
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-eye me-1"></i>Voir détails
                                        </a>

                                        @auth
                                            @if($produit->qte > 0)
                                                <form action="{{ route('cart.add', $produit->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="qte" value="1">
                                                    <button type="submit" class="btn btn-success btn-sm w-100">
                                                        <i class="bi bi-cart-plus me-1"></i>Ajouter au panier
                                                    </button>
                                                </form>
                                            @else
                                                <button class="btn btn-secondary btn-sm w-100" disabled>
                                                    <i class="bi bi-x-circle me-1"></i>Rupture de stock
                                                </button>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-success btn-sm">
                                                <i class="bi bi-box-arrow-in-right me-1"></i>Se connecter
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
                                <p class="text-muted mt-3">Aucun produit disponible pour le moment.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="text-center mt-5">
                    <a href="{{ route('shop') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-shop me-2"></i>Voir tous les produits
                    </a>
                </div>
            </div>
        </section>

       

     <!-- Farm Gallery Section -->
    <!-- Section Portfolio Accueil -->
<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="display-6 fw-bold" style="color: #2e7d32;">Découvrez Notre Ferme</h2>
        <p class="text-muted">Un aperçu de notre quotidien, entre élevage respectueux et cultures naturelles.</p>
    </div>

    <div class="row g-4">
        <!-- Image 1 : Poulailler -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <img src="{{ asset('images/farm/poulailler1.jpg') }}" 
                     class="card-img-top" 
                     alt="Poulailler"
                     style="height: 220px; object-fit: cover;">
                <div class="card-body text-center">
                    <h5 class="card-title" style="color: #2e7d32;">Nos Poules Heureuses</h5>
                    <p class="card-text small text-muted">Élevage en plein air, œufs de qualité.</p>
                </div>
            </div>
        </div>

        <!-- Image 2 : Lapins -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <img src="{{ asset('images/farm/lapin3.jpg') }}" 
                     class="card-img-top" 
                     alt="Élevage de lapins"
                     style="height: 220px; object-fit: cover;">
                <div class="card-body text-center">
                    <h5 class="card-title" style="color: #2e7d32;">Élevage de Lapins</h5>
                    <p class="card-text small text-muted">Bien-être animal et alimentation naturelle.</p>
                </div>
            </div>
        </div>

        <!-- Image 3 : Papayers -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <img src="{{ asset('images/farm/papayer1.jpg') }}" 
                     class="card-img-top" 
                     alt="Champ de papayers"
                     style="height: 220px; object-fit: cover;">
                <div class="card-body text-center">
                    <h5 class="card-title" style="color: #2e7d32;">Verger de Papayers</h5>
                    <p class="card-text small text-muted">Fruits mûrs, cueillis à la main, sans pesticides.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('portfolio') }}" class="btn btn-outline-success px-4 py-2">
            Voir toute la galerie <i class="bi bi-images ms-2"></i>
        </a>
    </div>
</div>
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
