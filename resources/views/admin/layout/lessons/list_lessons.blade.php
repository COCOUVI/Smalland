@extends('admin.master')

@section('content')
    <div class="container mt-5 pt-3">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
            <h2 class="mb-2 mb-md-0">Liste des leçons</h2>
            <a href="{{ route('modules.list') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-1"></i> Retour aux modules
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Version desktop -->
        <div class="d-none d-md-block">
            <div id="deleteAlert" class="alert d-none" role="alert"></div>
            <div class="card shadow-sm border-0">
                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>Titre</th>
                                    <th>Module</th>
                                    <th>Formation</th>
                                    <th class="text-center">Date création</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lessons as $lesson)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $lesson->titre }}</td>
                                        <td><span class="badge bg-secondary">{{ $lesson->module->titre ?? 'N/A' }}</span>
                                        </td>
                                        <td><span
                                                class="badge bg-primary">{{ $lesson->module->formation->titre ?? 'N/A' }}</span>
                                        </td>
                                        <td class="text-center">{{ $lesson->created_at->format('d/m/Y') }}</td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <!-- Voir -->
                                                <button type="button" class="btn btn-sm btn-info btn-view-lesson"
                                                    data-bs-toggle="modal" data-bs-target="#lessonModal"
                                                    data-lesson-title="{{ $lesson->titre }}"
                                                    data-lesson-video="/storage/{{ $lesson->video_url }}"
                                                    data-lesson-pdf="/storage/{{ $lesson->pdf_url }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <!-- Modifier -->
                                                <button type="button" class="btn btn-sm btn-warning btn-edit-lesson"
                                                    data-bs-toggle="modal" data-bs-target="#editLessonModal"
                                                    data-lesson-id="{{ $lesson->id }}"
                                                    data-lesson-title="{{ $lesson->titre }}"
                                                    data-lesson-video="/storage/{{ $lesson->video_url }}"
                                                    data-lesson-pdf="/storage/{{ $lesson->pdf_url }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <!-- Supprimer -->
                                                <button type="button" class="btn btn-sm btn-danger btn-delete-lesson"
                                                    data-lesson-id="{{ $lesson->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="alert alert-info mb-0">
                                                <i class="fas fa-info-circle me-2"></i>Aucune leçon disponible.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Version mobile -->
        <div class="d-md-none">
            <div id="deleteAlert" class="alert d-none" role="alert"></div>
            <div id="lessons-container-mobile" class="mb-4">
                @forelse($lessons as $lesson)
                    <div class="card card-lesson mb-3 shadow-sm border-0">
                        <div
                            class="card-header bg-transparent border-0 pb-0 d-flex justify-content-between align-items-center">
                            <span class="badge bg-secondary">ID: {{ $lesson->id }}</span>
                            <span class="text-muted small">{{ $lesson->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="card-body">
                            <h5 class="lesson-title mb-2">{{ $lesson->titre }}</h5>
                            <div class="lesson-details mb-3">
                                <span class="badge bg-secondary w-100 d-block mb-1">
                                    <i class="fas fa-folder me-1"></i>Module: {{ $lesson->module->titre ?? 'N/A' }}
                                </span>
                                <span class="badge bg-primary w-100 d-block">
                                    <i class="fas fa-graduation-cap me-1"></i>Formation:
                                    {{ $lesson->module->formation->titre ?? 'N/A' }}
                                </span>
                            </div>
                            <div class="lesson-actions d-flex gap-2 justify-content-center">
                                <button type="button" class="btn btn-sm btn-info flex-fill btn-view-lesson"
                                    data-bs-toggle="modal" data-bs-target="#lessonModal"
                                    data-lesson-title="{{ $lesson->titre }}"
                                    data-lesson-video="/storage/{{ $lesson->video_url }}"
                                    data-lesson-pdf="/storage/{{ $lesson->pdf_url }}">
                                    <i class="fas fa-eye me-1"></i>Voir
                                </button>
                                <button type="button" class="btn btn-sm btn-warning flex-fill btn-edit-lesson"
                                    data-bs-toggle="modal" data-bs-target="#editLessonModal"
                                    data-lesson-id="{{ $lesson->id }}" data-lesson-title="{{ $lesson->titre }}"
                                    data-lesson-video="{{ $lesson->video_url }}" data-lesson-pdf="{{ $lesson->pdf_url }}">
                                    <i class="fas fa-edit me-1"></i>Modifier
                                </button>
                                <button type="button" class="btn btn-sm btn-danger btn-delete-lesson"
                                    data-lesson-id="{{ $lesson->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>


                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info teUxt-center">
                        <i class="fas fa-info-circle me-2"></i>Aucune leçon disponible.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        @if ($lessons->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $lessons->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    @include('admin.layout.lessons.modal')
    @include('admin.layout.lessons.script')
    <style>
        .card-lesson {
            border-radius: 0.5rem;
        }

        .lesson-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .lesson-details .badge {
            text-align: left;
            white-space: normal;
        }

        .lesson-actions .btn {
            padding: 0.375rem 0.5rem;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .card-body {
            padding: 1rem !important;
        }

        /* pour éviter "enfoncement" */
    </style>
@endsection
