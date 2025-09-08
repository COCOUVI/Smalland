@extends('master')

@section('content')
 <!-- En-tête du tableau de bord -->
    <div class="dashboard-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-5 fw-bold">Espace étudiant</h1>
                    <p class="lead">Bienvenue Marie, continuez votre apprentissage</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="formations-catalog.html" class="btn btn-light">Découvrir de nouvelles formations</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="card sidebar">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Avatar" class="rounded-circle mb-2" width="80">
                            <h5>Marie Dupont</h5>
                            <p class="text-muted">Étudiante depuis juin 2023</p>
                        </div>
                        
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">
                                    <i class="bi bi-house"></i> Tableau de bord
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="bi bi-collection-play"></i> Mes formations
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="bi bi-award"></i> Certificats
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="bi bi-bookmark"></i> Favoris
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="bi bi-credit-card"></i> Facturation
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="bi bi-gear"></i> Paramètres
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="bi bi-question-circle"></i> Aide
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- Statistiques -->
                <div class="card mt-4">
                    <div class="card-body stats-card">
                        <i class="bi bi-play-btn display-6 text-primary mb-3"></i>
                        <div class="stats-number">12h</div>
                        <p>de formation suivies</p>
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-body stats-card">
                        <i class="bi bi-award display-6 text-primary mb-3"></i>
                        <div class="stats-number">2</div>
                        <p>certificats obtenus</p>
                    </div>
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="col-lg-9">
                <!-- Progression globale -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="section-title">Votre progression</h3>
                        <div class="progress mb-3" style="height: 20px;">
                            <div class="progress-bar" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">65%</div>
                        </div>
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="h4 mb-0">3</div>
                                <div class="text-muted">Formations</div>
                            </div>
                            <div class="col-md-3">
                                <div class="h4 mb-0">2</div>
                                <div class="text-muted">Terminées</div>
                            </div>
                            <div class="col-md-3">
                                <div class="h4 mb-0">1</div>
                                <div class="text-muted">En cours</div>
                            </div>
                            <div class="col-md-3">
                                <div class="h4 mb-0">4</div>
                                <div class="text-muted">Leçons cette semaine</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formations en cours -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="section-title">Formations en cours</h3>
                        
                        <div class="row">
                            <!-- Formation 1 -->
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <span class="certificate-badge badge bg-warning text-dark">En cours</span>
                                    <img src="https://images.unsplash.com/photo-1518531933037-91b2f5f229cc?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Maraîchage">
                                    <div class="card-body">
                                        <h5 class="card-title">Maraîchage biologique intensif</h5>
                                        <p class="card-text">Apprenez à maximiser votre production sur de petites surfaces avec des techniques écologiques.</p>
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between mb-1">
                                                <small>Progression</small>
                                                <small>75%</small>
                                            </div>
                                            <div class="progress course-progress">
                                                <div class="progress-bar" style="width: 75%;"></div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">8h de formation</small>
                                            <a href="#" class="btn btn-sm btn-primary continue-btn">Continuer</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Formation 2 -->
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <span class="certificate-badge badge bg-warning text-dark">En cours</span>
                                    <img src="https://images.unsplash.com/photo-1593686340314-42f27a1e50c9?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Compostage">
                                    <div class="card-body">
                                        <h5 class="card-title">Maîtriser l'art du compostage</h5>
                                        <p class="card-text">Transformez vos déchets en or noir pour votre jardin avec les techniques de compostage.</p>
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between mb-1">
                                                <small>Progression</small>
                                                <small>30%</small>
                                            </div>
                                            <div class="progress course-progress">
                                                <div class="progress-bar" style="width: 30%;"></div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">5h de formation</small>
                                            <a href="#" class="btn btn-sm btn-primary continue-btn">Continuer</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formations terminées -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="section-title">Formations terminées</h3>
                        
                        <div class="row">
                            <!-- Formation 1 -->
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <span class="certificate-badge badge bg-success">Terminé</span>
                                    <img src="https://images.unsplash.com/photo-1416879595882-3373a0480b5b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Apiculture">
                                    <div class="card-body">
                                        <h5 class="card-title">Initiation à l'apiculture</h5>
                                        <p class="card-text">Découvrez les bases de l'apiculture et comment installer votre première ruche.</p>
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between mb-1">
                                                <small>Progression</small>
                                                <small>100%</small>
                                            </div>
                                            <div class="progress course-progress">
                                                <div class="progress-bar" style="width: 100%;"></div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">Terminé le 15/06/2023</small>
                                            <a href="#" class="btn btn-sm btn-outline-primary continue-btn">Voir certificat</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Formation 2 -->
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <span class="certificate-badge badge bg-success">Terminé</span>
                                    <img src="https://images.unsplash.com/photo-1590172205845-2441aae4bad4?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Irrigation">
                                    <div class="card-body">
                                        <h5 class="card-title">Gestion de l'eau au jardin</h5>
                                        <p class="card-text">Techniques pour économiser l'eau et optimiser son utilisation au potager.</p>
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between mb-1">
                                                <small>Progression</small>
                                                <small>100%</small>
                                            </div>
                                            <div class="progress course-progress">
                                                <div class="progress-bar" style="width: 100%;"></div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">Terminé le 10/06/2023</small>
                                            <a href="#" class="btn btn-sm btn-outline-primary continue-btn">Voir certificat</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activité récente -->
                <div class="card">
                    <div class="card-body">
                        <h3 class="section-title">Activité récente</h3>
                        
                        <div class="list-group">
                            <div class="list-group-item border-0">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Leçon "Planification des rotations culturales" terminée</h6>
                                    <small class="text-muted">Aujourd'hui, 14:32</small>
                                </div>
                                <p class="mb-1">Maraîchage biologique intensif</p>
                            </div>
                            
                            <div class="list-group-item border-0">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Quiz "Techniques de compostage" réussi</h6>
                                    <small class="text-muted">Hier, 18:15</small>
                                </div>
                                <p class="mb-1">Maîtriser l'art du compostage</p>
                                <small class="text-muted">Score: 85%</small>
                            </div>
                            
                            <div class="list-group-item border-0">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Certificat obtenu</h6>
                                    <small class="text-muted">15 juin 2023</small>
                                </div>
                                <p class="mb-1">Initiation à l'apiculture</p>
                                <small class="text-muted">Félicitations !</small>
                            </div>
                            
                            <div class="list-group-item border-0">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Nouvelle formation commencée</h6>
                                    <small class="text-muted">12 juin 2023</small>
                                </div>
                                <p class="mb-1">Maîtriser l'art du compostage</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
