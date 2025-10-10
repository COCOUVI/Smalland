@extends('admin.master')

@section('content')
<div class="container mt-4">

    {{-- Message de succès --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Liste des Publications</h2>
        <a href="{{ route('publications.create') }}" class="btn btn-primary">+ Nouvelle publication</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Catégorie</th>
                <th>Auteur</th>
                <th>Statut</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($publications as $pub)
                <tr>
                    <td>{{ $pub->id }}</td>
                    <td>{{ $pub->titre }}</td>
                    <td>{{ $pub->category ? $pub->category->name : 'Non définie' }}</td>
                    <td>{{ $pub->author }}</td>
                    <td>
                        <span class="badge 
                            @if($pub->status == 'Publish') bg-success 
                            @elseif($pub->status == 'Draft') bg-secondary 
                            @else bg-warning @endif">
                            {{ $pub->status }}
                        </span>
                    </td>
                    <td>{{ $pub->created_at->format('d/m/Y') }}</td>
                    <td>
                        <!-- Bouton Edit -->
                        <a href="{{ route('publications.edit', $pub->id) }}" 
                           class="btn btn-primary">
                            Éditer
                        </a>

                        <!-- Bouton Supprimer (ouvre modal) -->
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $pub->id }}">
                            Supprimer
                        </button>
                    </td>
                </tr>

                <!-- Modal de suppression -->
                <div class="modal fade" id="deleteModal{{ $pub->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $pub->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title" id="deleteModalLabel{{ $pub->id }}">Confirmer la suppression</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body">
                                Voulez-vous vraiment supprimer <strong>{{ $pub->titre }}</strong> ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <form action="{{ route('publications.destroy', $pub->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Aucune publication trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $publications->links() }}
    </div>

</div>
@endsection
