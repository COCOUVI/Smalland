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
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .category-card {
            height: 100%;
            position: relative;
            overflow: hidden;
            border-radius: 8px;
        }
        
        .category-card img {
            transition: transform 0.5s;
        }
        
        .category-card:hover img {
            transform: scale(1.1);
        }
        
        .category-card .overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            padding: 20px;
            color: white;
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
    </style>
    <!-- En-tête de page -->
    <div class="page-header">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Catégories du blog</h1>
            <p class="lead">Explorez nos articles par thématiques</p>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="container">
        <div class="row">
            <!-- Catégorie 1 -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card category-card">
                    <img src="https://images.unsplash.com/photo-1597848212624-e9d2c1e7a50d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Permaculture">
                    <div class="overlay">
                        <h3 class="card-title">Permaculture</h3>
                        <p class="card-text">12 articles</p>
                        <a href="blog-list.html?category=permaculture" class="btn btn-sm btn-light">Voir les articles</a>
                    </div>
                </div>
            </div>
            
            <!-- Catégorie 2 -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card category-card">
                    <img src="https://images.unsplash.com/photo-1625246335525-8b5e7e723b64?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Agriculture Bio">
                    <div class="overlay">
                        <h3 class="card-title">Agriculture Bio</h3>
                        <p class="card-text">8 articles</p>
                        <a href="blog-list.html?category=agriculture-bio" class="btn btn-sm btn-light">Voir les articles</a>
                    </div>
                </div>
            </div>
            
            <!-- Catégorie 3 -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card category-card">
                    <img src="https://images.unsplash.com/photo-1590172205845-2441aae4bad4?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Techniques">
                    <div class="overlay">
                        <h3 class="card-title">Techniques</h3>
                        <p class="card-text">5 articles</p>
                        <a href="blog-list.html?category=techniques" class="btn btn-sm btn-light">Voir les articles</a>
                    </div>
                </div>
            </div>
            
            <!-- Catégorie 4 -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card category-card">
                    <img src="https://images.unsplash.com/photo-1596461404969-9b70b3e2a60d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Sol">
                    <div class="overlay">
                        <h3 class="card-title">Sol</h3>
                        <p class="card-text">3 articles</p>
                        <a href="blog-list.html?category=sol" class="btn btn-sm btn-light">Voir les articles</a>
                    </div>
                </div>
            </div>
            
            <!-- Catégorie 5 -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card category-card">
                    <img src="https://images.unsplash.com/photo-1416879595882-3373a0480b5b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Semences">
                    <div class="overlay">
                        <h3 class="card-title">Semences</h3>
                        <p class="card-text">7 articles</p>
                        <a href="blog-list.html?category=semences" class="btn btn-sm btn-light">Voir les articles</a>
                    </div>
                </div>
            </div>
            
            <!-- Catégorie 6 -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card category-card">
                    <img src="https://images.unsplash.com/photo-1589923188937-cb64779f4abe?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Élevage">
                    <div class="overlay">
                        <h3 class="card-title">Élevage</h3>
                        <p class="card-text">4 articles</p>
                        <a href="blog-list.html?category=elevage" class="btn btn-sm btn-light">Voir les articles</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Description des catégories -->
        <div class="row mt-5">
            <div class="col-lg-8 mx-auto">
                <h2 class="section-title text-center">Explorez nos thématiques</h2>
                
                <div class="accordion" id="categoriesAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                Permaculture
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#categoriesAccordion">
                            <div class="accordion-body">
                                La permaculture est une méthode de conception systémique qui s'inspire des écosystèmes naturels pour créer des environnements durables et productifs. Découvrez nos articles sur les principes de conception, les techniques de culture et les designs permaculturels.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                Agriculture Bio
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#categoriesAccordion">
                            <div class="accordion-body">
                                L'agriculture biologique privilégie les pratiques respectueuses de l'environnement et de la santé. Explorez nos articles sur les méthodes de culture bio, la certification, la lutte biologique contre les parasites et bien plus encore.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                Techniques Agricoles
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#categoriesAccordion">
                            <div class="accordion-body">
                                Des méthodes traditionnelles aux innovations modernes, découvrez les techniques qui font avancer l'agriculture. Irrigation, travail du sol, semis direct, agriculture de précision...
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                                Sol
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#categoriesAccordion">
                            <div class="accordion-body">
                                Le sol est la base de toute production agricole. Apprenez à analyser, améliorer et entretenir la santé de votre sol pour des cultures plus productives et résilientes.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive">
                                Semences
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#categoriesAccordion">
                            <div class="accordion-body">
                                Des semences de qualité sont essentielles pour de bonnes récoltes. Découvrez comment sélectionner, conserver et reproduire vos semences, ainsi que les enjeux autour de la biodiversité cultivée.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix">
                                Élevage
                            </button>
                        </h2>
                        <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#categoriesAccordion">
                            <div class="accordion-body">
                                L'élevage intégré à l'agriculture offre de nombreux avantages. Explorez nos articles sur les pratiques d'élevage respectueuses des animaux et de l'environnement, et sur l'intégration entre cultures et élevage.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
