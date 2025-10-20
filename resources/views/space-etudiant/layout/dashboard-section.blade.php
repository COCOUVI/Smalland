<div class="card mb-4">
    <div class="card-body">
        <h3 class="section-title">Votre progression</h3>
        <div class="progress mb-3" style="height: 20px;">
            <div class="progress-bar" role="progressbar" style="width: {{ $progressGlobal }}%;"
                aria-valuenow="{{ $progressGlobal }}" aria-valuemin="0" aria-valuemax="100">
                {{ $progressGlobal }}%
            </div>
        </div>
        <div class="row text-center">
            <div class="col-md-3">
                <div class="h4 mb-0">{{ $totalFormations }}</div>
                <div class="text-muted">Formations</div>
            </div>
            <div class="col-md-3">
                <div class="h4 mb-0">{{ $termines }}</div>
                <div class="text-muted">Terminées</div>
            </div>
            <div class="col-md-3">
                <div class="h4 mb-0">{{ $enCours }}</div>
                <div class="text-muted">En cours</div>
            </div>
            <div class="col-md-3">
                <div class="h4 mb-0">{{ $total_certifications }}</div>
                <div class="text-muted">Certifications</div>
            </div>
        </div>
    </div>
</div>


<div class="card mb-4">
    <div class="card-body">
        <h3 class="section-title">Formations en cours</h3>

        <div class="row">
            @forelse ($formationsEnCours as $userFormation)
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <span class="certificate-badge badge bg-warning text-dark">En cours</span>
                        <img src="/storage/{{ $userFormation->formation->image_path ?? 'https://via.placeholder.com/500' }}"
                            class="card-img-top" alt="{{ $userFormation->formation->titre }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $userFormation->formation->titre }}</h5>
                            <p class="card-text">{{ $userFormation->formation->description }}</p>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <small>Progression</small>
                                    <small>{{ $userFormation->progression }}%</small>
                                </div>
                                <div class="progress course-progress">
                                    <div class="progress-bar" style="width: {{ $userFormation->progression }}%;"></div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">{{ $userFormation->formation->getTotalDurationAttribute() }}
                                    de formation</small>
                                <a href="" class="btn btn-sm btn-primary continue-btn">Continuer</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center fw-bold">Aucune formation en cours</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Formations terminées -->
<div class="card mb-4">
    <div class="card-body">
        <h3 class="section-title">Formations terminées</h3>

        <div class="row">
            @forelse($formationsTerminees as $userFormation)
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <span class="certificate-badge badge bg-success">Terminé</span>
                        <img src="/storage/{{ $userFormation->formation->image_path ?? 'default-image.jpg' }}"
                            class="card-img-top" alt="{{ $userFormation->formation->titre }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $userFormation->formation->titre }}</h5>
                            <p class="card-text">{{ $userFormation->formation->description }}</p>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <small>Progression</small>
                                    <small>100%</small>
                                </div>
                                <div class="progress course-progress">
                                    <div class="progress-bar" style="width: 100%;"></div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    Terminé le {{ $userFormation->updated_at->format('d/m/Y') }}
                                </small>
                                @if ($userFormation->path_attestation)
                                    <a href="{{ asset($userFormation->path_attestation) }}"
                                        class="btn btn-sm btn-outline-primary continue-btn" target="_blank">
                                        Voir certificat
                                    </a>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center fw-bold">Aucune formation déjà terminée</p>
            @endforelse
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h3 class="section-title">Activité récente</h3>

        <div class="list-group">
            {{-- Leçon terminée --}}
            @if ($activity['lesson'])
                <div class="list-group-item border-0">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">Leçon "{{ $activity['lesson']->titre }}" terminée</h6>
                        <small
                            class="text-muted">{{ \Carbon\Carbon::parse($activity['lesson']->pivot->completed_at)->diffForHumans() }}</small>
                    </div>
                    <p class="mb-1">{{ $activity['lesson']->module->formation->titre ?? '' }}</p>
                </div>
            @endif

            {{-- Quiz réussi --}}
            @if ($activity['quiz'])
                <div class="list-group-item border-0">
                    <div class="d-flex w-100 justify-content-between">

                        @if ($activity['quiz']->pivot->score == 100)
                            <h6 class="mb-1">Quiz "{{ $activity['quiz']->titre }}" réussi</h6>
                        @else
                            <h6 class="mb-1">Quiz "{{ $activity['quiz']->titre }}" non réussi</h6>
                        @endif
                        <small class="text-muted">{{ $activity['quiz']->pivot->created_at->diffForHumans() }}</small>
                    </div>
                    <p class="mb-1">{{ $activity['quiz']->module->formation->titre ?? '' }}</p>
                    <small class="text-muted">Score : {{ $activity['quiz']->pivot->score }}%</small>
                </div>
            @endif

            {{-- Formation terminée --}}
            @if ($activity['formation'])
                <div class="list-group-item border-0">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">Formation terminée</h6>
                        <small
                            class="text-muted">{{ $activity['formation']->pivot->updated_at->diffForHumans() }}</small>
                    </div>
                    <p class="mb-1">{{ $activity['formation']->titre }}</p>
                    @if ($activity['formation']->pivot->path_attestation)
                        <a href="{{ asset($activity['formation']->pivot->path_attestation) }}"
                            class="btn btn-sm btn-outline-primary">Voir certificat</a>
                    @endif
                </div>
            @endif

            {{-- Si aucune activité --}}
            @if (!$activity['lesson'] && !$activity['quiz'] && !$activity['formation'])
                <p class="text-center fw-bold">Aucune activité récente</p>
            @endif
        </div>
    </div>
</div>
