@extends('admin.master')

@section('content')
<div class="container">
    <h4 class="mb-4">📜 Liste des Certifications Générées</h4>

    <table class="table table-bordered table-striped text-center">
        <thead class="bg-success text-white">
            <tr >
                <th class="text-white">#</th>
                <th class="text-white">Utilisateur</th>
                <th class="text-white">Formation</th>
                <th class="text-white">Date</th>
                <th class="text-white">Progression</th>
                <th class="text-white">Attestation</th>
            </tr>
        </thead>
        <tbody>
            @forelse($certifications as $certification)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $certification->user->nom}} {{ $certification->user->prenom}}</td>
                    <td>{{ $certification->formation->titre ?? 'Inconnue' }}</td>
                    <td>{{ $certification->created_at->format('d/m/Y') }}</td>
                    <td>{{ $certification->progression }}%</td>
                    <td>
                        @if($certification->path_attestation)
                            <a href="{{ asset($certification->path_attestation) }}" 
                               target="_blank" 
                               class="btn btn-sm btn-primary">
                                <i class="bi bi-file-earmark-pdf"></i> Voir
                            </a>
                            <a href="{{ asset($certification->path_attestation) }}" 
                               download 
                               class="btn btn-sm btn-success">
                                <i class="bi bi-download"></i> Télécharger
                            </a>
                        @else
                            <span class="text-muted">Non disponible</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-muted fw-bold py-3">
                        Aucune certification générée pour le moment.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
