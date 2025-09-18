@extends('admin.master')

@section('content')
    <<div class="container mt-3 mt-md-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
            <h2 class="mb-2 mb-md-0">Liste des modules</h2>
            <div>
                <span class="badge bg-primary rounded-pill">Formation: {{ $formation->titre ?? 'Non spécifiée' }}</span>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <!-- Version desktop (cartes en grille) -->
            <div class="d-none d-md-block">
                <div class="row">
                    @forelse($modules as $module)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card card-module h-100 shadow-sm border-0">
                            <div class="card-body module-info">
                                <h5 class="module-title">{{ $module->titre }}</h5>
                                <div class="module-details">
                                    <div class="mb-2">
                                        <span class="badge badge-ordre">Ordre: {{ $module->ordre }}</span>
                                        <span class="badge badge-formation ms-1">Formation ID: {{ $module->formation_id }}</span>
                                    </div>
                                    <div class="text-muted small">
                                        Créé le: {{ $module->created_at->format('d/m/Y') }}
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-0 pt-0">
                                <div class="module-actions">
                                    <button class="btn btn-sm btn-danger btn-action" title="Supprimer le module">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning btn-action" title="Modifier le module">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-success btn-action" title="Ajouter une leçon">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            Aucun module disponible pour cette formation.
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Version mobile (liste de cartes) -->
            <div class="d-md-none">
                @forelse($modules as $module)
                <div class="card card-module mb-3 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="module-title">{{ $module->titre }}</h5>
                        <div class="module-details">
                            <div class="mb-2">
                                <span class="badge badge-ordre">Ordre: {{ $module->ordre }}</span>
                                <span class="badge badge-formation ms-1">Formation ID: {{ $module->formation_id }}</span>
                            </div>
                            <div class="text-muted small">
                                Créé le: {{ $module->created_at->format('d/m/Y') }}
                            </div>
                        </div>
                        <div class="module-actions mt-3">
                            <button class="btn btn-sm btn-danger btn-action" title="Supprimer le module">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button class="btn btn-sm btn-warning btn-action" title="Modifier le module">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-success btn-action" title="Ajouter une leçon">
                                <i class="fas fa-plus-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="alert alert-info text-center">
                    Aucun module disponible pour cette formation.
                </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        @if($modules->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $modules->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>


    @include('admin.layout.formations.modals')
    @include('admin.layout.formations.styles')
    @include('admin.layout.formations.scripts')
@endsection
