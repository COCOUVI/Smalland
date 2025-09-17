<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

<script>
    $(document).ready(function () {
        // ✅ Configuration CSRF pour toutes les requêtes AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // === AJOUTER FORMATION ===
        $('#addFormationForm').on('submit', function (e) {
            e.preventDefault();
            $('.text-danger').text('');
            $('#addFormationAlert').html('');
            const formData = new FormData(this);

            $.ajax({
                url: '{{ route("store_formation") }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#addFormationAlert').html('<div class="alert alert-success">Formation créée avec succès ✅</div>');
                    $('#addFormationForm')[0].reset();
                    setTimeout(() => {
                        $('#addFormationModal').modal('hide');
                        location.reload();
                    }, 1500);
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            if (key === 'title') $('#addTitleError').text(value[0]);
                            if (key === 'description') $('#addDescriptionError').text(value[0]);
                            if (key === 'price') $('#addPriceError').text(value[0]);
                            if (key === 'image') $('#addImageError').text(value[0]);
                        });
                    } else {
                        $('#addFormationAlert').html('<div class="alert alert-danger">Une erreur est survenue ❌</div>');
                    }
                }
            });
        });

        // === MODIFIER FORMATION ===
        $('.editFormationBtn').on('click', function () {
            const formationId = $(this).data('formation-id');
            const titre = $(this).data('formation-title');
            const description = $(this).data('formation-description');
            const price = $(this).data('formation-price');
            const imagePath = $(this).data('formation-image');

            $('#editFormationId').val(formationId);
            $('#editTitre').val(titre);
            $('#editDescription').val(description);
            $('#editPrice').val(price);

            if (imagePath) {
                $('#currentImagePreview').html(`
                <p>Image actuelle :</p>
                <img src="${imagePath}" alt="Image formation" class="img-thumbnail" style="max-width: 200px;">
            `);
            } else {
                $('#currentImagePreview').html('');
            }

            $('.text-danger').text('');
            $('#editFormationAlert').html('');
        });

        $('#editFormationForm').on('submit', function (e) {
            e.preventDefault();
            const formationId = $('#editFormationId').val();
            const formData = new FormData(this);

            $('.text-danger').text('');
            $('#editFormationAlert').html('');

            $.ajax({
                url: `/dashboard/modify_formation/${formationId}`,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#editFormationAlert').html('<div class="alert alert-success">Formation mise à jour avec succès ✅</div>');
                    setTimeout(() => {
                        $('#editFormationModal').modal('hide');
                        location.reload();
                    }, 1500);
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            if (key === 'titre') $('#editTitreError').text(value[0]);
                            if (key === 'description') $('#editDescriptionError').text(value[0]);
                            if (key === 'price') $('#editPriceError').text(value[0]);
                            if (key === 'image') $('#editImageError').text(value[0]);
                        });
                    } else {
                        $('#editFormationAlert').html('<div class="alert alert-danger">Une erreur est survenue ❌</div>');
                    }
                }
            });
        });

        // === SUPPRIMER FORMATION ===
        $('.deleteFormationBtn').on('click', function () {
            const formationId = $(this).data('formation-id');
            const titre = $(this).data('formation-title');

            $('#deleteFormationTitle').text(titre);
            $('#confirmDeleteBtn').data('formation-id', formationId);
        });

        $('#confirmDeleteBtn').on('click', function () {
            const formationId = $(this).data('formation-id');
            const $confirmBtn = $(this);

            $confirmBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Suppression...');

            $.ajax({
                url: `/dashboard/delete_formation/${formationId}`,
                type: 'POST',
                data: {
                    '_method': 'DELETE'
                },
                success: function (response) {
                    $confirmBtn.blur();

                    setTimeout(() => {
                        $('#deleteFormationModal').modal('hide');
                    }, 100);

                    $(`[data-formation-id="${formationId}"]`).addClass('fade-out').delay(300).fadeOut(500, function () {
                        $(this).remove();
                        if ($('[data-formation-id]').length === 0) {
                            location.reload();
                        }
                    });

                    $('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                        'Formation supprimée avec succès ✅' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '</div>').prependTo('.container').delay(3000).fadeOut();
                },
                error: function (xhr) {
                    $confirmBtn.blur();
                    setTimeout(() => {
                        $('#deleteFormationModal').modal('hide');
                    }, 100);

                    $('<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                        'Erreur lors de la suppression ❌' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '</div>').prependTo('.container').delay(3000).fadeOut();
                },
                complete: function () {
                    $confirmBtn.prop('disabled', false).html('Supprimer');
                }
            });
        });

        $('#deleteFormationModal').on('hidden.bs.modal', function () {
            $('#confirmDeleteBtn').prop('disabled', false).html('Supprimer').blur();
        });

        // === GÉRER MODULES (AJOUT / ÉDITION / SUPPRESSION DIFFÉRÉE) ===
        $('.addModuleBtn').on('click', function () {
            const formationId = $(this).data('formation-id');
            const formationTitle = $(this).data('formation-title');

            const form = $('#addModuleForm');
            form.attr('action', `/dashboard/formations/${formationId}/modules`);
            $('#addModuleModalLabel').text("Gérer les modules de : " + formationTitle);
            $('#modulesContainer').html('');
            $('#ajaxAlert').html('');

            // Charger les modules existants
            $.get(`/dashboard/formations/${formationId}/modules`, function (modules) {
                if (modules.length > 0) {
                    modules.forEach(module => {
                        $('#modulesContainer').append(`
                            <div class="module-item" data-module-id="${module.id}">
                                <div class="module-input-group">
                                    <input type="text" name="modules_existing[${module.id}]" value="${module.titre}" class="module-input" required>
                                    <button type="button" class="remove-module-btn remove-existing-module" data-module-id="${module.id}" title="Supprimer">×</button>
                                </div>
                            </div>
                        `);
                    });
                }

                // Champ vide pour nouveaux modules
                $('#modulesContainer').append(`
                    <div class="module-item">
                        <div class="module-input-group">
                            <input type="text" name="modules_new[]" class="module-input" placeholder="Nouveau module">
                            <button type="button" class="remove-module-btn remove-module" title="Supprimer">×</button>
                        </div>
                    </div>
                `);
            });
        });

        // ➕ Ajouter un champ vide
        $('#addModuleField').on('click', function () {
            $('#modulesContainer').append(`
                <div class="module-item">
                    <div class="module-input-group">
                        <input type="text" name="modules_new[]" class="module-input" placeholder="Nouveau module">
                        <button type="button" class="remove-module-btn remove-module" title="Supprimer">×</button>
                    </div>
                </div>
            `);
        });

        // ❌ Supprimer un champ nouveau module (frontend uniquement)
        $(document).on('click', '.remove-module', function () {
            $(this).closest('.module-item').remove();
        });

        // ❌ Marquer un module existant pour suppression
        $(document).on('click', '.remove-existing-module', function () {
            const element = $(this).closest('.module-item');
            const input = element.find('input');

            // On modifie le nom de l'input pour signaler au backend qu'il faut le supprimer
            const name = input.attr('name'); // modules_existing[12]
            const moduleId = name.match(/\d+/)[0]; // extrait l'ID du module

            // On ajoute un input caché pour signaler la suppression
            $('#addModuleForm').append(`
                <input type="hidden" name="modules_to_delete[]" value="${moduleId}">
            `);

            // On supprime visuellement le champ
            element.remove();
        });

        // ✅ Soumission du formulaire
        $('#addModuleForm').on('submit', function (e) {
            e.preventDefault();

            const form = $(this);
            const url = form.attr('action');

            $('#ajaxAlert').html('');

            // Modules existants (non supprimés)
            const modulesExisting = {};
            $('#modulesContainer .module-item').not('.marked-for-deletion').each(function () {
                const input = $(this).find('input[name^="modules_existing"]');
                if (input.length > 0) {
                    const id = input.attr('name').match(/\[(\d+)\]/)[1];
                    modulesExisting[id] = input.val();
                }
            });

            // Modules nouveaux
            const modulesNew = [];
            $('input[name="modules_new[]"]').each(function () {
                const val = $(this).val();
                if (val.trim() !== '') {
                    modulesNew.push(val);
                }
            });

            // Collecte des modules à supprimer
            const modulesToDelete = [];
            $('input[name="modules_to_delete[]"]').each(function () {
                modulesToDelete.push($(this).val());
            });

            // Validation : au moins un module doit être rempli
            if (Object.values(modulesExisting).concat(modulesNew).length === 0) {
                $('#ajaxAlert').html('<div class="alert alert-danger">Veuillez remplir au moins un module.</div>');
                return;
            }

            // Vérifier qu'aucun champ n'est vide
            const allModules = Object.values(modulesExisting).concat(modulesNew);
            if (allModules.some(val => val.trim() === '')) {
                $('#ajaxAlert').html('<div class="alert alert-danger">Veuillez remplir tous les champs de modules.</div>');
                return;
            }

            // Requête AJAX
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    modules_existing: modulesExisting,
                    modules_new: modulesNew,
                    modules_to_delete: modulesToDelete,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('#ajaxAlert').html('<div class="alert alert-success">' + response.success + '</div>');
                    setTimeout(() => {
                        $('#addModuleModal').modal('hide');
                        location.reload();
                    }, 1500);
                },
                error: function () {
                    $('#ajaxAlert').html('<div class="alert alert-danger">Erreur lors de l\'enregistrement des modules ❌</div>');
                }
            });
        });

        // Avant que le modal commence à se cacher
        $('#addModuleModal').on('hide.bs.modal', function () {
            if (document.activeElement instanceof HTMLElement) {
                document.activeElement.blur();
            }
        });

        // Après qu'il soit complètement fermé, nettoyage
        $('#addModuleModal').on('hidden.bs.modal', function () {
            // Reset du formulaire
            $('#addModuleForm')[0].reset();

            // Supprimer les inputs cachés modules_to_delete s'ils existent
            $('#addModuleForm input[name="modules_to_delete[]"]').remove();
        });

        // Lorsqu'une modale se cache, enlever le focus sur l'élément actif
        $('#editFormationModal, #deleteFormationModal, #addFormationModal').on('hide.bs.modal', function () {
            if (document.activeElement instanceof HTMLElement) {
                document.activeElement.blur();
            }
        });

        // remettre le focus sur le bouton qui ouvre la modale après fermeture
        $('#editFormationModal').on('hidden.bs.modal', function () {
            $('#btnOpenEditFormationModal').focus();
        });

        $('#deleteFormationModal').on('hidden.bs.modal', function () {
            $('#btnOpenDeleteFormationModal').focus();
        });

        $('#addFormationModal').on('hidden.bs.modal', function () {
            $('#btnOpenAddFormationModal').focus();
        });

    });
</script>
