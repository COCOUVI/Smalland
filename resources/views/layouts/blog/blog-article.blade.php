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
        
        .article-header {
            background-color: var(--primary-color);
            color: white;
            padding: 80px 0;
            margin-bottom: 40px;
        }
        
        .article-meta {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .article-meta img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        
        .card {
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .category-badge {
            position: absolute;
            top: 10px;
            right: 10px;
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
        
        .sidebar-widget {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .article-content {
            line-height: 1.8;
            font-size: 1.1rem;
        }
        
        .article-content img {
            border-radius: 8px;
            margin: 30px 0;
        }
        
        .article-content blockquote {
            border-left: 4px solid var(--primary-color);
            padding-left: 20px;
            margin: 30px 0;
            font-style: italic;
            color: #555;
        }
        
        .social-share a {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            border-radius: 50%;
            color: white;
            margin-right: 10px;
        }
        
        .social-share .facebook { background-color: #3b5998; }
        .social-share .twitter { background-color: #1da1f2; }
        .social-share .linkedin { background-color: #0077b5; }
        
        .comment-form {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
        }
        
        .instructor-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }
    </style>
     <!-- En-tête de l'article -->
    <div class="article-header">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <span class="badge bg-light text-primary mb-3">Permaculture</span>
                    <h1 class="display-4 fw-bold">Introduction à la permaculture</h1>
                    <p class="lead">Découvrez les principes de base de la permaculture et comment les appliquer dans votre jardin.</p>
                    <div class="article-meta">
                        <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Auteur">
                        <div>
                            <div>Marie Dupont</div>
                            <small><i class="bi bi-calendar me-1"></i> 15 juin 2023 • <i class="bi bi-clock me-1"></i> 5 min de lecture</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="container">
        <div class="row">
            <!-- Colonne principale -->
            <div class="col-lg-8">
                <!-- Contenu de l'article -->
                <article class="article-content">
                    <p>La permaculture est bien plus qu'une simple méthode de jardinage. C'est une philosophie de conception qui s'inspire des écosystèmes naturels pour créer des environnements durables et productifs. Dans cet article, nous explorerons les principes fondamentaux de la permaculture et comment vous pouvez les appliquer dans votre propre jardin.</p>

                    <h2>Qu'est-ce que la permaculture ?</h2>
                    <p>Le terme "permaculture" a été inventé dans les années 1970 par Bill Mollison et David Holmgren. Il combine les mots "permanent" et "agriculture" (ou "culture") pour décrire un système de conception visant à créer des habitats humains durables.</p>

                    <img src="https://images.unsplash.com/photo-1597848212624-e9d2c1e7a50d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" class="img-fluid" alt="Jardin en permaculture">

                    <p>La permaculture repose sur trois éthiques fondamentales :</p>
                    <ul>
                        <li><strong>Prendre soin de la Terre</strong> : Préserver et régénérer les écosystèmes.</li>
                        <li><strong>Prendre soin des personnes</strong> : Satisfaire les besoins fondamentaux de tous.</li>
                        <li><strong>Partager équitablement</strong> : Redistribuer les surplus et limiter la consommation.</li>
                    </ul>

                    <h2>Les principes de conception</h2>
                    <p>David Holmgren a formulé 12 principes de permaculture qui servent de guide pour la conception de systèmes durables :</p>

                    <blockquote>
                        "La permaculture est la conception consciente de paysages qui miment les modèles et les relations observés dans la nature, visant à produire une abondance de nourriture, de fibres et d'énergie pour satisfaire les besoins locaux."
                    </blockquote>

                    <h3>1. Observer et interagir</h3>
                    <p>Prenez le temps d'observer votre environnement avant d'intervenir. Comprenez les patterns naturels, les flux d'énergie et les relations entre les éléments.</p>

                    <h3>2. Capter et stocker l'énergie</h3>
                    <p>Développez des systèmes qui collectent les ressources quand elles sont abondantes (eau de pluie, énergie solaire) et les stockent pour une utilisation future.</p>

                    <h2>Application pratique au jardin</h2>
                    <p>Voici quelques applications concrètes des principes de permaculture dans un jardin :</p>

                    <h3>Les buttes de culture</h3>
                    <p>Les buttes permettent une meilleure gestion de l'eau, améliorent le drainage et augmentent la surface de culture. Elles créent également des microclimats favorables à certaines plantes.</p>

                    <h3>Le compagnonnage végétal</h3>
                    <p>Associez des plantes qui s'entraident mutuellement. Par exemple, planter des œillets d'Inde près des tomates repousse les nématodes et autres parasites.</p>

                    <img src="https://images.unsplash.com/photo-1589923188937-cb64779f4abe?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" class="img-fluid" alt="Récupération d'eau de pluie">

                    <h2>Conclusion</h2>
                    <p>La permaculture offre un cadre conceptuel puissant pour concevoir des systèmes résilients et productifs. En appliquant ses principes, vous pouvez transformer votre jardin en un écosystème diversifié qui nécessite moins d'entretien tout en produisant une abondance de nourriture.</p>

                    <p>Commencez petit, observez les résultats, et ajustez votre conception au fil du temps. La permaculture est un processus d'apprentissage continu qui évolue avec votre compréhension de votre environnement.</p>
                </article>

                <!-- Partage social -->
                <div class="d-flex justify-content-between align-items-center my-5 py-3 border-top border-bottom">
                    <div class="social-share">
                        <span class="me-3">Partager :</span>
                        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                    </div>
                    <div>
                        <button class="btn btn-outline-primary"><i class="bi bi-heart me-1"></i> 42</button>
                    </div>
                </div>

                <!-- Auteur -->
                <div class="card mb-5">
                    <div class="card-body">
                        <h3 class="section-title">À propos de l'auteur</h3>
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Auteur" class="instructor-img">
                            </div>
                            <div class="col-md-9">
                                <h4>Marie Dupont</h4>
                                <p class="text-muted">Agronome spécialisée en permaculture</p>
                                <p>Agriculteur bio depuis 15 ans, Marie a transformé sa ferme familiale en modèle de maraîchage bio intensif. Diplômée en agronomie, elle partage maintenant son expertise à travers des articles et des formations.</p>
                                <div class="d-flex">
                                    <a href="#" class="text-primary me-3"><i class="bi bi-globe me-1"></i> Site web</a>
                                    <a href="#" class="text-primary me-3"><i class="bi bi-twitter me-1"></i> Twitter</a>
                                    <a href="#" class="text-primary"><i class="bi bi-instagram me-1"></i> Instagram</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Commentaires -->
                <div class="mb-5">
                    <h3 class="section-title">Commentaires (3)</h3>
                    
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <img src="https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Utilisateur" class="rounded-circle me-3" width="40">
                                <div>
                                    <h5 class="mb-0">Pierre Martin</h5>
                                    <small class="text-muted">16 juin 2023</small>
                                </div>
                            </div>
                            <p class="mb-0">Excellent article ! J'applique déjà certains principes dans mon jardin et les résultats sont impressionnants. Merci pour ces conseils.</p>
                        </div>
                    </div>
                    
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Utilisateur" class="rounded-circle me-3" width="40">
                                <div>
                                    <h5 class="mb-0">Sophie Leroux</h5>
                                    <small class="text-muted">17 juin 2023</small>
                                </div>
                            </div>
                            <p class="mb-0">Je débute en permaculture et cet article m'a donné envie d'en apprendre davantage. Avez-vous des recommandations de livres pour approfondir le sujet ?</p>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Utilisateur" class="rounded-circle me-3" width="40">
                                <div>
                                    <h5 class="mb-0">Thomas Dubois</h5>
                                    <small class="text-muted">18 juin 2023</small>
                                </div>
                            </div>
                            <p class="mb-0">Merci pour cet article très complet. Je cherchais justement des informations sur la conception de buttes de culture.</p>
                        </div>
                    </div>
                </div>

                <!-- Formulaire de commentaire -->
                <div class="comment-form">
                    <h3 class="section-title">Laisser un commentaire</h3>
                    <form>
                        <div class="mb-3">
                            <label for="comment" class="form-label">Votre commentaire</label>
                            <textarea class="form-control" id="comment" rows="4" placeholder="Votre commentaire..."></textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Publier le commentaire</button>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Newsletter -->
                <div class="sidebar-widget">
                    <h5 class="mb-3">Newsletter</h5>
                    <p>Inscrivez-vous pour recevoir nos nouveaux articles</p>
                    <form>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Votre email">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
                    </form>
                </div>

                <!-- Articles populaires -->
                <div class="sidebar-widget">
                    <h5 class="mb-3">Articles populaires</h5>
                    <div class="d-flex mb-3">
                        <img src="https://images.unsplash.com/photo-1597848212624-e9d2c1e7a50d?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" class="flex-shrink-0 me-3" width="60" alt="Article populaire">
                        <div>
                            <h6 class="mt-0">Introduction à la permaculture</h6>
                            <small class="text-muted"><i class="bi bi-calendar me-1"></i> 15 juin 2023</small>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <img src="https://images.unsplash.com/photo-1625246335525-8b5e7e723b64?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" class="flex-shrink-0 me-3" width="60" alt="Article populaire">
                        <div>
                            <h6 class="mt-0">Les bienfaits de l'agriculture biologique</h6>
                            <small class="text-muted"><i class="bi bi-calendar me-1"></i> 10 juin 2023</small>
                        </div>
                    </div>
                    <div class="d-flex">
                        <img src="https://images.unsplash.com/photo-1590172205845-2441aae4bad4?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" class="flex-shrink-0 me-3" width="60" alt="Article populaire">
                        <div>
                            <h6 class="mt-0">Nouvelles techniques d'irrigation</h6>
                            <small class="text-muted"><i class="bi bi-calendar me-1"></i> 5 juin 2023</small>
                        </div>
                    </div>
                </div>

                <!-- Catégories -->
                <div class="sidebar-widget">
                    <h5 class="mb-3">Catégories</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Permaculture
                            <span class="badge bg-primary rounded-pill">12</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Agriculture Bio
                            <span class="badge bg-primary rounded-pill">8</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Techniques
                            <span class="badge bg-primary rounded-pill">5</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Sol
                            <span class="badge bg-primary rounded-pill">3</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Semences
                            <span class="badge bg-primary rounded-pill">7</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    
@endsection
