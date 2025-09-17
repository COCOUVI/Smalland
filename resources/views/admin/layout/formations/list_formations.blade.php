@extends('admin.master')

@section('content')
    <div class="container mt-3 mt-md-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
            <h2 class="mb-2 mb-md-0">Liste des formations</h2>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFormationModal">
                <i class="fas fa-plus d-none d-md-inline"></i> Ajouter
            </button>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                @if($formations->count())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 d-none d-md-table">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Titre</th>
                                    <th class="text-center">Prix</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($formations as $formation)
                                    <tr data-formation-id="{{ $formation->id }}">
                                        <td class="text-center">{{ $formation->id }}</td>
                                        <td class="text-center">{{ $formation->titre }}</td>
                                        <td class="text-center">{{ number_format($formation->price, 2) }} FCFA</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-outline-primary viewDescriptionBtn"
                                                data-bs-toggle="modal" data-bs-target="#descriptionModal"
                                                data-description="{{ $formation->description }}"
                                                data-title="{{ $formation->titre }}" title="Voir description">
                                                <i class="fas fa-eye"></i> Voir
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center flex-wrap gap-1">
                                                <a href="{{ route('details.formation', $formation->id) }}"
                                                    class="btn btn-sm btn-info" title="Voir">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                <!-- Bouton Ajouter module -->
                                                <button type="button" class="btn btn-sm btn-success addModuleBtn"
                                                    data-bs-toggle="modal" data-bs-target="#addModuleModal"
                                                    data-formation-id="{{ $formation->id }}"
                                                    data-formation-title="{{ $formation->titre }}" title="Ajouter module">
                                                    <i class="fas fa-plus-circle"></i>
                                                </button>


                                                <!-- Bouton Modifier -->
                                                <button type="button" class="btn btn-sm btn-warning editFormationBtn"
                                                    data-bs-toggle="modal" data-bs-target="#editFormationModal"
                                                    data-formation-id="{{ $formation->id }}"
                                                    data-formation-title="{{ $formation->titre }}"
                                                    data-formation-description="{{ $formation->description }}"
                                                    data-formation-price="{{ $formation->price }}"
                                                    data-formation-image="{{ $formation->image_path ? asset('storage/' . $formation->image_path) : '' }}"
                                                    title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <!-- Bouton Supprimer -->
                                                <button type="button" class="btn btn-sm btn-danger deleteFormationBtn"
                                                    data-bs-toggle="modal" data-bs-target="#deleteFormationModal"
                                                    data-formation-id="{{ $formation->id }}"
                                                    data-formation-title="{{ $formation->titre }}" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Version mobile (cartes) -->
                        <div class="d-md-none">
                            @foreach($formations as $formation)
                                <div class="card m-2 border-0 shadow-sm" data-formation-id="{{ $formation->id }}">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">{{ $formation->titre }}</h5>
                                        <h6 class="card-subtitle mb-2 text-muted text-center">ID: {{ $formation->id }}</h6>
                                        <p class="card-text text-center"><strong>Prix:</strong>
                                            {{ number_format($formation->price, 2) }} FCFA</p>
                                        <p class="card-text text-center">
                                            <button type="button" class="btn btn-sm btn-outline-primary viewDescriptionBtn"
                                                data-bs-toggle="modal" data-bs-target="#descriptionModal"
                                                data-description="{{ $formation->description }}"
                                                data-title="{{ $formation->titre }}" title="Voir description">
                                                <i class="fas fa-eye"></i> Voir
                                            </button>
                                        </p>

                                        <div class="d-flex justify-content-center flex-wrap gap-1">
                                            <a href="{{ route('details.formation', $formation->id) }}" class="btn btn-sm btn-info"
                                                title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <button type="button" class="btn btn-sm btn-success addModuleBtn" data-bs-toggle="modal"
                                                data-bs-target="#addModuleModal" data-formation-id="{{ $formation->id }}"
                                                data-formation-title="{{ $formation->titre }}" title="Ajouter module">
                                                <i class="fas fa-plus-circle"></i>
                                            </button>

                                            <button type="button" class="btn btn-sm btn-warning editFormationBtn"
                                                data-bs-toggle="modal" data-bs-target="#editFormationModal"
                                                data-formation-id="{{ $formation->id }}"
                                                data-formation-title="{{ $formation->titre }}"
                                                data-formation-description="{{ $formation->description }}"
                                                data-formation-price="{{ $formation->price }}"
                                                data-formation-image="{{ $formation->image_path ? asset('storage/' . $formation->image_path) : '' }}"
                                                title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <button type="button" class="btn btn-sm btn-danger deleteFormationBtn"
                                                data-bs-toggle="modal" data-bs-target="#deleteFormationModal"
                                                data-formation-id="{{ $formation->id }}"
                                                data-formation-title="{{ $formation->titre }}" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex justify-content-center p-3">
                        {{ $formations->links('pagination::bootstrap-5') }}
                    </div>
                @else
                    <p class="text-center m-3">Aucune formation disponible.</p>
                @endif
            </div>
        </div>
    </div>

    @include('admin.layout.formations.modals')
    @include('admin.layout.formations.styles')
    @include('admin.layout.formations.scripts')
@endsection
