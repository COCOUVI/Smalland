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
                            <!-- Bouton pour ouvrir le modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCategoryModal">
                                + Ajouter Catégorie
                            </button>
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
                                    @forelse($categorie as $category)
                                        <tr>
                                            <td class="text-center">{{ $category->id }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->description }}</td>
                                            <td class="text-center">
                                                <!-- Bouton Modifier -->
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" 
                                                    data-target="#editCategoryModal-{{ $category->id }}">
                                                    Modifier
                                                </button>

                                                <!-- Bouton Supprimer -->
                                                <form action="{{ route('admin.deleteCategory', $category->id) }}" 
                                                    method="POST" class="d-inline" 
                                                    onsubmit="return confirm('Supprimer cette catégorie ?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Aucune catégorie enregistrée.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('admin.storeCategory') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="addCategoryLabel">Ajouter une Catégorie</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nom</label>
            <input type="text" name="name" class="form-control" required>
            @error('name') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
          </div>
          <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="3" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="submit" class="btn btn-primary">Ajouter</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Modifier Catégorie -->
@foreach($categorie as $category)
<div class="modal fade" id="editCategoryModal-{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="editCategoryLabel-{{ $category->id }}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('admin.updateCategory', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title" id="editCategoryLabel-{{ $category->id }}">Modifier Catégorie</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nom</label>
            <input type="text" name="name" value="{{ $category->name }}" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="3" class="form-control">{{ $category->description }}</textarea>
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="submit" class="btn btn-warning text-white">Sauvegarder</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach
</main>



<!-- Modal -->
<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nouvelle Catégorie</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" class="form-control" id="nom" placeholder="Ex: Tech">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" rows="3" placeholder="Description..."></textarea>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-primary">Sauvegarder</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
            </div>
            
        </div>
    </div>
</div>
       

 @forelse($categorie as $category)
                                    <tr>
                                        <form action="{{ route('admin.updateCategory', $category->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <td class="text-center">{{ $category->id }}</td>
                                            <td>
                                                <input type="text" name="name" class="form-control form-control-sm" value="{{ $category->name }}" required>
                                            </td>
                                            <td>
                                                <input type="text" name="description" class="form-control form-control-sm" value="{{ $category->description }}">
                                            </td>
                                            
                                            <td class="text-center">
                                                <button type="submit" class="btn btn-primary">Modifier</button>
                                                
                                                <!-- Supprimer -->
                                                <form action="{{ route('admin.deleteCategory', $category->id) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('Supprimer cette catégorie ?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                                </form>
                                            </td>
                                        </form>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Aucune catégorie enregistrée.</td>
                                    </tr>
                                    @endforelse

@endsection
