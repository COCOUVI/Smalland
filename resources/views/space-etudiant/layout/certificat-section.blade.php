<div class="card shadow-sm border-0">
    <div class="card-body">
        <h3 class="section-title mb-4 text-success fw-bold">
            <i class="bi bi-award"></i> Certificats obtenus
        </h3>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-center border">
                <thead class="bg-success text-white">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Titre de la formation</th>
                        <th scope="col">Date d’obtention</th>
                        <th scope="col">Attestation</th>
                    </tr>
                </thead>
                <tbody class="table-light">
                    @forelse($certificats as $index => $certificat)
                        <tr>
                            <td class="fw-semibold text-success">
                                {{ $loop->iteration + ($certificats->currentPage() - 1) * $certificats->perPage() }}
                            </td>
                            <td>{{ $certificat->titre }}</td>
                            <td>{{ $certificat->pivot->updated_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $certificat->pivot->path_attestation) }}" 
                                   class="btn btn-sm btn-outline-success px-3" 
                                   target="_blank">
                                    <i class="bi bi-file-earmark-text"></i> Voir
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted fw-bold">
                                <i class="bi bi-info-circle"></i> Aucun certificat obtenu pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $certificats->links() }}
        </div>
    </div>
</div>

<style>
    .table thead th {
        border-bottom: 2px solid #ffffff !important;
    }

    .table tbody tr:hover {
        background-color: #e8f5e9 !important; /* vert clair au survol */
        transition: all 0.3s ease;
    }

    .btn-outline-success:hover {
        background-color: #28a745;
        color: white;
    }

    .section-title {
        border-left: 5px solid #28a745;
        padding-left: 10px;
    }
</style>
