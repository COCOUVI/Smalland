@extends('master')

@section('content')
<style>
    :root {
        --primary-color: #2e7d32;
        --secondary-color: #7cb342;
    }

    .page-header {
        background-color: var(--primary-color);
        color: white;
        padding: 60px 0;
        margin-bottom: 40px;
        background-image: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.2)), url('{{ asset('images/farm-banner.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .portfolio-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
        margin-top: 30px;
    }

    .portfolio-item {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: white;
    }

    .portfolio-item:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.15);
    }

    .portfolio-img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        display: block;
    }

    .portfolio-caption {
        padding: 16px;
    }

    .portfolio-caption h5 {
        color: var(--primary-color);
        margin-bottom: 8px;
    }

    .portfolio-caption p {
        color: #555;
        font-size: 0.95rem;
    }
</style>

<div class="page-header">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">Notre Ferme</h1>
        <p class="lead">Découvrez la beauté et l’authenticité de notre exploitation agricole</p>
    </div>
</div>

<div class="container">
    <div class="text-center mb-5">
        <p class="text-muted">Chaque image raconte une histoire de terre, de soin et de respect de la nature.</p>
    </div>

    <div class="portfolio-grid">
     
    @php
        $images = [
            // 🐔 Poulailler (9 photos)
            ['src' => 'poulailler1.jpg', 'title' => 'Notre Poulailler', 'desc' => 'Un espace spacieux et sécurisé où nos poules vivent en harmonie avec la nature.'],
            ['src' => 'poulailler2.jpg', 'title' => 'Poules en Liberté', 'desc' => 'Nos poules picorent librement, garantissant leur bien-être et la qualité de leurs œufs.'],
            ['src' => 'poulailler3.jpg', 'title' => 'Coin Nidification', 'desc' => 'Des nids douillets et propres pour une ponte sereine et naturelle.'],
            ['src' => 'poulailler4.jpg', 'title' => 'Alimentation Naturelle', 'desc' => 'Céréales locales, insectes et herbes fraîches composent leur alimentation quotidienne.'],
            ['src' => 'poulailler5.jpg', 'title' => 'Protégé et Aéré', 'desc' => 'Notre poulailler est conçu pour offrir ombre, ventilation et sécurité contre les prédateurs.'],
            ['src' => 'poulailler6.jpg', 'title' => 'Matin au Poulailler', 'desc' => 'Le calme du matin, rompu seulement par le chant des coqs et le bruit des becs.'],
            ['src' => 'poulailler7.jpg', 'title' => 'Élevage Familial', 'desc' => 'Un élevage à taille humaine, où chaque poule est connue et respectée.'],
            ['src' => 'poulailler8.jpg', 'title' => 'Nettoyage Quotidien', 'desc' => 'Hygiène rigoureuse pour préserver la santé de nos volailles.'],
            ['src' => 'poulailler9.jpg', 'title' => 'Vue d’Ensemble', 'desc' => 'Notre poulailler, cœur vivant de notre ferme, entouré de verdure et de calme.'],

            // 🥚 Œufs (2 photos)
            ['src' => 'oeufs1.jpg', 'title' => 'Œufs Frais du Matin', 'desc' => 'Ramassés à l’aube, nos œufs sont d’une fraîcheur incomparable et d’un jaune intense.'],
            ['src' => 'oeufs2.jpg', 'title' => 'Qualité Naturelle', 'desc' => 'Pas d’antibiotiques, pas d’hormones — juste des œufs sains, issus d’un élevage éthique.'],

            // 🐇 Lapins (10 photos)
            ['src' => 'lapin1.jpg', 'title' => 'Élevage de Lapins', 'desc' => 'Nos lapins grandissent dans des clapiers spacieux, propres et bien ventilés.'],
            ['src' => 'lapin2.jpg', 'title' => 'Alimentation Végétale', 'desc' => 'Feuilles de manioc, herbes fraîches et légumes de la ferme composent leur menu quotidien.'],
            ['src' => 'lapin3.jpg', 'title' => 'Mères et Petits', 'desc' => 'Nous veillons à la santé des lapines et à la croissance saine de leurs petits.'],
            ['src' => 'lapin4.jpg', 'title' => 'Clapier Écologique', 'desc' => 'Construit en matériaux locaux, notre clapier respecte l’environnement et le confort des animaux.'],
            ['src' => 'lapin5.jpg', 'title' => 'Hygiène Rigoureuse', 'desc' => 'Nettoyage quotidien pour prévenir les maladies et assurer un élevage sain.'],
            ['src' => 'lapin6.jpg', 'title' => 'Repos et Bien-être', 'desc' => 'Nos lapins disposent de zones ombragées et calmes pour se reposer en toute tranquillité.'],
            ['src' => 'lapin7.jpg', 'title' => 'Sélection Naturelle', 'desc' => 'Nous favorisons la reproduction naturelle pour préserver la robustesse de notre cheptel.'],
            ['src' => 'lapin8.jpg', 'title' => 'Croissance Saine', 'desc' => 'Chaque lapin est suivi de près pour garantir une croissance équilibrée et sans stress.'],
            ['src' => 'lapin9.jpg', 'title' => 'Élevage Responsable', 'desc' => 'Un élevage à petite échelle, centré sur le respect animal et la qualité de la viande.'],
            ['src' => 'lapin10.jpg', 'title' => 'Vue d’Ensemble', 'desc' => 'Notre clapier, intégré harmonieusement dans le paysage de la ferme.'],

            // 🌴 Papayers (1 photo)
            ['src' => 'papayer1.jpg', 'title' => 'Champ de Papayers', 'desc' => 'Nos papayers poussent sous le soleil, sans pesticides, offrant des fruits juteux et riches en vitamines.']
        ];
    @endphp
        @foreach($images as $img)
            <div class="portfolio-item">
                <img src="{{ asset('images/farm/' . $img['src']) }}" alt="{{ $img['title'] }}" class="portfolio-img">
                <div class="portfolio-caption">
                    <h5>{{ $img['title'] }}</h5>
                    <p>{{ $img['desc'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection