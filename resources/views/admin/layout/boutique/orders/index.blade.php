@extends('admin.master')

@section('content')

<style>
    .stats-card {
        border-left: 4px solid;
        transition: transform 0.2s;
    }
    .stats-card:hover {
        transform: translateY(-5px);
    }
    .filter-card {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
    }
</style>

<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="bi bi-cart-check me-2"></i>Gestion des commandes</h2>
            <p class="text-muted">Gérez et suivez toutes les commandes</p>
        </div>
        <div>
            <a href="{{ route('admin.order.export') }}" class="btn btn-success">
                <i class="bi bi-download me-2"></i>Exporter CSV
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="card stats-card" style="border-left-color: #6c757d;">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Total</h6>
                    <h3 class="mb-0">{{ $stats['total'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card stats-card" style="border-left-color: #ffc107;">
                <div class="card-body">
                    <h6 class="text-muted mb-1">En attente</h6>
                    <h3 class="mb-0">{{ $stats['pending'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card stats-card" style="border-left-color: #17a2b8;">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Confirmées</h6>
                    <h3 class="mb-0">{{ $stats['confirmed'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card stats-card" style="border-left-color: #007bff;">
                <div class="card-body">
                    <h6 class="text-muted mb-1">En préparation</h6>
                    <h3 class="mb-0">{{ $stats['processing'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card stats-card" style="border-left-color: #6f42c1;">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Expédiées</h6>
                    <h3 class="mb-0">{{ $stats['shipped'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card stats-card" style="border-left-color: #28a745;">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Livrées</h6>
                    <h3 class="mb-0">{{ $stats['delivered'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="card filter-card mb-4">
        <form method="GET" action="{{ route('admin.order.index') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Recherche</label>
                    <input type="text" name="search" class="form-control" 
                        placeholder="Code, nom ou email" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Statut</label>
                    <select name="status" class="form-select">
                        <option value="">Tous</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmée</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>En préparation</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Expédiée</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Livrée</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Date début</label>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Date fin</label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-funnel me-1"></i>Filtrer
                    </button>
                    <a href="{{ route('admin.order.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i>Réinitialiser
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Liste des commandes -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Client</th>
                            <th>Date</th>
                            <th>Articles</th>
                            <th>Montant</th>
                            <th>Paiement</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>
                                    <strong class="text-primary">{{ $order->order_code }}</strong>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $order->user->name }}</strong><br>
                                        <small class="text-muted">{{ $order->user->email }}</small><br>
                                        <small class="text-muted">
                                            <i class="bi bi-telephone"></i> {{ $order->telephone }}
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <small>{{ $order->created_at->format('d/m/Y') }}</small><br>
                                    <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $order->products->count() }} article(s)
                                    </span>
                                </td>
                                <td>
                                    <strong>{{ number_format($order->price_total_order, 0, ',', ' ') }} FCFA</strong>
                                </td>
                                <td>
                                    @if($order->paiement)
                                        @if($order->paiement->status == 'completed')
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle"></i> Payé
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-hourglass-split"></i> En attente
                                            </span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-cash"></i> À la livraison
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $order->statusBadgeClass }}">
                                        {{ $order->statusLabel }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" 
                                            class="btn btn-info" title="Voir détails">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        
                                        @if($order->paiement && $order->paiement->status != 'completed')
                                            <form action="{{ route('admin.orders.validate-payment', $order->id) }}" 
                                                method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success" 
                                                    title="Valider le paiement"
                                                    onclick="return confirm('Confirmer la validation du paiement ?')">
                                                    <i class="bi bi-check-circle"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                    <p class="text-muted mt-2">Aucune commande trouvée</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

@endsection