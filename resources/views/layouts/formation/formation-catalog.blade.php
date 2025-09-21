@extends('master')

@section('content')
<style>
    .card {
        transition: transform 0.3s, box-shadow 0.3s;
        margin-bottom: 20px;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }
</style>

<div class="page-header">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">Formations</h1>
        <p class="lead">Découvrez nos formations et développez vos compétences</p>
    </div>
</div>

<div class="container">
    <div class="row">
        @foreach($formations as $formation)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <img src="/storage/{{ $formation->image_path }}" class="card-img-top" alt="{{ $formation->titre }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $formation->titre }}</h5>

                        <!-- Niveau avec couleurs -->
                        @php
                            $levelColors = [
                                'debutant' => 'success',      // vert
                                'intermediaire' => 'warning', // orange
                                'expert' => 'danger',         // rouge
                            ];
                        @endphp

                        <p class="badge bg-{{ $levelColors[$formation->niveau] ?? 'secondary' }} mb-2">
                            Niveau : {{ ucfirst($formation->niveau) }}
                        </p>

                        <p class="card-text">{{ Str::limit($formation->description, 120) }}</p>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><i class="bi bi-collection-play me-1"></i> {{ $formation->lecons }} leçons</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0 text-primary">{{ $formation->price }} FCFA</span>
                            <a href="{{ route('formation-detail', $formation->id) }}" class="btn btn-primary">Voir détails</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $formations->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
