<div class="container py-5">
    <h1 class="mb-5 fw-bold" style="color:#558B2F;">Mes Formations</h1>

    @if ($userFormations->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($userFormations as $userFormation)
                @php
                    $formation = $userFormation->formation;
                    $userAvis = \App\Models\Avis::where('formation_id', $formation->id)
                        ->where('user_id', auth()->id())
                        ->first();
                @endphp
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="/storage/{{$formation->image_path}}" 
                             alt="{{ $formation->titre }}" 
                             class="card-img-top" style="height: 220px; object-fit: cover;">

                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title fw-semibold mb-0">{{ $formation->titre }}</h5>
                                <span class="badge bg-success text-uppercase">{{ ucfirst($formation->niveau) }}</span>
                            </div>

                            <p class="card-text text-muted small mb-3" style="min-height: 48px;">
                                {{ Str::limit($formation->description, 80) }}
                            </p>

                            <!-- Progression -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between small mb-1">
                                    <span>Progression</span>
                                    <span>{{ $userFormation->progression }}%</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-success" 
                                         role="progressbar" 
                                         style="width: {{ $userFormation->progression }}%;" 
                                         aria-valuenow="{{ $userFormation->progression }}" 
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="mt-auto d-flex flex-column gap-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-success">{{ $formation->price }} €</span>
                                    <a href="{{ route('formations.show', $formation->id) }}" 
                                       class="btn btn-success btn-sm">
                                        Continuer
                                    </a>
                                </div>

                                @if ($userAvis)
                                    <div class="d-flex flex-column gap-2">
                                        <button class="btn btn-warning btn-sm w-100" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editAvisModal-{{ $formation->id }}">
                                            Modifier mon avis
                                        </button>

                                        <button class="btn btn-danger btn-sm w-100" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteAvisModal-{{ $formation->id }}">
                                            Supprimer mon avis
                                        </button>
                                    </div>
                                @elseif ($userFormation->progression == 100)
                                    <button class="btn btn-primary btn-sm w-100" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#addAvisModal-{{ $formation->id }}">
                                        Donner son avis
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Ajouter Avis -->
                <div class="modal fade" id="addAvisModal-{{ $formation->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header">
                                <h5 class="modal-title">Donner votre avis</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('avis.store', $formation->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="note-{{ $formation->id }}" class="form-label fw-semibold">
                                            Note (1 à 5)
                                        </label>
                                        <select name="note" id="note-{{ $formation->id }}" class="form-select" required>
                                            <option value="">-- Choisir une note --</option>
                                            @for ($i = 1; $i <= 5; $i++)
                                                <option value="{{ $i }}">{{ $i }} étoile{{ $i > 1 ? 's' : '' }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="content_avis-{{ $formation->id }}" class="form-label fw-semibold">
                                            Votre avis
                                        </label>
                                        <textarea name="content_avis" id="content_avis-{{ $formation->id }}" 
                                                  class="form-control" rows="4" required></textarea>
                                    </div>

                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Annuler
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            Envoyer
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Modifier Avis -->
                @if ($userAvis)
                <div class="modal fade" id="editAvisModal-{{ $formation->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header">
                                <h5 class="modal-title">Modifier votre avis</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('avis.update', $formation->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="edit-note-{{ $formation->id }}" class="form-label fw-semibold">
                                            Note (1 à 5)
                                        </label>
                                        <select name="note" id="edit-note-{{ $formation->id }}" class="form-select" required>
                                            @for ($i = 1; $i <= 5; $i++)
                                                <option value="{{ $i }}" {{ $userAvis->note == $i ? 'selected' : '' }}>
                                                    {{ $i }} étoile{{ $i > 1 ? 's' : '' }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit-content_avis-{{ $formation->id }}" class="form-label fw-semibold">
                                            Votre avis
                                        </label>
                                        <textarea name="content_avis" id="edit-content_avis-{{ $formation->id }}" 
                                                  class="form-control" rows="4" required>{{ $userAvis->content_avis }}</textarea>
                                    </div>

                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Annuler
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            Modifier
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Supprimer Avis -->
                <div class="modal fade" id="deleteAvisModal-{{ $formation->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header">
                                <h5 class="modal-title">Supprimer votre avis</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>Êtes-vous sûr de vouloir supprimer votre avis ? Cette action est irréversible.</p>
                                <form action="{{ route('avis.destroy', $formation->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Annuler
                                        </button>
                                        <button type="submit" class="btn btn-danger">
                                            Supprimer
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    @else
        <div class="text-center py-5 text-muted">
            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="none" stroke="currentColor" stroke-width="1" class="mb-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l-9 5m9-5v6"></path>
            </svg>
            <h4 class="fw-semibold">Aucune formation</h4>
            <p>Vous n'êtes inscrit à aucune formation pour le moment.</p>
        </div>
    @endif
</div>