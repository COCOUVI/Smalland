<div class="card shadow-sm border-0">
    <div class="card-body">
        <h3 class="section-title mb-4 text-success fw-bold">
            <i class="bi bi-receipt"></i> Facturations
        </h3>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-center border">
                <thead class="bg-success text-white">
                    <tr>
                        <th>#</th>
                        <th>Formation</th>
                        <th>Montant payé</th>
                        <th>Moyen de paiement</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody class="table-light">
                    @forelse($paiements as $index => $paiement)
                        <tr>
                            <td class="fw-semibold text-success">
                                {{ $loop->iteration + ($paiements->currentPage() - 1) * $paiements->perPage() }}
                            </td>
                            <td>{{ $paiement->formation->titre }}</td>
                            <td>{{ number_format($paiement->montant_payé, 0, ',', ' ') }} FCFA</td>
                            <td>{{ ucfirst($paiement->moyen_de_paiment) }}</td>
                            <td>{{ $paiement->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted fw-bold">
                                <i class="bi bi-info-circle"></i> Aucune facturation trouvée.
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
