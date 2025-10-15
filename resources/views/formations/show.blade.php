@extends('Master')

@section('content')
<div class="container py-5">
    <!-- En-tête de la formation -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="row g-0">
            <!-- Image -->
            <div class="col-md-4">
                <img src="{{ asset($formation->image_path) }}" alt="{{ $formation->titre }}" 
                     class="img-fluid rounded-start h-100" style="object-fit: cover;">
            </div>

            <!-- Informations -->
            <div class="col-md-8">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h1 class="card-title fw-bold h3 mb-0">{{ $formation->titre }}</h1>
                        <span class="badge bg-success text-uppercase">{{ ucfirst($formation->niveau) }}</span>
                    </div>

                    <p class="card-text text-muted">{{ $formation->description }}</p>

                    <!-- Progression globale -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between small mb-1">
                            <span>Progression globale</span>
                            <span>{{ $globalProgress }}%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: {{ $globalProgress }}%" 
                                 aria-valuenow="{{ $globalProgress }}" 
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Objectifs -->
    @if ($formation->objectifs->count() > 0)
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <h2 class="h4 fw-semibold mb-3">Objectifs de la formation</h2>
            <ul class="row list-unstyled">
                @foreach ($formation->objectifs as $objectif)
                    <li class="col-md-6 d-flex align-items-center mb-2">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span>{{ $objectif->content }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- Modules -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h2 class="h4 fw-semibold mb-4">Plan de formation</h2>

            <div class="d-flex flex-column gap-3">
                @foreach ($modulesWithProgress as $moduleData)
                <div class="border rounded p-3 bg-light hover-shadow">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0">
                            Module {{ $moduleData['module']->ordre }} :
                            {{ $moduleData['module']->titre }}
                        </h5>
                        <small class="text-muted">
                            {{ $moduleData['completed_lessons'] }}/{{ $moduleData['total_lessons'] }} leçons
                        </small>
                    </div>

                    <!-- Barre de progression module -->
                    <div class="mb-2">
                        <div class="d-flex justify-content-between small mb-1">
                            <span>Progression du module</span>
                            <span>{{ round($moduleData['progress']) }}%</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: {{ $moduleData['progress'] }}%;" 
                                 aria-valuenow="{{ $moduleData['progress'] }}" 
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        @if ($moduleData['module']->quizz)
                            <span class="badge bg-primary">Quiz disponible</span>
                        @else
                            <span></span>
                        @endif
                        <a href="{{ route('modules.show', ['formation' => $formation->id, 'module' => $moduleData['module']->id]) }}" 
                           class="btn btn-success btn-sm">
                            Accéder au module
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
