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
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-5">Bienvenue à Smalland </h1>
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
                                <img src="{{ asset('images/default.jpg') }}" class="card-img-top" alt="Image par défaut">                            @endif

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
                                        <a href="{{ route('formation-detail', $formation->id) }}" class="btn btn-primary">
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
