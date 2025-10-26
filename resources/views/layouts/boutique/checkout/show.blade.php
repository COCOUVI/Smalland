@extends('master')

@section('content')

<style>
    :root {
        --primary-color: #2e7d32;
    }

    .success-container {
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .success-card {
        max-width: 600px;
        text-align: center;
        padding: 40px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border-radius: 15px;
    }

    .success-icon {
        width: 80px;
        height: 80px;
        background-color: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        animation: scaleIn 0.5s ease-out;
    }

    @keyframes scaleIn {
        0% { transform: scale(0); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    .success-icon i {
        font-size: 40px;
        color: white;
    }

    .order-number {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        display: inline-block;
        margin: 20px 0;
    }
</style>

<div class="success-container">
    <div class="container">
        <div class="success-card mx-auto">
            <div class="success-icon">
                <i class="bi bi-check-lg"></i>
            </div>

            <h2 class="text-success mb-3">Commande confirmée !</h2>
            <p class="lead mb-4">Merci pour votre commande. Nous avons bien reçu votre demande.</p>

            <div class="order-number">
                <small class="text-muted d-block">Numéro de commande</small>
                <strong class="fs-4">#{{ $order->id }}</strong>
            </div>

            <div class="alert alert-info mt-4">
                <i class="bi bi-envelope me-2"></i>
                Un email de confirmation a été envoyé à votre adresse
            </div>

            <div class="row mt-4 text-start">
                <div class="col-6">
                    <small class="text-muted">Mode de livraison</small>
                    <p class="fw-bold mb-0">
                        @if($order->mode_livraison == 'standard')
                            Livraison Standard
                        @elseif($order->mode_livraison == 'express')
                            Livraison Express
                        @else
                            Retrait en magasin
                        @endif
                    </p>
                </div>
                <div class="col-6">
                    <small class="text-muted">Montant total</small>
                    <p class="fw-bold mb-0">{{ number_format($order->price_total_order, 0, ',', ' ') }} FCFA</p>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex gap-2 justify-content-center flex-wrap">
                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary">
                    <i class="bi bi-eye me-2"></i>Voir ma commande
                </a>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-list me-2"></i>Mes commandes
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-shop me-2"></i>Continuer mes achats
                </a>
            </div>
        </div>
    </div>
</div>

@endsection