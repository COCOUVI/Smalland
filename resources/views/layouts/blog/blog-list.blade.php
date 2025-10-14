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
        
        .tag-cloud a {
            display: inline-block;
            padding: 5px 10px;
            background-color: #f1f1f1;
            border-radius: 4px;
            margin: 0 5px 5px 0;
            color: var(--dark-color);
            text-decoration: none;
        }
        
        .tag-cloud a:hover {
            background-color: var(--primary-color);
            color: white;
        }
    </style>

    <!-- En-tête de page -->
    <div class="page-header">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Blog Agronomie</h1>
            <p class="lead">Découvrez tous nos articles sur l'agriculture moderne, l'écologie et le développement durable</p>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="container">
        <div class="row">
            <!-- Colonne principale -->
            <div class="col-lg-8">
                <!-- Filtres -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <span class="me-2">Filtrer par :</span>
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-primary active">Tous</button>
                            <button type="button" class="btn btn-outline-primary">Permaculture</button>
                            <button type="button" class="btn btn-outline-primary">Agriculture Bio</button>
                            <button type="button" class="btn btn-outline-primary">Techniques</button>
                        </div>
                    </div>
                    <div>
                        <span class="me-2">Trier par :</span>
                        <select class="form-select form-select-sm d-inline-block w-auto">
                            <option>Plus récents</option>
                            <option>Plus populaires</option>
                            <option>Plus commentés</option>
                        </select>
                    </div>
                </div>

                <!-- Liste des articles -->
                <div class="row">
                    <!-- Article 1 -->
                    <div class="col-md-6 mb-4">
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
                            <div class="card-footer bg-transparent d-flex justify-content-between">
                                <small><i class="bi bi-eye me-1"></i> 245</small>
                                <small><i class="bi bi-chat me-1"></i> 12</small>
                                <small><i class="bi bi-heart me-1"></i> 42</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Article 2 -->
                    <div class="col-md-6 mb-4">
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
                            <div class="card-footer bg-transparent d-flex justify-content-between">
                                <small><i class="bi bi-eye me-1"></i> 189</small>
                                <small><i class="bi bi-chat me-1"></i> 8</small>
                                <small><i class="bi bi-heart me-1"></i> 35</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Article 3 -->
                    <div class="col-md-6 mb-4">
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
                            <div class="card-footer bg-transparent d-flex justify-content-between">
                                <small><i class="bi bi-eye me-1"></i> 156</small>
                                <small><i class="bi bi-chat me-1"></i> 5</small>
                                <small><i class="bi bi-heart me-1"></i> 28</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Article 4 -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <span class="category-badge badge bg-warning text-dark">Sol</span>
                            <img src="https://images.unsplash.com/photo-1597848212624-e9d2c1e7a50d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Analyse de sol">
                            <div class="card-body">
                                <h5 class="card-title">Comment analyser votre sol</h5>
                                <p class="card-text">Apprenez à comprendre la composition de votre sol pour améliorer vos cultures.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">1 juin 2023</small>
                                    <a href="blog-article.html" class="btn btn-sm btn-primary">Lire la suite</a>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent d-flex justify-content-between">
                                <small><i class="bi bi-eye me-1"></i> 132</small>
                                <small><i class="bi bi-chat me-1"></i> 7</small>
                                <small><i class="bi bi-heart me-1"></i> 24</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Article 5 -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <span class="category-badge badge bg-primary">Permaculture</span>
                            <img src="https://images.unsplash.com/photo-1597848212624-e9d2c1e7a50d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Design permaculture">
                            <div class="card-body">
                                <h5 class="card-title">Concevoir un design en permaculture</h5>
                                <p class="card-text">Les étapes essentielles pour créer un design efficace en permaculture.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">28 mai 2023</small>
                                    <a href="blog-article.html" class="btn btn-sm btn-primary">Lire la suite</a>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent d-flex justify-content-between">
                                <small><i class="bi bi-eye me-1"></i> 178</small>
                                <small><i class="bi bi-chat me-1"></i> 9</small>
                                <small><i class="bi bi-heart me-1"></i> 31</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Article 6 -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <span class="category-badge badge bg-success">Agriculture Bio</span>
                            <img src="https://images.unsplash.com/photo-1625246335525-8b5e7e723b64?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Certification bio">
                            <div class="card-body">
                                <h5 class="card-title">Obtenir une certification bio</h5>
                                <p class="card-text">Le guide complet pour obtenir la certification agriculture biologique.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">25 mai 2023</small>
                                    <a href="blog-article.html" class="btn btn-sm btn-primary">Lire la suite</a>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent d-flex justify-content-between">
                                <small><i class="bi bi-eye me-1"></i> 201</small>
                                <small><i class="bi bi-chat me-1"></i> 14</small>
                                <small><i class="bi bi-heart me-1"></i> 37</small>
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

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Recherche -->
                <div class="sidebar-widget">
                    <h5 class="mb-3">Rechercher</h5>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Mot-clé...">
                        <button class="btn btn-primary" type="button"><i class="bi bi-search"></i></button>
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

                <!-- Tags -->
                <div class="sidebar-widget">
                    <h5 class="mb-3">Tags</h5>
                    <div class="tag-cloud">
                        <a href="#">permaculture</a>
                        <a href="#">bio</a>
                        <a href="#">compost</a>
                        <a href="#">irrigation</a>
                        <a href="#">sol</a>
                        <a href="#">semences</a>
                        <a href="#">jardinage</a>
                        <a href="#">durable</a>
                        <a href="#">écologie</a>
                        <a href="#">agriculture</a>
                    </div>
                </div>

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
            </div>
        </div>
    </div>

    
@endsection
