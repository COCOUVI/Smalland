@extends('master')

@section('content')
    <style>
        :root {
            --primary-color: #2e7d32;
            --secondary-color: #7cb342;
            --accent-color: #ffd54f;
            --light-color: #f5f5f5;
            --dark-color: #263238;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .bg-primary {
            background-color: var(--primary-color) !important;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #1b5e20;
            border-color: #1b5e20;
        }

        .text-primary {
            color: var(--primary-color) !important;
        }

        .formation-header {
            background-color: var(--primary-color);
            color: white;
            padding: 80px 0;
            margin-bottom: 40px;
        }

        .formation-level {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .level-beginner {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .card {
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .footer {
            background-color: var(--dark-color);
            color: white;
            padding: 40px 0;
        }

        .section-title {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: var(--secondary-color);
        }

        .rating {
            color: #ffc107;
        }

        .progress-bar {
            background-color: var(--primary-color);
        }

        .module-item {
            border-left: 3px solid var(--primary-color);
            padding-left: 15px;
            margin-bottom: 15px;
        }

        .instructor-card {
            text-align: center;
        }

        .instructor-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }

        .pricing-card {
            position: sticky;
            top: 20px;
        }

        .level-intermediate {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }

        .level-expert {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>

    <!-- En-tête de la formation -->
    <div class="formation-header">
        <div class="container">
            {{-- Ne montrer les toasts que si l'utilisateur n'est pas encore inscrit --}}
            @if (!$isEnrolled && (session('success') || session('error') || session('info')))
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    @if (session('success'))
                        Swal.fire({
                            icon: 'success',
                            title: 'Succès !',
                            text: '{{ session('success') }}',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    @endif

                    @if (session('error'))
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: '{{ session('error') }}',
                            confirmButtonColor: '#2e7d32'
                        });
                    @endif

                    @if (session('info'))
                        Swal.fire({
                            icon: 'info',
                            title: 'Information',
                            text: '{{ session('info') }}',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    @endif
                </script>
            @endif

            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span
                        class="formation-level 
                    @if ($formation->niveau === 'debutant') level-beginner 
                    @elseif($formation->niveau === 'intermediaire') level-intermediate 
                    @elseif($formation->niveau === 'expert') level-expert @endif
                mb-3">
                        {{ ucfirst($formation->niveau) }}
                    </span>
                    <h1 class="display-4 fw-bold mb-3">{{ $formation->titre }}</h1>
                    <p class="lead mb-4">{{ $formation->description }}</p>

                    <div class="d-flex flex-wrap align-items-center">
                        @php
                            $average = round($formation->averageRating(), 1);
                            $totalAvis = $formation->totalAvis();
                            $fullStars = floor($average);
                            $halfStar = $average - $fullStars >= 0.5;
                        @endphp

                        <div class="rating me-3">
                            @for ($i = 0; $i < $fullStars; $i++)
                                <i class="bi bi-star-fill text-warning"></i>
                            @endfor

                            @if ($halfStar)
                                <i class="bi bi-star-half text-warning"></i>
                            @endif

                            @for ($i = $fullStars + ($halfStar ? 1 : 0); $i < 5; $i++)
                                <i class="bi bi-star text-warning"></i>
                            @endfor

                            <span class="ms-1">{{ $average ?? 0 }} ({{ $totalAvis }} avis)</span>
                        </div>

                        <div class="me-3"><i class="bi bi-people me-1"></i> {{ $formation->totalInscriptions() }}
                            étudiants</div>
                        <div><i class="bi bi-clock me-1"></i> {{ $formation->getTotalDurationAttribute() }} de formation
                        </div>
                    </div>
                </div>

                <!-- Prix et inscription (sidebar desktop) -->
                <div class="col-lg-4 mt-4 mt-lg-0">
                    <div class="card pricing-card">
                        <div class="card-body text-center">
                            <div class="h2 text-primary mb-3">{{ $formation->price }} FCFA</div>
                            @auth
                                {{-- <a href="{{ route('paiement.initier', $formation->id) }}"
                                    class="btn btn-primary btn-lg w-100 mb-3">
                                    S'inscrire maintenant
                                </a> --}}
                                @if ($isEnrolled)
                                    <a href="{{ route('trainings.paid') }}" class="btn btn-success btn-lg w-100 mb-3">
                                        <i class="bi bi-check-circle me-2"></i>Déjà inscrit - Accéder au cours
                                    </a>
                                @else
                                    <button id="btn-pay" class="btn btn-primary">S'inscrire maintenant</button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100 mb-3">
                                    Connectez-vous pour vous inscrire
                                </a>
                            @endauth

                            <div class="text-muted small">Garantie satisfait ou remboursé 30 jours</div>
                            <hr>
                            <ul class="list-unstyled text-start">
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Accès à vie</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>
                                    {{ $formation->total_lessons }} leçons vidéo</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Certificat de
                                    completion</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Accès sur mobile
                                    et
                                    TV</li>
                                <li><i class="bi bi-check-circle text-success me-2"></i> Support formateur</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="container">
        <div class="row">
            <!-- Colonne principale -->
            <div class="col-lg-8">

                <!-- Objectifs -->
                <div class="card mb-5">
                    <div class="card-body">
                        <h3 class="section-title">Objectifs de la formation</h3>
                        @if ($formation->objectifs->count() > 0)
                            <p>À la fin de cette formation, vous serez capable de :</p>
                            <ul>
                                @foreach ($formation->objectifs as $obj)
                                    <li>{{ $obj->content }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>Aucun Objectif</p>
                        @endif
                    </div>
                </div>

                <!-- Programme -->
                <div class="card mb-5">
                    <div class="card-body">
                        <h3 class="section-title">Programme de la formation</h3>
                        <div class="accordion" id="programAccordion">
                            @foreach ($formation->modules as $index => $module)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingModule{{ $module->id }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#module{{ $module->id }}">
                                            <div class="d-flex justify-content-between w-100 me-3">
                                                <span>Module {{ $index + 1 }} : {{ $module->titre }}</span>
                                                <span class="text-muted">
                                                    {{ $module->lessons->count() }} leçons • {{ $module->total_duration }}
                                                </span>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="module{{ $module->id }}" class="accordion-collapse collapse"
                                        data-bs-parent="#programAccordion">
                                        <div class="accordion-body">
                                            @foreach ($module->lessons as $lesson)
                                                <div class="module-item d-flex justify-content-between align-items-center">
                                                    <div>
                                                        @if ($lesson->video_url)
                                                            <i class="bi bi-play-circle me-2 text-primary"></i>
                                                        @elseif($lesson->pdf_url)
                                                            <i class="bi bi-file-text me-2 text-primary"></i>
                                                        @endif
                                                        <span>{{ $lesson->titre }}</span>
                                                    </div>
                                                    <span class="text-muted">
                                                        @if ($lesson->video_url)
                                                            {{ floor($lesson->duree / 60) }} min
                                                        @elseif($lesson->pdf_url)
                                                            PDF
                                                        @endif
                                                    </span>
                                                </div>
                                            @endforeach

                                            @if ($module->quizz)
                                                <hr>
                                                <div class="module-item">
                                                    <i class="bi bi-question-circle me-2 text-warning"></i>
                                                    <strong>Quizz :</strong> {{ $module->quizz->titre }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Formateur -->
                <div class="card mb-5">
                    <div class="card-body">
                        <h3 class="section-title">Votre formateur</h3>
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a" alt="Formateur"
                                    class="instructor-img">
                            </div>
                            <div class="col-md-9">
                                <h4>Jean Martin</h4>
                                <p class="text-muted">Expert en agriculture biologique</p>
                                <p>Agriculteur bio depuis 15 ans, Jean Martin a transformé sa ferme familiale en modèle de
                                    maraîchage bio intensif.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Avis -->
                <div class="card mb-5">
                    <div class="card-body">
                        <h3 class="section-title">Avis des étudiants</h3>
                        @php
                            $averageRating = round($formation->averageRating(), 1);
                            $totalAvis = $formation->avis->count();
                        @endphp

                        <div class="row mb-4">
                            <div class="col-md-4 text-center">
                                <div class="display-4 text-primary">{{ $averageRating }}</div>
                                <div class="rating mb-2">
                                    @for ($i = 0; $i < floor($averageRating); $i++)
                                        <i class="bi bi-star-fill"></i>
                                    @endfor
                                    @if ($averageRating - floor($averageRating) >= 0.5)
                                        <i class="bi bi-star-half"></i>
                                    @endif
                                    @for ($i = ceil($averageRating); $i < 5; $i++)
                                        <i class="bi bi-star"></i>
                                    @endfor
                                </div>
                                <div class="text-muted">Note moyenne • {{ $totalAvis }} avis</div>
                            </div>
                            <div class="col-md-8">
                                @for ($note = 5; $note >= 1; $note--)
                                    @php
                                        $count = $formation->avis->where('note', $note)->count();
                                        $percent = $totalAvis ? round(($count / $totalAvis) * 100) : 0;
                                    @endphp
                                    <div class="mb-2">
                                        <div class="d-flex align-items-center">
                                            <span class="me-2">{{ $note }}</span>
                                            <div class="progress flex-grow-1" style="height: 8px;">
                                                <div class="progress-bar" style="width: {{ $percent }}%;"></div>
                                            </div>
                                            <span class="ms-2">{{ $percent }}%</span>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <!-- Liste des avis -->
                        @foreach ($formation->avis as $avis)
                            @php
                                $initials = strtoupper(
                                    substr($avis->user->prenom, 0, 1) . substr($avis->user->nom, 0, 1),
                                );
                            @endphp
                            <div class="border-bottom pb-3 mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <!-- Avatar cercle -->
                                    <div class="rounded-circle bg-success text-white d-flex justify-content-center align-items-center me-3"
                                        style="width: 50px; height: 50px; font-weight: 600; font-size: 1.2rem;">
                                        {{ $initials }}
                                    </div>

                                    <!-- Nom + étoiles -->
                                    <div>
                                        <div class="fw-bold">{{ $avis->user->prenom }} {{ $avis->user->nom }}</div>
                                        <div class="rating small text-warning">
                                            @for ($i = 0; $i < floor($avis->note); $i++)
                                                <i class="bi bi-star-fill"></i>
                                            @endfor
                                            @if ($avis->note - floor($avis->note) >= 0.5)
                                                <i class="bi bi-star-half"></i>
                                            @endif
                                            @for ($i = ceil($avis->note); $i < 5; $i++)
                                                <i class="bi bi-star"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>

                                <!-- Contenu de l'avis -->
                                <p class="mb-1">{{ $avis->content_avis }}</p>
                                <small class="text-muted">Publié {{ $avis->created_at->diffForHumans() }}</small>
                            </div>
                        @endforeach


                        <a href="#" class="btn btn-outline-primary">Voir tous les avis</a>
                    </div>
                </div>
            </div>

            <!-- Colonne sidebar -->
            <div class="col-lg-4">
                <div class="card mb-4 d-lg-none">
                    <div class="card-body text-center">
                        <div class="h2 text-primary mb-0">{{ $formation->price }} FCFA</div>
                        <a href="#" class="btn btn-primary btn-lg w-100 mb-3">S'inscrire maintenant</a>
                        <div class="text-muted small">Garantie satisfait ou remboursé 30 jours</div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Cette formation comprend</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><i class="bi bi-play-btn me-2 text-primary"></i>
                                {{ $formation->total_duration }} de vidéo</li>
                            <li class="list-group-item"><i class="bi bi-file-text me-2 text-primary"></i>
                                {{ $formation->total_lessons }} leçons</li>
                            <li class="list-group-item"><i class="bi bi-phone me-2 text-primary"></i> Accès mobile & TV
                            </li>
                            <li class="list-group-item"><i class="bi bi-infinity me-2 text-primary"></i> Accès à vie</li>
                            <li class="list-group-item"><i class="bi bi-award me-2 text-primary"></i> Certificat de
                                completion</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.fedapay.com/checkout.js?v=1.1.7"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            @auth
            const widget = FedaPay.init({
                public_key: '{{ $publicKey }}',
                transaction: {
                    amount: {{ $formation->price }},
                    description: 'Paiement formation {{ addslashes($formation->titre) }}'
                },
                customer: {
                    email: '{{ auth()->user()->email }}',
                    firstname: '{{ auth()->user()->nom }}',
                    lastname: '{{ auth()->user()->prenom }}'
                },
                onComplete: function(data) {
                    console.log('onComplete appelé', data);

                    if (data.reason === 'CHECKOUT COMPLETE') {
                        console.log('Paiement complété - envoi des données...');

                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route('paiement.callback') }}';

                        // CSRF Token
                        const csrf = document.createElement('input');
                        csrf.type = 'hidden';
                        csrf.name = '_token';
                        csrf.value = '{{ csrf_token() }}';
                        form.appendChild(csrf);

                        // Transaction ID - CHANGÉ DE transaction_id À id
                        const transactionId = document.createElement('input');
                        transactionId.type = 'hidden';
                        transactionId.name = 'id'; // ← Votre controller cherche 'id'
                        transactionId.value = data.transaction.id;
                        form.appendChild(transactionId);

                        // Formation ID (optionnel si vous en avez besoin)
                        const formationId = document.createElement('input');
                        formationId.type = 'hidden';
                        formationId.name = 'formation_id';
                        formationId.value = '{{ $formation->id }}';
                        form.appendChild(formationId);

                        console.log('Soumission avec id:', data.transaction.id);
                        document.body.appendChild(form);
                        form.submit();
                    }
                }
            });

            document.getElementById('btn-pay').addEventListener('click', () => {
                widget.open();
            });
        @endauth
        });
    </script>
@endpush
