@extends('admin.master')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-3">Ajouter une Catégorie</h4>

    <form action="{{ route('admin.categories.store') }}" method="POST" class="row g-3">
        @csrf
        <div class="col-md-6">
            <label class="form-label">Nom de la catégorie</label>
            <input type="text" name="nom" class="form-control" required>
        </div>

        <div class="col-12 text-end">
            <button type="submit" class="btn btn-success">Enregistrer</button>
        </div>
    </form>
</div>
@endsection
