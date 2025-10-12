@extends('layouts.App')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <!-- En-tête du module -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $module->titre }}</h1>
                        <p class="text-gray-600 mt-2">Formation: {{ $module->formation->titre }}</p>
                    </div>
                    <span class="bg-very-green text-white px-3 py-1 rounded-full text-sm">
                        Module {{ $module->ordre }}
                    </span>
                </div>
            </div>

            <!-- Leçons -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Leçons du module</h2>

                <div class="space-y-3">
                    @foreach ($module->lessons as $lesson)
                        <div id="lesson-{{ $lesson->id }}"
                            class="border border-gray-200 rounded-lg p-4 hover:border-very-green transition-colors {{ $userProgress[$lesson->id] ? 'bg-green-50 border-green-200' : '' }}">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-4">
                                    @if ($userProgress[$lesson->id])
                                        <div id="check-{{ $lesson->id }}" class="text-very-green">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-6 h-6 border-2 border-gray-300 rounded-full"></div>
                                    @endif

                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ $lesson->titre }}</h3>
                                        <div class="flex items-center space-x-4 text-sm text-gray-600 mt-1">
                                            @if ($lesson->video_url)
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                    Vidéo
                                                </span>
                                            @endif
                                            @if ($lesson->pdf_url)
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                        </path>
                                                    </svg>
                                                    PDF
                                                </span>
                                            @endif
                                            <span>{{ $lesson->duree }} min</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex space-x-2">
                                    @if ($lesson->video_url || $lesson->pdf_url)
                                        <button onclick="openLessonModal({{ $lesson }})"
                                            class="bg-very-green text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors text-sm">
                                            Voir le contenu
                                        </button>
                                    @endif

                                    @if (!$userProgress[$lesson->id])
                                        <button onclick="completeLesson({{ $lesson->id }})"
                                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors text-sm">
                                            Marquer comme terminé
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Quiz -->
            @if ($module->quizz)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-6">Quiz du module</h2>

                    <div class="border border-gray-200 rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-semibold text-gray-900">{{ $module->quizz->titre }}</h3>

                            @if ($userQuizz)
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                    Score: {{ round($userQuizz->score) }}%
                                </span>
                            @endif
                        </div>

                        <p class="text-gray-600 mb-4">
                            Ce quiz contient {{ $module->quizz->questions->count() }} questions pour tester vos
                            connaissances sur ce module.
                        </p>

                        <div class="flex justify-between items-center">
                            <div>
                                @if ($userQuizz)
                                    <p class="text-sm text-gray-600">
                                        Dernier passage: {{ $userQuizz->updated_at->format('d/m/Y') }}
                                    </p>
                                @endif
                            </div>

                            <a href="{{ route('quizz.show', $module->quizz->id) }}"
                                class="bg-very-green text-white px-6 py-3 rounded-lg hover:bg-green-600 transition-colors">
                                {{ $userQuizz ? 'Repasser le quiz' : 'Commencer le quiz' }}
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal pour afficher le contenu de la leçon -->
    <div id="lessonModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="fixed inset-0 flex items-center justify-center z-50 bg-gray-900 bg-opacity-50">
            <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-hidden">
                <div class="flex justify-between items-center p-6 border-b">
                    <h3 id="modalTitle" class="text-xl font-semibold text-gray-900"></h3>
                    <button onclick="closeLessonModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>

                <div class="p-6 overflow-y-auto">
                    <div id="modalContent"></div>

                    <div class="mt-6 flex justify-end">
                        <button onclick="completeCurrentLesson()"
                            class="bg-very-green text-white px-6 py-2 rounded-lg hover:bg-green-600 transition-colors">
                            Marquer comme terminé
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentLessonId = null;

        function openLessonModal(lesson) {
            currentLessonId = lesson.id;
            document.getElementById('modalTitle').textContent = lesson.titre;

            let content = '';
            if (lesson.video_url) {
                content += `
            <div class="mb-6">
                <h4 class="font-semibold mb-3">Vidéo de la leçon</h4>
                <div class="aspect-w-16 aspect-h-9">
                    <iframe src="${lesson.video_url}" class="w-full h-64 md:h-96 rounded-lg" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        `;
            }

            if (lesson.pdf_url) {
                content += `
            <div>
                <h4 class="font-semibold mb-3">Document PDF</h4>
                <a href="${lesson.pdf_url}" target="_blank" class="inline-flex items-center text-very-green hover:text-green-600">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Télécharger le PDF
                </a>
            </div>
        `;
            }

            document.getElementById('modalContent').innerHTML = content;
            document.getElementById('lessonModal').classList.remove('hidden');
        }

        function closeLessonModal() {
            document.getElementById('lessonModal').classList.add('hidden');
            currentLessonId = null;
        }

        function completeCurrentLesson() {
            if (currentLessonId) {
                completeLesson(currentLessonId);
                closeLessonModal();
            }
        }
    </script>
@endsection
