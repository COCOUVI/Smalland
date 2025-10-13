@extends('layouts.App')

@section('content')
<div class="max-w-2xl mx-auto py-10 px-6 bg-white shadow-md rounded-lg">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        Modifier votre avis pour <span class="text-very-green">"{{ $formation->titre }}"</span>
    </h1>

    {{-- Message d'erreur --}}
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
            {{ session('error') }}
        </div>
    @endif

    {{-- Formulaire de modification --}}
    <form action="{{ route('avis.update', $formation->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Note --}}
        <div>
            <label for="note" class="block text-sm font-medium text-gray-700 mb-1">
                Note (1 à 5 étoiles)
            </label>
            <select name="note" id="note" class="mt-1 block w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-md shadow-sm" required>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ $avis->note == $i ? 'selected' : '' }}>
                        {{ $i }} étoile{{ $i > 1 ? 's' : '' }}
                    </option>
                @endfor
            </select>
        </div>

        {{-- Contenu de l'avis --}}
        <div>
            <label for="content_avis" class="block text-sm font-medium text-gray-700 mb-1">
                Votre avis
            </label>
            <textarea name="content_avis" id="content_avis" rows="5" class="mt-1 block w-full border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 rounded-md shadow-sm" required>{{ old('content_avis', $avis->content_avis) }}</textarea>
        </div>

        {{-- Boutons --}}
        <div class="flex justify-end space-x-4">
            <a href="{{ route('formations.show', $formation->id) }}"
               class="inline-block px-5 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-100 transition">
                Annuler
            </a>
            <button type="submit"
                    class="inline-block px-5 py-2 bg-very-green text-white font-semibold rounded-md hover:bg-green-700 transition">
                Enregistrer
            </button>
        </div>
    </form>

</div>
  <br><br><br>
@endsection

