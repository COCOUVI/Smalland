@extends('admin.master')

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-body">
        <h3 class="section-title mb-4 text-success fw-bold">
            <i class="bi bi-cash-coin"></i> Liste des Paiements
        </h3>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-center border">
                <thead class="bg-success text-white">
                    <tr>
                        <th>#</th>
                        <th class=" text-white">Utilisateur</th>
                        <th class="text-white">Commande</th>
                        <th  class="text-white">Montant</th>
                        <th  class="text-white">Moyen</th>
                        <th  class="text-white">Date</th>
                    </tr>
                </thead>
                <tbody class="table-light">
                    @forelse($paiements as $paiement)
                        <tr>
                            <td>{{ $loop->iteration + ($paiements->currentPage() - 1) * $paiements->perPage() }}</td>
                            <td>{{ $paiement->user->nom }} {{$paiement->user->prenom}}</td>
                            <td>{{ $paiement->Order->order_code ?? '—' }}</td>
                            <td>{{ number_format($paiement->montant_payé, 0, ',', ' ') }} FCFA</td>
                            <td>{{ ucfirst($paiement->moyen_de_paiment) }}</td>
                            <td>{{ $paiement->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted fw-bold">
                                <i class="bi bi-info-circle"></i> Aucun paiement trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $paiements->links() }}
        </div>
    </div>
</div>


@endsection