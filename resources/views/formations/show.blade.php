@extends('layouts.App')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <!-- En-tête de la formation -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Image -->
                    <div class="w-full md:w-64 h-48">
                        <img src="/storage/{{($formation->image_path) }}" alt="{{ $formation->titre }}"
                            class="w-full h-full object-cover rounded-lg">
                    </div>

                    <!-- Colonne droite (Informations et description) -->
                    <div class="flex-1">
                        <div class="flex justify-between items-start mb-4">
                            <h1 class="text-3xl font-bold text-gray-900">{{ $formation->titre }}</h1>
                            <span class="bg-very-green text-white px-3 py-1 rounded-full text-sm">
                                {{ ucfirst($formation->niveau) }}
                            </span>
                        </div>

                        <p class="text-gray-600 mb-4">{{ $formation->description }}</p>

                        <div class="mb-4">
                            <div class="flex justify-between text-sm text-gray-600 mb-1">
                                <span>{{ $globalProgress }}%</span>
                             

                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-very-green h-3 rounded-full"
                                    style="width: {{ $globalProgress }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Objectifs -->
            @if ($formation->objectifs->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">Objectifs de la formation</h2>
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        @foreach ($formation->objectifs as $objectif)
                            <li class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 text-very-green mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ $objectif->content }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Modules -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Plan de formation</h2>

                <div class="space-y-4">
                    @foreach ($modulesWithProgress as $moduleData)
                        <div class="border border-gray-200 rounded-lg hover:border-very-green transition-colors">
                            <div class="p-4">
                                <div class="flex justify-between items-center mb-3">
                                    <h3 class="text-xl font-semibold text-gray-900">
                                        Module {{ $moduleData['module']->ordre }}: {{ $moduleData['module']->titre }}
                                    </h3>
                                    <span class="text-sm text-gray-600">
                                        {{ $moduleData['completed_lessons'] }}/{{ $moduleData['total_lessons'] }} leçons
                                    </span>
                                </div>

                                <div class="mb-3">
                                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                                        <span>Progression du module</span>
                                        <span>{{ round($moduleData['progress']) }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-very-green h-2 rounded-full"
                                            style="width: {{ $moduleData['progress'] }}%"></div>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center">
                                    <div class="flex space-x-2">
                                        @if ($moduleData['module']->quizz)
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">
                                                Quiz disponible
                                            </span>
                                        @endif
                                    </div>
                                    <a href="{{ route('modules.show', ['formation' => $formation->id, 'module' => $moduleData['module']->id]) }}"
                                        class="bg-very-green text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors text-sm">
                                        Accéder au module
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


@endsection
