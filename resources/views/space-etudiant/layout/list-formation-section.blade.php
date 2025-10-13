<div class="container">
    <div class="row g-3">
        @foreach ($formations as $formation)
            @php $progression = $formation->pivot->progression ?? 0; @endphp
            <div class="col-12">
                <div class="card shadow-sm border-0 hover-card" 
                     style="border-radius:10px; transition: transform 0.2s, box-shadow 0.2s;">
                    <div class="row g-0 align-items-center">
                        {{-- Image à gauche --}}
                        <div class="col-md-4 col-lg-3">
                            <img src="/storage/{{ $formation->image_path }}" 
                                 class="img-fluid rounded-start" 
                                 alt="{{ $formation->titre }}" 
                                 style="height: 120px; object-fit: cover;">
                        </div>

                        {{-- Contenu à droite --}}
                        <div class="col-md-8 col-lg-9">
                            <div class="card-body d-flex flex-column justify-content-between">
                                {{-- Header: titre + badge --}}
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="card-title mb-0" style="font-weight:600; font-size:1.1rem;">
                                        {{ $formation->titre }}
                                    </h5>
                                    @if($progression == 100)
                                        <span class="badge bg-success">Terminé</span>
                                    @elseif($progression > 0)
                                        <span class="badge bg-info text-dark">En cours</span>
                                    @else
                                        <span class="badge bg-secondary">Non commencé</span>
                                    @endif
                                </div>

                                {{-- Jauge de progression --}}
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small class="text-muted">Progression</small>
                                        <small>{{ $progression }}%</small>
                                    </div>
                                    <div class="progress" style="height:10px; border-radius:5px;">
                                        <div class="progress-bar" role="progressbar" 
                                             style="width: {{ $progression }}%;"
                                             aria-valuenow="{{ $progression }}" 
                                             aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>

                                {{-- Bouton dynamique --}}
                                <div>
                                    @if ($progression == 0)
                                        <a href="{{route('formations.show',$formation->id)}}" class="btn btn-primary btn-sm">Commencer</a>
                                    @elseif($progression < 100)
                                        <a href="{{route('formations.show',$formation->id)}}" class="btn btn-warning btn-sm">Continuer</a>
                                    @else
                                        <a href="{{route('formations.show',$formation->id)}}" class="btn btn-success btn-sm">Voir attestation</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $formations->links() }}
    </div>
</div>
@if (session('success'))
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
    <div id="success-toast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body fw-bold">
                {{ session('success') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fermer"></button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let toastEl = document.getElementById('success-toast');
        let toast = new bootstrap.Toast(toastEl);
        toast.show();

        // 🔥 Supprimer le message de la session dans l'historique navigateur
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    });
</script>
@endif


{{-- Styles additionnels pour UX --}}
@push('styles')
<style>
.hover-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}
.card-title {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
@media (max-width: 768px) {
    .card-body {
        padding: 0.75rem;
    }
    .progress {
        height: 8px;
    }
}
</style>
@endpush
