<div class="card border-success shadow-sm mb-4">
    <div class="card-header bg-success text-white">
        <h4 class="mb-0">Paramètres du compte</h4>
    </div>
    <div class="card-body">
        <form id="parametre-form" action="{{ route('parametres.update') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nom" class="form-label fw-bold">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="{{ $user->nom }}" required>
                    <div class="text-danger mt-1" id="nom-error"></div>
                </div>
                <div class="col-md-6">
                    <label for="prenom" class="form-label fw-bold">Prénom</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" value="{{ $user->prenom }}" required>
                    <div class="text-danger mt-1" id="prenom-error"></div>
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-bold">Adresse email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                <div class="text-danger mt-1" id="email-error"></div>
            </div>

            <button type="submit" class="btn btn-success" id="update-btn">
                <span id="update-btn-text">Mettre à jour</span>
                <span id="update-spinner" class="spinner-border spinner-border-sm d-none"></span>
            </button>
        </form>
    </div>
</div>

{{-- Toast de confirmation --}}
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
    <div id="update-toast" class="toast text-bg-success border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body fw-bold"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
    $('#parametre-form').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let btn = $('#update-btn');
        let spinner = $('#update-spinner');
        let btnText = $('#update-btn-text');

        $('.text-danger').text('');
        btn.prop('disabled', true);
        btnText.text('Mise à jour...');
        spinner.removeClass('d-none');

        $.post(form.attr('action'), form.serialize())
            .done(function(res) {
                const toastEl = document.getElementById('update-toast');
                toastEl.querySelector('.toast-body').innerText = res.success;
                new bootstrap.Toast(toastEl).show();
            })
            .fail(function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, val) {
                        $('#' + key + '-error').text(val[0]);
                    });
                }
            })
            .always(function() {
                btn.prop('disabled', false);
                btnText.text('Mettre à jour');
                spinner.addClass('d-none');
            });
    });
});
</script>
