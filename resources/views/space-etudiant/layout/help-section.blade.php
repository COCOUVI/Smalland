<div class="card border-success shadow-sm mb-4">
    <div class="card-header bg-success text-white">
        <h4 class="mb-0">Aide / Contactez le support</h4>
    </div>
    <div class="card-body">
        <form id="help-form" action="{{ route('help.send') }}" method="POST" novalidate>
            @csrf
            <div class="mb-3">
                <label for="message" class="form-label fw-bold">Votre message</label>
                <textarea class="form-control" id="message" name="message" rows="5"
                          placeholder="Écrivez votre message ici..." required></textarea>
                <div class="text-danger mt-1" id="message-error"></div>
            </div>
            <button type="button" class="btn btn-success" id="help-submit-btn">
                <span id="help-btn-text">Envoyer le message</span>
                <span id="help-spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            </button>
        </form>
    </div>
</div>

{{-- Toast Bootstrap --}}
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
    <div id="help-toast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body fw-bold">
                Message envoyé avec succès ✅
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fermer"></button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#help-submit-btn').on('click', function(e) {
            e.preventDefault();

            let form = $('#help-form');
            let url = form.attr('action');
            let data = form.serialize();
            let btn = $(this);
            let spinner = $('#help-spinner');
            let btnText = $('#help-btn-text');

            $('#message-error').text('');

            // Désactiver le bouton + spinner
            btn.prop('disabled', true);
            btnText.text('Envoi en cours...');
            spinner.removeClass('d-none');

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                success: function(response) {
                    // ✅ Afficher le toast
                    let toastEl = document.getElementById('help-toast');
                    let toast = new bootstrap.Toast(toastEl);
                    toast.show();

                    // Réinitialiser le formulaire
                    form[0].reset();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        $('#message-error').text(xhr.responseJSON.errors.message[0]);
                    }
                },
                complete: function() {
                    btn.prop('disabled', false);
                    btnText.text('Envoyer le message');
                    spinner.addClass('d-none');
                }
            });
        });
    });
</script>
