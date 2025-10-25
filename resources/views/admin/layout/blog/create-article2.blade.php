@extends('admin.master')

@section('content')
<div class="container mt-4">

    {{-- Message de succès --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Message d'erreur --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h2 class="mb-4">
        {{ isset($publication) ? 'Modifier la publication' : 'Créer une nouvelle publication' }}
    </h2>

    <form action="{{ isset($publication) ? route('publications.update', $publication->id) : route('publications.store') }}" 
          method="POST" enctype="multipart/form-data">

        @csrf
        @if(isset($publication))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" name="titre" id="titre" class="form-control" 
                   value="{{ old('titre', $publication->titre ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Contenu</label>
            <textarea name="content" id="content" rows="6" class="form-control" required>{{ old('content', $publication->content ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image (optionnelle)</label>
            <input type="file" name="image" id="image" class="form-control">
            @if(isset($publication) && $publication->image_path)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $publication->image_path) }}" alt="Image actuelle" width="150" class="rounded shadow">
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="pub_category_id" class="form-label">Catégorie</label>
            <select name="pub_category_id" id="pub_category_id" class="form-select" required>
                <option value="">-- Choisir une catégorie --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" 
                        {{ old('pub_category_id', $publication->pub_category_id ?? '') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="author" class="form-label">Auteur</label>
            <input type="text" name="author" id="author" class="form-control" 
                   value="{{ old('author', $publication->author ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="tags" class="form-label">Tags (séparés par des virgules)</label>
            <input type="text" name="tags" id="tags" class="form-control" 
                   value="{{ old('tags', $publication->tags ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Statut</label>
            <select name="status" id="status" class="form-select" required>
                <option value="Draft" {{ old('status', $publication->status ?? '') == 'Draft' ? 'selected' : '' }}>Brouillon</option>
                <option value="Publish" {{ old('status', $publication->status ?? '') == 'Publish' ? 'selected' : '' }}>Publié</option>
                <option value="Pending" {{ old('status', $publication->status ?? '') == 'Pending' ? 'selected' : '' }}>En attente</option>
            </select>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('publications.index') }}" class="btn btn-secondary">Annuler</a>
            <button type="submit" class="btn btn-success">
                {{ isset($publication) ? 'Mettre à jour' : 'Publier' }}
            </button>
        </div>

    </form>
</div>
@endsection
