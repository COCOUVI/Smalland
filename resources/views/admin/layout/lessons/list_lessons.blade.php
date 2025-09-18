@extends('admin.master')

@section('content')
    <div class="container mt-3 mt-md-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
            <h2 class="mb-2 mb-md-0">Liste des leçons</h2>
            <a href="{{ route('modules.list') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-1"></i> Retour aux modules
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Alert pour les messages AJAX -->
        <div id="ajaxAlert" class="alert alert-dismissible fade" role="alert" style="display: none;">
            <span id="ajaxMessage"></span>
            <button type="button" class="btn-close" onclick="hideAlert()"></button>
        </div>

        <!-- Tableau des leçons -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="text-center">ID</th>
                                <th scope="col">Titre</th>
                                <th scope="col">Module</th>
                                <th scope="col">Formation</th>
                                <th scope="col" class="text-center">Date création</th>
                                <th scope="col" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lessons as $lesson)
                                <tr>
                                    <td class="text-center">{{ $lesson->id }}</td>
                                    <td>{{ $lesson->titre }}</td>
                                    <td>
                                        @if($lesson->module)
                                            <span class="badge bg-secondary">{{ $lesson->module->titre }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($lesson->module && $lesson->module->formation)
                                            <span class="badge bg-primary">{{ $lesson->module->formation->titre }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $lesson->created_at->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <!-- Bouton Voir (non fonctionnel) -->
                                            <button type="button" class="btn btn-sm btn-info" title="Voir la leçon">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <!-- Bouton Modifier (non fonctionnel) -->
                                            <button type="button" class="btn btn-sm btn-warning" title="Modifier la leçon">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <!-- Bouton Supprimer (non fonctionnel) -->
                                            <button type="button" class="btn btn-sm btn-danger" title="Supprimer la leçon">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="alert alert-info mb-0">
                                            <i class="fas fa-info-circle me-2"></i>Aucune leçon disponible.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        @if ($lessons->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $lessons->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    <style>
        .badge {
            font-size: 0.85em;
        }
        .btn-group .btn {
            padding: 0.25rem 0.5rem;
        }
        .table th, .table td {
            vertical-align: middle;
        }
    </style>
@endsection
