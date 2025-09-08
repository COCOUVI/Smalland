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
            padding: 40px 0;
            margin-bottom: 40px;
        }
        
        .card {
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
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
        
        .tracking-timeline {
            position: relative;
            padding: 20px 0;
        }
        
        .tracking-timeline::before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 30px;
            width: 2px;
            background-color: var(--primary-color);
        }
        
        .tracking-step {
            position: relative;
            padding-left: 70px;
            margin-bottom: 30px;
        }
        
        .tracking-step::before {
            content: '';
            position: absolute;
            left: 24px;
            top: 5px;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background-color: white;
            border: 2px solid var(--primary-color);
            z-index: 2;
        }
        
        .tracking-step.active::before {
            background-color: var(--primary-color);
        }
        
        .tracking-step.completed::before {
            background-color: var(--primary-color);
        }
        
        .tracking-step.completed::after {
            content: '✓';
            position: absolute;
            left: 26px;
            top: 3px;
            color: white;
            font-size: 12px;
            z-index: 3;
        }
        
        .tracking-icon {
            position: absolute;
            left: 15px;
            top: 0;
            width: 30px;
            height: 30px;
            background-color: white;
            border: 2px solid var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
        }
        
        .tracking-step.active .tracking-icon,
        .tracking-step.completed .tracking-icon {
            background-color: var(--primary-color);
            color: white;
        }
        
        .order-status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .status-processing {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-shipped {
            background-color: #cce5ff;
            color: #004085;
        }
        
        .status-delivered {
            background-color: #d4edda;
            color: #155724;
        }
    </style>
 <!-- En-tête de page -->
    <div class="page-header">
        <div class="container text-center">
            <h1 class="display-5 fw-bold">Suivi de commande</h1>
            <p class="lead">Suivez l'état d'avancement de votre commande</p>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="container">
        <!-- Recherche de commande -->
        <div class="card mb-5">
            <div class="card-body">
                <h3 class="section-title">Rechercher une commande</h3>
                <p class="text-muted mb-4">Entrez votre numéro de commande et votre email pour suivre votre colis</p>
                
                <form class="row g-3">
                    <div class="col-md-6">
                        <label for="orderNumber" class="form-label">Numéro de commande</label>
                        <input type="text" class="form-control" id="orderNumber" placeholder="Ex: CMD-123456">
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Votre email">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Rechercher la commande</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Détails de la commande -->
        <div class="row">
            <div class="col-lg-8">
                <!-- Résultats de la recherche (affichés après recherche) -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="card-title mb-0">Commande #CMD-123456</h3>
                            <span class="order-status-badge status-shipped">Expédiée</span>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6>Date de commande</h6>
                                <p>15 juin 2023 à 14:30</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Date d'expédition</h6>
                                <p>16 juin 2023 à 09:15</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Méthode de livraison</h6>
                                <p>Livraison standard - Colissimo</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Numéro de suivi</h6>
                                <p>8X123456789FR</p>
                            </div>
                        </div>
                        
                        <h5 class="mb-3">Articles commandés</h5>
                        
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th>Prix</th>
                                        <th>Quantité</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://images.unsplash.com/photo-1595341888016-a392ef81b7de?ixlib=rb-4.0.3&auto=format&fit=crop&w=50&q=80" class="me-3" width="40" alt="Produit">
                                                <div>Kit de jardinage débutant</div>
                                            </div>
                                        </td>
                                        <td>39,90€</td>
                                        <td>1</td>
                                        <td>39,90€</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://images.unsplash.com/photo-1471194402529-8e0f5a675de6?ixlib=rb-4.0.3&auto=format&fit=crop&w=50&q=80" class="me-3" width="40" alt="Produit">
                                                <div>Coffret graines bio</div>
                                            </div>
                                        </td>
                                        <td>24,90€</td>
                                        <td>2</td>
                                        <td>49,80€</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://images.unsplash.com/photo-1596461404969-9b70b3e2a60d?ixlib=rb-4.0.3&auto=format&fit=crop&w=50&q=80" class="me-3" width="40" alt="Produit">
                                                <div>Arrosoir écologique</div>
                                            </div>
                                        </td>
                                        <td>32,50€</td>
                                        <td>1</td>
                                        <td>32,50€</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end">Sous-total</td>
                                        <td>122,20€</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end">Frais de livraison</td>
                                        <td>4,90€</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Total</td>
                                        <td class="fw-bold">127,10€</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Adresse de livraison -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Adresse de livraison</h5>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Adresse de livraison</h6>
                                <p>
                                    Marie Dupont<br>
                                    25 Rue des Jardins<br>
                                    75000 Paris<br>
                                    France
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Adresse de facturation</h6>
                                <p>
                                    Marie Dupont<br>
                                    25 Rue des Jardins<br>
                                    75000 Paris<br>
                                    France
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Timeline de suivi -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Suivi de livraison</h5>
                        
                        <div class="tracking-timeline">
                            <div class="tracking-step completed">
                                <div class="tracking-icon">
                                    <i class="bi bi-cart"></i>
                                </div>
                                <h6>Commande confirmée</h6>
                                <p class="text-muted mb-0">15 juin 2023, 14:30</p>
                                <p>Votre commande a été confirmée et est en préparation.</p>
                            </div>
                            
                            <div class="tracking-step completed">
                                <div class="tracking-icon">
                                    <i class="bi bi-gear"></i>
                                </div>
                                <h6>En préparation</h6>
                                <p class="text-muted mb-0">15 juin 2023, 16:45</p>
                                <p>Votre commande est en cours de préparation.</p>
                            </div>
                            
                            <div class="tracking-step completed">
                                <div class="tracking-icon">
                                    <i class="bi bi-box"></i>
                                </div>
                                <h6>Expédiée</h6>
                                <p class="text-muted mb-0">16 juin 2023, 09:15</p>
                                <p>Votre commande a été expédiée.</p>
                            </div>
                            
                            <div class="tracking-step active">
                                <div class="tracking-icon">
                                    <i class="bi bi-truck"></i>
                                </div>
                                <h6>En transit</h6>
                                <p class="text-muted mb-0">16 juin 2023, 14:20</p>
                                <p>Votre colis est en cours de livraison.</p>
                            </div>
                            
                            <div class="tracking-step">
                                <div class="tracking-icon">
                                    <i class="bi bi-house-door"></i>
                                </div>
                                <h6>Livrée</h6>
                                <p class="text-muted mb-0">Estimation: 19 juin 2023</p>
                                <p>Votre colis sera livré à l'adresse indiquée.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Support -->
                <div class="card mt-4">
                    <div class="card-body text-center">
                        <i class="bi bi-headset display-6 text-primary mb-3"></i>
                        <h5>Un problème avec votre commande ?</h5>
                        <p class="text-muted">Notre équipe est là pour vous aider</p>
                        <a href="#" class="btn btn-outline-primary me-2">Contacter le support</a>
                    </div>
                </div>
                
                <!-- Historique des commandes -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Historique des commandes</h5>
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="mb-0">CMD-123123</h6>
                                <small class="text-muted">10 juin 2023</small>
                            </div>
                            <span class="badge bg-success">Livrée</span>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="mb-0">CMD-122987</h6>
                                <small class="text-muted">5 juin 2023</small>
                            </div>
                            <span class="badge bg-success">Livrée</span>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">CMD-122654</h6>
                                <small class="text-muted">1 juin 2023</small>
                            </div>
                            <span class="badge bg-success">Livrée</span>
                        </div>
                        
                        <div class="text-center mt-3">
                            <a href="#" class="btn btn-sm btn-outline-primary">Voir tout l'historique</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
