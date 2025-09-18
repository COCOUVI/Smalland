@extends('admin.master')

@section('content')
    <div class="container mt-3 mt-md-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
            <h2 class="mb-2 mb-md-0">Liste des modules</h2>
            <a href="{{ route('lists_formation') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-1"></i> Retour aux formations
            </a>
        </div>

        @if(session('success'))
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
                                            @if($module->updated_at != $module->created_at)
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
                        <div class="card card-module mb-3 shadow-sm border-0 module-card" data-module-id="{{ $module->id }}">
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
                                        @if($module->updated_at != $module->created_at)
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
        @if($modules->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $modules->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    <!-- Modal pour modifier un module -->
    <div class="modal fade" id="editModuleModal" tabindex="-1" aria-labelledby="editModuleModalLabel" aria-hidden="true">
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
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let moduleToDelete = null;

        // Gestion du modal d'édition
        const editModuleModal = document.getElementById('editModuleModal');
        if (editModuleModal) {
            editModuleModal.addEventListener('show.bs.modal', function (event) {
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
        document.getElementById('editModuleForm').addEventListener('submit', function (e) {
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
                        // Fermer la modal avec l'approche directe
                        const modalElement = document.getElementById('editModuleModal');
                        const bsModal = new bootstrap.Modal(modalElement);
                        bsModal.hide();

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
            window.scrollTo({ top: 0, behavior: 'smooth' });

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
        editModuleModal.addEventListener('hidden.bs.modal', function () {
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
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
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

        document.addEventListener('DOMContentLoaded', function () {
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

        document.getElementById('deleteModuleModal').addEventListener('hidden.bs.modal', function () {
            moduleToDelete = null;

            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove();
            }
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        });

        document.querySelector('#deleteModuleModal [data-bs-dismiss="modal"]').addEventListener('click', function () {
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
    </script>
@endsection
