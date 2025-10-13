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
