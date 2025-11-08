@extends('admin.master')

@section('content')

<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="bi bi-people me-2"></i>Gestion des clients</h2>
            <p class="text-muted">Liste de tous les clients inscrits</p>
        </div>
        <div>
            <a href="{{ route('admin.clients.export') }}" class="btn btn-success">
                <i class="bi bi-download me-2"></i>Exporter CSV
            </a>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm" style="border-left: 4px solid #007bff;">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Total clients</h6>
                    <h3 class="mb-0">{{ $stats['total'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm" style="border-left: 4px solid #28a745;">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Clients actifs</h6>
                    <h3 class="mb-0 text-success">{{ $stats['with_orders'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm" style="border-left: 4px solid #ffc107;">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Sans commande</h6>
                    <h3 class="mb-0 text-warning">{{ $stats['without_orders'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm" style="border-left: 4px solid #17a2b8;">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Ce mois</h6>
                    <h3 class="mb-0 text-info">{{ $stats['this_month'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.clients.index') }}">
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label fw-bold">Recherche</label>
                        <input type="text" name="search" class="form-control" 
                            placeholder="Nom, email, téléphone..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Filtre</label>
                        <select name="filter" class="form-select">
                            <option value="">Tous</option>
                            <option value="active" {{ request('filter') == 'active' ? 'selected' : '' }}>
                                Avec commandes
                            </option>
                            <option value="inactive" {{ request('filter') == 'inactive' ? 'selected' : '' }}>
                                Sans commande
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Trier par</label>
                        <select name="sort" class="form-select">
                            <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>
                                Date d'inscription
                            </option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>
                                Nom
                            </option>
                            <option value="orders_count" {{ request('sort') == 'orders_count' ? 'selected' : '' }}>
                                Nombre de commandes
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel me-1"></i>Filtrer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des clients -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Commandes</th>
                            <th>Inscription</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clients as $client)
                            <tr>
                                <td><strong>#{{ $client->id }}</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-primary text-white me-2">
                                            {{ strtoupper(substr($client->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong>{{ $client->nom }} {{ $client->prenom}}</strong>
                                            @if($client->orders_count > 0)
                                                <br><small class="text-success">
                                                    <i class="bi bi-star-fill"></i> Client actif
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="mailto:{{ $client->email }}" class="text-decoration-none">
                                        <i class="bi bi-envelope me-1"></i>{{ $client->email }}
                                    </a>
                                </td>
                                <td>
                                    @if($client->telephone)
                                        <a href="tel:{{ $client->telephone }}" class="text-decoration-none">
                                            <i class="bi bi-telephone me-1"></i>{{ $client->telephone }}
                                        </a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($client->orders_count > 0)
                                        <span class="badge bg-primary">
                                            {{ $client->orders_count }} commande(s)
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">Aucune</span>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $client->created_at->format('d/m/Y') }}</small><br>
                                    <small class="text-muted">{{ $client->created_at->diffForHumans() }}</small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.clients.show', $client->id) }}" 
                                            class="btn btn-info" title="Voir détails">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="mailto:{{ $client->email }}" 
                                            class="btn btn-primary" title="Envoyer un email">
                                            <i class="bi bi-envelope"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="bi bi-people" style="font-size: 3rem; color: #ccc;"></i>
                                    <p class="text-muted mt-2">Aucun client trouvé</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $clients->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}
</style>

@endsection