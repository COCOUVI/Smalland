<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    /* ========================================
       VARIABLES GLOBALES ET INITIALISATION
    ======================================== */
    let moduleToDelete = null;

    // Éléments DOM fréquemment utilisés
    const editModuleModal = document.getElementById('editModuleModal');
    const deleteModuleModal = new bootstrap.Modal(document.getElementById('deleteModuleModal'));

    /* ========================================
       GESTION DU MODAL D'ÉDITION DE MODULE
    ======================================== */
    if (editModuleModal) {
        editModuleModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const moduleId = button.getAttribute('data-module-id');
            const moduleTitre = button.getAttribute('data-module-titre');

            const modalTitle = this.querySelector('.modal-title');
            const moduleTitreInput = this.querySelector('#moduleTitre');
            const form = this.querySelector('#editModuleForm');

            modalTitle.textContent = `Modifier le module: ${moduleTitre}`;
            moduleTitreInput.value = moduleTitre;
            form.setAttribute('data-module-id', moduleId);
        });

        // Nettoyage lors de la fermeture
        editModuleModal.addEventListener('hidden.bs.modal', function () {
            const form = this.querySelector('#editModuleForm');
            form.reset();
            form.removeAttribute('data-module-id');

            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Enregistrer';
        });
    }

    /* ========================================
       SOUMISSION DU FORMULAIRE D'ÉDITION
    ======================================== */
    document.getElementById('editModuleForm').addEventListener('submit', function (e) {
        e.preventDefault();
        handleModuleUpdate(this);
    });

    function handleModuleUpdate(form) {
        const moduleId = form.getAttribute('data-module-id');
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;

        // État de chargement
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Enregistrement...';

        const data = {
            titre: formData.get('titre'),
            _method: 'PUT',
            _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };

        fetch(`/dashboard/modules/${moduleId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeModal('editModuleModal');
                    updateModuleInInterface(moduleId, data.module);
                    showAlert('success', data.message || 'Module mis à jour avec succès !');
                } else {
                    showAlert('danger', data.message || 'Erreur lors de la mise à jour.');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                showAlert('danger', 'Une erreur est survenue lors de la mise à jour.');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            });
    }

    /* ========================================
       GESTION DE LA SUPPRESSION DE MODULE
    ======================================== */
    document.addEventListener('click', function (e) {
        if (e.target.closest('.btn-delete')) {
            const btn = e.target.closest('.btn-delete');
            const moduleId = btn.dataset.moduleId;
            const moduleTitle = btn.dataset.moduleTitle;

            moduleToDelete = {
                id: moduleId,
                title: moduleTitle,
                button: btn
            };

            document.getElementById('moduleToDeleteTitle').textContent = moduleTitle;
            deleteModuleModal.show();
        }
    });

    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        if (!moduleToDelete) return;
        handleModuleDelete();
    });

    function handleModuleDelete() {
        const confirmBtn = document.getElementById('confirmDeleteBtn');
        const originalText = confirmBtn.innerHTML;

        confirmBtn.disabled = true;
        confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Suppression...';

        const moduleCards = document.querySelectorAll(`[data-module-id="${moduleToDelete.id}"]`);
        moduleCards.forEach(card => card.classList.add('deleting'));

        fetch(`/dashboard/modules/${moduleToDelete.id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    deleteModuleModal.hide();
                    cleanupModalBackdrop();

                    moduleCards.forEach(card => {
                        card.classList.remove('deleting');
                        card.classList.add('deleted');
                        setTimeout(() => {
                            card.remove();
                            checkIfNoModulesLeft();
                        }, 500);
                    });

                    showAlert('success', data.message || 'Module supprimé avec succès !');
                } else {
                    moduleCards.forEach(card => card.classList.remove('deleting'));
                    showAlert('danger', data.message || 'Erreur lors de la suppression du module.');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                moduleCards.forEach(card => card.classList.remove('deleting'));
                showAlert('danger', 'Une erreur est survenue lors de la suppression.');
            })
            .finally(() => {
                confirmBtn.disabled = false;
                confirmBtn.innerHTML = originalText;
                moduleToDelete = null;
            });
    }

    /* ========================================
       GESTION DES LEÇONS
    ======================================== */
    document.addEventListener('DOMContentLoaded', function () {
        const addLessonModalEl = document.getElementById('addLessonModal');
        if (!addLessonModalEl) return;

        // Instancier UNE SEULE FOIS
        const addLessonModalInstance = new bootstrap.Modal(addLessonModalEl);

        // ✅ GESTION DE L'OUVERTURE
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.btn-success[title="Ajouter une leçon"]');
            if (!btn) return;

            const moduleCard = btn.closest('.module-card');
            const moduleId = moduleCard.dataset.moduleId;
            const moduleTitle = moduleCard.querySelector('.module-title').textContent;

            document.getElementById('lessonModuleId').value = moduleId;
            document.getElementById('moduleNamePreview').textContent = moduleTitle;

            resetLessonForm();

            addLessonModalInstance.show();
        });

        // ✅ AVANT LA FERMETURE : Retirer le focus pour éviter aria-hidden error
        addLessonModalEl.addEventListener('hide.bs.modal', function () {
            if (document.activeElement instanceof HTMLElement) {
                document.activeElement.blur();
            }
        });

        // ✅ APRÈS FERMETURE : Réinitialiser le formulaire
        addLessonModalEl.addEventListener('hidden.bs.modal', function () {
            resetLessonForm();
        });

        // ✅ GESTION DES BOUTONS "Annuler" / "X"
        addLessonModalEl.querySelectorAll('[data-bs-dismiss="modal"]').forEach(btnClose => {
            btnClose.addEventListener('click', () => {
                addLessonModalInstance.hide();
            });
        });

        // ✅ RÉFOCUS SUR LE BOUTON AJOUT APRÈS FERMETURE
        addLessonModalEl.addEventListener('hidden.bs.modal', function () {
            const triggerBtn = document.querySelector('.btn-success[title="Ajouter une leçon"]');
            if (triggerBtn instanceof HTMLElement) {
                triggerBtn.focus();
            }
        });
    });

    // Gestion des uploads de fichiers
    document.getElementById('lessonVideo').addEventListener('change', function (e) {
        handleFileSelection(e, 'video');
    });

    document.getElementById('lessonPdf').addEventListener('change', function (e) {
        handleFileSelection(e, 'pdf');
    });

    function handleFileSelection(event, type) {
        const file = event.target.files[0];
        if (!file) return;

        const maxSize = type === 'video' ? 100 * 1024 * 1024 : 10 * 1024 * 1024;
        if (file.size > maxSize) {
            alert(`Le fichier est trop volumineux. Taille maximale: ${type === 'video' ? '100MB' : '10MB'}`);
            event.target.value = '';
            return;
        }

        showFilePreview(file, type);
    }

    function showFilePreview(file, type) {
        const fileName = document.getElementById(`${type}FileName`);
        const fileSize = document.getElementById(`${type}FileSize`);
        const preview = document.getElementById(`${type}Preview`);
        const placeholder = document.querySelector(`#${type}UploadZone .upload-placeholder`);

        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);

        placeholder.style.display = 'none';
        preview.style.display = 'block';
    }

    // Suppression des fichiers sélectionnés
    function removeVideo() {
        document.getElementById('lessonVideo').value = '';
        document.getElementById('videoPreview').style.display = 'none';
        document.querySelector('#videoUploadZone .upload-placeholder').style.display = 'flex';
    }

    function removePdf() {
        document.getElementById('lessonPdf').value = '';
        document.getElementById('pdfPreview').style.display = 'none';
        document.querySelector('#pdfUploadZone .upload-placeholder').style.display = 'flex';
    }

    // Soumission du formulaire d'ajout de leçon
    document.getElementById('addLessonForm').addEventListener('submit', function (e) {
        e.preventDefault();
        handleLessonSubmit(this);
    });

    function handleLessonSubmit(form) {
        // Validation personnalisée
        const videoFile = document.getElementById('lessonVideo').files[0];
        const titleValue = document.getElementById('lessonTitle').value.trim();

        if (!titleValue) {
            showAlert('danger', 'Veuillez saisir un titre pour la leçon.');
            document.getElementById('lessonTitle').focus();
            return;
        }

        if (!videoFile) {
            showAlert('danger', 'Veuillez sélectionner une vidéo pour la leçon.');
            document.querySelector('#videoUploadZone .upload-placeholder').click();
            return;
        }

        if (videoFile && videoFile.size > 100 * 1024 * 1024) {
            showAlert('danger', 'La vidéo ne doit pas dépasser 100MB.');
            return;
        }

        const pdfFile = document.getElementById('lessonPdf').files[0];
        if (pdfFile && pdfFile.size > 10 * 1024 * 1024) {
            showAlert('danger', 'Le fichier PDF ne doit pas dépasser 10MB.');
            return;
        }

        // Soumission
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        const moduleId = document.getElementById('lessonModuleId').value;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Création en cours...';

        // Afficher les progress bars
        document.getElementById('videoProgress').style.display = 'block';
        if (pdfFile) {
            document.getElementById('pdfProgress').style.display = 'block';
        }

        simulateProgress('video');
        if (pdfFile) {
            simulateProgress('pdf');
        }

        fetch(`/dashboard/modules/${moduleId}/lessons`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeModal('addLessonModal');
                    showAlert('success', data.message || 'Leçon ajoutée avec succès !');

                    // ACTUALISATION PARTIELLE - REMPLACEMENT DU RELOAD COMPLET
                    setTimeout(() => {
                        updateLessonsList(moduleId);
                    }, 500);
                } else {
                    showAlert('danger', data.message || 'Erreur lors de l\'ajout de la leçon.');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                showAlert('danger', 'Une erreur est survenue lors de l\'ajout de la leçon.');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;

                document.getElementById('videoProgress').style.display = 'none';
                document.getElementById('pdfProgress').style.display = 'none';
            });
    }

    /* ========================================
       FONCTIONS UTILITAIRES
    ======================================== */
    function updateModuleInInterface(moduleId, updatedModule) {
        const moduleCards = document.querySelectorAll(`[data-module-id="${moduleId}"]`);

        moduleCards.forEach(card => {
            const titleElement = card.querySelector('.module-title');
            if (titleElement) {
                titleElement.textContent = updatedModule.titre;
            }

            const editBtn = card.querySelector('[data-bs-target="#editModuleModal"]');
            if (editBtn) {
                editBtn.setAttribute('data-module-titre', updatedModule.titre);
            }

            const deleteBtn = card.querySelector('.btn-delete');
            if (deleteBtn) {
                deleteBtn.setAttribute('data-module-title', updatedModule.titre);
            }

            // Animation de succès
            card.style.transform = 'scale(1.02)';
            card.style.boxShadow = '0 0 20px rgba(40, 167, 69, 0.3)';
            card.style.transition = 'all 0.3s ease';

            setTimeout(() => {
                card.style.transform = '';
                card.style.boxShadow = '';
            }, 600);
        });
    }

    // NOUVELLE FONCTION: Actualisation de la liste des leçons
    function updateLessonsList(moduleId) {
        fetch(`/dashboard/modules/${moduleId}/lessons`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mettre à jour le conteneur des leçons
                    const lessonsContainer = document.querySelector(`.module-card[data-module-id="${moduleId}"] .lessons-container`);
                    if (lessonsContainer) {
                        // Générer le HTML pour les leçons
                        let lessonsHtml = '';

                        if (data.lessons && data.lessons.length > 0) {
                            data.lessons.forEach(lesson => {
                                lessonsHtml += `
                                    <div class="lesson-item mb-2 p-2 border rounded d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-play-circle text-primary me-2"></i>
                                            <span>${lesson.titre}</span>
                                        </div>
                                        <div class="lesson-actions">
                                            <a href="/storage/${lesson.video_url}" target="_blank" class="btn btn-sm btn-outline-primary me-1" title="Voir la vidéo">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            ${lesson.pdf_url ? `
                                                <a href="/storage/${lesson.pdf_url}" target="_blank" class="btn btn-sm btn-outline-info me-1" title="Voir le PDF">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                            ` : ''}
                                            <button class="btn btn-sm btn-outline-danger" title="Supprimer la leçon" onclick="deleteLesson(${lesson.id})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                `;
                            });
                        } else {
                            lessonsHtml = '<p class="text-muted">Aucune leçon pour ce module.</p>';
                        }

                        lessonsContainer.innerHTML = lessonsHtml;

                        // Mettre à jour le compteur de leçons
                        const lessonCountBadge = document.querySelector(`.module-card[data-module-id="${moduleId}"] .lesson-count`);
                        if (lessonCountBadge) {
                            lessonCountBadge.textContent = data.lessons.length;
                        }
                    }
                } else {
                    console.error('Erreur lors de la récupération des leçons');
                }
            })
            .catch(error => {
                console.error('Erreur lors de la mise à jour des leçons:', error);
                // Fallback: rechargement complet en cas d'erreur
                window.location.reload();
            });
    }

    function showAlert(type, message) {
        const alertDiv = document.getElementById('ajaxAlert');
        const messageSpan = document.getElementById('ajaxMessage');

        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        messageSpan.textContent = message;
        alertDiv.style.display = 'block';

        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });

        setTimeout(() => {
            hideAlert();
        }, 5000);
    }

    function hideAlert() {
        const alertDiv = document.getElementById('ajaxAlert');
        alertDiv.classList.remove('show');
        setTimeout(() => {
            alertDiv.style.display = 'none';
        }, 150);
    }

    function closeModal(modalId) {
        const modalElement = document.getElementById(modalId);
        const closeButton = modalElement.querySelector('[data-bs-dismiss="modal"]');
        if (closeButton) {
            closeButton.click();
        } else {
            modalElement.style.display = 'none';
            modalElement.classList.remove('show');
            modalElement.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            cleanupModalBackdrop();
        }
    }

    function cleanupModalBackdrop() {
        setTimeout(() => {
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove();
            }
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        }, 150);
    }

    function checkIfNoModulesLeft() {
        const desktopContainer = document.getElementById('modules-container-desktop');
        const mobileContainer = document.getElementById('modules-container-mobile');

        const remainingDesktopModules = desktopContainer.querySelectorAll('.module-card').length;
        const remainingMobileModules = mobileContainer ? mobileContainer.querySelectorAll('.module-card').length : 0;

        if (remainingDesktopModules === 0) {
            desktopContainer.innerHTML = `
                <div class="col-12" id="no-modules-message-desktop">
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle me-2"></i>Aucun module disponible.
                    </div>
                </div>
            `;
        }

        if (mobileContainer && remainingMobileModules === 0) {
            mobileContainer.innerHTML = `
                <div class="alert alert-info text-center" id="no-modules-message-mobile">
                    <i class="fas fa-info-circle me-2"></i>Aucun module disponible.
                </div>
            `;
        }
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function resetLessonForm() {
        document.getElementById('addLessonForm').reset();

        document.getElementById('videoPreview').style.display = 'none';
        document.getElementById('pdfPreview').style.display = 'none';
        document.querySelector('#videoUploadZone .upload-placeholder').style.display = 'flex';
        document.querySelector('#pdfUploadZone .upload-placeholder').style.display = 'flex';

        document.getElementById('videoProgress').style.display = 'none';
        document.getElementById('pdfProgress').style.display = 'none';
    }

    function simulateProgress(type) {
        const progressBar = document.querySelector(`#${type}Progress .progress-bar`);
        let progress = 0;

        const interval = setInterval(() => {
            progress += Math.random() * 15;
            if (progress > 95) progress = 95;

            progressBar.style.width = progress + '%';
            progressBar.textContent = Math.round(progress) + '%';

            if (progress >= 95) {
                clearInterval(interval);
                setTimeout(() => {
                    progressBar.style.width = '100%';
                    progressBar.textContent = '100%';
                }, 500);
            }
        }, 200);
    }

    /* ========================================
       ÉVÉNEMENTS ET INITIALISATION
    ======================================== */
    document.addEventListener('DOMContentLoaded', function () {
        // Animation des cards
        const cards = document.querySelectorAll('.card-module');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';

            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100 + (index * 100));
        });

        // Gestion des modals (focus / reset)
        const addLessonModal = document.getElementById('addLessonModal');

        // Retire le focus actif avant la fermeture du modal pour éviter l'erreur aria-hidden
        addLessonModal.addEventListener('hide.bs.modal', function () {
            if (document.activeElement instanceof HTMLElement) {
                document.activeElement.blur();
            }
        });

        // Réinitialisation du formulaire quand la modale est complètement fermée
        addLessonModal.addEventListener('hidden.bs.modal', function () {
            resetLessonForm();
        });

        ['#editModuleModal', '#deleteModuleModal', '#addLessonModal'].forEach(modalSelector => {
            const modalElement = document.querySelector(modalSelector);
            if (!modalElement) return;

            // Avant fermeture, enlever le focus pour éviter aria-hidden errors
            modalElement.addEventListener('hide.bs.modal', function () {
                if (document.activeElement instanceof HTMLElement) {
                    document.activeElement.blur();
                }
            });
        });

        // Instancier le modal UNE SEULE FOIS
        window.addLessonModalInstance = new bootstrap.Modal(addLessonModal);
    });

    // Nettoyage des modals
    document.getElementById('deleteModuleModal').addEventListener('hidden.bs.modal', function () {
        moduleToDelete = null;
        cleanupModalBackdrop();
    });

    document.querySelector('#deleteModuleModal [data-bs-dismiss="modal"]').addEventListener('click', function () {
        cleanupModalBackdrop();
    });

    document.getElementById('addLessonModal').addEventListener('hidden.bs.modal', function () {
        resetLessonForm();
    });

    // Empêcher l'erreur "aria-hidden" en retirant le focus avant la fermeture des modals
    ['editModuleModal', 'deleteModuleModal', 'addLessonModal'].forEach(modalId => {
        const modalEl = document.getElementById(modalId);
        if (!modalEl) return;

        modalEl.addEventListener('hide.bs.modal', () => {
            if (document.activeElement instanceof HTMLElement) {
                document.activeElement.blur();
            }
        });
    });

    // Remettre le focus sur les boutons déclencheurs si besoin
    document.getElementById('editModuleModal')?.addEventListener('hidden.bs.modal', () => {
        document.querySelector('[data-bs-target="#editModuleModal"]')?.focus();
    });

    document.getElementById('deleteModuleModal')?.addEventListener('hidden.bs.modal', () => {
        if (moduleToDelete?.button instanceof HTMLElement) {
            moduleToDelete.button.focus();
        }
    });

    document.getElementById('addLessonModal')?.addEventListener('hidden.bs.modal', () => {
        document.querySelector('[data-bs-target="#addLessonModal"]')?.focus();
    });

    // Exposition des fonctions globales pour les boutons inline
    window.removeVideo = removeVideo;
    window.removePdf = removePdf;
    window.hideAlert = hideAlert;
</script>
