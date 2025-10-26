@extends('admin.master')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Liste des Catégories</h4>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Ajouter catégorie
        </a>
    </div>

   {{-- Message de succès --}}
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

{{-- Affichage des erreurs --}}
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>- {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-striped align-middle" id="categories-table">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $categorie)
                <tr data-id="{{ $categorie->id }}">
                    <td>{{ $categorie->id }}</td>
                    <td contenteditable="true" class="editable" data-field="nom">{{ $categorie->nom }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.categories.destroy', $categorie->id) }}" onsubmit="return confirm('Confirmer la suppression ?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- jQuery pour AJAX inline edit --}}
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('.editable').blur(function () {
        var td = $(this);
        var value = td.text();
        var id = td.closest('tr').data('id');
        var field = td.data('field');

        $.ajax({
            url: '/admin/categories/' + id,
            method: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                [field]: value
            },
            success: function (response) {
                console.log('Mise à jour réussie');
            },
            error: function () {
                alert('Erreur lors de la mise à jour.');
            }
        });
    });
});
</script>
@endsection

@endsection
