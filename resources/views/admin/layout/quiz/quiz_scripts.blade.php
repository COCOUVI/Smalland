@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let reponseCount = 2;
        let currentQuestionIdToDelete = null;
        let deleteModal = null;
        let editTitleModal = null;
        let deleteQuizzModal = null;

        // Initialiser les modals Bootstrap
        const deleteModalElement = document.getElementById('deleteConfirmModal');
        if (deleteModalElement) {
            deleteModal = new bootstrap.Modal(deleteModalElement);

            deleteModalElement.addEventListener('hide.bs.modal', function () {
                if (document.activeElement instanceof HTMLElement) {
                    document.activeElement.blur();
                }
            });

            deleteModalElement.addEventListener('hidden.bs.modal', function () {
                currentQuestionIdToDelete = null;
            });
        }

        // Modal pour modifier le titre du quiz
        const editTitleModalElement = document.getElementById('editQuizzTitleModal');
        if (editTitleModalElement) {
            editTitleModal = new bootstrap.Modal(editTitleModalElement);
        }

        // Modal pour supprimer le quiz
        const deleteQuizzModalElement = document.getElementById('deleteQuizzModal');
        if (deleteQuizzModalElement) {
            deleteQuizzModal = new bootstrap.Modal(deleteQuizzModalElement);
        }

        // ✅ SYSTÈME DE NOTIFICATIONS ÉLÉGANT
        function showNotification(message, type = 'success') {
            // Supprimer toutes les notifications existantes
            const existingNotifications = document.querySelectorAll('.custom-notification');
            existingNotifications.forEach(notif => notif.remove());

            // Créer la nouvelle notification
            const notification = document.createElement('div');
            notification.className = `custom-notification custom-notification-${type}`;

            const icon = type === 'success' ?
                '<i class="bi bi-check-circle-fill"></i>' :
                '<i class="bi bi-exclamation-triangle-fill"></i>';

            notification.innerHTML = `
                ${icon}
                <span>${message}</span>
                <button type="button" class="notification-close">
                    <i class="bi bi-x"></i>
                </button>
            `;

            // Ajouter au body
            document.body.appendChild(notification);

            // Animation d'entrée
            setTimeout(() => {
                notification.classList.add('show');
            }, 10);

            // Fermeture automatique après 4 secondes
            const autoClose = setTimeout(() => {
                closeNotification(notification);
            }, 4000);

            // Fermeture manuelle
            notification.querySelector('.notification-close').addEventListener('click', () => {
                clearTimeout(autoClose);
                closeNotification(notification);
            });

            // Pause du timer au survol
            notification.addEventListener('mouseenter', () => clearTimeout(autoClose));
            notification.addEventListener('mouseleave', () => {
                setTimeout(() => closeNotification(notification), 2000);
            });
        }

        function closeNotification(notification) {
            notification.classList.remove('show');
            notification.classList.add('hide');
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 300);
        }

        // ✅ GESTION MODIFICATION TITRE DU QUIZ - VERSION CORRIGÉE AVEC RAFRAÎCHISSEMENT
        const editQuizzTitleForm = document.getElementById('editQuizzTitleForm');
        if (editQuizzTitleForm) {
            editQuizzTitleForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Sauvegarde...';

                const formData = new FormData(this);

                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Titre du quiz modifié avec succès !', 'success');

                        // Fermer le modal
                        if (editTitleModal) {
                            editTitleModal.hide();
                        }

                        // ✅ Actualiser la page après un court délai pour voir les changements
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        showNotification('Erreur lors de la modification: ' + (data.message || 'Erreur inconnue'), 'error');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    showNotification('Erreur lors de la modification du titre', 'error');
                })
                .finally(() => {
                    // Restaurer le bouton
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                });
            });
        }

        // ✅ GESTION SUPPRESSION DU QUIZ COMPLET - VERSION CORRIGÉE AVEC RAFRAÎCHISSEMENT
        const deleteQuizzForm = document.getElementById('deleteQuizzForm');
        if (deleteQuizzForm) {
            deleteQuizzForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Suppression...';

                // ✅ Création du FormData pour simuler DELETE avec Laravel
                const formData = new FormData();
                formData.append('_method', 'DELETE');
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                fetch(this.action, {
                    method: 'POST', // Laravel utilise POST avec _method pour simuler DELETE
                    body: formData, // Utiliser FormData au lieu de headers vides
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Quiz supprimé avec succès !', 'success');

                        // Fermer le modal
                        if (deleteQuizzModal) {
                            deleteQuizzModal.hide();
                        }

                        // ✅ Actualiser la page après un court délai pour voir les changements
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        showNotification('Erreur lors de la suppression: ' + (data.message || 'Erreur inconnue'), 'error');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    showNotification('Erreur lors de la suppression du quiz', 'error');
                })
                .finally(() => {
                    // Restaurer le bouton
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                });
            });
        }

        // ✅ AJOUTER UNE NOUVELLE RÉPONSE avec checkbox
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
                            <input type="checkbox" name="correct_answers[]" value="${reponseCount}" class="form-check-input" id="${uniqueId}">
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

        // ✅ AJOUT DE QUESTION EN AJAX
        const addQuestionForm = document.getElementById('add-question-form');
        if (addQuestionForm) {
            addQuestionForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const checkedAnswers = this.querySelectorAll('input[name="correct_answers[]"]:checked');

                if (checkedAnswers.length === 0) {
                    showNotification('Vous devez cocher au moins une réponse correcte.', 'error');
                    return false;
                }

                // Afficher un indicateur de chargement
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Ajout en cours...';

                const formData = new FormData(this);

                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur réseau');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        showNotification('Question ajoutée avec succès !', 'success');

                        // Réinitialiser le formulaire
                        this.reset();

                        // Remettre à 2 réponses par défaut
                        const container = document.getElementById('reponses-container');
                        const allReponses = container.querySelectorAll('.mb-3');

                        // Supprimer les réponses supplémentaires
                        for (let i = 2; i < allReponses.length; i++) {
                            allReponses[i].remove();
                        }

                        reponseCount = 2;
                        updateCheckboxValues();

                        // Ajouter la nouvelle question à la liste
                        addQuestionToList(data.question);

                    } else {
                        showNotification('Erreur lors de l\'ajout: ' + (data.message || 'Erreur inconnue'), 'error');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    showNotification('Erreur lors de l\'ajout de la question', 'error');
                })
                .finally(() => {
                    // Restaurer le bouton
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                });
            });
        }

        // ✅ FONCTION POUR AJOUTER UNE QUESTION À LA LISTE
        function addQuestionToList(questionData) {
            // Trouver le bon conteneur (celui avec les questions existantes)
            const questionsCard = document.querySelector('.card:last-of-type .card-body');

            // Supprimer le message "Aucune question" s'il existe
            const noQuestionMessage = questionsCard.querySelector('p.text-muted');
            if (noQuestionMessage) {
                noQuestionMessage.remove();
            }

            // Calculer l'index de la nouvelle question (basé sur les questions existantes)
            const existingQuestions = document.querySelectorAll('.question-item');
            const questionIndex = existingQuestions.length + 1;

            // Créer l'élément HTML de la nouvelle question
            const questionDiv = document.createElement('div');
            questionDiv.className = 'mb-4 p-3 border rounded question-item';
            questionDiv.id = 'question-' + questionData.id;

            let responsesHTML = '';
            questionData.reponses.forEach((reponse, index) => {
                responsesHTML += `
                    <li class="mb-1">
                        <span class="badge ${reponse.is_correct ? 'bg-success' : 'bg-secondary'} me-2">
                            ${index + 1}
                        </span>
                        ${reponse.content}
                        ${reponse.is_correct ? '<i class="bi bi-check-circle text-success ms-1"></i>' : ''}
                    </li>
                `;
            });

            questionDiv.innerHTML = `
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <strong class="question-title">Q${questionIndex}: ${questionData.content}</strong>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-primary btn-edit-question" data-question-id="${questionData.id}">
                            <i class="bi bi-pencil"></i> Modifier
                        </button>
                        <button class="btn btn-outline-danger btn-delete-question" data-question-id="${questionData.id}">
                            <i class="bi bi-trash"></i> Supprimer
                        </button>
                    </div>
                </div>

                <div class="question-display">
                    <ul class="list-unstyled">
                        ${responsesHTML}
                    </ul>
                </div>

                <div class="question-edit" style="display: none;">
                    <form class="edit-question-form" data-question-id="${questionData.id}">
                        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                        <div class="mb-3">
                            <label class="form-label">Question</label>
                            <input type="text" name="question_content" class="form-control" value="${questionData.content}" required>
                        </div>

                        <div class="edit-reponses-container">
                            ${questionData.reponses.map((reponse, index) => `
                                <div class="mb-3 input-group reponse-item">
                                    <input type="text" name="reponses[${reponse.id}]" class="form-control" value="${reponse.content}" required>
                                    <span class="input-group-text">
                                        <input type="checkbox" name="correct_reponses[]" value="${reponse.id}" class="form-check-input mt-0" id="edit_correct_${reponse.id}" ${reponse.is_correct ? 'checked' : ''}>
                                    </span>
                                    <span class="input-group-text">
                                        <label class="form-check-label mb-0" for="edit_correct_${reponse.id}">Correct</label>
                                    </span>
                                    ${index >= 2 ? '<button type="button" class="btn btn-sm btn-outline-danger remove-edit-reponse"><i class="bi bi-trash"></i></button>' : ''}
                                </div>
                            `).join('')}
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
            `;

            // Ajouter avec une animation À LA FIN de la liste des questions
            questionDiv.style.opacity = '0';
            questionDiv.style.transform = 'translateY(20px)';
            questionsCard.appendChild(questionDiv);

            // Animation d'apparition
            setTimeout(() => {
                questionDiv.style.transition = 'all 0.3s ease';
                questionDiv.style.opacity = '1';
                questionDiv.style.transform = 'translateY(0)';
            }, 10);
        }

        // ✅ GESTION DES CLICS
        document.addEventListener('click', function(e) {
            // Supprimer une réponse (nouvelle question)
            if (e.target.classList.contains('remove-reponse') || e.target.closest('.remove-reponse')) {
                const button = e.target.classList.contains('remove-reponse') ? e.target : e.target.closest('.remove-reponse');
                const parentDiv = button.closest('.mb-3');
                if (parentDiv && document.querySelectorAll('#reponses-container .mb-3').length > 2) {
                    parentDiv.remove();
                    updateCheckboxValues();
                } else {
                    showNotification('Vous devez avoir au moins deux réponses.', 'error');
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

            // Ajouter une réponse en mode édition avec checkbox
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
                        <input type="checkbox" name="correct_reponses[]" value="${newReponseId}" class="form-check-input mt-0" id="${uniqueEditId}">
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
                    showNotification('Vous devez avoir au moins deux réponses.', 'error');
                }
            }

            // Supprimer une question (ouvrir modal de confirmation)
            if (e.target.classList.contains('btn-delete-question') || e.target.closest('.btn-delete-question')) {
                const button = e.target.classList.contains('btn-delete-question') ? e.target : e.target.closest('.btn-delete-question');
                currentQuestionIdToDelete = button.getAttribute('data-question-id');

                if (deleteModal) {
                    deleteModal.show();
                }
            }
        });

        // Confirmation de suppression question depuis le modal
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
                        const questionElement = document.getElementById('question-' + currentQuestionIdToDelete);
                        questionElement.style.transition = 'all 0.3s ease';
                        questionElement.style.opacity = '0';
                        questionElement.style.transform = 'translateX(-20px)';

                        setTimeout(() => {
                            questionElement.remove();
                        }, 300);

                        showNotification('Question supprimée avec succès !', 'success');
                    } else {
                        showNotification('Erreur lors de la suppression: ' + (data.message || ''), 'error');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    showNotification('Erreur lors de la suppression', 'error');
                })
                .finally(() => {
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

        // ✅ SAUVEGARDER MODIFICATION avec support checkbox multiples
        document.addEventListener('submit', function(e) {
            if (e.target.classList.contains('edit-question-form')) {
                e.preventDefault();

                const questionId = e.target.getAttribute('data-question-id');
                const formData = new FormData(e.target);

                // Vérifier qu'au moins une réponse est cochée
                const checkedAnswers = e.target.querySelectorAll('input[name="correct_reponses[]"]:checked');
                if (checkedAnswers.length === 0) {
                    showNotification('Vous devez cocher au moins une réponse correcte.', 'error');
                    return false;
                }

                // Indicateur de chargement
                const submitBtn = e.target.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Sauvegarde...';

                // Convertir FormData en objet
                const data = {
                    question_content: formData.get('question_content'),
                    reponses: {},
                    correct_reponses: []
                };

                // Récupérer toutes les réponses
                for (let [key, value] of formData.entries()) {
                    if (key.startsWith('reponses[')) {
                        const reponseId = key.match(/reponses\[(.+)\]/)[1];
                        data.reponses[reponseId] = value;
                    }
                    if (key === 'correct_reponses[]') {
                        data.correct_reponses.push(value);
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
                        showNotification('Question modifiée avec succès !', 'success');

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
                                            const isCorrect = data.correct_reponses.includes(id);
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
                        showNotification('Erreur lors de la modification: ' + (data.message || ''), 'error');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    showNotification('Erreur lors de la modification', 'error');
                })
                .finally(() => {
                    // Restaurer le bouton
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                });
            }
        });

        // ✅ Fonction pour réajuster les valeurs des checkboxes
        function updateCheckboxValues() {
            const reponseInputs = document.querySelectorAll('#reponses-container .mb-3');
            reponseInputs.forEach((div, index) => {
                const checkbox = div.querySelector('input[type="checkbox"]');
                if (checkbox) {
                    checkbox.value = index;
                    checkbox.id = 'new_correct_' + index;
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
        }

        // ✅ CRÉATION DE QUIZ EN AJAX (éviter rechargement)
        const createQuizForm = document.querySelector('form[action*="storeOrUpdate"]:not(#add-question-form)');
        if (createQuizForm) {
            createQuizForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Création en cours...';

                const formData = new FormData(this);

                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Quiz créé avec succès !', 'success');

                        // Masquer le formulaire de création
                        const createCard = this.closest('.card');
                        createCard.style.transition = 'all 0.3s ease';
                        createCard.style.opacity = '0';
                        createCard.style.transform = 'translateY(-20px)';

                        setTimeout(() => {
                            createCard.style.display = 'none';

                            // Afficher la section d'ajout de questions
                            const addQuestionCard = document.querySelector('.card:nth-of-type(2)');
                            if (addQuestionCard) {
                                addQuestionCard.style.display = 'block';
                                addQuestionCard.style.opacity = '0';
                                addQuestionCard.style.transform = 'translateY(20px)';

                                setTimeout(() => {
                                    addQuestionCard.style.transition = 'all 0.3s ease';
                                    addQuestionCard.style.opacity = '1';
                                    addQuestionCard.style.transform = 'translateY(0)';
                                }, 10);
                            }
                        }, 300);
                    } else {
                        showNotification('Erreur lors de la création: ' + (data.message || 'Erreur inconnue'), 'error');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    showNotification('Erreur lors de la création du quiz', 'error');
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                });
            });
        }

        // ✅ Gérer les messages de session Laravel (quiz créé)
        const sessionSuccess = document.querySelector('.alert-success');
        if (sessionSuccess && !sessionSuccess.id) { // Éviter les alertes AJAX
            const message = sessionSuccess.textContent.trim();
            sessionSuccess.style.display = 'none'; // Masquer l'alerte Bootstrap
            showNotification(message, 'success');
        }

        const sessionError = document.querySelector('.alert-danger');
        if (sessionError && !sessionError.id) { // Éviter les alertes AJAX
            const message = sessionError.textContent.trim();
            sessionError.style.display = 'none'; // Masquer l'alerte Bootstrap
            showNotification(message, 'error');
        }
    });
</script>
@endpush
