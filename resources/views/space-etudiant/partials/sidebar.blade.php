<div class="col-lg-3">
    <div class="card sidebar">
        <div class="card-body">
            <div class="text-center mb-4">
                <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80"
                    alt="Avatar" class="rounded-circle mb-2" width="80">
                <h5>{{ auth()->user()->nom }} {{ auth()->user()->prenom }}</h5>


                @if ($firstFormation)
                    <p class="text-muted">
                        Étudiant depuis le {{ $firstFormation->created_at->translatedFormat('d F Y') }}
                    </p>
                @else
                    <p class="text-muted">Aucune formation commencée</p>
                @endif
            </div>

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('espace.etudiant') ? 'active' : '' }}"
                        href="{{ route('espace.etudiant') }}" data-url="{{ route('espace.etudiant') }}">
                        <i class="bi bi-house"></i> Tableau de bord
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('trainings.paid') ? 'active' : '' }}"
                        href="{{ route('formations.index') }}" data-url="{{ route('formations.index') }}">
                        <i class="bi bi-collection-play"></i> Mes formations
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('certificats.index') ? 'active' : '' }}" href="{{route('certificats.index')}}" data-url="{{route('certificats.index')}}" <i class="bi bi-award"></i> Certificats
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('facturations.index') ? 'active' : '' }}" href="{{route('facturations.index')}}" data-url="{{route('facturations.index')}}">
                        <i class="bi bi-credit-card"></i> Facturation
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link{{ request()->routeIs('parametres.index') ? 'active' : '' }}" href="{{route('parametres.index')}}" data-url="{{route('parametres.index')}}">
                        <i class="bi bi-gear"></i> Paramètres
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('help.index') ? 'active' : '' }}" href="{{route('help.index')}}" data-url="{{route('help.index')}}">
                        <i class="bi bi-question-circle"></i> Aide
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="card mt-4">
        <div class="card-body stats-card">
            <i class="bi bi-play-btn display-6 text-primary mb-3"></i>
            <div class="stats-number">12h</div>
            <p>de formation suivies</p>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body stats-card">
            <i class="bi bi-award display-6 text-primary mb-3"></i>
            <div class="stats-number">2</div>
            <p>certificats obtenus</p>
        </div>
    </div>
</div>
