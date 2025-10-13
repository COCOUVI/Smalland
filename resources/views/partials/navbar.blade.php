<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('accueil') }}">
      <img src="{{ asset('storage/logo/small_land_b.png') }}" 
                class="img-fluid" 
                style="height: 100px; width:150px" 
                alt="Logo smalland">
            </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">

                {{-- Accueil --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('accueil') ? 'active' : '' }}" href="{{ route('accueil') }}">
                        Accueil
                    </a>
                </li>

                {{-- Blog Agronomie --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('blog*') ? 'active' : '' }}" href="#" id="blogDropdown" role="button" data-bs-toggle="dropdown">
                        Blog Agronomie
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item {{ request()->is('blog-list') ? 'active' : '' }}" href="{{ route('blog.list') }}">Tous les articles</a></li>
                        <li><a class="dropdown-item {{ request()->is('blog-category') ? 'active' : '' }}" href="{{ route('blog.category') }}">Catégories</a></li>
                    </ul>
                </li>

                {{-- Formations --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('formations*') ? 'active' : '' }}" href="#" id="formationsDropdown" role="button" data-bs-toggle="dropdown">
                        Formations
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item {{ request()->is('formations-catalog') ? 'active' : '' }}" href="{{ route('formations.catalog') }}">Catalogue</a></li>
                        @auth
                            <li><a class="dropdown-item {{ request()->is('student-dashboard') ? 'active' : '' }}" href="{{ route('student.dashboard') }}">Espace étudiant</a></li>
                        @endauth
                    </ul>
                </li>

                {{-- Boutique --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('boutique*') ? 'active' : '' }}" href="#" id="shopDropdown" role="button" data-bs-toggle="dropdown">
                        Boutique
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item {{ request()->is('products-list') ? 'active' : '' }}" href="{{ route('shop') }}">Catalogue produits</a></li>
                        <li><a class="dropdown-item {{ request()->is('cart') ? 'active' : '' }}" href="{{ route('cart.index') }}">Panier</a></li>
                        <li><a class="dropdown-item {{ request()->is('order-tracking') ? 'active' : '' }}" href="{{ route('order.tracking') }}">Suivi de commande</a></li>
                    </ul>
                </li>

            </ul>

            <div class="d-flex align-items-center">
                <!-- Panier -->
                <a href="{{ route('cart.index') }}" class="btn btn-outline-light position-relative me-3">
                    <i class="bi bi-cart"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        3
                        <span class="visually-hidden">articles dans le panier</span>
                    </span>
                </a>

                <!-- Utilisateur connecté -->
                @auth
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-2"></i> {{ auth()->user()->nom }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('student.dashboard') }}">Mon espace</a></li>
                        <li><a class="dropdown-item" href="#">Mon profil</a></li>
                        <li><a class="dropdown-item" href="#">Paramètres</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                               Déconnexion
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
                @endauth

                @guest
                <a href="{{ route('login') }}" class="btn btn-outline-light ms-2">Connexion</a>
                <a href="{{ route('register') }}" class="btn btn-light ms-2">Inscription</a>
                @endguest
            </div>
        </div>
    </div>
</nav>
