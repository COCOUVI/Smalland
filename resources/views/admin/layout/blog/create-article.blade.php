@extends('admin.master')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">
    <!-- Main Content -->
    <main class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="">
            
            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg shadow-sm animate-fade-in">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-green-800 font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            {{-- Error Message --}}
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg shadow-sm">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-red-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h4 class="text-red-800 font-semibold">Erreurs détectées:</h4>
                            <ul class="text-red-700 mt-2 text-sm space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="flex items-start">
                                        <span class="mr-2">•</span>
                                        <span>{{ $error }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Page Title --}}
            <div class="mb-8 text-center">
                <h2 class="text-4xl font-bold text-gray-900 mb-2">
                    {{ isset($publication) ? '✏️ Modifier la publication' : 'Créer une nouvelle publication' }}
                </h2>
                <p class="text-gray-600 text-lg">Remplissez le formulaire ci-dessous pour {{ isset($publication) ? 'modifier' : 'créer' }} votre publication</p>
            </div>

            {{-- Publication Form --}}
            <form action="{{ isset($publication) ? route('publications.update', $publication->id) : route('publications.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data" 
                  class="bg-white rounded-2xl shadow-xl p-8 space-y-6">
                
                @csrf
                @if(isset($publication))
                    @method('PUT')
                @endif

                {{-- Titre Field --}}
                <div class="space-y-2">
                    <label for="titre" class="block text-sm font-semibold text-gray-700">
                        Titre <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="titre" 
                        id="titre" 
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-lg"
                        placeholder="Un titre accrocheur pour votre publication..."
                        value="{{ old('titre', $publication->titre ?? '') }}"
                        required
                    >
                </div>

                {{-- Content Field avec Éditeur Riche --}}
                <div class="space-y-2">
                    <label for="content" class="block text-sm font-semibold text-gray-700">
                        Contenu <span class="text-red-500">*</span>
                    </label>
                    
                    {{-- Barre d'outils de l'éditeur --}}
                    <div class="border-2 border-gray-200 rounded-t-xl bg-gray-50 p-3 flex flex-wrap gap-2">
                        <button type="button" onclick="formatText('bold')" class="editor-btn" title="Gras">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 3h6.5a4.5 4.5 0 011.9 8.6A4.5 4.5 0 0111.5 20H4V3zm6 7.5a2 2 0 100-4H6.5v4H10zm1.5 7a2 2 0 100-4H6.5v4h5z"/>
                            </svg>
                        </button>
                        
                        <button type="button" onclick="formatText('italic')" class="editor-btn" title="Italique">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 3l-1 2h2l-4 10H5l-1 2h6l1-2H9l4-10h2l1-2z"/>
                            </svg>
                        </button>
                        
                        <button type="button" onclick="formatText('underline')" class="editor-btn" title="Souligné">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 17a5 5 0 01-5-5V3h2v9a3 3 0 006 0V3h2v9a5 5 0 01-5 5zm-7 1h14v2H3v-2z"/>
                            </svg>
                        </button>

                        <div class="border-l-2 border-gray-300 mx-1"></div>

                        <button type="button" onclick="formatText('insertUnorderedList')" class="editor-btn" title="Liste à puces">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 5a2 2 0 100-4 2 2 0 000 4zm0 7a2 2 0 100-4 2 2 0 000 4zm0 7a2 2 0 100-4 2 2 0 000 4zM7 4h10v2H7V4zm0 6h10v2H7v-2zm0 6h10v2H7v-2z"/>
                            </svg>
                        </button>

                        <button type="button" onclick="formatText('insertOrderedList')" class="editor-btn" title="Liste numérotée">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3h2v2H2V3zm0 4h2v2H2V7zm0 4h2v2H2v-2zm0 4h2v2H2v-2zm5-12h11v2H7V3zm0 4h11v2H7V7zm0 4h11v2H7v-2zm0 4h11v2H7v-2z"/>
                            </svg>
                        </button>

                        <div class="border-l-2 border-gray-300 mx-1"></div>

                        <button type="button" onclick="formatText('justifyLeft')" class="editor-btn" title="Aligner à gauche">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 3h14v2H3V3zm0 4h10v2H3V7zm0 4h14v2H3v-2zm0 4h10v2H3v-2z"/>
                            </svg>
                        </button>

                        <button type="button" onclick="formatText('justifyCenter')" class="editor-btn" title="Centrer">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 3h14v2H3V3zm2 4h10v2H5V7zm-2 4h14v2H3v-2zm2 4h10v2H5v-2z"/>
                            </svg>
                        </button>

                        <button type="button" onclick="formatText('justifyRight')" class="editor-btn" title="Aligner à droite">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 3h14v2H3V3zm4 4h10v2H7V7zm-4 4h14v2H3v-2zm4 4h10v2H7v-2z"/>
                            </svg>
                        </button>

                        <div class="border-l-2 border-gray-300 mx-1"></div>

                        <button type="button" onclick="insertHeading()" class="editor-btn" title="Titre">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 3h2v6h6V3h2v14h-2v-6H5v6H3V3z"/>
                            </svg>
                        </button>

                        <button type="button" onclick="insertLink()" class="editor-btn" title="Insérer un lien">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z"/>
                            </svg>
                        </button>

                        <button type="button" onclick="clearFormatting()" class="editor-btn" title="Effacer le formatage">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Zone d'édition --}}
                    <div 
                        id="editor" 
                        contenteditable="true"
                        class="w-full min-h-[300px] px-4 py-3 border-2 border-t-0 border-gray-200 rounded-b-xl focus:outline-none focus:ring-2 focus:ring-blue-500 overflow-auto prose max-w-none"
                        style="max-height: 500px;"
                    >{{ old('content', $publication->content ?? '') }}</div>

                    {{-- Champ caché pour soumettre le contenu --}}
                    <textarea 
                        name="content" 
                        id="content" 
                        class="hidden"
                        required
                    >{{ old('content', $publication->content ?? '') }}</textarea>

                    <p class="text-sm text-gray-500 mt-2">Utilisez la barre d'outils pour formater votre texte</p>
                </div>

                {{-- Image Field --}}
                <div class="space-y-2">
                    <label for="image" class="block text-sm font-semibold text-gray-700">
                        Image (optionnelle)
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-blue-400 hover:bg-blue-50 transition-all cursor-pointer">
                        <input 
                            type="file" 
                            name="image" 
                            id="image" 
                            class="hidden"
                            accept="image/*"
                            onchange="previewImage(event)"
                        >
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="text-gray-600 font-medium mb-2">Glissez votre image ici ou cliquez pour parcourir</p>
                            <p class="text-sm text-gray-500 mb-3">PNG, JPG, GIF jusqu'à 10MB</p>
                            <button 
                                type="button" 
                                onclick="document.getElementById('image').click()" 
                                class="px-6 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all shadow-md hover:shadow-lg"
                            >
                                Choisir un fichier
                            </button>
                        </div>
                    </div>
                    
                    {{-- Preview de la nouvelle image --}}
                    <div id="newImagePreview" class="hidden mt-4">
                        <p class="text-sm text-gray-600 font-medium mb-2">Aperçu de la nouvelle image:</p>
                        <div class="relative inline-block">
                            <img id="imagePreview" class="w-48 h-48 object-cover rounded-xl shadow-lg border-2 border-blue-200">
                            <button type="button" onclick="removeImagePreview()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-2 hover:bg-red-600 shadow-lg">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    {{-- Image actuelle --}}
                    @if(isset($publication) && $publication->image_path)
                        <div class="mt-4">
                            <p class="text-sm text-gray-600 font-medium mb-2">Image actuelle:</p>
                            <img src="{{ asset('storage/' . $publication->image_path) }}" 
                                 alt="Image actuelle" 
                                 class="w-48 h-48 object-cover rounded-xl shadow-lg border-2 border-gray-200">
                        </div>
                    @endif
                </div>

                {{-- Category Field --}}
                <div class="space-y-2">
                    <label for="pub_category_id" class="block text-sm font-semibold text-gray-700">
                        Catégorie <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="pub_category_id" 
                        id="pub_category_id"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all font-semibold text-gray-700"
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
                    <label for="author" class="block text-sm font-semibold text-gray-700">
                        Auteur <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="author" 
                        id="author" 
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                        placeholder="Nom de l'auteur"
                        value="{{ old('author', $publication->author ?? '') }}"
                        required
                    >
                </div>

                {{-- Tags Field --}}
                <div class="space-y-2">
                    <label for="tags" class="block text-sm font-semibold text-gray-700">
                        Tags (séparés par des virgules)
                    </label>
                    <input 
                        type="text" 
                        name="tags" 
                        id="tags" 
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all font-semibold text-gray-700"
                        placeholder="technologie, design, développement"
                        value="{{ old('tags', $publication->tags ?? '') }}"
                    >
                </div>

                {{-- Status Field --}}
                <div class="space-y-2">
                    <label for="status" class="block text-sm font-semibold text-gray-700">
                         Statut <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="status" 
                        id="status"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all font-semibold text-gray-700"
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
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-6 border-t-2 border-gray-200">
                    <a href="{{ route('publications.index') }}" 
                       class="w-full sm:w-auto px-8 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-100 transition-all text-center font-medium flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                        </svg>
                        Retour
                    </a>
                    <button 
                        type="submit" 
                        class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl hover:from-green-600 hover:to-green-700 transition-all font-semibold shadow-lg hover:shadow-xl flex items-center justify-center"
                    >
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
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
// Synchroniser le contenu de l'éditeur avec le textarea caché
document.getElementById('editor').addEventListener('input', function() {
    document.getElementById('content').value = this.innerHTML;
});

// Avant la soumission du formulaire
document.querySelector('form').addEventListener('submit', function() {
    document.getElementById('content').value = document.getElementById('editor').innerHTML;
});

// Fonctions de formatage
function formatText(command) {
    document.execCommand(command, false, null);
    document.getElementById('editor').focus();
}

function insertHeading() {
    const level = prompt('Niveau du titre (1-6):', '2');
    if (level && level >= 1 && level <= 6) {
        document.execCommand('formatBlock', false, 'h' + level);
    }
    document.getElementById('editor').focus();
}

function insertLink() {
    const url = prompt('URL du lien:', 'https://');
    if (url) {
        document.execCommand('createLink', false, url);
    }
    document.getElementById('editor').focus();
}

function clearFormatting() {
    document.execCommand('removeFormat', false, null);
    document.getElementById('editor').focus();
}

// Preview de l'image
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

function removeImagePreview() {
    document.getElementById('image').value = '';
    document.getElementById('newImagePreview').classList.add('hidden');
}
</script>

<style>
.editor-btn {
    padding: 0.5rem;
    border-radius: 0.5rem;
    background-color: rgb(147, 144, 144);
    border: 1px solid #e5e7eb;
    transition: all 0.2s;
}

.editor-btn:hover {
    background-color: #cacbcd;
    border-color: #3b82f6;
    color: #3b82f6;
}

.editor-btn:active {
    transform: scale(0.95);
}

#editor {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    line-height: 1.6;
}

#editor h1 { font-size: 2em; font-weight: bold; margin: 0.5em 0; }
#editor h2 { font-size: 1.5em; font-weight: bold; margin: 0.5em 0; }
#editor h3 { font-size: 1.25em; font-weight: bold; margin: 0.5em 0; }
#editor ul, #editor ol { margin: 1em 0; padding-left: 2em; }
#editor a { color: #3b82f6; text-decoration: underline; }

@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}

/* Style pour la prose (texte formaté) */
.prose {
    color: #374151;
}

.prose p {
    margin-bottom: 1em;
}

.prose strong {
    font-weight: 600;
}

.prose em {
    font-style: italic;
}
</style>
@endsection