@extends('master')

@section('content')
    <div class="container my-5">
        <!-- En-tête -->
        <!-- En-tête -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-primary rounded-circle p-2 me-3">
                                <i class="bi bi-chat-square-quote-fill text-white fs-5"></i>
                            </div>
                            <div>
                                <h1 class="h2 fw-bold text-dark mb-0">Avis Formation</h1>
                                <p class="text-muted mb-0">{{ $formation->titre }}</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center text-muted">
                            <div class="rating small me-3">
                                @php $avgNote = $avis->avg('note') ?? 0; @endphp
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $avgNote)
                                        <i class="bi bi-star-fill text-warning"></i>
                                    @elseif ($i - 0.5 <= $avgNote)
                                        <i class="bi bi-star-half text-warning"></i>
                                    @else
                                        <i class="bi bi-star text-warning"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="fw-medium">{{ number_format($avgNote, 1) }} · {{ $avis->total() }} avis</span>
                        </div>
                    </div>
                    <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-2"></i>Retour
                    </a>
                </div>
            </div>
        </div>

        <!-- Liste des avis -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @forelse ($avis as $a)
                    @php
                        $initials = strtoupper(substr($a->user->prenom, 0, 1) . substr($a->user->nom, 0, 1));
                        $colors = ['primary', 'success', 'warning', 'danger', 'info'];
                        $color = $colors[array_rand($colors)];
                    @endphp

                    <!-- Carte Avis -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body">
                            <!-- En-tête de l'avis -->
                            <div class="d-flex align-items-start mb-3">
                                <div class="rounded-circle bg-{{ $color }} text-white d-flex justify-content-center align-items-center me-3 flex-shrink-0"
                                    style="width: 60px; height: 60px; font-weight: 600; font-size: 1.3rem;">
                                    {{ $initials }}
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h5 class="fw-bold mb-1">{{ $a->user->prenom }} {{ $a->user->nom }}</h5>
                                            <div class="rating mb-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $a->note)
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                    @elseif ($i - 0.5 <= $a->note)
                                                        <i class="bi bi-star-half text-warning"></i>
                                                    @else
                                                        <i class="bi bi-star text-warning"></i>
                                                    @endif
                                                @endfor
                                                <span
                                                    class="ms-2 text-muted small">{{ number_format($a->note, 1) }}/5</span>
                                            </div>
                                        </div>
                                        <small class="text-muted">
                                            <i class="bi bi-clock me-1"></i>
                                            {{ $a->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Contenu de l'avis -->
                            <div class="avis-content">
                                <p class="text-dark mb-0 line-clamp-3" style="line-height: 1.6;">
                                    {{ $a->content_avis }}
                                </p>
                            </div>


                        </div>
                    </div>

                @empty
                    <!-- État vide -->
                    <div class="text-center py-5">
                        <div class="empty-state">
                            <i class="bi bi-chat-quote display-1 text-muted mb-4"></i>
                            <h3 class="h4 text-muted mb-3">Aucun avis pour le moment</h3>
                            <p class="text-muted mb-4">
                                Soyez le premier à partager votre expérience sur cette formation.
                            </p>
                            <a href="#" class="btn btn-primary">
                                <i class="bi bi-pencil-square me-2"></i>Écrire un avis
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        @if ($avis->hasPages())
            <div class="row mt-5">
                <div class="col-12">
                    <nav aria-label="Pagination des avis">
                        {{ $avis->links('vendor.pagination.bootstrap-5') }}
                    </nav>
                </div>
            </div>
        @endif
    </div>

    <style>
        .rating {
            font-size: 1.1rem;
        }

        .card {
            border-radius: 12px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .empty-state {
            max-width: 400px;
            margin: 0 auto;
        }

        .bg-custom-avatar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
@endsection
