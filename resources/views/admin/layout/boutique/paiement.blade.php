@extends('admin.master')

@section('content')
<div class="container-fluid py-4">
    <h4 class="fw-bold mb-4">Liste des Paiements</h4>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Montant payé</th>
                    <th>Moyen de paiement</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paiements as $paiement)
                <tr>
                    <td>{{ $paiement->id }}</td>
                    <td>{{ $paiement->user->nom ?? 'Inconnu' }}</td>
                    <td>{{ number_format($paiement->mtt_payé, 0, ',', ' ') }} FCFA</td>
                    <td>{{ $paiement->moyen_paiement }}</td>
                    <td>
                        <span class="badge {{ $paiement->statut == 'valide' ? 'bg-success' : 'bg-warning' }}">
                            {{ ucfirst($paiement->statut) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $paiements->links() }}
    </div>
</div>
@endsection
