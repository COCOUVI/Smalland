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
        padding: 40px 0;
        margin-bottom: 40px;
    }
    
    .card {
        margin-bottom: 20px;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
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
</style>

<div class="page-header">
    <div class="container text-center">
        <h1 class="display-5 fw-bold">Suivi de commande</h1>
        <p class="lead">Suivez l'état d'avancement de votre commande</p>
    </div>
</div>

<div class="container">
    <!-- Recherche de commande -->
    <div class="card mb-5">
        <div class="card-body">
            <h3 class="mb-3">Rechercher une commande</h3>
            <p class="text-muted mb-4">Entrez votre code de commande pour suivre votre colis</p>
            
            <form method="GET" action="{{ route('order.track') }}" class="row g-3">
                <div class="col-md-8">
                    <label for="orderCode" class="form-label">Code de commande</label>
                    <input type="text" class="form-control" name="order_code" 
                        placeholder="Ex: CMD-2025-001" value="{{ request('order_code') }}" required>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-2"></i>Rechercher
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(isset($order))
        <!-- Détails de la commande -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="card-title mb-0">Commande {{ $order->order_code }}</h3>
                            <span class="badge {{ $order->statusBadgeClass }} fs-6">
                                {{ $order->statusLabel }}
                            </span>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6>Date de commande</h6>
                                <p>{{ $order->created_at->format('d/m/Y à H:i') }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Méthode de livraison</h6>
                                <p>
                                    @if($order->mode_livraison == 'standard')
                                        Livraison Standard
                                    @elseif($order->mode_livraison == 'express')
                                        Livraison Express
                                    @else
                                        Retrait en magasin
                                    @endif
                                </p>
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
                                    @foreach($order->products as $product)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($product->path_img)
                                                        <img src="{{ asset('produits/' . $product->path_img) }}" 
                                                            class="me-3" width="40" alt="{{ $product->nom }}">
                                                    @endif
                                                    <div>{{ $product->nom }}</div>
                                                </div>
                                            </td>
                                            <td>{{ number_format($product->prix, 0, ',', ' ') }} FCFA</td>
                                            <td>{{ $product->pivot->qte_commander }}</td>
                                            <td>{{ number_format($product->prix * $product->pivot->qte_commander, 0, ',', ' ') }} FCFA</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Total</td>
                                        <td class="fw-bold">{{ number_format($order->price_total_order, 0, ',', ' ') }} FCFA</td>
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
                        <p><i class="bi bi-geo-alt me-2"></i>{{ $order->addresse }}</p>
                        <p><i class="bi bi-telephone me-2"></i>{{ $order->telephone }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Timeline de suivi -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Suivi de livraison</h5>
                        
                        <div class="tracking-timeline">
                            <!-- Commande confirmée -->
                            <div class="tracking-step {{ in_array($order->status, ['pending', 'confirmed', 'processing', 'shipped', 'delivered']) ? 'completed' : '' }}">
                                <div class="tracking-icon">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                                <h6>Commande confirmée</h6>
                                <p class="text-muted mb-0">{{ $order->created_at->format('d/m/Y, H:i') }}</p>
                                <p class="small">Votre commande a été reçue</p>
                            </div>
                            
                            <!-- En préparation -->
                            <div class="tracking-step {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'completed' : ($order->status == 'confirmed' ? 'active' : '') }}">
                                <div class="tracking-icon">
                                    <i class="bi bi-box-seam"></i>
                                </div>
                                <h6>En préparation</h6>
                                <p class="small">Vos articles sont en cours de préparation</p>
                            </div>
                            
                            <!-- Expédiée -->
                            <div class="tracking-step {{ in_array($order->status, ['shipped', 'delivered']) ? 'completed' : ($order->status == 'processing' ? 'active' : '') }}">
                                <div class="tracking-icon">
                                    <i class="bi bi-truck"></i>
                                </div>
                                <h6>Expédiée</h6>
                                <p class="small">Votre commande est en route</p>
                            </div>
                            
                            <!-- Livrée -->
                            <div class="tracking-step {{ $order->status == 'delivered' ? 'completed' : ($order->status == 'shipped' ? 'active' : '') }}">
                                <div class="tracking-icon">
                                    <i class="bi bi-house-check"></i>
                                </div>
                                <h6>Livrée</h6>
                                <p class="small">Commande livrée avec succès</p>
                            </div>
                            
                            @if($order->status == 'cancelled')
                                <div class="alert alert-danger mt-3">
                                    <i class="bi bi-x-circle me-2"></i>
                                    <strong>Commande annulée</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Support -->
                <div class="card mt-4">
                    <div class="card-body text-center">
                        <i class="bi bi-headset display-6 text-primary mb-3"></i>
                        <h5>Besoin d'aide ?</h5>
                        <p class="text-muted">Notre équipe est là pour vous</p>
                        <a href="#" class="btn btn-outline-primary">Contacter le support</a>
                    </div>
                </div>
            </div>
        </div>
    @elseif(request('order_code'))
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Aucune commande trouvée avec le code <strong>{{ request('order_code') }}</strong>
        </div>
    @endif
</div>

@endsection