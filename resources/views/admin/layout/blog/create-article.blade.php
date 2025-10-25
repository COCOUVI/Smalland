@extends('admin.master')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Main Content -->
    <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="">
            
            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-green-800">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            {{-- Error Message --}}
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h4 class="text-red-800 font-medium">Erreurs détectées:</h4>
                            <ul class="text-red-700 mt-1 text-sm list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Page Title --}}
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900">
                    {{ isset($publication) ? 'Modifier la publication' : 'Créer une nouvelle publication' }}
                </h2>
                <p class="text-gray-600 mt-2">Remplissez le formulaire ci-dessous pour créer ou modifier une publication</p>
            </div>

            {{-- Publication Form --}}
            <form action="{{ isset($publication) ? route('publications.update', $publication->id) : route('publications.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data" 
                  class="space-y-6">
                
                @csrf
                @if(isset($publication))
                    @method('PUT')
                @endif

                {{-- Titre Field --}}
                <div class="space-y-2">
                    <label for="titre" class="block text-sm font-medium text-gray-700">
                        Titre <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="titre" 
                        id="titre" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="Entrez le titre de la publication"
                        value="{{ old('titre', $publication->titre ?? '') }}"
                        required
                    >
                </div>

                {{-- Content Field --}}
                <div class="space-y-2">
                    <label for="content" class="block text-sm font-medium text-gray-700">
                        Contenu <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        name="content" 
                        id="content" 
                        rows="8"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-vertical"
                        placeholder="Rédigez le contenu de votre publication..."
                        required
                    >{{ old('content', $publication->content ?? '') }}</textarea>
                </div>

                {{-- Image Field --}}
                <div class="space-y-2">
                    <label for="image" class="block text-sm font-medium text-gray-700">
                        Image (optionnelle)
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 transition-colors">
                        <input 
                            type="file" 
                            name="image" 
                            id="image" 
                            class="hidden"
                            accept="image/*"
                            onchange="previewImage(event)"
                        >
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-10 h-10 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="text-gray-600 mb-2">Cliquez pour télécharger une image</p>
                            <button 
                                type="button" 
                                onclick="document.getElementById('image').click()" 
                                class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors"
                            >
                                <svg class="inline-block w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                                </svg>
                                Choisir un fichier
                            </button>
                        </div>
                    </div>
                    
                    {{-- Preview de la nouvelle image --}}
                    <div id="newImagePreview" class="hidden mt-4">
                        <p class="text-sm text-gray-600 mb-2">Aperçu de la nouvelle image:</p>
                        <img id="imagePreview" class="w-40 h-40 object-cover rounded-lg shadow-md">
                    </div>
                    
                    {{-- Image actuelle --}}
                    @if(isset($publication) && $publication->image_path)
                        <div class="mt-4">
                            <p class="text-sm text-gray-600 mb-2">Image actuelle:</p>
                            <img src="{{ asset('storage/' . $publication->image_path) }}" 
                                 alt="Image actuelle" 
                                 class="w-40 h-40 object-cover rounded-lg shadow-md">
                        </div>
                    @endif
                </div>

                {{-- Category Field --}}
                <div class="space-y-2">
                    <label for="pub_category_id" class="block text-sm font-medium text-gray-700">
                        Catégorie <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="pub_category_id" 
                        id="pub_category_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        required
                    >
                        <option value="">-- Choisir une catégorie --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" 
                                {{ old('pub_category_id', $publication->pub_category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Author Field --}}
                <div class="space-y-2">
                    <label for="author" class="block text-sm font-medium text-gray-700">
                        Auteur <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="author" 
                        id="author" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="Nom de l'auteur"
                        value="{{ old('author', $publication->author ?? '') }}"
                        required
                    >
                </div>

                {{-- Tags Field --}}
                <div class="space-y-2">
                    <label for="tags" class="block text-sm font-medium text-gray-700">
                        Tags (séparés par des virgules)
                    </label>
                    <input 
                        type="text" 
                        name="tags" 
                        id="tags" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="Exemple: technologie, design, développement"
                        value="{{ old('tags', $publication->tags ?? '') }}"
                    >
                </div>

                {{-- Status Field --}}
                <div class="space-y-2">
                    <label for="status" class="block text-sm font-medium text-gray-700">
                        Statut <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="status" 
                        id="status"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        required
                    >
                        <option value="Draft" {{ old('status', $publication->status ?? '') == 'Draft' ? 'selected' : '' }}>
                            Brouillon
                        </option>
                        <option value="Publish" {{ old('status', $publication->status ?? '') == 'Publish' ? 'selected' : '' }}>
                            Publié
                        </option>
                        <option value="Pending" {{ old('status', $publication->status ?? '') == 'Pending' ? 'selected' : '' }}>
                            En attente
                        </option>
                    </select>
                </div>

                {{-- Form Actions --}}
                <div class="flex flex-col sm:flex-row justify-between items-center gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('publications.index') }}" 
                       class="w-full sm:w-auto px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-center">
                        <svg class="inline-block w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                        </svg>
                        Retour aux publications
                    </a>
                    <button 
                        type="submit" 
                        class="w-full sm:w-auto px-8 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors font-medium"
                    >
                        <svg class="inline-block w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                        </svg>
                        {{ isset($publication) ? 'Mettre à jour' : 'Publier' }}
                    </button>
                </div>

            </form>

        </div>
    </main>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').src = e.target.result;
            document.getElementById('newImagePreview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}
</script>

<style>
.resize-vertical {
    resize: vertical;
}
</style>
@endsection