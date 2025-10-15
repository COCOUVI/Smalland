@extends('Master')

@section('content')
<div class="container py-5">
    <!-- En-tête du module -->
    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between align-items-start">
            <div>
                <h1 class="card-title h3">{{ $module->titre }}</h1>
                <p class="text-muted mt-2">Formation: {{ $module->formation->titre }}</p>
            </div>
            <span class="badge bg-success fs-6">Module {{ $module->ordre }}</span>
        </div>
    </div>

    <!-- Leçons -->
    <div class="card mb-4">
        <div class="card-body">
            <h2 class="h4 mb-4">Leçons du module</h2>

            @foreach ($module->lessons as $lesson)
            <div id="lesson-{{ $lesson->id }}" class="card mb-3 {{ $userProgress[$lesson->id] ? 'bg-light border-success' : '' }}">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        @if ($userProgress[$lesson->id])
                        <div class="text-success me-3">
                            <i class="bi bi-check-circle-fill fs-4"></i>
                        </div>
                        @else
                        <div class="border border-secondary rounded-circle me-3" style="width: 24px; height: 24px;"></div>
                        @endif

                        <div>
                            <h5 class="card-title mb-1">{{ $lesson->titre }}</h5>
                            <div class="d-flex gap-3 text-muted small">
                                @if ($lesson->video_url)
                                <span><i class="bi bi-play-btn-fill"></i> Vidéo</span>
                                @endif
                                @if ($lesson->pdf_url)
                                <span><i class="bi bi-file-earmark-pdf-fill"></i> PDF</span>
                                @endif
                                <span>{{ $lesson->duree }} min</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        @if ($lesson->video_url || $lesson->pdf_url)
                        <button onclick="openLessonModal({{ $lesson }})" class="btn btn-success btn-sm">Voir le contenu</button>
                        @endif
                        @if (!$userProgress[$lesson->id])
                        <button onclick="completeLesson({{ $lesson->id }})" class="btn btn-secondary btn-sm">Terminer</button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Quiz -->
    @if ($module->quizz)
    <div class="card mb-4">
        <div class="card-body">
            <h2 class="h4 mb-3">Quiz du module</h2>
            <div class="border rounded p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>{{ $module->quizz->titre }}</h5>
                    @if ($userQuizz)
                    <span class="badge bg-primary">Score: {{ round($userQuizz->score) }}%</span>
                    @endif
                </div>
                <p>Ce quiz contient {{ $module->quizz->questions->count() }} questions pour tester vos connaissances.</p>
                <div class="d-flex justify-content-between align-items-center">
                    @if ($userQuizz)
                    <small class="text-muted">Dernier passage: {{ $userQuizz->updated_at->format('d/m/Y') }}</small>
                    @endif
                    <a href="{{ route('quizz.show', $module->quizz->id) }}" class="btn btn-success">
                        {{ $userQuizz ? 'Repasser le quiz' : 'Commencer le quiz' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Modal leçon -->
<div class="modal fade" id="lessonModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="btn-close" onclick="closeLessonModal()"></button>
            </div>
            <div class="modal-body" id="modalContent"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="completeCurrentLesson()">Marquer comme terminé</button>
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
                <div class="mb-4">
                    <h6>Vidéo de la leçon</h6>
                    <div class="ratio ratio-16x9">
                        <iframe src="/storage/${lesson.video_url}" class="rounded" allowfullscreen></iframe>
                    </div>
                </div>`;
        }
        if (lesson.pdf_url) {
            content += `
                <div>
                    <h6>Document PDF</h6>
                    <a href="/storage/${lesson.pdf_url}" target="_blank" class="text-success">
                        <i class="bi bi-file-earmark-pdf-fill"></i> Télécharger le PDF
                    </a>
                </div>`;
        }

        document.getElementById('modalContent').innerHTML = content;
        new bootstrap.Modal(document.getElementById('lessonModal')).show();
    }

    function closeLessonModal() {
        bootstrap.Modal.getInstance(document.getElementById('lessonModal')).hide();
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
