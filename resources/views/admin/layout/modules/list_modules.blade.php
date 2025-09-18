@extends('admin.master')

@section('content')
    <div class="container mt-3 mt-md-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
            <h2 class="mb-2 mb-md-0">Liste des modules</h2>
            <a href="{{ route('lists_formation') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-1"></i> Retour aux formations
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Alert pour les messages AJAX -->
        <div id="ajaxAlert" class="alert alert-dismissible fade" role="alert" style="display: none;">
            <span id="ajaxMessage"></span>
            <button type="button" class="btn-close" onclick="hideAlert()"></button>
        </div>

        <div class="row">
            <!-- Version desktop (cartes en grille) -->
            <div class="d-none d-md-block">
                <div class="row" id="modules-container-desktop">
                    @forelse($modules as $module)
                        <div class="col-md-6 col-lg-4 mb-4 module-card" data-module-id="{{ $module->id }}">
                            <div class="card card-module h-100 shadow-sm border-0">
                                <div
                                    class="card-header bg-transparent border-0 pb-0 d-flex justify-content-between align-items-center">
                                    <span class="badge bg-secondary">ID: {{ $module->id }}</span>
                                </div>
                                <div class="card-body module-info">
                                    <h5 class="module-title">{{ $module->titre }}</h5>
                                    <div class="module-details">
                                        <div class="mb-2">
                                            <span class="badge badge-formation">Formation:
                                                {{ $module->formation->titre ?? 'N/A' }}</span>
                                        </div>
                                        <div class="text-muted small">
                                            <div><i class="fas fa-calendar-plus me-1"></i> Créé le:
                                                {{ $module->created_at->format('d/m/Y') }}</div>
                                            @if ($module->updated_at != $module->created_at)
                                                <div><i class="fas fa-calendar-check me-1"></i> Modifié le:
                                                    {{ $module->updated_at->format('d/m/Y') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-white border-0 pt-0">
                                    <div class="module-actions">
                                        <button type="button" class="btn btn-sm btn-danger btn-action btn-delete"
                                            title="Supprimer le module" data-module-id="{{ $module->id }}"
                                            data-module-title="{{ $module->titre }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning btn-action" title="Modifier le module"
                                            data-bs-toggle="modal" data-bs-target="#editModuleModal"
                                            data-module-id="{{ $module->id }}" data-module-titre="{{ $module->titre }}"
                                            data-module-ordre="{{ $module->ordre }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-success btn-action" title="Ajouter une leçon">
                                            <i class="fas fa-plus-circle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12" id="no-modules-message-desktop">
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle me-2"></i>Aucun module disponible.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Version mobile (liste de cartes) -->
            <div class="d-md-none">
                <div id="modules-container-mobile">
                    @forelse($modules as $module)
                        <div class="card card-module mb-3 shadow-sm border-0 module-card"
                            data-module-id="{{ $module->id }}">
                            <div
                                class="card-header bg-transparent border-0 pb-0 d-flex justify-content-between align-items-center">
                                <span class="badge bg-secondary">ID: {{ $module->id }}</span>
                            </div>
                            <div class="card-body">
                                <h5 class="module-title mb-3">{{ $module->titre }}</h5>
                                <div class="module-details mb-3">
                                    <div class="mb-2">
                                        <span class="badge badge-formation w-100">Formation:
                                            {{ $module->formation->titre ?? 'N/A' }}</span>
                                    </div>
                                    <div class="text-muted small">
                                        <div><i class="fas fa-calendar-plus me-1"></i> Créé le:
                                            {{ $module->created_at->format('d/m/Y') }}</div>
                                        @if ($module->updated_at != $module->created_at)
                                            <div><i class="fas fa-calendar-check me-1"></i> Modifié le:
                                                {{ $module->updated_at->format('d/m/Y') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="module-actions d-grid gap-2 d-flex justify-content-center">
                                    <button type="button" class="btn btn-sm btn-danger flex-fill btn-delete"
                                        title="Supprimer le module" data-module-id="{{ $module->id }}"
                                        data-module-title="{{ $module->titre }}">
                                        <i class="fas fa-trash me-1"></i><span class="d-none d-sm-inline">Supprimer</span>
                                    </button>
                                    <button class="btn btn-sm btn-warning flex-fill" title="Modifier le module"
                                        data-bs-toggle="modal" data-bs-target="#editModuleModal"
                                        data-module-id="{{ $module->id }}" data-module-titre="{{ $module->titre }}"
                                        data-module-ordre="{{ $module->ordre }}">
                                        <i class="fas fa-edit me-1"></i><span class="d-none d-sm-inline">Modifier</span>
                                    </button>
                                    <button class="btn btn-sm btn-success flex-fill" title="Ajouter une leçon">
                                        <i class="fas fa-plus-circle me-1"></i><span class="d-none d-sm-inline">Leçon</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info text-center" id="no-modules-message-mobile">
                            <i class="fas fa-info-circle me-2"></i>Aucun module disponible.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Pagination -->
        @if ($modules->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $modules->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    <!-- Modal pour modifier un module -->
    <div class="modal fade" id="editModuleModal" tabindex="-1" aria-labelledby="editModuleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModuleModalLabel">Modifier le module</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editModuleForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="moduleTitre" class="form-label">Titre du module <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="moduleTitre" name="titre" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div class="modal fade" id="deleteModuleModal" tabindex="-1" aria-labelledby="deleteModuleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0 pb-1">
                    <h5 class="modal-title text-danger" id="deleteModuleModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Confirmer la suppression
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="text-center mb-3">
                        <i class="fas fa-trash-alt text-danger" style="font-size: 3rem; opacity: 0.7;"></i>
                    </div>
                    <p class="text-center fs-6">Êtes-vous sûr de vouloir supprimer le module :</p>
                    <p class="text-center fw-bold fs-5 text-primary" id="moduleToDeleteTitle"></p>
                    <div class="alert alert-warning border-0 bg-warning bg-opacity-10 text-warning-emphasis">
                        <i class="fas fa-info-circle me-2"></i>
                        Cette action est irréversible et supprimera définitivement ce module.
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Annuler
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="fas fa-trash me-1"></i>Supprimer définitivement
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pour ajouter une leçon -->
    <div class="modal fade" id="addLessonModal" tabindex="-1" aria-labelledby="addLessonModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLessonModalLabel">Ajouter une leçon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addLessonForm" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" id="lessonModuleId" name="module_id" value="">

                        <!-- Titre de la leçon -->
                        <div class="mb-4">
                            <label for="lessonTitle" class="form-label">
                                Titre de la leçon <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="lessonTitle" name="titre" required>
                            <div class="form-text">Donnez un titre descriptif à votre leçon</div>
                        </div>

                        <!-- Section Upload Vidéo -->
                        {{-- <div class="mb-4">
                            <label for="lessonVideo" class="form-label">
                                <i class="fas fa-video me-2 text-primary"></i>
                                Vidéo de la leçon <span class="text-danger">*</span>
                            </label>
                            <div class="upload-zone" id="videoUploadZone">
                                <input type="file" class="form-control" id="lessonVideo" name="video"
                                    accept="video/*" required style="display: none;">
                                <div class="upload-placeholder" onclick="document.getElementById('lessonVideo').click()">
                                    <div class="upload-icon">
                                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                    </div>
                                    <p class="mb-2"><strong>Cliquez pour sélectionner une vidéo</strong></p>
                                    <p class="text-muted small">Formats acceptés: MP4, AVI, MOV, WMV (Max: 100MB)</p>
                                </div>
                                <div class="upload-preview" id="videoPreview" style="display: none;">
                                    <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-file-video fa-2x text-primary me-3"></i>
                                            <div>
                                                <div class="fw-bold" id="videoFileName"></div>
                                                <div class="text-muted small" id="videoFileSize"></div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="removeVideo()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="progress mt-2" id="videoProgress" style="display: none;">
                                        <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}


                        <!-- REMPLACEZ la section vidéo dans votre modal par ceci : -->
                        <div class="mb-4">
                            <label for="lessonVideo" class="form-label">
                                <i class="fas fa-video me-2 text-primary"></i>
                                Vidéo de la leçon <span class="text-danger">*</span>
                            </label>
                            <div class="upload-zone" id="videoUploadZone">
                                <!-- SUPPRIMEZ l'attribut 'required' du champ input -->
                                <input type="file" class="form-control" id="lessonVideo" name="video"
                                    accept="video/*" style="display: none;">
                                <div class="upload-placeholder" onclick="document.getElementById('lessonVideo').click()">
                                    <div class="upload-icon">
                                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                    </div>
                                    <p class="mb-2"><strong>Cliquez pour sélectionner une vidéo</strong></p>
                                    <p class="text-muted small">Formats acceptés: MP4, AVI, MOV, WMV (Max: 100MB)</p>
                                </div>
                                <div class="upload-preview" id="videoPreview" style="display: none;">
                                    <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-file-video fa-2x text-primary me-3"></i>
                                            <div>
                                                <div class="fw-bold" id="videoFileName"></div>
                                                <div class="text-muted small" id="videoFileSize"></div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="removeVideo()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="progress mt-2" id="videoProgress" style="display: none;">
                                        <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section Upload PDF -->
                        <div class="mb-4">
                            <label for="lessonPdf" class="form-label">
                                <i class="fas fa-file-pdf me-2 text-danger"></i>
                                Document PDF <span class="text-muted">(optionnel)</span>
                            </label>
                            <div class="upload-zone" id="pdfUploadZone">
                                <input type="file" class="form-control" id="lessonPdf" name="pdf" accept=".pdf"
                                    style="display: none;">
                                <div class="upload-placeholder" onclick="document.getElementById('lessonPdf').click()">
                                    <div class="upload-icon">
                                        <i class="fas fa-file-pdf fa-3x text-muted mb-3"></i>
                                    </div>
                                    <p class="mb-2"><strong>Cliquez pour sélectionner un PDF</strong></p>
                                    <p class="text-muted small">Support de cours, exercices, etc. (Max: 10MB)</p>
                                </div>
                                <div class="upload-preview" id="pdfPreview" style="display: none;">
                                    <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-file-pdf fa-2x text-danger me-3"></i>
                                            <div>
                                                <div class="fw-bold" id="pdfFileName"></div>
                                                <div class="text-muted small" id="pdfFileSize"></div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="removePdf()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="progress mt-2" id="pdfProgress" style="display: none;">
                                        <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Aperçu du module -->
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Cette leçon sera ajoutée au module: <strong id="moduleNamePreview"></strong>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Annuler
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-plus me-1"></i>Ajouter la leçon
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <style>
        .card-module {
            transition: transform 0.2s, box-shadow 0.2s;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.08);
        }

        .card-module:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .module-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: center;
        }

        .btn-action {
            min-width: 40px;
        }

        .module-info {
            padding: 15px;
        }

        .module-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 12px;
            line-height: 1.4;
        }

        .module-details {
            color: #666;
            font-size: 0.9rem;
        }

        .badge-ordre {
            background-color: #6c757d;
            color: white;
        }

        .badge-formation {
            background-color: #0d6efd;
            color: white;
            font-weight: 500;
        }

        /* Styles pour la modal de suppression */
        .modal-content {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            border-radius: 15px 15px 0 0;
        }

        /* Animation de suppression */
        .module-card.deleting {
            opacity: 0.5;
            transform: scale(0.95);
            transition: all 0.3s ease;
        }

        .module-card.deleted {
            opacity: 0;
            transform: scale(0.8) translateY(-20px);
            transition: all 0.5s ease;
        }

        /* Loading state */
        .btn-delete.loading {
            position: relative;
            color: transparent !important;
        }

        .btn-delete.loading::after {
            content: "";
            position: absolute;
            width: 16px;
            height: 16px;
            top: 50%;
            left: 50%;
            margin-left: -8px;
            margin-top: -8px;
            border-radius: 50%;
            border: 2px solid transparent;
            border-top-color: #ffffff;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Améliorations pour mobile */
        @media (max-width: 768px) {
            .container {
                padding-left: 12px;
                padding-right: 12px;
            }

            .card-module {
                margin-bottom: 16px;
                border-radius: 10px;
            }

            .module-title {
                font-size: 1.1rem;
            }

            .module-actions {
                margin-top: 16px;
                gap: 6px;
            }

            .module-actions .btn {
                padding: 0.35rem 0.7rem;
                font-size: 0.85rem;
                border-radius: 6px;
            }

            .badge {
                font-size: 0.75rem;
                padding: 0.35em 0.65em;
            }

            .alert {
                margin: 0.5rem;
                border-radius: 8px;
            }
        }

        /* Amélioration de l'accessibilité */
        .btn:focus {
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .card-module .card-header {
            padding: 12px 15px 0;
        }






        .upload-zone {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .upload-zone:hover {
            border-color: #0d6efd;
            background-color: #f8f9ff;
        }

        .upload-placeholder {
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            min-height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .upload-placeholder:hover .upload-icon i {
            color: #0d6efd !important;
            transform: scale(1.1);
            transition: all 0.3s ease;
        }

        .upload-preview {
            display: none;
        }

        .modal-lg {
            max-width: 600px;
        }

        @media (max-width: 768px) {
            .upload-placeholder {
                padding: 1.5rem;
                min-height: 100px;
            }

            .upload-placeholder .fa-3x {
                font-size: 2rem !important;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let moduleToDelete = null;

        // Gestion du modal d'édition
        const editModuleModal = document.getElementById('editModuleModal');
        if (editModuleModal) {
            editModuleModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const moduleId = button.getAttribute('data-module-id');
                const moduleTitre = button.getAttribute('data-module-titre');
                const moduleOrdre = button.getAttribute('data-module-ordre');

                const modalTitle = editModuleModal.querySelector('.modal-title');
                const moduleTitreInput = editModuleModal.querySelector('#moduleTitre');
                const form = editModuleModal.querySelector('#editModuleForm');

                modalTitle.textContent = `Modifier le module: ${moduleTitre}`;
                moduleTitreInput.value = moduleTitre;

                // Définir l'action correctement
                form.setAttribute('data-module-id', moduleId);
            });
        }


        // VERSION SIMPLIFIÉE - Sans getInstance
        document.getElementById('editModuleForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const moduleId = form.getAttribute('data-module-id');
            const formData = new FormData(form);
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;

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
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Fermer la modal avec l'approche directe
                        // const modalElement = document.getElementById('editModuleModal');
                        // const bsModal = new bootstrap.Modal(modalElement);
                        // bsModal.hide();

                        const modalElement = document.getElementById('editModuleModal');
                        const closeButton = modalElement.querySelector('[data-bs-dismiss="modal"]');
                        if (closeButton) {
                            closeButton.click();
                        } else {
                            // Méthode 2 : Fermeture manuelle si le bouton n'existe pas
                            modalElement.style.display = 'none';
                            modalElement.classList.remove('show');
                            modalElement.setAttribute('aria-hidden', 'true');
                            document.body.classList.remove('modal-open');
                            document.body.style.overflow = '';

                            // Supprimer le backdrop
                            const backdrop = document.querySelector('.modal-backdrop');
                            if (backdrop) {
                                backdrop.remove();
                            }
                        }

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
        });



        // FONCTION MISE À JOUR : Mettre à jour l'interface après modification
        function updateModuleInInterface(moduleId, updatedModule) {
            // Récupérer TOUTES les cartes avec cet ID (desktop et mobile)
            const moduleCards = document.querySelectorAll(`[data-module-id="${moduleId}"]`);

            moduleCards.forEach(card => {
                // Mettre à jour le titre du module
                const titleElement = card.querySelector('.module-title');
                if (titleElement) {
                    titleElement.textContent = updatedModule.titre;
                }

                // Mettre à jour les attributs data pour les boutons de modification
                const editBtn = card.querySelector('[data-bs-target="#editModuleModal"]');
                if (editBtn) {
                    editBtn.setAttribute('data-module-titre', updatedModule.titre);
                    // Supprimer l'attribut ordre qui n'est plus utilisé
                    editBtn.removeAttribute('data-module-ordre');
                }

                // Mettre à jour les attributs data pour les boutons de suppression
                const deleteBtn = card.querySelector('.btn-delete');
                if (deleteBtn) {
                    deleteBtn.setAttribute('data-module-title', updatedModule.titre);
                }

                // Ajouter un effet visuel de mise à jour réussie
                card.style.transform = 'scale(1.02)';
                card.style.boxShadow = '0 0 20px rgba(40, 167, 69, 0.3)';
                card.style.transition = 'all 0.3s ease';

                // Remettre l'état normal après l'animation
                setTimeout(() => {
                    card.style.transform = '';
                    card.style.boxShadow = '';
                }, 600);
            });
        }

        // Fonction pour afficher les alertes (existante, mais améliorée)
        function showAlert(type, message) {
            const alertDiv = document.getElementById('ajaxAlert');
            const messageSpan = document.getElementById('ajaxMessage');

            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            messageSpan.textContent = message;
            alertDiv.style.display = 'block';

            // Scroll vers le haut pour voir l'alerte
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });

            // Auto-hide après 5 secondes
            setTimeout(() => {
                hideAlert();
            }, 5000);
        }

        // Fonction pour cacher les alertes
        function hideAlert() {
            const alertDiv = document.getElementById('ajaxAlert');
            alertDiv.classList.remove('show');
            setTimeout(() => {
                alertDiv.style.display = 'none';
            }, 150);
        }

        // Nettoyer lors de la fermeture de la modal d'édition
        editModuleModal.addEventListener('hidden.bs.modal', function() {
            // Reset du formulaire
            this.querySelector('#editModuleForm').reset();

            // Nettoyer les attributs
            const form = this.querySelector('#editModuleForm');
            form.removeAttribute('data-module-id');

            // S'assurer que le bouton est réactivé
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Enregistrer';
        });

        // === Code existant pour la suppression (inchangé) ===
        const deleteModuleModal = new bootstrap.Modal(document.getElementById('deleteModuleModal'));

        document.addEventListener('click', function(e) {
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

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (!moduleToDelete) return;

            const confirmBtn = this;
            const originalText = confirmBtn.innerHTML;

            confirmBtn.disabled = true;
            confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Suppression...';

            const moduleCards = document.querySelectorAll(`[data-module-id="${moduleToDelete.id}"]`);

            moduleCards.forEach(card => {
                card.classList.add('deleting');
            });

            fetch(`/dashboard/modules/${moduleToDelete.id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        deleteModuleModal.hide();

                        setTimeout(() => {
                            const backdrop = document.querySelector('.modal-backdrop');
                            if (backdrop) {
                                backdrop.remove();
                            }
                            document.body.classList.remove('modal-open');
                            document.body.style.overflow = '';
                            document.body.style.paddingRight = '';
                        }, 150);

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
                        moduleCards.forEach(card => {
                            card.classList.remove('deleting');
                        });
                        showAlert('danger', data.message || 'Erreur lors de la suppression du module.');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    moduleCards.forEach(card => {
                        card.classList.remove('deleting');
                    });
                    showAlert('danger', 'Une erreur est survenue lors de la suppression.');
                })
                .finally(() => {
                    confirmBtn.disabled = false;
                    confirmBtn.innerHTML = originalText;
                    moduleToDelete = null;
                });
        });

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

        document.addEventListener('DOMContentLoaded', function() {
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
        });

        document.getElementById('deleteModuleModal').addEventListener('hidden.bs.modal', function() {
            moduleToDelete = null;

            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove();
            }
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        });

        document.querySelector('#deleteModuleModal [data-bs-dismiss="modal"]').addEventListener('click', function() {
            setTimeout(() => {
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
            }, 150);
        });


        // Gestion de l'ouverture du modal
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-success[title="Ajouter une leçon"]')) {
                const btn = e.target.closest('.btn-success');
                const moduleCard = btn.closest('.module-card');
                const moduleId = moduleCard.dataset.moduleId;
                const moduleTitle = moduleCard.querySelector('.module-title').textContent;

                // Remplir les informations du module
                document.getElementById('lessonModuleId').value = moduleId;
                document.getElementById('moduleNamePreview').textContent = moduleTitle;

                // Réinitialiser le formulaire
                resetLessonForm();

                // Ouvrir le modal
                const addLessonModal = new bootstrap.Modal(document.getElementById('addLessonModal'));
                addLessonModal.show();
            }
        });

        // Gestion des uploads de fichiers
        document.getElementById('lessonVideo').addEventListener('change', function(e) {
            handleFileSelection(e, 'video');
        });

        document.getElementById('lessonPdf').addEventListener('change', function(e) {
            handleFileSelection(e, 'pdf');
        });

        function handleFileSelection(event, type) {
            const file = event.target.files[0];
            if (!file) return;

            // Vérification de la taille
            const maxSize = type === 'video' ? 100 * 1024 * 1024 : 10 * 1024 * 1024; // 100MB pour vidéo, 10MB pour PDF
            if (file.size > maxSize) {
                alert(`Le fichier est trop volumineux. Taille maximale: ${type === 'video' ? '100MB' : '10MB'}`);
                event.target.value = '';
                return;
            }

            // Afficher l'aperçu
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

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function resetLessonForm() {
            document.getElementById('addLessonForm').reset();

            // Réinitialiser les previews
            document.getElementById('videoPreview').style.display = 'none';
            document.getElementById('pdfPreview').style.display = 'none';
            document.querySelector('#videoUploadZone .upload-placeholder').style.display = 'flex';
            document.querySelector('#pdfUploadZone .upload-placeholder').style.display = 'flex';

            // Réinitialiser les progress bars
            document.getElementById('videoProgress').style.display = 'none';
            document.getElementById('pdfProgress').style.display = 'none';
        }

        document.getElementById('addLessonForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // VALIDATION PERSONNALISÉE AVANT SOUMISSION
            const videoFile = document.getElementById('lessonVideo').files[0];
            const titleValue = document.getElementById('lessonTitle').value.trim();

            // Vérifications personnalisées
            if (!titleValue) {
                showAlert('danger', 'Veuillez saisir un titre pour la leçon.');
                document.getElementById('lessonTitle').focus();
                return;
            }

            if (!videoFile) {
                showAlert('danger', 'Veuillez sélectionner une vidéo pour la leçon.');
                // Déclencher le clic sur la zone d'upload pour attirer l'attention
                document.querySelector('#videoUploadZone .upload-placeholder').click();
                return;
            }

            // Vérification de la taille des fichiers
            if (videoFile && videoFile.size > 100 * 1024 * 1024) {
                showAlert('danger', 'La vidéo ne doit pas dépasser 100MB.');
                return;
            }

            const pdfFile = document.getElementById('lessonPdf').files[0];
            if (pdfFile && pdfFile.size > 10 * 1024 * 1024) {
                showAlert('danger', 'Le fichier PDF ne doit pas dépasser 10MB.');
                return;
            }

            // Si on arrive ici, tout est validé, on peut procéder
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            const moduleId = document.getElementById('lessonModuleId').value;

            // Désactiver le bouton et afficher le loading
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Création en cours...';

            // Afficher les progress bars
            document.getElementById('videoProgress').style.display = 'block';
            if (pdfFile) {
                document.getElementById('pdfProgress').style.display = 'block';
            }

            // Simuler la progression
            simulateProgress('video');
            if (pdfFile) {
                simulateProgress('pdf');
            }

            // Envoyer la requête
            fetch(`/dashboard/modules/${moduleId}/lessons`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })


                .then(data => {
                    console.log('Response data:', data);
                    if (data.success) {
                        // 1. Fermer le modal d'abord
                        const modalElement = document.getElementById('addLessonModal');
                        const closeButton = modalElement.querySelector('[data-bs-dismiss="modal"]');
                        if (closeButton) {
                            closeButton.click();
                        }

                        // 2. Afficher le message de succès
                        showAlert('success', data.message || 'Leçon ajoutée avec succès !');

                        // 3. Attendre un peu que le modal se ferme, puis actualiser la page
                        setTimeout(() => {
                            // Option A : Actualiser toute la page
                            window.location.reload();

                            // Option B : Rediriger vers la même page (alternative)
                            // window.location.href = window.location.href;
                        }, 1000); // Attendre 1 seconde pour voir le message de succès

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

                    // Masquer les progress bars
                    document.getElementById('videoProgress').style.display = 'none';
                    document.getElementById('pdfProgress').style.display = 'none';
                });
        });


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

        // Nettoyage lors de la fermeture du modal
        document.getElementById('addLessonModal').addEventListener('hidden.bs.modal', function() {
            resetLessonForm();
        });

        function updateLessonCount(moduleId, count) {
            // Si vous voulez afficher le nombre de leçons sur les cartes modules
            const moduleCards = document.querySelectorAll(`[data-module-id="${moduleId}"]`);

            moduleCards.forEach(card => {
                let countBadge = card.querySelector('.lessons-count');
                const titleElement = card.querySelector('.module-title');

                // Vérifier que titleElement existe avant d'essayer d'y ajouter quelque chose
                if (!titleElement) {
                    console.warn('Élément .module-title non trouvé dans la carte module');
                    return;
                }

                if (!countBadge) {
                    // Créer le badge s'il n'existe pas
                    countBadge = document.createElement('span');
                    countBadge.className = 'badge bg-success lessons-count ms-2';
                    titleElement.appendChild(countBadge);
                }

                // Mettre à jour le texte du badge
                countBadge.textContent = `${count} leçon${count > 1 ? 's' : ''}`;
            });
        }
    </script>
@endsection
