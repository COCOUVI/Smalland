@extends('admin.master')

@section('content')
<style> 
/* Assurer que le modal passe toujours au-dessus */
.modal {
  z-index: 2000 !important;
}

.modal-backdrop {
  z-index: 1999 !important;
}

/* Pour éviter que le tableau ou le sidebar ne bloquent le modal */
.main-content, .card, .sidebar {
  z-index: 1;
}

</style>
<style>
input.form-control-sm {
    padding: 0.25rem;
    font-size: 0.9rem;
}
</style>


<main class="p-6 min-h-screen">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                  

                    <!-- Header avec bouton ajouter -->
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Gestion des Catégories</h4>
                        <div class="card-header-form">
                              </div>
                    </div>

                    <!-- Table -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Nom</th>
                                        <th>Description</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   

                                  @foreach($categorie as $category)
                                  <tr id="row-{{ $category->id }}">
                                      <!-- Formulaire de mise à jour -->
                                      <form action="{{ route('admin.updateCategory', $category->id) }}" method="POST" class="w-100">
                                          @csrf
                                          @method('PUT')

                                          <td class="text-center">{{ $category->id }}</td>

                                          <td>
                                              <span class="display-name">{{ $category->name }}</span>
                                              <input type="text" name="name" class="form-control form-control-sm edit-name d-none" value="{{ $category->name }}">
                                          </td>

                                          <td>
                                              <span class="display-description">{{ $category->description }}</span>
                                              <textarea name="description" rows="1" class="form-control form-control-sm edit-description d-none">{{ $category->description }}</textarea>
                                          </td>

                                          <td class="text-center">
                                              <!-- Bouton Modifier -->
                                              <button type="button" class="btn btn-primary btn-edit" data-id="{{ $category->id }}">
                                                  Modifier
                                              </button>

                                              <!-- Bouton Sauvegarder -->
                                              <button type="submit" class="btn btn-primary btn-save d-none">
                                                  💾 Sauvegarder
                                              </button>
                                      </form>
                                              <!-- Formulaire de suppression SEPARÉ, en dehors du form update -->
                                              <form action="{{ route('admin.deleteCategory', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette catégorie ?')">
                                                  @csrf
                                                  @method('DELETE')
                                                  <button type="submit" class="btn  btn-danger">Supprimer</button>
                                              </form>
                                          </td>
                                      
                                  </tr>
                                  @endforeach



                                </tbody>
                            </table>
                           <div class="mb-3 px-3">
                                <button class="btn btn-primary" id="toggleAddForm">+ Ajouter une Catégorie</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
   


<!-- Formulaire caché -->
<div id="addForm" style="display: none;" class="mb-4">
    <form action="{{ route('admin.storeCategory') }}" method="POST">
        @csrf
        <div class="card p-3">
            <div class="form-group">
                <label>Nom</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success">Ajouter</button>
            </div>
        </div>
    </form>
</div>

<script>
    document.getElementById('toggleAddForm').addEventListener('click', function () {
        const form = document.getElementById('addForm');
        form.style.display = (form.style.display === 'none') ? 'block' : 'none';
    });
</script>
<script>
    document.querySelectorAll('.btn-edit').forEach(function (button) {
        button.addEventListener('click', function () {
            const id = this.dataset.id;
            const row = document.getElementById('row-' + id);

            // Masquer les spans (textes)
            row.querySelector('.display-name').classList.add('d-none');
            row.querySelector('.display-description').classList.add('d-none');

            // Afficher les inputs
            row.querySelector('.edit-name').classList.remove('d-none');
            row.querySelector('.edit-description').classList.remove('d-none');

            // Afficher bouton Sauvegarder, cacher Modifier
            this.classList.add('d-none');
            row.querySelector('.btn-save').classList.remove('d-none');
        });
    });
</script>


</main>





@endsection
