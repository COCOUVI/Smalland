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
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        margin-bottom: 20px;
    }

    .delivery-option {
        border: 2px solid #dee2e6;
        padding: 15px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
        margin-bottom: 10px;
    }

    .delivery-option:hover {
        border-color: var(--primary-color);
        background-color: #f8f9fa;
    }

    .delivery-option.active {
        border-color: var(--primary-color);
        background-color: #e8f5e9;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .total {
        font-weight: bold;
        font-size: 1.3rem;
        border-top: 2px solid #eee;
        padding-top: 15px;
        margin-top: 15px;
    }
</style>

<div class="page-header text-center">
    <div class="container">
        <h1 class="display-5 fw-bold">Finaliser ma commande</h1>
        <p class="lead">Plus qu'une étape avant de recevoir vos produits</p>
    </div>
</div>

<div class="container">
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
        @csrf
        <div class="row">
            <!-- Formulaire -->
            <div class="col-lg-8">
                <!-- Informations de livraison -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">
                            <i class="bi bi-geo-alt me-2"></i>Adresse de livraison
                        </h4>

                        <div class="mb-3">
                            <label for="address" class="form-label">Adresse complète *</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="telephone" class="form-label">Numéro de téléphone *</label>
                            <input type="tel" class="form-control @error('telephone') is-invalid @enderror" 
                                id="telephone" name="telephone" value="{{ old('telephone') }}" required>
                            @error('telephone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Mode de livraison -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">
                            <i class="bi bi-truck me-2"></i>Mode de livraison
                        </h4>

                        <div class="delivery-option" data-mode="standard" data-fee="1500">
                            <input type="radio" name="mode_livraison" value="standard" id="standard" checked>
                            <label for="standard" class="w-100 cursor-pointer ms-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Livraison Standard</strong>
                                        <p class="text-muted mb-0 small">Livraison sous 3-5 jours ouvrés</p>
                                    </div>
                                    <strong>1 500 FCFA</strong>
                                </div>
                            </label>
                        </div>

                        <div class="delivery-option" data-mode="express" data-fee="3000">
                            <input type="radio" name="mode_livraison" value="express" id="express">
                            <label for="express" class="w-100 cursor-pointer ms-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Livraison Express</strong>
                                        <p class="text-muted mb-0 small">Livraison sous 24-48h</p>
                                    </div>
                                    <strong>3 000 FCFA</strong>
                                </div>
                            </label>
                        </div>

                        <div class="delivery-option" data-mode="retrait" data-fee="0">
                            <input type="radio" name="mode_livraison" value="retrait" id="retrait">
                            <label for="retrait" class="w-100 cursor-pointer ms-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Retrait en magasin</strong>
                                        <p class="text-muted mb-0 small">Disponible immédiatement</p>
                                    </div>
                                    <strong class="text-success">GRATUIT</strong>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Récapitulatif des articles -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Vos articles ({{ $cart->items->count() }})</h4>
                        
                        @foreach($cart->items as $item)
                            <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                <img src="{{ $item->product->path_img ? asset('storage/' . $item->product->path_img) : 'https://via.placeholder.com/60' }}" 
                                    width="60" class="rounded me-3" alt="{{ $item->product->nom }}">
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ $item->product->nom }}</h6>
                                    <small class="text-muted">Quantité : {{ $item->qte }}</small>
                                </div>
                                <strong>{{ number_format($item->product->prix * $item->qte, 0, ',', ' ') }} FCFA</strong>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Récapitulatif de la commande -->
            <div class="col-lg-4">
                <div class="card sticky-top" style="top: 20px;">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Récapitulatif</h4>

                        <div class="summary-item">
                            <span>Sous-total</span>
                            <span id="subtotal">{{ number_format($subtotal, 0, ',', ' ') }} FCFA</span>
                        </div>

                        <div class="summary-item">
                            <span>Frais de livraison</span>
                            <span id="shippingFee">{{ number_format($shippingFee, 0, ',', ' ') }} FCFA</span>
                        </div>

                        @if($subtotal >= 50000)
                            <div class="alert alert-success py-2 my-2">
                                <small><i class="bi bi-gift me-1"></i>Livraison offerte !</small>
                            </div>
                        @endif

                        <div class="summary-item total">
                            <span>Total TTC</span>
                            <span id="totalAmount">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 mt-4">
                            <i class="bi bi-check-circle me-2"></i>Confirmer ma commande
                        </button>

                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="bi bi-shield-check me-1"></i>Paiement sécurisé
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
const subtotal = {{ $subtotal }};

document.querySelectorAll('.delivery-option').forEach(option => {
    option.addEventListener('click', function() {
        // Activer visuellement
        document.querySelectorAll('.delivery-option').forEach(o => o.classList.remove('active'));
        this.classList.add('active');
        
        // Cocher le radio
        this.querySelector('input[type="radio"]').checked = true;
        
        // Calculer les frais
        const fee = parseInt(this.dataset.fee);
        const total = subtotal >= 50000 ? subtotal : subtotal + fee;
        
        document.getElementById('shippingFee').textContent = 
            (subtotal >= 50000 ? 0 : fee).toLocaleString('fr-FR') + ' FCFA';
        document.getElementById('totalAmount').textContent = 
            total.toLocaleString('fr-FR') + ' FCFA';
    });
});

// Activer la première option au chargement
document.querySelector('.delivery-option').classList.add('active');
</script>

@endsection