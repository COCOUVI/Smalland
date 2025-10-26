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
        transition: transform 0.2s;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .order-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .badge-pending { background-color: #fff3cd; color: #856404; }
    .badge-confirmed { background-color: #cfe2ff; color: #084298; }
    .badge-processing { background-color: #e7f1ff; color: #0c63e4; }
    .badge-shipped { background-color: #cce5ff; color: #004085; }
    .badge-delivered { background-color: #d1e7dd; color: #0f5132; }
    .badge-cancelled { background-color: #f8d7da; color: #842029; }

    .empty-orders {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon {
        font-size: 4rem;
        color: #dee2e6;
    }
</style>

<div class="page-header text-center">
    <div class="container">
        <h1 class="display-5 fw-bold">Mes commandes</h1>
        <p class="lead">Suivez l'état de vos commandes en temps réel</p>
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

    @if($orders->count() > 0)
        <div class="row">
            @foreach($orders as $order)
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="card-title mb-1">Commande #{{ $order->id }}</h5>
                                    <small class="text-muted">{{ $order->created_at->format('d/m/Y à H:i') }}</small>
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

                            <div class="mb-3">
                                <p class="mb-1">
                                    <i class="bi bi-box-seam me-2"></i>
                                    <strong>{{ $order->products->count() }}</strong> article(s)
                                </p>
                                <p class="mb-1">
                                    <i class="bi bi-truck me-2"></i>
                                    @if($order->mode_livraison == 'standard')
                                        Livraison Standard
                                    @elseif($order->mode_livraison == 'express')
                                        Livraison Express
                                    @else
                                        Retrait en magasin
                                    @endif
                                </p>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <strong class="text-primary fs-5">{{ number_format($order->price_total_order, 0, ',', ' ') }} FCFA</strong>
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                    Voir détails
                                </a>
                            </div>

                            @if($order->status == 'pending')
                                <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="mt-2" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette commande ?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                        <i class="bi bi-x-circle me-1"></i>Annuler la commande
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $orders->links() }}
        </div>
    @else
        <div class="empty-orders">
            <i class="bi bi-cart-x empty-icon"></i>
            <h4 class="mt-3">Aucune commande pour le moment</h4>
            <p class="text-muted">Vous n'avez pas encore passé de commande.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                <i class="bi bi-shop me-2"></i>Découvrir nos produits
            </a>
        </div>
    @endif
</div>

@endsection