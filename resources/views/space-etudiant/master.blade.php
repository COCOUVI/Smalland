@extends('Master')

@section('content')
    @include('space-etudiant.partials.header')

    <div class="container">
        {{-- Messages flash --}}
        <div id="flash-messages">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('info'))
                <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>

        <div class="row">
            @include('space-etudiant.partials.sidebar')

            <!-- Contenu principal avec spinner -->
            <div class="col-lg-9">
                <!-- Spinner de chargement -->
                <div id="loading-spinner" style="display: none;">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                            <span class="visually-hidden">Chargement...</span>
                        </div>
                        <p class="mt-3 text-muted">Chargement en cours...</p>
                    </div>
                </div>

                <!-- Zone de contenu dynamique -->
                <div id="main-content">
                     @yield('main-content')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
    // Gestion des clics sur la sidebar
    $('.sidebar .nav-link').on('click', function(e) {
        e.preventDefault();

        // Retirer la classe active de tous les liens
        $('.sidebar .nav-link').removeClass('active');
        $(this).addClass('active');

        const url = $(this).data('url');
        if (url) {
            loadSection(url, true);
        }
    });

    // Fonction pour charger une section
    function loadSection(url, pushState = false) {
        // Afficher le spinner et masquer le contenu
        $('#main-content').fadeOut(200, function() {
            $('#loading-spinner').fadeIn(200);
        });

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'html',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                $('#loading-spinner').fadeOut(200, function() {
                    $('#main-content').html(response).fadeIn(200);

                    // Scroll vers le haut
                    $('html, body').animate({
                        scrollTop: $('#main-content').offset().top - 100
                    }, 300);

                    // Ajouter dans l'historique si nécessaire
                    if (pushState) {
                        history.pushState({ url: url }, '', url);
                    }
                });
            },
            error: function(xhr, status, error) {
                $('#loading-spinner').fadeOut(200, function() {
                    $('#main-content').html(`
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            Une erreur s'est produite lors du chargement. Veuillez réessayer.
                        </div>
                    `).fadeIn(200);
                });
                console.error('Erreur AJAX:', error);
            }
        });
    }

    // Gestion du bouton retour du navigateur
    window.addEventListener('popstate', function(e) {
        if (e.state && e.state.url) {
            loadSection(e.state.url, false);
        }
    });
});

</script>
@endpush
