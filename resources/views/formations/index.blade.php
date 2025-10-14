@extends('layouts.Appindex')

@section('content')

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <h1 class="text-3xl font-bold text-gray-900 mb-8" style="color: #558B2F;">Mes Formations</h1>

            @if ($formations->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($formations as $formation)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                            <img src="{{ asset($formation->image_path) }}" alt="{{ $formation->titre }}"
                                class="w-full h-48 object-cover">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-xl font-semibold text-gray-900">{{ $formation->titre }}</h3>
                                    <span class="bg-very-green text-white px-2 py-1 rounded-full text-xs">
                                        {{ ucfirst($formation->niveau) }}
                                    </span>
                                </div>

                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $formation->description }}</p>

                                <!-- Progression -->
                                <div class="mb-4">
                                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                                        <span>Progression</span>
                                        <span>{{ $formation->calculated_progress }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-very-green h-2 rounded-full"
                                            style="width: {{ $formation->calculated_progress }}%"></div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex flex-wrap gap-2 justify-between items-center mt-4">
                                    <span class="text-very-green font-bold">{{ $formation->price }} €</span>

                                    <a href="{{ route('formations.show', $formation->id) }}"
                                        class="bg-very-green text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors"
                                        style="text-decoration: none;">
                                        Continuer
                                    </a>

                                    @php
                                        $userAvis = \App\Models\Avis::where('formation_id', $formation->id)
                                            ->where('user_id', auth()->id())
                                            ->first();
                                    @endphp

                                    @if ($userAvis)
                                        <!-- Modifier avis -->
                                        <a href="{{ route('avis.edit', $formation->id) }}"
                                            class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition-colors w-100"
                                            style="text-decoration: none;">
                                            Modifier mon avis
                                        </a>

                                        <!-- Supprimer avis -->
                                        <form action="{{ route('avis.destroy', $formation->id) }}" method="POST"
                                            onsubmit="return confirm('Voulez-vous vraiment supprimer votre avis ?');"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors w-100">
                                                Supprimer mon avis
                                            </button>
                                        </form>
                                    @elseif ($formation->calculated_progress == 100)
                                        <!-- Donner avis (uniquement si progression 100%) -->
                                        <button
                                            onclick="document.getElementById('addAvisModal-{{ $formation->id }}').classList.remove('hidden')"
                                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors w-100">
                                            Donner son avis
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Modal pour donner son avis -->
                        <div id="addAvisModal-{{ $formation->id }}"
                            class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                            <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 mx-auto mt-32 relative">
                                <h2 class="text-xl font-bold mb-4">Donner votre avis</h2>

                                <form action="{{ route('avis.store', $formation->id) }}" method="POST">
                                    @csrf

                                    <label for="note-{{ $formation->id }}" class="block font-semibold mb-1">Note (1 à 5)</label>
                                    <select name="note" id="note-{{ $formation->id }}"
                                        class="w-full border rounded p-2 mb-4" required>
                                        <option value="">-- Choisir une note --</option>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}">{{ $i }} étoile{{ $i > 1 ? 's' : '' }}</option>
                                        @endfor
                                    </select>

                                    <label for="content_avis-{{ $formation->id }}" class="block font-semibold mb-1">Votre avis</label>
                                    <textarea name="content_avis" id="content_avis-{{ $formation->id }}" rows="4"
                                        class="w-full border rounded p-2 mb-4" required></textarea>

                                    <div class="flex justify-between">
                                        <button type="button"
                                            onclick="document.getElementById('addAvisModal-{{ $formation->id }}').classList.add('hidden')"
                                            class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Annuler</button>

                                        <button type="submit"
                                            class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Envoyer</button>
                                    </div>
                                </form>

                                <!-- Bouton de fermeture -->
                                <button
                                    onclick="document.getElementById('addAvisModal-{{ $formation->id }}').classList.add('hidden')"
                                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">
                                    &times;
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <svg class="mx-auto h-24 w-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M12 14l9-5-9-5-9 5 9 5zm0 0l-9 5m9-5v6"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune formation</h3>
                    <p class="text-gray-500">Vous n'êtes inscrit à aucune formation pour le moment.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
