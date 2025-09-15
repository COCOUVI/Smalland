@extends('admin.master')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-warning text-dark">
            <h4>Modifier la formation</h4>
        </div>
        <div class="card-body">

            {{-- Message de succès --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                </div>
            @endif
            
            <form action="{{ route('admin.formations.update', $formation->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Titre -->
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre</label>
                    <input type="text" name="titre" id="titre" 
                           class="form-control @error('titre') is-invalid @enderror" 
                           value="{{ old('titre', $formation->titre) }}" required>
                    @error('titre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" rows="5" 
                              class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $formation->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Prix -->
                <div class="mb-3">
                    <label for="price" class="form-label">Prix (FCFA)</label>
                    <input type="number" step="0.01" name="price" id="price" 
                           class="form-control @error('price') is-invalid @enderror" 
                           value="{{ old('price', $formation->price) }}" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Image -->
                <div class="mb-3">
                    <label for="image" class="form-label">Image (laisser vide si inchangée)</label>
                    <input type="file" name="image" id="image" 
                           class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    @if($formation->image_path)
                        <div class="mt-2">
                            <p>Image actuelle :</p>
                            <img src="{{ asset('storage/' . $formation->image_path) }}" 
                                 alt="Image formation" 
                                 class="img-thumbnail" style="max-width: 200px;">
                        </div>
                    @endif
                </div>

                <!-- Boutons -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    <a href="{{ route('lists_formation') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
