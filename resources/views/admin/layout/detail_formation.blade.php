@extends('admin.master')

@section('content')
<div class="container-fluid">
    <!-- Header avec breadcrumb et actions -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('lists_formation') }}">Formations</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Détails</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0">{{ $formation->titre }}</h1>
        </div>
        
        <div class="btn-group" role="group">
            <a href="{{ route('lists_formation') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Retour
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Colonne principale -->
        <div class="col-lg-8">
            <!-- Carte principale avec informations -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informations de la formation
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Titre :</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $formation->titre }}
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Prix :</strong>
                        </div>
                        <div class="col-sm-9">
                            <span class="badge bg-success fs-6">
                                {{ number_format($formation->price, 0, ',', ' ') }} FCFA
                            </span>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Statut :</strong>
                        </div>
                        <div class="col-sm-9">
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle me-1"></i>Active
                            </span>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Date de création :</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $formation->created_at->format('d/m/Y à H:i') }}
                        </div>
                    </div>
                    
                    <div class="row mb-0">
                        <div class="col-sm-3">
                            <strong>Dernière modification :</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $formation->updated_at->format('d/m/Y à H:i') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-align-left me-2"></i>Description
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $formation->description }}</p>
                </div>
            </div>

            <!-- Image si présente -->
            @if($formation->image_path)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-image me-2"></i>Image de la formation
                    </h5>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('storage/' . $formation->image_path) }}" 
                         alt="{{ $formation->titre }}" 
                         class="img-fluid rounded shadow-sm" 
                         style="max-width: 500px;">
                    <div class="mt-2">
                        <small class="text-muted">{{ $formation->image_path }}</small>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Colonne secondaire -->
        <div class="col-lg-4">
            <!-- Actions rapides -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-tools me-2"></i>Actions
                    </h6>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Statistiques
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <h4 class="text-secondary">{{ $formation->views ?? '0' }}</h4>
                            <small class="text-muted">Modules</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success">{{ $formation->enrollments ?? '0' }}</h4>
                            <small class="text-muted">Inscriptions</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations techniques -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-cog me-2"></i>Informations techniques
                    </h6>
                </div>
                <div class="card-body">
                    <small>
                        <div class="mb-2">
                            <strong>ID :</strong> #{{ $formation->id }}
                        </div>
                        <div class="mb-2">
                            <strong>Caractères description :</strong> {{ strlen($formation->description) }}
                        </div>
                        @if($formation->image_path)
                        <div class="mb-0">
                            <strong>Image :</strong> 
                            @php
                                $imagePath = storage_path('app/public/' . $formation->image_path);
                                $imageSize = file_exists($imagePath) ? round(filesize($imagePath) / 1024, 1) : 'N/A';
                            @endphp
                            {{ $imageSize }} KB
                        </div>
                        @endif
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection