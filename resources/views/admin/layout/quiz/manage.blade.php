@extends('admin.master')

@section('content')
    <div class="container mt-4">
        <h2>Quizz du module : {{ $module->titre }}</h2>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div id="ajax-success" class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
            <span id="ajax-success-message"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <div id="ajax-error" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
            <span id="ajax-error-message"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        {{-- Création du quizz si inexistant --}}
        @if (!$module->quizz)
            <div class="card mb-4">
                <div class="card-header">Créer le quizz</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('quizz.storeOrUpdate', $module->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label>Titre du quizz</label>
                            <input type="text" name="titre" class="form-control" value="Quizz du module {{ $module->titre }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Créer le quizz</button>
                    </form>
                </div>
            </div>
        @endif

        {{-- Ajouter une question --}}
        @if ($module->quizz)
            <div class="card mb-4">
                <div class="card-header">Ajouter une question</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('quizz.storeOrUpdate', $module->id) }}" id="add-question-form">
                        @csrf
                        <div class="mb-3">
                            <label>Question</label>
                            <input type="text" name="question" class="form-control" required>
                        </div>

                        <div id="reponses-container">
                            <div class="mb-3">
                                <div class="input-group">
                                    <input type="text" name="reponses[]" class="form-control" placeholder="Réponse 1" required>
                                    <div class="input-group-text">
                                        <input type="radio" name="is_correct" value="0" class="form-check-input" id="new_correct_0" required checked>
                                        <label class="form-check-label ms-2" for="new_correct_0">Correct</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <input type="text" name="reponses[]" class="form-control" placeholder="Réponse 2" required>
                                    <div class="input-group-text">
                                        <input type="radio" name="is_correct" value="1" class="form-check-input" id="new_correct_1" required>
                                        <label class="form-check-label ms-2" for="new_correct_1">Correct</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="add-reponse" class="btn btn-secondary mb-3">Ajouter une réponse</button>
                        <br>
                        <button type="submit" class="btn btn-success">Ajouter la question</button>
                    </form>
                </div>
            </div>

            {{-- Liste des questions existantes --}}
            <div class="card">
                <div class="card-header">Questions existantes</div>
                <div class="card-body">
                    @if ($module->quizz && $module->quizz->questions->count() > 0)
                        @foreach ($module->quizz->questions as $qIndex => $question)
                            <div class="mb-4 p-3 border rounded question-item" id="question-{{ $question->id }}">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <strong class="question-title">Q{{ $qIndex + 1 }}: {{ $question->content }}</strong>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary btn-edit-question" data-question-id="{{ $question->id }}">
                                            <i class="bi bi-pencil"></i> Modifier
                                        </button>
                                        <button class="btn btn-outline-danger btn-delete-question" data-question-id="{{ $question->id }}">
                                            <i class="bi bi-trash"></i> Supprimer
                                        </button>
                                    </div>
                                </div>

                                {{-- Affichage normal --}}
                                <div class="question-display">
                                    <ul class="list-unstyled">
                                        @foreach ($question->reponses as $rIndex => $rep)
                                            <li class="mb-1">
                                                <span class="badge {{ $rep->is_correct ? 'bg-success' : 'bg-secondary' }} me-2">
                                                    {{ $rIndex + 1 }}
                                                </span>
                                                {{ $rep->content }}
                                                @if ($rep->is_correct)
                                                    <i class="bi bi-check-circle text-success ms-1"></i>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                {{-- Formulaire de modification (caché par défaut) --}}
                                <div class="question-edit" style="display: none;">
                                    <form class="edit-question-form" data-question-id="{{ $question->id }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Question</label>
                                            <input type="text" name="question_content" class="form-control" value="{{ $question->content }}" required>
                                        </div>

                                        <div class="edit-reponses-container">
                                            @foreach ($question->reponses as $rIndex => $rep)
                                                <div class="mb-3 input-group reponse-item">
                                                    <input type="text" name="reponses[{{ $rep->id }}]" class="form-control" value="{{ $rep->content }}" required>

                                                    <span class="input-group-text">
                                                        <input type="radio" name="correct_reponse" value="{{ $rep->id }}" class="form-check-input mt-0" id="edit_correct_{{ $rep->id }}" {{ $rep->is_correct ? 'checked' : '' }} required>
                                                    </span>
                                                    <span class="input-group-text">
                                                        <label class="form-check-label mb-0" for="edit_correct_{{ $rep->id }}">Correct</label>
                                                    </span>

                                                    @if ($loop->index >= 2)
                                                        <button type="button" class="btn btn-sm btn-outline-danger remove-edit-reponse">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="mt-3">
                                            <button type="button" class="btn btn-sm btn-outline-secondary add-edit-reponse">
                                                Ajouter une réponse
                                            </button>
                                            <div class="float-end">
                                                <button type="button" class="btn btn-secondary btn-cancel-edit">Annuler</button>
                                                <button type="submit" class="btn btn-primary">Sauvegarder</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">Aucune question ajoutée pour le moment.</p>
                    @endif
                </div>
            </div>
        @endif
    </div>

    @include('admin.layout.quiz.quiz_modals')
    @include('admin.layout.quiz.quiz_styles')
    @include('admin.layout.quiz.quiz_scripts')
@endsection
