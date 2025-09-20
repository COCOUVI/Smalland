@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let reponseCount = 2;
        let currentQuestionIdToDelete = null;
        let deleteModal = null;

        // Initialiser le modal Bootstrap
        const deleteModalElement = document.getElementById('deleteConfirmModal');
        if (deleteModalElement) {
            deleteModal = new bootstrap.Modal(deleteModalElement);

            // ✅ CORRECTION: Avant que le modal commence à se cacher
            deleteModalElement.addEventListener('hide.bs.modal', function () {
                if (document.activeElement instanceof HTMLElement) {
                    document.activeElement.blur();
                }
            });

            // Gérer la fermeture complète du modal
            deleteModalElement.addEventListener('hidden.bs.modal', function () {
                currentQuestionIdToDelete = null;
            });
        }

        // Fonction pour afficher les messages de succès
        function showSuccessMessage(message) {
            const successAlert = document.getElementById('ajax-success');
            const successMessage = document.getElementById('ajax-success-message');

            // Vérifier que les éléments existent avant de les manipuler
            if (successAlert && successMessage) {
                successMessage.textContent = message;
                successAlert.style.display = 'block';

                // Masquer automatiquement après 5 secondes
                setTimeout(() => {
                    successAlert.style.display = 'none';
                }, 5000);
            }
        }

        // Fonction pour afficher les messages d'erreur
        function showErrorMessage(message) {
            const errorAlert = document.getElementById('ajax-error');
            const errorMessage = document.getElementById('ajax-error-message');

            // Vérifier que les éléments existent avant de les manipuler
            if (errorAlert && errorMessage) {
                errorMessage.textContent = message;
                errorAlert.style.display = 'block';

                // Masquer automatiquement après 5 secondes
                setTimeout(() => {
                    errorAlert.style.display = 'none';
                }, 5000);
            }
        }

        // ✅ AJOUTER UNE NOUVELLE RÉPONSE
        const addButton = document.getElementById('add-reponse');
        if (addButton) {
            addButton.addEventListener('click', function() {
                const container = document.getElementById('reponses-container');
                const div = document.createElement('div');
                div.classList.add('mb-3');

                const uniqueId = 'new_correct_' + reponseCount;
                div.innerHTML = `
                    <div class="input-group">
                        <input type="text" name="reponses[]" class="form-control" placeholder="Réponse ${reponseCount + 1}" required>
                        <div class="input-group-text">
                            <input type="radio" name="is_correct" value="${reponseCount}" class="form-check-input" id="${uniqueId}" required>
                            <label class="form-check-label ms-2" for="${uniqueId}">Correct</label>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-reponse">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
                container.appendChild(div);
                reponseCount++;
            });
        }

        // ✅ GESTION DES CLICS
        document.addEventListener('click', function(e) {
            // Gérer la croix de fermeture du modal
            if (e.target.classList.contains('btn-close') && e.target.closest('#deleteConfirmModal')) {
                currentQuestionIdToDelete = null;
            }

            // Supprimer une réponse (nouvelle question)
            if (e.target.classList.contains('remove-reponse') || e.target.closest('.remove-reponse')) {
                const button = e.target.classList.contains('remove-reponse') ? e.target : e.target.closest('.remove-reponse');
                const parentDiv = button.closest('.mb-3');
                if (parentDiv && document.querySelectorAll('#reponses-container .mb-3').length > 2) {
                    parentDiv.remove();
                    updateRadioValues();
                } else {
                    showErrorMessage('Vous devez avoir au moins deux réponses.');
                }
            }

            // Modifier une question
            if (e.target.classList.contains('btn-edit-question') || e.target.closest('.btn-edit-question')) {
                const button = e.target.classList.contains('btn-edit-question') ? e.target : e.target.closest('.btn-edit-question');
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
                div.classList.add('mb-3', 'input-group', 'reponse-item');
                div.innerHTML = `
                    <input type="text" name="reponses[${newReponseId}]" class="form-control" placeholder="Nouvelle réponse" required>
                    <span class="input-group-text">
                        <input type="radio" name="correct_reponse" value="${newReponseId}" class="form-check-input mt-0" id="${uniqueEditId}" required>
                    </span>
                    <span class="input-group-text">
                        <label class="form-check-label mb-0" for="${uniqueEditId}">Correct</label>
                    </span>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-edit-reponse">
                        <i class="bi bi-trash"></i>
                    </button>
                `;
                container.appendChild(div);
            }

            // Supprimer une réponse en mode édition
            if (e.target.classList.contains('remove-edit-reponse') || e.target.closest('.remove-edit-reponse')) {
                const button = e.target.classList.contains('remove-edit-reponse') ? e.target : e.target.closest('.remove-edit-reponse');
                const parentDiv = button.closest('.reponse-item');
                if (parentDiv && document.querySelectorAll('.edit-reponses-container .reponse-item').length > 2) {
                    parentDiv.remove();
                } else {
                    showErrorMessage('Vous devez avoir au moins deux réponses.');
                }
            }

            // Supprimer une question (ouvrir modal de confirmation)
            if (e.target.classList.contains('btn-delete-question') || e.target.closest('.btn-delete-question')) {
                const button = e.target.classList.contains('btn-delete-question') ? e.target : e.target.closest('.btn-delete-question');
                currentQuestionIdToDelete = button.getAttribute('data-question-id');

                // Afficher le modal de confirmation personnalisé
                if (deleteModal) {
                    deleteModal.show();
                }
            }
        });

        // Confirmation de suppression depuis le modal
        document.getElementById('confirm-delete-btn').addEventListener('click', function() {
            if (currentQuestionIdToDelete) {
                fetch(`/dashboard/questions/${currentQuestionIdToDelete}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('question-' + currentQuestionIdToDelete).remove();
                        showSuccessMessage('Question supprimée avec succès !');
                    } else {
                        showErrorMessage('Erreur lors de la suppression: ' + (data.message || ''));
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    showErrorMessage('Erreur lors de la suppression');
                })
                .finally(() => {
                    // Fermer le modal
                    if (deleteModal) {
                        deleteModal.hide();
                    }
                    currentQuestionIdToDelete = null;
                });
            }
        });

        // Annuler la suppression
        document.getElementById('cancel-delete-btn').addEventListener('click', function() {
            if (deleteModal) {
                deleteModal.hide();
            }
            currentQuestionIdToDelete = null;
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

                // Appel AJAX pour modifier
                fetch(`/dashboard/questions/${questionId}`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showSuccessMessage('Question modifiée avec succès !');

                        // Mettre à jour l'affichage sans recharger la page
                        const questionItem = document.getElementById('question-' + questionId);
                        if (questionItem) {
                            const displayDiv = questionItem.querySelector('.question-display');
                            const editDiv = questionItem.querySelector('.question-edit');

                            // Mettre à jour le titre de la question
                            const questionTitle = questionItem.querySelector('.question-title');
                            if (questionTitle) {
                                const questionIndex = Array.from(questionItem.parentNode.children).indexOf(questionItem) + 1;
                                questionTitle.textContent = 'Q' + questionIndex + ': ' + formData.get('question_content');
                            }

                            // Mettre à jour les réponses affichées
                            if (displayDiv) {
                                const reponsesList = displayDiv.querySelector('ul');
                                if (reponsesList) {
                                    reponsesList.innerHTML = '';

                                    if (data.reponses) {
                                        Object.entries(data.reponses).forEach(([id, reponse], index) => {
                                            const isCorrect = id == data.correct_reponse;
                                            const li = document.createElement('li');
                                            li.classList.add('mb-1');
                                            li.innerHTML = `
                                                <span class="badge ${isCorrect ? 'bg-success' : 'bg-secondary'} me-2">
                                                    ${index + 1}
                                                </span>
                                                ${reponse}
                                                ${isCorrect ? '<i class="bi bi-check-circle text-success ms-1"></i>' : ''}
                                            `;
                                            reponsesList.appendChild(li);
                                        });
                                    }
                                }
                            }

                            // Revenir à l'affichage normal
                            if (displayDiv && editDiv) {
                                displayDiv.style.display = 'block';
                                editDiv.style.display = 'none';
                            }
                        }
                    } else {
                        showErrorMessage('Erreur lors de la modification: ' + (data.message || ''));
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    showErrorMessage('Erreur lors de la modification');
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

                // Mettre à jour le placeholder
                const input = div.querySelector('input[type="text"]');
                if (input) {
                    input.placeholder = `Réponse ${index + 1}`;
                }
            });

            // S'assurer qu'au moins un radio est sélectionné
            if (!document.querySelector('input[name="is_correct"]:checked')) {
                const firstRadio = document.querySelector('input[name="is_correct"]');
                if (firstRadio) {
                    firstRadio.checked = true;
                }
            }
        }
    });
</script>
@endpush
