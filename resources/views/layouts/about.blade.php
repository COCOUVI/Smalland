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

    .page-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: white;
        padding: 80px 0;
        margin-bottom: 60px;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        width: 500px;
        height: 500px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        top: -250px;
        right: -250px;
    }

    .page-header h1 {
        font-size: 3rem;
        font-weight: bold;
        position: relative;
        z-index: 2;
    }

    .section {
        padding: 60px 0;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 20px;
        position: relative;
        display: inline-block;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 60px;
        height: 4px;
        background-color: var(--secondary-color);
        border-radius: 2px;
    }

    .about-image {
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }

    .about-image:hover {
        transform: scale(1.05);
    }

    .stats-card {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        text-align: center;
        transition: transform 0.3s;
        height: 100%;
    }

    .stats-card:hover {
        transform: translateY(-10px);
    }

    .stats-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 0 auto 20px;
    }

    .stats-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: var(--primary-color);
    }

    .value-card {
        background: var(--light-color);
        padding: 30px;
        border-radius: 15px;
        border-left: 5px solid var(--primary-color);
        margin-bottom: 20px;
        transition: all 0.3s;
    }

    .value-card:hover {
        background: white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transform: translateX(10px);
    }

    .value-icon {
        width: 60px;
        height: 60px;
        background: var(--primary-color);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 15px;
    }

    .team-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: transform 0.3s;
        margin-bottom: 30px;
    }

    .team-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .team-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
    }

    .team-info {
        padding: 20px;
        text-align: center;
    }

    .timeline {
        position: relative;
        padding: 20px 0;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        width: 4px;
        height: 100%;
        background: var(--primary-color);
    }

    .timeline-item {
        position: relative;
        margin-bottom: 50px;
    }

    .timeline-content {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        width: 45%;
    }

    .timeline-item:nth-child(odd) .timeline-content {
        margin-left: auto;
    }

    .timeline-dot {
        position: absolute;
        left: 50%;
        top: 30px;
        transform: translateX(-50%);
        width: 20px;
        height: 20px;
        background: var(--primary-color);
        border: 4px solid white;
        border-radius: 50%;
        box-shadow: 0 0 0 4px var(--primary-color);
    }

    @media (max-width: 768px) {
        .timeline::before {
            left: 20px;
        }
        .timeline-content {
            width: calc(100% - 50px);
            margin-left: 50px !important;
        }
        .timeline-dot {
            left: 20px;
        }
    }

    .cta-section {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: white;
        padding: 80px 0;
        border-radius: 20px;
        margin: 60px 0;
    }
</style>

<!-- En-tête de page -->
<div class="page-header">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">À propos de Smalland</h1>
        <p class="lead">La première plateforme dédiée à l’innovation, à la formation et à la fourniture d’équipements et intrants dans les domaines de l’élevage et de l’agriculture.</p>
    </div>
</div>

<!-- Qui sommes-nous -->
<section class="section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="{{ asset('storage/logo/about-image.jpg') }}" 
                    class="img-fluid about-image" 
                    alt="Small Land"
                    onerror="this.src='https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=600'">
            </div>
            <div class="col-lg-6">
                <h2 class="section-title">Qui sommes-nous ?</h2>
                <p class="lead text-muted mt-4">
                    Small Land est une entreprise béninoise spécialisée dans la vente d'équipements agricoles 
                    et de jardinage de qualité.
                </p>
                <p>
                    Fondée avec la passion de l'agriculture, de l'elevage et le désir d'accompagner les agriculteurs et des eleveurs.
                    Nous sommes une initiative portée par l'<span class="text-primary"><strong>Établissement Sakoul Entreprises</strong></span>, spécialisée dans la fabrication d’incubateurs automatiques performants et adaptés aux besoins des éleveurs, la commercialisation d’œufs fertiles de volailles pour une reproduction de qualité, la fourniture d’équipements pour la fabrication de couveuses et autres matériels d’élevage et la mise à disposition d’équipements agricoles pour accompagner les producteurs dans la modernisation et la rentabilité de leurs activités.

                </p>
                <p>
                    Notre mission est de rendre l'agriculture et l'elevage accessible et productive pour tous, en offrant 
                    des équipements fiables à des prix compétitifs, tout en assurant un service client de qualité.
                </p>
                <div class="mt-4">
                    <a href="{{ route('shop') }}" class="btn btn-primary btn-lg me-2">
                        <i class="bi bi-shop me-2"></i>Découvrir nos produits
                    </a>
                    <a href="" class="btn btn-outline-primary btn-lg">
                        <i class="bi bi-envelope me-2"></i>Nous contacter
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistiques -->
<section class="section" style="background-color: var(--light-color);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Small Land en chiffres</h2>
        </div>
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="stats-number">500+</div>
                    <p class="text-muted mb-0">Clients satisfaits</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div class="stats-number">200+</div>
                    <p class="text-muted mb-0">Produits disponibles</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div class="stats-number">1000+</div>
                    <p class="text-muted mb-0">Livraisons effectuées</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="bi bi-star"></i>
                    </div>
                    <div class="stats-number">5/5</div>
                    <p class="text-muted mb-0">Note moyenne</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Nos valeurs -->
<section class="section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Nos valeurs</h2>
            <p class="lead text-muted">Ce qui nous guide au quotidien</p>
        </div>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h4>Qualité</h4>
                    <p class="text-muted mb-0">
                        Nous sélectionnons rigoureusement nos produits pour garantir leur durabilité 
                        et leur efficacité.
                    </p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="bi bi-hand-thumbs-up"></i>
                    </div>
                    <h4>Confiance</h4>
                    <p class="text-muted mb-0">
                        Nous construisons des relations durables avec nos clients basées sur la transparence 
                        et l'honnêteté.
                    </p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="bi bi-lightning"></i>
                    </div>
                    <h4>Innovation</h4>
                    <p class="text-muted mb-0">
                        Nous proposons constamment de nouvelles solutions pour améliorer la productivité agricole.
                    </p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="bi bi-headset"></i>
                    </div>
                    <h4>Service client</h4>
                    <p class="text-muted mb-0">
                        Une équipe dédiée pour vous accompagner avant, pendant et après votre achat.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Notre histoire -->
<section class="section" style="background-color: var(--light-color);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Notre histoire</h2>
            <p class="lead text-muted">Le chemin parcouru depuis nos débuts</p>
        </div>
        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <h4>2020 - La création</h4>
                    <p class="text-muted">
                        Lancement de Small Land avec une vision claire : démocratiser l'accès 
                        aux équipements agricoles de qualité au Bénin.
                    </p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <h4>2021 - Premier succès</h4>
                    <p class="text-muted">
                        Atteinte des 100 premiers clients et élargissement de notre catalogue 
                        avec de nouvelles gammes de produits.
                    </p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <h4>2023 - Expansion</h4>
                    <p class="text-muted">
                        Ouverture de notre boutique en ligne et extension de nos services 
                        de livraison à tout le pays.
                    </p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <h4>2025 - Aujourd'hui</h4>
                    <p class="text-muted">
                        Plus de 500 clients satisfaits, une boutique en ligne complète et 
                        des formations pour accompagner nos clients.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Call to Action -->
<div class="container">
    <div class="cta-section">
        <div class="align-items-center">
            <div class=" text-center mb-4 mb-lg-0">
                <h2 class="mb-3">Prêt à démarrer votre projet agricole ?</h2>
                <p class="lead mb-0">
                    Découvrez notre gamme complète de produits et bénéficiez de nos formations d'experts
                </p>
            </div>
            <div class="col-lg-8 text-center text-lg-end">
                
                <a href="" class="btn btn-outline-light btn-lg">
                    Voir nos formations
                </a>
                <a href="" class="btn btn-outline-light btn-lg">
                    Voir nos produits
                </a>
            </div>
        </div>
    </div>
</div>

@endsection