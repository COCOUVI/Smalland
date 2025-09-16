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

    // === AJOUTER MODULE ===
    $('.addModuleBtn').on('click', function() {
        const formationId = $(this).data('formation-id');
        const formationTitle = $(this).data('formation-title');

        const form = $('#addModuleForm');
        form.attr('action', `/dashboard/formations/${formationId}/modules`);

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
