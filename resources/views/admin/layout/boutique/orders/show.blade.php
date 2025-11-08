@extends('admin.layout.master')

@section('content')

<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Commandes</a></li>
                    <li class="breadcrumb-item active">{{ $order->order_code }}</li>
                </ol>
            </nav>
            <h2 class="mb-0">Commande {{ $order->order_code }}</h2>
        </div>
        <div>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Retour
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Colonne gauche -->
        <div class="col-lg-8">
            <!-- Informations de la commande -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Informations de la commande</h5>
                        <span class="badge {{ $order->statusBadgeClass }} fs-6">
                            {{ $order->statusLabel }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Code de commande</label>
                            <p class="fw-bold">{{ $order->order_code }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Date de commande</label>
                            <p class="fw-bold">{{ $order->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Mode de livraison</label>
                            <p class="fw-bold">
                                @if($order->mode_livraison == 'standard')
                                    <i class="bi bi-truck me-1"></i>Livraison Standard
                                @elseif($order->mode_livraison == 'express')
                                    <i class="bi bi-lightning me-1"></i>Livraison Express
                                @else
                                    <i class="bi bi-shop me-1"></i>Retrait en magasin
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Montant total</label>
                            <p class="fw-bold text-success fs-5">
                                {{ number_format($order->price_total_order, 0, ',', ' ') }} FCFA
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Produits commandés -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Produits commandés ({{ $order->products->count() }})</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Prix unitaire</th>
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
                                                        width="50" class="rounded me-2" alt="{{ $product->nom }}">
                                                @endif
                                                <div>
                                                    <strong>{{ $product->nom }}</strong><br>
                                                    <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ number_format($product->prix, 0, ',', ' ') }} FCFA</td>
                                        <td><span class="badge bg-secondary">{{ $product->pivot->qte_commander }}</span></td>
                                        <td class="fw-bold">{{ number_format($product->prix * $product->pivot->qte_commander, 0, ',', ' ') }} FCFA</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Total</td>
                                    <td class="fw-bold text-success">{{ number_format($order->price_total_order, 0, ',', ' ') }} FCFA</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Informations client et livraison -->
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Informations client et livraison</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Client</h6>
                            <p>
                                <strong>{{ $order->user->name }}</strong><br>
                                <i class="bi bi-envelope me-1"></i>{{ $order->user->email }}<br>
                                <i class="bi bi-telephone me-1"></i>{{ $order->telephone }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Adresse de livraison</h6>
                            <p>{{ $order->addresse }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonne droite -->
        <div class="col-lg-4">
            <!-- Changer le statut -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Modifier le statut</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nouveau statut</label>
                            <select name="status" class="form-select" required>
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                    En attente
                                </option>
                                <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>
                                    Confirmée
                                </option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                    En préparation
                                </option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>
                                    Expédiée
                                </option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                    Livrée
                                </option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                    Annulée
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Note (optionnel)</label>
                            <textarea name="note" class="form-control" rows="3" 
                                placeholder="Ajoutez une note..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-circle me-2"></i>Mettre à jour le statut
                        </button>
                    </form>
                </div>
            </div>

            <!-- Informations de paiement -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Paiement</h5>
                </div>
                <div class="card-body">
                    @if($order->paiement)
                        <div class="mb-2">
                            <label class="text-muted small">Statut</label>
                            <p>
                                @if($order->paiement->status == 'completed')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> Payé
                                    </span>
                                @else
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-hourglass-split"></i> En attente
                                    </span>
                                @endif
                            </p>
                        </div>
                        <div class="mb-2">
                            <label class="text-muted small">Méthode</label>
                            <p class="fw-bold">{{ ucfirst($order->paiement->moyen_de_paiment) }}</p>
                        </div>
                        <div class="mb-2">
                            <label class="text-muted small">Montant</label>
                            <p class="fw-bold">{{ number_format($order->paiement->montant_payé, 0, ',', ' ') }} FCFA</p>
                        </div>
                        @if($order->paiement->transaction_id)
                            <div class="mb-2">
                                <label class="text-muted small">Transaction ID</label>
                                <p class="fw-bold small">{{ $order->paiement->transaction_id }}</p>
                            </div>
                        @endif

                        @if($order->paiement->status != 'completed')
                            <form action="{{ route('admin.orders.validate-payment', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100 mt-3"
                                    onclick="return confirm('Confirmer la validation du paiement ?')">
                                    <i class="bi bi-check-circle me-2"></i>Valider le paiement
                                </button>
                            </form>
                        @endif
                    @else
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle me-2"></i>
                            Paiement à la livraison
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <a href="mailto:{{ $order->user->email }}" class="btn btn-outline-primary w-100 mb-2">
                        <i class="bi bi-envelope me-2"></i>Contacter le client
                    </a>
                    <a href="tel:{{ $order->telephone }}" class="btn btn-outline-success w-100 mb-2">
                        <i class="bi bi-telephone me-2"></i>Appeler le client
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection