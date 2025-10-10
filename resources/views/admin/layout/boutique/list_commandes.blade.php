@extends('admin.master')

@section('content')
<div class="container-fluid py-4">
    <h4 class="fw-bold mb-4">Liste des Commandes</h4>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Adresse</th>
                    <th>Montant total</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commandes as $commande)
                <tr>
                    <td>#{{ $commande->id }}</td>
                    <td>{{ $commande->user->nom ?? 'Inconnu' }}</td>
                    <td>{{ $commande->date_commande }}</td>
                    <td>{{ $commande->address }}</td>
                    <td>{{ number_format($commande->price_total_order, 0, ',', ' ') }} FCFA</td>
                    <td>
                        <span class="badge bg-info text-dark">{{ ucfirst($commande->statut) }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $commandes->links() }}
    </div>
</div>
@endsection
