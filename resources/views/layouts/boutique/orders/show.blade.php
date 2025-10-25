@extends('master')

@section('content')

<style>
    :root {
        --primary-color: #2e7d32;
    }

    .page-header {
        background-color: var(--primary-color);
        color: white;
        padding: 40px 0;
        margin-bottom: 40px;
    }

    .card {
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        margin-bottom: 20px;
    }

    .order-badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .badge-pending { background-color: #fff3cd; color: #856404; }
    .badge-confirmed { background-color: #cfe2ff; color: #084298; }
    .badge-processing { background-color: #e7f1ff; color: #0c63e4; }
    .badge-shipped { background-color: #cce5ff; color: #004085; }
    .badge-delivered { background-color: #d1e7dd; color: #0f5132; }
    .badge-cancelled { background-color: #f8d7da; color: #842029; }

    .tracking-timeline {
        position: relative;
        padding: 20px 0;
    }

    .tracking-timeline::before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 20px;
        width: 3px;
        background-color: #dee2e6;
    }

    .tracking-step {
        position: relative;
        padding-left: 60px;
        margin-bottom: 30px;
    }

    .tracking-icon {
        position: absolute;
        left: 5px;
        top: 0;
        width: 35px;
        height: 35px;
        background-color: #fff;
        border: 3px solid #dee2e6;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
    }

    .tracking-step.completed .tracking-icon {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }

    .tracking-step.active .tracking-icon {
        background-color: #fff;
        border-color: var(--primary-color);
        color: var(--primary-color);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(46, 125, 50, 0.4); }
        50% { box-shadow: 0 0 0 10px rgba(46, 125, 50, 0); }
    }
</style>

<div class="page-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="display-6 fw-bold mb-2">Commande #{{ $order->id }}</h1>
                <p class="mb-0">Passée le {{ $order->created_at->format('d/m/Y à H:i') }}</p>
            </div>
            <span class="order-badge badge-{{ $order->status }}">
                @switch($order->status)
                    @case('pending') En attente @break
                    @case('confirmed') Confirmée @break
                    @case('processing') En préparation @break
                    @case('shipped') Expédiée @break
                    @case('delivered') Livrée @break
                    @case('cancelled') Annulée @break
                    @default {{ $order->status }}
                @endswitch
            </span>
        </div>
    </div>
</div>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Partie gauche -->
        <div class="col-lg-8">
            <!-- Articles commandés -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Articles commandés ({{ $order->products->count() }})</h4>
                    
                    @foreach($order->products as $product)
                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                            <img src="{{ $product->path_img ? asset('storage/' . $product->path_img) : 'https://via.placeholder.com/80' }}" 
                                width="80" class="rounded me-3" alt="{{ $product->nom }}">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $product->nom }}</h6>
                                <p class="text-muted mb-0 small">{{ Str::limit($product->description, 60) }}</p>
                                <p class="mb-0">
                                    <small class="text-muted">Quantité : {{ $product->pivot->qte_commander }}</small>
                                </p>
                            </div>
                            <div class="text-end">
                                <p class="mb-0"><strong>{{ number_format($product->prix, 0, ',', ' ') }} FCFA</strong></p>
                                <small class="text-muted">x {{ $product->pivot->qte_commander }}</small>
                            </div>
                        </div>
                    @endforeach

                    <!-- Totaux -->
                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Sous-total</span>
                            <span>{{ number_format($order->products->sum(fn($p) => $p->prix * $p->pivot->qte_commander), 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Frais de livraison</span>
                            <span>
                                @php
                                    $subtotal = $order->products->sum(fn($p) => $p->prix * $p->pivot->qte_commander);
                                    $shipping = $order->price_total_order - $subtotal;
                                @endphp
                                {{ number_format($shipping, 0, ',', ' ') }} FCFA
                            </span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong class="fs-5">Total TTC</strong>
                            <strong class="fs-5 text-primary">{{ number_format($order->price_total_order, 0, ',', ' ') }} FCFA</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations de livraison -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">
                        <i class="bi bi-geo-alt me-2"></i>Informations de livraison
                    </h4>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Mode de livraison</h6>
                            <p>
                                @if($order->mode_livraison == 'standard')
                                    <i class="bi bi-truck me-2"></i>Livraison Standard (3-5 jours)
                                @elseif($order->mode_livraison == 'express')
                                    <i class="bi bi-lightning me-2"></i>Livraison Express (24-48h)
                                @else
                                    <i class="bi bi-shop me-2"></i>Retrait en magasin
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Téléphone</h6>
                            <p><i class="bi bi-telephone me-2"></i>{{ $order->telephone }}</p>
                        </div>
                        <div class="col-12">
                            <h6 class="text-muted">Adresse de livraison</h6>
                            <p><i class="bi bi-house me-2"></i>{{ $order->addresse }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-2"></i>Retour à mes commandes
                </a>
                
                @if($order->status == 'pending')
                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette commande ?')">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="bi bi-x-circle me-2"></i>Annuler la commande
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Timeline de suivi -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="bi bi-clock-history me-2"></i>Suivi de commande
                    </h5>
                    
                    <div class="tracking-timeline">
                        <div class="tracking-step {{ in_array($order->status, ['pending', 'confirmed', 'processing', 'shipped', 'delivered']) ? 'completed' : '' }}">
                            <div class="tracking-icon">
                                <i class="bi bi-check-lg"></i>
                            </div>
                            <h6 class="mb-1">Commande reçue</h6>
                            <small class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</small>
                        </div>

                        <div class="tracking-step {{ in_array($order->status, ['confirmed', 'processing', 'shipped', 'delivered']) ? 'completed' : ($order->status == 'pending' ? 'active' : '') }}">
                            <div class="tracking-icon">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <h6 class="mb-1">Commande confirmée</h6>
                            <small class="text-muted">En attente de confirmation</small>
                        </div>

                        <div class="tracking-step {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'completed' : ($order->status == 'confirmed' ? 'active' : '') }}">
                            <div class="tracking-icon">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <h6 class="mb-1">En préparation</h6>
                            <small class="text-muted">Votre commande est en cours de préparation</small>
                        </div>

                        <div class="tracking-step {{ in_array($order->status, ['shipped', 'delivered']) ? 'completed' : ($order->status == 'processing' ? 'active' : '') }}">
                            <div class="tracking-icon">
                                <i class="bi bi-truck"></i>
                            </div>
                            <h6 class="mb-1">Expédiée</h6>
                            <small class="text-muted">Votre commande est en route</small>
                        </div>

                        <div class="tracking-step {{ $order->status == 'delivered' ? 'completed' : ($order->status == 'shipped' ? 'active' : '') }}">
                            <div class="tracking-icon">
                                <i class="bi bi-house-check"></i>
                            </div>
                            <h6 class="mb-1">Livrée</h6>
                            <small class="text-muted">Commande livrée</small>
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
            <div class="card mt-3">
                <div class="card-body text-center">
                    <i class="bi bi-headset display-6 text-primary mb-3"></i>
                    <h6>Besoin d'aide ?</h6>
                    <p class="text-muted small">Notre équipe est là pour vous</p>
                    <a href="#" class="btn btn-sm btn-outline-primary">Contacter le support</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection