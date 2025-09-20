@extends('admin.master')

@section('content')
    <div class="container mt-4">

        <h2>Quizz du module : {{ $module->titre }}</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Création du quizz si inexistant --}}
        @if (!$module->quizz)
            <div class="card mb-4">
                <div class="card-header">Créer le quizz</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('quizz.storeOrUpdate', $module->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label>Titre du quizz</label>
                            <input type="text" name="titre" class="form-control"
                                value="Quizz du module {{ $module->titre }}">
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
                    <form method="POST" action="{{ route('quizz.storeOrUpdate', $module->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label>Question</label>
                            <input type="text" name="question" class="form-control" required>
                        </div>

                        <div id="reponses-container">
                            <div class="mb-3">
                                <div class="input-group">
                                    <input type="text" name="reponses[]" class="form-control" placeholder="Réponse 1"
                                        required>
                                    <div class="input-group-text">
                                        <input type="radio" name="is_correct" value="0" class="form-check-input"
                                            id="new_correct_0" required>
                                        <label class="form-check-label ms-2" for="new_correct_0">Correct</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <input type="text" name="reponses[]" class="form-control" placeholder="Réponse 1"
                                        required>
                                    <div class="input-group-text">
                                        <input type="radio" name="is_correct" value="0" class="form-check-input"
                                            id="new_correct_0" required>
                                        <label class="form-check-label ms-2" for="new_correct_0">Correct</label>
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
                                        <button class="btn btn-outline-primary btn-edit-question"
                                            data-question-id="{{ $question->id }}">
                                            <i class="bi bi-pencil"></i> Modifier
                                        </button>
                                        <button class="btn btn-outline-danger btn-delete-question"
                                            data-question-id="{{ $question->id }}">
                                            <i class="bi bi-trash"></i> Supprimer
                                        </button>
                                    </div>
                                </div>

                                {{-- Affichage normal --}}
                                <div class="question-display">
                                    <ul class="list-unstyled">
                                        @foreach ($question->reponses as $rIndex => $rep)
                                            <li class="mb-1">
                                                <span
                                                    class="badge {{ $rep->is_correct ? 'bg-success' : 'bg-secondary' }} me-2">
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
                                            <input type="text" name="question_content" class="form-control"
                                                value="{{ $question->content }}" required>
                                        </div>

                                        <div class="edit-reponses-container">
                                            @foreach ($question->reponses as $rIndex => $rep)
                                                <div class="mb-3 input-group reponse-item">
                                                    <input type="text" name="reponses[{{ $rep->id }}]"
                                                        class="form-control" value="{{ $rep->content }}" required>

                                                    <span class="input-group-text">
                                                        <input type="radio" name="correct_reponse"
                                                            value="{{ $rep->id }}" class="form-check-input mt-0"
                                                            id="edit_correct_{{ $rep->id }}"
                                                            {{ $rep->is_correct ? 'checked' : '' }} required>
                                                    </span>
                                                    <span class="input-group-text">
                                                        <label class="form-check-label mb-0"
                                                            for="edit_correct_{{ $rep->id }}">Correct</label>
                                                    </span>

                                                    @if ($loop->index >= 2)
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-danger remove-edit-reponse">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="mt-3">
                                            <button type="button"
                                                class="btn btn-sm btn-outline-secondary add-edit-reponse">
                                                Ajouter une réponse
                                            </button>
                                            <div class="float-end">
                                                <button type="button"
                                                    class="btn btn-secondary btn-cancel-edit">Annuler</button>
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
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let reponseCount = 2;

        // ✅ AJOUTER UNE NOUVELLE RÉPONSE
        const addButton = document.getElementById('add-reponse');
        if (addButton) {
            addButton.addEventListener('click', function() {
                const container = document.getElementById('reponses-container');
                const div = document.createElement('div');
                div.classList.add('mb-3', 'd-flex', 'align-items-center');

                const uniqueId = 'new_correct_' + reponseCount;
                div.innerHTML = `
                <input type="text" name="reponses[]" class="form-control me-3" placeholder="Réponse ${reponseCount + 1}" required>
                <div class="form-check me-3">
                    <input type="radio" name="is_correct" value="${reponseCount}" class="form-check-input" id="${uniqueId}" required>
                    <label class="form-check-label" for="${uniqueId}">Correct</label>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger remove-reponse">
                    <i class="bi bi-trash"></i>
                </button>
            `;
                container.appendChild(div);
                reponseCount++;
            });
        }

        // ✅ GESTION DES CLICS
        document.addEventListener('click', function(e) {
            // Supprimer une réponse (nouvelle question)
            if (e.target.classList.contains('remove-reponse') || e.target.closest('.remove-reponse')) {
                const button = e.target.classList.contains('remove-reponse') ? e.target : e.target
                    .closest('.remove-reponse');
                const parentDiv = button.closest('.mb-3');
                if (parentDiv) {
                    parentDiv.remove();
                    updateRadioValues();
                }
            }

            // Modifier une question
            if (e.target.classList.contains('btn-edit-question') || e.target.closest(
                    '.btn-edit-question')) {
                const button = e.target.classList.contains('btn-edit-question') ? e.target : e.target
                    .closest('.btn-edit-question');
                const questionId = button.getAttribute('data-question-id');
                const questionItem = document.getElementById('question-' + questionId);
                const displayDiv = questionItem.querySelector('.question-display');
                const editDiv = questionItem.querySelector('.question-edit');

                displayDiv.style.display = 'none';
                editDiv.style.display = 'block';
            }

            // Annuler la modification
            if (e.target.classList.contains('btn-cancel-edit')) {
                const questionItem = e.target.closest('.question-item');
                const displayDiv = questionItem.querySelector('.question-display');
                const editDiv = questionItem.querySelector('.question-edit');

                displayDiv.style.display = 'block';
                editDiv.style.display = 'none';
            }

            // Ajouter une réponse en mode édition
            if (e.target.classList.contains('add-edit-reponse')) {
                const questionForm = e.target.closest('.edit-question-form');
                const questionId = questionForm.getAttribute('data-question-id');
                const container = questionForm.querySelector('.edit-reponses-container');
                const newReponseId = 'new_' + Date.now();
                const uniqueEditId = 'edit_correct_' + newReponseId;

                const div = document.createElement('div');
                div.classList.add('mb-3', 'd-flex', 'align-items-center', 'reponse-item');
                div.innerHTML = `
                <input type="text" name="reponses[${newReponseId}]" class="form-control me-3" placeholder="Nouvelle réponse" required>
                <div class="form-check me-3">
                    <input type="radio" name="correct_reponse" value="${newReponseId}" class="form-check-input" id="${uniqueEditId}" required>
                    <label class="form-check-label" for="${uniqueEditId}">Correct</label>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger remove-edit-reponse">
                    <i class="bi bi-trash"></i>
                </button>
            `;
                container.appendChild(div);
            }

            // Supprimer une réponse en mode édition
            if (e.target.classList.contains('remove-edit-reponse') || e.target.closest(
                    '.remove-edit-reponse')) {
                const button = e.target.classList.contains('remove-edit-reponse') ? e.target : e.target
                    .closest('.remove-edit-reponse');
                const parentDiv = button.closest('.reponse-item');
                if (parentDiv) {
                    parentDiv.remove();
                }
            }

            // Supprimer une question
            if (e.target.classList.contains('btn-delete-question') || e.target.closest(
                    '.btn-delete-question')) {
                const button = e.target.classList.contains('btn-delete-question') ? e.target : e.target
                    .closest('.btn-delete-question');
                const questionId = button.getAttribute('data-question-id');

                if (confirm('Êtes-vous sûr de vouloir supprimer cette question ?')) {
                    fetch(`/dashboard/questions/${questionId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('question-' + questionId).remove();
                                alert('Question supprimée avec succès !');
                            } else {
                                alert('Erreur lors de la suppression');
                            }
                        })
                        .catch(error => {
                            console.error('Erreur:', error);
                            alert('Erreur lors de la suppression');
                        });
                }
            }
        });

        // ✅ SAUVEGARDER MODIFICATION
        document.addEventListener('submit', function(e) {
            if (e.target.classList.contains('edit-question-form')) {
                e.preventDefault();

                const questionId = e.target.getAttribute('data-question-id');
                const formData = new FormData(e.target);

                // Convertir FormData en objet
                const data = {
                    question_content: formData.get('question_content'),
                    reponses: {},
                    correct_reponse: formData.get('correct_reponse')
                };

                // Récupérer toutes les réponses
                for (let [key, value] of formData.entries()) {
                    if (key.startsWith('reponses[')) {
                        const reponseId = key.match(/reponses\[(.+)\]/)[1];
                        data.reponses[reponseId] = value;
                    }
                }

                console.log('Données envoyées:', data); // Pour debug

                // Appel AJAX pour modifier
                fetch(`/dashboard/questions/${questionId}`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Question modifiée avec succès !');
                            location.reload();
                        } else {
                            alert('Erreur lors de la modification: ' + (data.message || ''));
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Erreur lors de la modification');
                    });
            }
        });

        // ✅ Fonction pour réajuster les valeurs des boutons radio
        function updateRadioValues() {
            const reponseInputs = document.querySelectorAll('#reponses-container .mb-3');
            reponseInputs.forEach((div, index) => {
                const radio = div.querySelector('input[type="radio"]');
                if (radio) {
                    radio.value = index;
                    radio.id = 'new_correct_' + index;
                    const label = div.querySelector('label');
                    if (label) {
                        label.setAttribute('for', 'new_correct_' + index);
                    }
                }
            });
        }
    });
</script>

@push('scripts')
@endpush
