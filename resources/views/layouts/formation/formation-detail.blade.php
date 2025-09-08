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
        
        .formation-header {
            background-color: var(--primary-color);
            color: white;
            padding: 80px 0;
            margin-bottom: 40px;
        }
        
        .formation-level {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .level-beginner {
            background-color: #e8f5e9;
            color: #2e7d32;
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
        
        .progress-bar {
            background-color: var(--primary-color);
        }
        
        .module-item {
            border-left: 3px solid var(--primary-color);
            padding-left: 15px;
            margin-bottom: 15px;
        }
        
        .instructor-card {
            text-align: center;
        }
        
        .instructor-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }
        
        .pricing-card {
            position: sticky;
            top: 20px;
        }
    </style>

    <!-- En-tête de la formation -->
    <div class="formation-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="formation-level level-beginner mb-3">Débutant</span>
                    <h1 class="display-4 fw-bold mb-3">Maraîchage biologique intensif</h1>
                    <p class="lead mb-4">Apprenez à maximiser votre production sur de petites surfaces avec des techniques écologiques.</p>
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="rating me-3">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                            <span class="ms-1">4.5 (42 avis)</span>
                        </div>
                        <div class="me-3"><i class="bi bi-people me-1"></i> 125 étudiants</div>
                        <div><i class="bi bi-clock me-1"></i> 8h de formation</div>
                    </div>
                </div>
                <div class="col-lg-4 mt-4 mt-lg-0">
                    <div class="card pricing-card">
                        <div class="card-body text-center">
                            <div class="h2 text-primary mb-0">89€</div>
                            <div class="text-muted mb-3">ou 3x 29,67€</div>
                            <a href="payment.html" class="btn btn-primary btn-lg w-100 mb-3">S'inscrire maintenant</a>
                            <div class="text-muted small">Garantie satisfait ou remboursé 30 jours</div>
                            <hr>
                            <ul class="list-unstyled text-start">
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Accès à vie</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> 24 leçons vidéo</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> 5 ressources téléchargeables</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Certificat de completion</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Accès sur mobile et TV</li>
                                <li><i class="bi bi-check-circle text-success me-2"></i> Support formateur</li>
                            </ul>
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
                <!-- Objectifs -->
                <div class="card mb-5">
                    <div class="card-body">
                        <h3 class="section-title">Objectifs de la formation</h3>
                        <p>À la fin de cette formation, vous serez capable de :</p>
                        <ul>
                            <li>Concevoir et planifier un maraîchage bio intensif sur petite surface</li>
                            <li>Maîtriser les techniques de culture intensive respectueuses de l'environnement</li>
                            <li>Optimiser la rotation des cultures et les associations végétales</li>
                            <li>Gérer efficacement l'eau et les ressources naturelles</li>
                            <li>Commercialiser votre production de manière rentable</li>
                        </ul>
                    </div>
                </div>

                <!-- Programme -->
                <div class="card mb-5">
                    <div class="card-body">
                        <h3 class="section-title">Programme de la formation</h3>
                        
                        <div class="accordion" id="programAccordion">
                            <!-- Module 1 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#module1">
                                        <div class="d-flex justify-content-between w-100 me-3">
                                            <span>Module 1 : Introduction au maraîchage bio intensif</span>
                                            <span class="text-muted">4 leçons • 1h20</span>
                                        </div>
                                    </button>
                                </h2>
                                <div id="module1" class="accordion-collapse collapse show" data-bs-parent="#programAccordion">
                                    <div class="accordion-body">
                                        <div class="module-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi bi-play-circle me-2 text-primary"></i>
                                                    <span>Présentation du concept de maraîchage bio intensif</span>
                                                </div>
                                                <span class="text-muted">25 min</span>
                                            </div>
                                        </div>
                                        <div class="module-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi bi-play-circle me-2 text-primary"></i>
                                                    <span>Avantages et défis de cette approche</span>
                                                </div>
                                                <span class="text-muted">20 min</span>
                                            </div>
                                        </div>
                                        <div class="module-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi bi-file-text me-2 text-primary"></i>
                                                    <span>Fiche technique : Calcul de rentabilité</span>
                                                </div>
                                                <span class="text-muted">PDF</span>
                                            </div>
                                        </div>
                                        <div class="module-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi bi-play-circle me-2 text-primary"></i>
                                                    <span>Étude de cas : Une micro-ferme réussie</span>
                                                </div>
                                                <span class="text-muted">35 min</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Module 2 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#module2">
                                        <div class="d-flex justify-content-between w-100 me-3">
                                            <span>Module 2 : Préparation du sol et planification</span>
                                            <span class="text-muted">5 leçons • 1h45</span>
                                        </div>
                                    </button>
                                </h2>
                                <div id="module2" class="accordion-collapse collapse" data-bs-parent="#programAccordion">
                                    <div class="accordion-body">
                                        <div class="module-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi bi-play-circle me-2 text-primary"></i>
                                                    <span>Analyse et préparation du sol</span>
                                                </div>
                                                <span class="text-muted">30 min</span>
                                            </div>
                                        </div>
                                        <div class="module-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi bi-play-circle me-2 text-primary"></i>
                                                    <span>Conception des planches de culture</span>
                                                </div>
                                                <span class="text-muted">25 min</span>
                                            </div>
                                        </div>
                                        <div class="module-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi bi-play-circle me-2 text-primary"></i>
                                                    <span>Planification des rotations culturales</span>
                                                </div>
                                                <span class="text-muted">20 min</span>
                                            </div>
                                        </div>
                                        <div class="module-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi bi-file-text me-2 text-primary"></i>
                                                    <span>Calendrier cultural personnalisable</span>
                                                </div>
                                                <span class="text-muted">PDF</span>
                                            </div>
                                        </div>
                                        <div class="module-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi bi-play-circle me-2 text-primary"></i>
                                                    <span>Atelier pratique : Concevoir son plan</span>
                                                </div>
                                                <span class="text-muted">30 min</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Modules supplémentaires (réduits pour la démo) -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#module3">
                                        <div class="d-flex justify-content-between w-100 me-3">
                                            <span>Module 3 : Techniques de culture intensive</span>
                                            <span class="text-muted">6 leçons • 2h10</span>
                                        </div>
                                    </button>
                                </h2>
                                <div id="module3" class="accordion-collapse collapse" data-bs-parent="#programAccordion">
                                    <div class="accordion-body">
                                        Contenu du module...
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#module4">
                                        <div class="d-flex justify-content-between w-100 me-3">
                                            <span>Module 4 : Gestion de l'eau et irrigation</span>
                                            <span class="text-muted">4 leçons • 1h30</span>
                                        </div>
                                    </button>
                                </h2>
                                <div id="module4" class="accordion-collapse collapse" data-bs-parent="#programAccordion">
                                    <div class="accordion-body">
                                        Contenu du module...
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#module5">
                                        <div class="d-flex justify-content-between w-100 me-3">
                                            <span>Module 5 : Commercialisation et rentabilité</span>
                                            <span class="text-muted">5 leçons • 1h15</span>
                                        </div>
                                    </button>
                                </h2>
                                <div id="module5" class="accordion-collapse collapse" data-bs-parent="#programAccordion">
                                    <div class="accordion-body">
                                        Contenu du module...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formateur -->
                <div class="card mb-5">
                    <div class="card-body">
                        <h3 class="section-title">Votre formateur</h3>
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Formateur" class="instructor-img">
                            </div>
                            <div class="col-md-9">
                                <h4>Jean Martin</h4>
                                <p class="text-muted">Expert en agriculture biologique</p>
                                <p>Agriculteur bio depuis 15 ans, Jean Martin a transformé sa ferme familiale en modèle de maraîchage bio intensif. Diplômé en agronomie, il partage maintenant son expertise à travers des formations et des consultations.</p>
                                <div class="d-flex flex-wrap">
                                    <div class="me-4 mb-2">
                                        <div class="h5 mb-0">4.7/5</div>
                                        <small>Note moyenne</small>
                                    </div>
                                    <div class="me-4 mb-2">
                                        <div class="h5 mb-0">1,245</div>
                                        <small>Étudiants</small>
                                    </div>
                                    <div class="mb-2">
                                        <div class="h5 mb-0">8</div>
                                        <small>Formations</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Avis -->
                <div class="card mb-5">
                    <div class="card-body">
                        <h3 class="section-title">Avis des étudiants</h3>
                        
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
                                <div class="text-muted">Note moyenne • 42 avis</div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-2">
                                    <div class="d-flex align-items-center">
                                        <span class="me-2">5</span>
                                        <div class="progress flex-grow-1" style="height: 8px;">
                                            <div class="progress-bar" style="width: 70%;"></div>
                                        </div>
                                        <span class="ms-2">70%</span>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="d-flex align-items-center">
                                        <span class="me-2">4</span>
                                        <div class="progress flex-grow-1" style="height: 8px;">
                                            <div class="progress-bar" style="width: 20%;"></div>
                                        </div>
                                        <span class="ms-2">20%</span>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="d-flex align-items-center">
                                        <span class="me-2">3</span>
                                        <div class="progress flex-grow-1" style="height: 8px;">
                                            <div class="progress-bar" style="width: 7%;"></div>
                                        </div>
                                        <span class="ms-2">7%</span>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="d-flex align-items-center">
                                        <span class="me-2">2</span>
                                        <div class="progress flex-grow-1" style="height: 8px;">
                                            <div class="progress-bar" style="width: 2%;"></div>
                                        </div>
                                        <span class="ms-2">2%</span>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="d-flex align-items-center">
                                        <span class="me-2">1</span>
                                        <div class="progress flex-grow-1" style="height: 8px;">
                                            <div class="progress-bar" style="width: 1%;"></div>
                                        </div>
                                        <span class="ms-2">1%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Avis 1 -->
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-4.0.3&auto=format&fit=crop&w=50&q=80" alt="Avatar" class="rounded-circle me-2" width="40">
                                <div>
                                    <div>Marie L.</div>
                                    <div class="rating small">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                </div>
                            </div>
                            <h5>Formation complète et pratique</h5>
                            <p>J'ai beaucoup apprécié cette formation qui m'a donné toutes les clés pour démarrer mon projet de maraîchage. Les exercices pratiques sont particulièrement utiles.</p>
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
                            <h5>Contenu de qualité</h5>
                            <p>Le formateur est très compétent et sait transmettre son savoir. J'ai particulièrement apprécié les études de cas concrets.</p>
                            <small class="text-muted">Publié il y a 1 mois</small>
                        </div>
                        
                        <a href="#" class="btn btn-outline-primary">Voir tous les avis</a>
                    </div>
                </div>

                <!-- FAQ -->
                <div class="card">
                    <div class="card-body">
                        <h3 class="section-title">Questions fréquentes</h3>
                        
                        <div class="accordion" id="faqAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                        Pendant combien de temps ai-je accès à la formation ?
                                    </button>
                                </h2>
                                <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Vous avez un accès à vie à cette formation. Après votre inscription, vous pouvez y accéder à tout moment, sur tous vos appareils.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                        Que se passe-t-il si je ne suis pas satisfait de la formation ?
                                    </button>
                                </h2>
                                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Nous offrons une garantie satisfait ou remboursé de 30 jours. Si vous n'êtes pas satisfait de la formation, contactez-nous dans les 30 jours suivant votre achat pour obtenir un remboursement intégral.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                        Ai-je besoin de matériel particulier pour suivre cette formation ?
                                    </button>
                                </h2>
                                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Non, aucun matériel particulier n'est nécessaire pour suivre la formation. Cependant, si vous souhaitez mettre en pratique les techniques enseignées, vous aurez besoin d'un accès à un terrain, même de petite taille.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Card d'inscription (visible uniquement sur mobile) -->
                <div class="card d-lg-none mb-4">
                    <div class="card-body text-center">
                        <div class="h2 text-primary mb-0">89€</div>
                        <div class="text-muted mb-3">ou 3x 29,67€</div>
                        <a href="payment.html" class="btn btn-primary btn-lg w-100 mb-3">S'inscrire maintenant</a>
                        <div class="text-muted small">Garantie satisfait ou remboursé 30 jours</div>
                    </div>
                </div>

                <!-- Statistiques -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Cette formation comprend</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-play-btn me-2 text-primary"></i> 8h de vidéo à la demande</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-file-text me-2 text-primary"></i> 5 ressources téléchargeables</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-phone me-2 text-primary"></i> Accès sur mobile et TV</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-infinity me-2 text-primary"></i> Accès à vie</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-award me-2 text-primary"></i> Certificat de completion</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Formations similaires -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Formations similaires</h5>
                        
                        <div class="d-flex mb-3">
                            <img src="https://images.unsplash.com/photo-1416879595882-3373a0480b5b?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" class="flex-shrink-0 me-3" width="80" alt="Formation">
                            <div>
                                <h6 class="mt-0">Initiation à l'apiculture</h6>
                                <div class="rating small mb-1">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star"></i>
                                    <span class="ms-1">(28)</span>
                                </div>
                                <div class="text-primary fw-bold">69€</div>
                            </div>
                        </div>
                        
                        <div class="d-flex">
                            <img src="https://images.unsplash.com/photo-1593686340314-42f27a1e50c9?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" class="flex-shrink-0 me-3" width="80" alt="Formation">
                            <div>
                                <h6 class="mt-0">Maîtriser l'art du compostage</h6>
                                <div class="rating small mb-1">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <span class="ms-1">(56)</span>
                                </div>
                                <div class="text-primary fw-bold">49€</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
