@extends('admin.master')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Liste des formations</h2>
        <a href="{{ route('add_formation_page') }}" class="btn btn-primary">Ajouter une formation</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Liste des formations</h5>
            <input type="hidden" id="formationId" name="formation_id">
        </div>
        <div class="card-body p-0">
            @if($formations->count())
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Titre</th>
                                <th>Prix</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($formations as $formation)
                            <tr>
                                <td>{{ $formation->id }}</td>
                                <td>{{ $formation->titre }}</td>
                                <td>{{ number_format($formation->price, 2) }} FCFA</td>
                                <td>{{ Str::limit($formation->description, 50) }}</td>
                                <td>
                                    <a href="{{ route('details.formation', $formation->id) }}" class="btn btn-sm btn-info mb-1">Voir</a>

                                    <!-- Bouton Ajouter module -->
                                    <button type="button" class="btn btn-sm btn-success mb-1 addModuleBtn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addModuleModal"
                                        data-formation-id="{{ $formation->id }}"
                                        data-formation-title="{{ $formation->titre }}">
                                        Ajouter module
                                    </button>

                                    <a href="{{ route('put_page.formation', $formation->id) }}" class="btn btn-sm btn-warning mb-1">Modifier</a>

                                    <form action="{{ route('delete.formation', $formation->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger mb-1"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette formation ?')">
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
@endsection
