@extends('admin.master')

@section('content')

<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.clients.index') }}">Clients</a></li>
                    <li class="breadcrumb-item active">{{ $client->nom }} {{ $client->prenom}}</li>
                </ol>
            </nav>
            <h2 class="mb-0">Profil de {{ $client->nom }} {{ $client->prenom}}</h2>
        </div>
        <div>
            <a href="{{ route('admin.clients.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Retour
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Colonne gauche -->
        <div class="col-lg-4">
            <!-- Informations client -->
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="avatar-circle-large bg-primary text-white mx-auto mb-3">
                        {{ strtoupper(substr($client->nom, 0, 2)) }}
                    </div>
                    <h4 class="mb-1">{{ $client->nom }} {{ $client->prenom}}</h4>
                    <p class="text-muted">Client depuis {{ $client->created_at->format('M Y') }}</p>

                    <hr class="my-4">

                    <div class="text-start">
                        <div class="mb-3">
                            <label class="text-muted small">Email</label>
                            <p class="mb-0">
                                <a href="mailto:{{ $client->email }}">
                                    <i class="bi bi-envelope me-2"></i>{{ $client->email }}
                                </a>
                            </p>
                        </div>

                        @if($client->telephone)
                            <div class="mb-3">
                                <label class="text-muted small">Téléphone</label>
                                <p class="mb-0">
                                    <a href="tel:{{ $client->telephone }}">
                                        <i class="bi bi-telephone me-2"></i>{{ $client->telephone }}
                                    </a>
                                </p>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="text-muted small">Membre depuis</label>
                            <p class="mb-0">
                                <i class="bi bi-calendar me-2"></i>{{ $client->created_at->format('d/m/Y') }}
                                <br><small class="text-muted">{{ $client->created_at->diffForHumans() }}</small>
                            </p>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-grid gap-2">
                        <a href="mailto:{{ $client->email }}" class="btn btn-primary">
                            <i class="bi bi-envelope me-2"></i>Envoyer un email
                        </a>
                        @if($client->telephone)
                            <a href="tel:{{ $client->telephone }}" class="btn btn-success">
                                <i class="bi bi-telephone me-2"></i>Appeler
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Statistiques</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Total commandes</span>
                            <strong>{{ $clientStats['total_commandes'] }}</strong>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Montant total</span>
                            <strong class="text-success">{{ number_format($clientStats['montant_total'], 0, ',', ' ') }} FCFA</strong>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Commande moyenne</span>
                            <strong>{{ number_format($clientStats['commande_moyenne'], 0, ',', ' ') }} FCFA</strong>
                        </div>
                    </div>
                    @if($clientStats['derniere_commande'])
                        <div class="mb-0">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Dernière commande</span>
                                <strong>{{ $clientStats['derniere_commande']->format('d/m/Y') }}</strong>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Colonne droite -->
        <div class="col-lg-8">
            <!-- Historique des commandes -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Historique des commandes ({{ $client->orders->count() }})</h5>
                </div>
                <div class="card-body">
                    @if($client->orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Date</th>
                                        <th>Articles</th>
                                        <th>Montant</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($client->orders as $order)
                                        <tr>
                                            <td><strong class="text-primary">{{ $order->order_code }}</strong></td>
                                            <td>
                                                <small>{{ $order->created_at->format('d/m/Y') }}</small><br>
                                                <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $order->products->count() }} article(s)</span>
                                            </td>
                                            <td><strong>{{ number_format($order->price_total_order, 0, ',', ' ') }} FCFA</strong></td>
                                            <td>
                                                <span class="badge {{ $order->statusBadgeClass }}">
                                                    {{ $order->statusLabel }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.orders.show', $order->id) }}" 
                                                    class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-cart-x" style="font-size: 3rem; color: #ccc;"></i>
                            <p class="text-muted mt-2">Aucune commande pour ce client</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Historique des paiements -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Historique des paiements ({{ $client->paiements->count() }})</h5>
                </div>
                <div class="card-body">
                    @if($client->paiements->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Référence</th>
                                        <th>Montant</th>
                                        <th>Méthode</th>
                                        <th>Statut</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($client->paiements as $paiement)
                                        <tr>
                                            <td>
                                                @if($paiement->type === 'formation')
                                                    <span class="badge bg-info">Formation</span>
                                                @else
                                                    <span class="badge bg-primary">Commande</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($paiement->type === 'formation' && $paiement->formation)
                                                    <small>{{ Str::limit($paiement->formation->titre ?? 'N/A', 30) }}</small>
                                                @elseif($paiement->type === 'order' && $paiement->order)
                                                    <strong>{{ $paiement->order->order_code ?? 'N/A' }}</strong>
                                                @endif
                                            </td>
                                            <td><strong class="text-success">{{ number_format($paiement->montant_payé, 0, ',', ' ') }} FCFA</strong></td>
                                            <td><span class="badge bg-secondary">{{ ucfirst($paiement->moyen_de_paiment) }}</span></td>
                                            <td>
                                                @if($paiement->status === 'completed')
                                                    <span class="badge bg-success">Complété</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">En attente</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small>{{ $paiement->created_at->format('d/m/Y') }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-credit-card" style="font-size: 3rem; color: #ccc;"></i>
                            <p class="text-muted mt-2">Aucun paiement pour ce client</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle-large {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 2rem;
}
</style>

@endsection