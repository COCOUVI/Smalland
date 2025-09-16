@extends('admin.master')

@section('content')
<div class="container mt-3 mt-md-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
        <h2 class="mb-2 mb-md-0">Liste des formations</h2>
        <a href="{{ route('add_formation_page') }}" class="btn btn-primary">
            <i class="fas fa-plus d-none d-md-inline"></i> Ajouter
        </a>
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
                            <tr>
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

                                        <a href="{{ route('put_page.formation', $formation->id) }}" class="btn btn-sm btn-warning" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('delete.formation', $formation->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette formation ?')"
                                                title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Version mobile (cartes) -->
                    <div class="d-md-none">
                        @foreach($formations as $formation)
                        <div class="card m-2 border-0 shadow-sm">
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

                                    <a href="{{ route('put_page.formation', $formation->id) }}" class="btn btn-sm btn-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('delete.formation', $formation->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette formation ?')"
                                            title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
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

<!-- Modal réutilisable -->
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
              <div id="ajaxAlert"></div> <!-- Pour afficher succès ou erreur -->
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
    // Remplir le formulaire avec la bonne formation avant d'ouvrir la modal
    document.querySelectorAll('.addModuleBtn').forEach(btn => {
        btn.addEventListener('click', function() {
            const formationId = this.dataset.formationId;
            const formationTitle = this.dataset.formationTitle;

            const form = document.getElementById('addModuleForm');
            form.action = '/formations/' + formationId + '/modules'; // adapte ta route si nécessaire

            document.getElementById('addModuleModalLabel').textContent = "Ajouter un module à : " + formationTitle;
            document.getElementById('moduleTitle').value = '';
            document.getElementById('titreError').textContent = '';
            document.getElementById('ajaxAlert').innerHTML = '';
        });
    });

    // AJAX pour soumission du formulaire
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
</style>
@endsection
