@extends('Master')

@section('content')
    <div class="container py-5">
        <div class="card shadow-sm mb-4 border-0">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="/storage/{{$formation->image_path}}" alt="{{ $formation->titre }}"
                        class="img-fluid rounded-start h-100" style="object-fit: cover;">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h1 class="card-title fw-bold h3 mb-0">{{ $formation->titre }}</h1>
                            <span class="badge bg-success text-uppercase">{{ ucfirst($formation->niveau) }}</span>
                        </div>
                        <p class="card-text text-muted">{{ $formation->description }}</p>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between small mb-1">
                                <span>Progression globale</span>
                                <span>{{ number_format($globalProgress, 0) }}%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: {{ $globalProgress }}%;" aria-valuenow="{{ $globalProgress }}"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        <div class="mb-2">
                            Statut : <strong>{{ $userFormation->status }}</strong>
                        </div>


                        <!-- Certificat (uniquement si progression 100%) -->
                   @if ($globalProgress == 100)
    <a href="{{ route('formations.attestation', $formation->id) }}"
       style="
           background-color: #4CAF50;
           color: #1a1a1a;
           padding: 10px 20px;
           border-radius: 8px;
           text-decoration: none;
           font-weight: 600;
           display: inline-block;
           box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
           transition: background-color 0.3s ease, color 0.3s ease;
       "
       onmouseover="this.style.backgroundColor='#388E3C'; this.style.color='#fff';"
       onmouseout="this.style.backgroundColor='#4CAF50'; this.style.color='#1a1a1a';"
    >
        Télécharger mon certificat
    </a>
@else
    <span style="font-style: italic; color: #888; font-size: 14px;">
        Attestation non disponible
    </span>
@endif


                    </div>
                </div>
            </div>
        </div>

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

                            <div class="mb-2">
                                <div class="d-flex justify-content-between small mb-1">
                                    <span>Progression du module</span>
                                    <span>{{ round($moduleData['progress']) }}%</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-success" role="progressbar"
                                        style="width: {{ $moduleData['progress'] }}%;"
                                        aria-valuenow="{{ $moduleData['progress'] }}" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                @if ($moduleData['module']->quizz)
                                    <span class="badge bg-primary">Quiz disponible</span>
                                @endif
                                <a href="{{ route('modules.show', ['formationId' => $formation->id, 'moduleId' => $moduleData['module']->id]) }}"
                                    class="btn btn-success btn-sm">Accéder au module</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        // Force le rechargement complet quand on revient sur la page via le bouton "Retour" du navigateur
        window.addEventListener('pageshow', function(event) {
            if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
                window.location.reload();
            }
        });
    </script>

@endsection
