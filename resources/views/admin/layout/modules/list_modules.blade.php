@extends('admin.master')

@section('content')
    <div class="container mt-3 mt-md-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
            <h2 class="mb-2 mb-md-0">Liste des modules</h2>
            <a href="{{ route('lists_formation') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-1"></i> Retour aux formations
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

        <div class="row">
            <!-- Version desktop (cartes en grille) -->
            <div class="d-none d-md-block">
                <div class="row" id="modules-container-desktop">
                    @forelse($modules as $module)
                        <div class="col-md-6 col-lg-4 mb-4 module-card" data-module-id="{{ $module->id }}">
                            <div class="card card-module h-100 shadow-sm border-0">
                                <div class="card-header bg-transparent border-0 pb-0 d-flex justify-content-between align-items-center">
                                    <span class="badge bg-secondary">ID: {{ $module->id }}</span>
                                </div>
                                <div class="card-body module-info">
                                    <h5 class="module-title">{{ $module->titre }}</h5>
                                    <div class="module-details">
                                        <div class="mb-2">
                                            <span class="badge badge-formation">Formation: {{ $module->formation->titre ?? 'N/A' }}</span>
                                        </div>
                                        <div class="text-muted small">
                                            <div><i class="fas fa-calendar-plus me-1"></i> Créé le: {{ $module->created_at->format('d/m/Y') }}</div>
                                            @if ($module->updated_at != $module->created_at)
                                                <div><i class="fas fa-calendar-check me-1"></i> Modifié le: {{ $module->updated_at->format('d/m/Y') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-white border-0 pt-0">
                                    <div class="module-actions">
                                        <button type="button" class="btn btn-sm btn-danger btn-action btn-delete"
                                            title="Supprimer le module" data-module-id="{{ $module->id }}"
                                            data-module-title="{{ $module->titre }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning btn-action" title="Modifier le module"
                                            data-bs-toggle="modal" data-bs-target="#editModuleModal"
                                            data-module-id="{{ $module->id }}" data-module-titre="{{ $module->titre }}">
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
                        <div class="col-12" id="no-modules-message-desktop">
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle me-2"></i>Aucun module disponible.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Version mobile (liste de cartes) -->
            <div class="d-md-none">
                <div id="modules-container-mobile">
                    @forelse($modules as $module)
                        <div class="card card-module mb-3 shadow-sm border-0 module-card" data-module-id="{{ $module->id }}">
                            <div class="card-header bg-transparent border-0 pb-0 d-flex justify-content-between align-items-center">
                                <span class="badge bg-secondary">ID: {{ $module->id }}</span>
                            </div>
                            <div class="card-body">
                                <h5 class="module-title mb-3">{{ $module->titre }}</h5>
                                <div class="module-details mb-3">
                                    <div class="mb-2">
                                        <span class="badge badge-formation w-100">Formation: {{ $module->formation->titre ?? 'N/A' }}</span>
                                    </div>
                                    <div class="text-muted small">
                                        <div><i class="fas fa-calendar-plus me-1"></i> Créé le: {{ $module->created_at->format('d/m/Y') }}</div>
                                        @if ($module->updated_at != $module->created_at)
                                            <div><i class="fas fa-calendar-check me-1"></i> Modifié le: {{ $module->updated_at->format('d/m/Y') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="module-actions d-grid gap-2 d-flex justify-content-center">
                                    <button type="button" class="btn btn-sm btn-danger flex-fill btn-delete"
                                        title="Supprimer le module" data-module-id="{{ $module->id }}"
                                        data-module-title="{{ $module->titre }}">
                                        <i class="fas fa-trash me-1"></i><span class="d-none d-sm-inline">Supprimer</span>
                                    </button>
                                    <button class="btn btn-sm btn-warning flex-fill" title="Modifier le module"
                                        data-bs-toggle="modal" data-bs-target="#editModuleModal"
                                        data-module-id="{{ $module->id }}" data-module-titre="{{ $module->titre }}">
                                        <i class="fas fa-edit me-1"></i><span class="d-none d-sm-inline">Modifier</span>
                                    </button>
                                    <button class="btn btn-sm btn-success flex-fill" title="Ajouter une leçon">
                                        <i class="fas fa-plus-circle me-1"></i><span class="d-none d-sm-inline">Leçon</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info text-center" id="no-modules-message-mobile">
                            <i class="fas fa-info-circle me-2"></i>Aucun module disponible.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Pagination -->
        @if ($modules->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $modules->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    @include('admin.layout.modules.modules_modals')
    @include('admin.layout.modules.modules_styles')
    @include('admin.layout.modules.modules_scripts')
@endsection
