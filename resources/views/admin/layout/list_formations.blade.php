@extends('admin.master')

@section('content')
<div class="container mt-3 mt-md-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
        <h2 class="mb-2 mb-md-0">Liste des formations</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFormationModal">
            <i class="fas fa-plus d-none d-md-inline"></i> Ajouter
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            @if($formations->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 d-none d-md-table">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Titre</th>
                                <th class="text-center">Prix</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($formations as $formation)
                            <tr data-formation-id="{{ $formation->id }}">
                                <td class="text-center">{{ $formation->id }}</td>
                                <td class="text-center">{{ $formation->titre }}</td>
                                <td class="text-center">{{ number_format($formation->price, 2) }} FCFA</td>
                                <td class="text-center">{{ Str::limit($formation->description, 50) }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center flex-wrap gap-1">
                                        <a href="{{ route('details.formation', $formation->id) }}" class="btn btn-sm btn-info" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <!-- Bouton Ajouter module -->
                                        <button type="button" class="btn btn-sm btn-success addModuleBtn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#addModuleModal"
                                            data-formation-id="{{ $formation->id }}"
                                            data-formation-title="{{ $formation->titre }}"
                                            title="Ajouter module">
                                            <i class="fas fa-plus-circle"></i>
                                        </button>

                                        <!-- Bouton Modifier -->
                                        <button type="button" class="btn btn-sm btn-warning editFormationBtn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editFormationModal"
                                            data-formation-id="{{ $formation->id }}"
                                            data-formation-title="{{ $formation->titre }}"
                                            data-formation-description="{{ $formation->description }}"
                                            data-formation-price="{{ $formation->price }}"
                                            data-formation-image="{{ $formation->image_path ? asset('storage/' . $formation->image_path) : '' }}"
                                            title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Bouton Supprimer -->
                                        <button type="button" class="btn btn-sm btn-danger deleteFormationBtn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteFormationModal"
                                            data-formation-id="{{ $formation->id }}"
                                            data-formation-title="{{ $formation->titre }}"
                                            title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Version mobile (cartes) -->
                    <div class="d-md-none">
                        @foreach($formations as $formation)
                        <div class="card m-2 border-0 shadow-sm" data-formation-id="{{ $formation->id }}">
                            <div class="card-body">
                                <h5 class="card-title text-center">{{ $formation->titre }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted text-center">ID: {{ $formation->id }}</h6>
                                <p class="card-text text-center"><strong>Prix:</strong> {{ number_format($formation->price, 2) }} FCFA</p>
                                <p class="card-text text-center">{{ Str::limit($formation->description, 50) }}</p>

                                <div class="d-flex justify-content-center flex-wrap gap-1">
                                    <a href="{{ route('details.formation', $formation->id) }}" class="btn btn-sm btn-info" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <button type="button" class="btn btn-sm btn-success addModuleBtn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addModuleModal"
                                        data-formation-id="{{ $formation->id }}"
                                        data-formation-title="{{ $formation->titre }}"
                                        title="Ajouter module">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>

                                    <button type="button" class="btn btn-sm btn-warning editFormationBtn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editFormationModal"
                                        data-formation-id="{{ $formation->id }}"
                                        data-formation-title="{{ $formation->titre }}"
                                        data-formation-description="{{ $formation->description }}"
                                        data-formation-price="{{ $formation->price }}"
                                        data-formation-image="{{ $formation->image_path ? asset('storage/' . $formation->image_path) : '' }}"
                                        title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button type="button" class="btn btn-sm btn-danger deleteFormationBtn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteFormationModal"
                                        data-formation-id="{{ $formation->id }}"
                                        data-formation-title="{{ $formation->titre }}"
                                        title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="d-flex justify-content-center p-3">
                    {{ $formations->links('pagination::bootstrap-5') }}
                </div>
            @else
                <p class="text-center m-3">Aucune formation disponible.</p>
            @endif
        </div>
    </div>
</div>

<!-- Modal Ajouter Formation -->
<div class="modal fade" id="addFormationModal" tabindex="-1" aria-labelledby="addFormationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFormationModalLabel">Ajouter une formation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addFormationForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div id="addFormationAlert"></div>

                    <div class="mb-3">
                        <label for="addTitle" class="form-label">Titre</label>
                        <input type="text" class="form-control" id="addTitle" name="title" required>
                        <span class="text-danger" id="addTitleError"></span>
                    </div>

                    <div class="mb-3">
                        <label for="addDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="addDescription" name="description" rows="5" required></textarea>
                        <span class="text-danger" id="addDescriptionError"></span>
                    </div>

                    <div class="mb-3">
                        <label for="addPrice" class="form-label">Prix</label>
                        <input type="number" min="0" class="form-control" id="addPrice" name="price" required>
                        <span class="text-danger" id="addPriceError"></span>
                    </div>

                    <div class="mb-3">
                        <label for="addImage" class="form-label">Image</label>
                        <input type="file" class="form-control" id="addImage" name="image" accept="image/*">
                        <span class="text-danger" id="addImageError"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Créer la formation</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Modifier Formation -->
<div class="modal fade" id="editFormationModal" tabindex="-1" aria-labelledby="editFormationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFormationModalLabel">Modifier la formation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editFormationForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="editFormationId" name="formation_id">
                <div class="modal-body">
                    <div id="editFormationAlert"></div>

                    <div class="mb-3">
                        <label for="editTitre" class="form-label">Titre</label>
                        <input type="text" class="form-control" id="editTitre" name="titre" required>
                        <span class="text-danger" id="editTitreError"></span>
                    </div>

                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editDescription" name="description" rows="5" required></textarea>
                        <span class="text-danger" id="editDescriptionError"></span>
                    </div>

                    <div class="mb-3">
                        <label for="editPrice" class="form-label">Prix (FCFA)</label>
                        <input type="number" step="0.01" class="form-control" id="editPrice" name="price" required>
                        <span class="text-danger" id="editPriceError"></span>
                    </div>

                    <div class="mb-3">
                        <label for="editImage" class="form-label">Image (laisser vide si inchangée)</label>
                        <input type="file" class="form-control" id="editImage" name="image" accept="image/*">
                        <span class="text-danger" id="editImageError"></span>
                        <div id="currentImagePreview" class="mt-2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Supprimer Formation -->
<div class="modal fade" id="deleteFormationModal" tabindex="-1" aria-labelledby="deleteFormationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteFormationModalLabel">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer la formation <strong id="deleteFormationTitle"></strong> ?</p>
                <p class="text-danger"><small>Cette action est irréversible.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Supprimer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ajouter Module (existant) -->
<div class="modal fade" id="addModuleModal" tabindex="-1" aria-labelledby="addModuleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModuleModalLabel">Ajouter un module</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addModuleForm" action="" method="POST">
                @csrf
                <div class="modal-body">
                    <div id="ajaxAlert"></div>
                    <div class="mb-3">
                        <label for="moduleTitle" class="form-label">Titre du module</label>
                        <input type="text" class="form-control" id="moduleTitle" name="titre" required>
                        <span class="text-danger" id="titreError"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
<script>
$(document).ready(function() {

    // === AJOUTER FORMATION ===
    $('#addFormationForm').on('submit', function(e) {
        e.preventDefault();

        // Nettoyer les erreurs précédentes
        $('.text-danger').text('');
        $('#addFormationAlert').html('');

        const formData = new FormData(this);

        $.ajax({
            url: '{{ route("store_formation") }}',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#addFormationAlert').html('<div class="alert alert-success">Formation créée avec succès ✅</div>');
                $('#addFormationForm')[0].reset();
                setTimeout(() => {
                    $('#addFormationModal').modal('hide');
                    location.reload();
                }, 1500);
            },
            error: function(xhr) {
                if(xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        if(key === 'title') $('#addTitleError').text(value[0]);
                        if(key === 'description') $('#addDescriptionError').text(value[0]);
                        if(key === 'price') $('#addPriceError').text(value[0]);
                        if(key === 'image') $('#addImageError').text(value[0]);
                    });
                } else {
                    $('#addFormationAlert').html('<div class="alert alert-danger">Une erreur est survenue ❌</div>');
                }
            }
        });
    });

    // === MODIFIER FORMATION ===
    $('.editFormationBtn').on('click', function() {
        const formationId = $(this).data('formation-id');
        const titre = $(this).data('formation-title');
        const description = $(this).data('formation-description');
        const price = $(this).data('formation-price');
        const imagePath = $(this).data('formation-image');

        $('#editFormationId').val(formationId);
        $('#editTitre').val(titre);
        $('#editDescription').val(description);
        $('#editPrice').val(price);

        // Afficher l'image actuelle si elle existe
        if(imagePath) {
            $('#currentImagePreview').html(`
                <p>Image actuelle :</p>
                <img src="${imagePath}" alt="Image formation" class="img-thumbnail" style="max-width: 200px;">
            `);
        } else {
            $('#currentImagePreview').html('');
        }

        // Nettoyer les erreurs
        $('.text-danger').text('');
        $('#editFormationAlert').html('');
    });

    $('#editFormationForm').on('submit', function(e) {
        e.preventDefault();

        const formationId = $('#editFormationId').val();
        const formData = new FormData(this);

        // Nettoyer les erreurs précédentes
        $('.text-danger').text('');
        $('#editFormationAlert').html('');

        $.ajax({
            url: `/dashboard/modify_formation/${formationId}`,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#editFormationAlert').html('<div class="alert alert-success">Formation mise à jour avec succès ✅</div>');
                setTimeout(() => {
                    $('#editFormationModal').modal('hide');
                    location.reload();
                }, 1500);
            },
            error: function(xhr) {
                if(xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        if(key === 'titre') $('#editTitreError').text(value[0]);
                        if(key === 'description') $('#editDescriptionError').text(value[0]);
                        if(key === 'price') $('#editPriceError').text(value[0]);
                        if(key === 'image') $('#editImageError').text(value[0]);
                    });
                } else {
                    $('#editFormationAlert').html('<div class="alert alert-danger">Une erreur est survenue ❌</div>');
                }
            }
        });
    });

    // === SUPPRIMER FORMATION ===
    $('.deleteFormationBtn').on('click', function() {
        const formationId = $(this).data('formation-id');
        const titre = $(this).data('formation-title');

        $('#deleteFormationTitle').text(titre);
        $('#confirmDeleteBtn').data('formation-id', formationId);
    });

    $('#confirmDeleteBtn').on('click', function() {
        const formationId = $(this).data('formation-id');
        const $confirmBtn = $(this);

        // Désactiver le bouton pour éviter les clics multiples
        $confirmBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Suppression...');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: `{{ url('/dashboard/delete_formation') }}/${formationId}`,
            type: 'POST',
            data: {
                '_method': 'DELETE',
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Retirer le focus du bouton avant de fermer la modal
                $confirmBtn.blur();

                // Fermer la modal avec un petit délai
                setTimeout(() => {
                    $('#deleteFormationModal').modal('hide');
                }, 100);

                // Supprimer la ligne du tableau ou la carte avec animation
                $(`[data-formation-id="${formationId}"]`).addClass('fade-out').delay(300).fadeOut(500, function() {
                    $(this).remove();

                    // Vérifier s'il reste des formations
                    if($('[data-formation-id]').length === 0) {
                        location.reload();
                    }
                });

                // Afficher un message de succès
                $('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                  'Formation supprimée avec succès ✅' +
                  '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                  '</div>').prependTo('.container').delay(3000).fadeOut();
            },
            error: function(xhr) {
                // Retirer le focus et fermer la modal
                $confirmBtn.blur();
                setTimeout(() => {
                    $('#deleteFormationModal').modal('hide');
                }, 100);

                // Afficher l'erreur
                $('<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                  'Erreur lors de la suppression ❌' +
                  '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                  '</div>').prependTo('.container').delay(3000).fadeOut();
            },
            complete: function() {
                // Réactiver le bouton dans tous les cas
                $confirmBtn.prop('disabled', false).html('Supprimer');
            }
        });
    });

    // Réinitialiser le bouton quand la modal se ferme
    $('#deleteFormationModal').on('hidden.bs.modal', function() {
        $('#confirmDeleteBtn').prop('disabled', false).html('Supprimer').blur();
    });

    // === AJOUTER MODULE (existant) ===
    $('.addModuleBtn').on('click', function() {
        const formationId = $(this).data('formation-id');
        const formationTitle = $(this).data('formation-title');

        const form = $('#addModuleForm');
        form.attr('action', `/formations/${formationId}/modules`);

        $('#addModuleModalLabel').text("Ajouter un module à : " + formationTitle);
        $('#moduleTitle').val('');
        $('#titreError').text('');
        $('#ajaxAlert').html('');
    });

    $('#addModuleForm').on('submit', function(e){
        e.preventDefault();
        const form = $(this);
        const url = form.attr('action');
        const titre = $('#moduleTitle').val();
        const token = $('input[name=_token]').val();

        $('#titreError').text('');
        $('#ajaxAlert').html('');

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                titre: titre,
                _token: token
            },
            success: function(response){
                if(response.success){
                    $('#ajaxAlert').html('<div class="alert alert-success">'+response.success+'</div>');
                    $('#moduleTitle').val('');
                    setTimeout(() => {
                        $('#addModuleModal').modal('hide');
                        $('#ajaxAlert').html('');
                    }, 1500);
                }
            },
            error: function(xhr){
                if(xhr.status === 422){
                    const errors = xhr.responseJSON.errors;
                    if(errors.titre){
                        $('#titreError').text(errors.titre[0]);
                    }
                } else {
                    $('#ajaxAlert').html('<div class="alert alert-danger">Une erreur est survenue ❌</div>');
                }
            }
        });
    });
});
</script>

<style>
    /* Styles pour améliorer l'expérience mobile */
    @media (max-width: 768px) {
        .container {
            padding-left: 10px;
            padding-right: 10px;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        .card {
            margin-bottom: 10px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .gap-1 {
            gap: 0.25rem !important;
        }
    }

    /* Styles pour le tableau desktop */
    .table {
        border-collapse: separate;
        border-spacing: 0;
    }

    .table th {
        border-top: 1px solid #dee2e6;
        border-bottom: 2px solid #dee2e6;
        background-color: #f8f9fa;
        font-weight: 600;
        padding: 12px 8px;
    }

    .table td {
        padding: 12px 8px;
        border-bottom: 1px solid #e9ecef;
        vertical-align: middle;
    }

    .table tr:last-child td {
        border-bottom: none;
    }

    .table tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }

    /* Amélioration de l'accessibilité */
    .btn:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    /* Style pour les cartes mobiles */
    .card {
        transition: transform 0.2s;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    /* Styles pour les modales */
    .modal-header {
        border-bottom: 1px solid #dee2e6;
        background-color: #f8f9fa;
    }

    .modal-footer {
        border-top: 1px solid #dee2e6;
        background-color: #f8f9fa;
    }

    /* Animation pour la suppression */
    .fade-out {
        opacity: 0 !important;
        transform: scale(0.95);
        transition: all 0.3s ease-out;
    }

    /* Amélioration du bouton de suppression */
    #confirmDeleteBtn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Animation des alertes */
    .alert {
        animation: slideInDown 0.3s ease-out;
    }

    @keyframes slideInDown {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>
@endsection
