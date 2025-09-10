<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{route('accueil')}}">
            <i class="bi bi-tree-fill me-2"></i>Small Land
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="index.html">Accueil</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="blogDropdown" role="button" data-bs-toggle="dropdown">
                        Blog Agronomie
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="blog-list.html">Tous les articles</a></li>
                        <li><a class="dropdown-item" href="blog-categories.html">Catégories</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="formationsDropdown" role="button" data-bs-toggle="dropdown">
                        Formations
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="formations-catalog.html">Catalogue</a></li>
                       @if(auth()->user() && auth()->user()->role ==="student")
                        <li><a class="dropdown-item" href="student-dashboard.html">Espace étudiant</a></li>
                       @endif
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="shopDropdown" role="button" data-bs-toggle="dropdown">
                        Boutique
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="products-catalog.html">Catalogue produits</a></li>
                        <li><a class="dropdown-item" href="cart.html">Panier</a></li>
                        <li><a class="dropdown-item" href="order-tracking.html">Suivi de commande</a></li>
                    </ul>
                </li>
            </ul>

            <div class="d-flex align-items-center">
                <!-- Panier -->
                <a href="cart.html" class="btn btn-outline-light position-relative me-3">
                    <i class="bi bi-cart"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        3
                        <span class="visually-hidden">articles dans le panier</span>
                    </span>
                </a>

                <!-- Espace client connecté -->
                @if(auth()->user() && auth()->user()->role == 'client')
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-2"></i> {{ auth()->user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="student-dashboard.html">Mon espace</a></li>
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
                @else
                <!-- Connexion / Inscription -->
                <a href="{{ route('login') }}" class="btn btn-outline-light ms-2">Connexion</a>
                <a href="{{ route('register') }}" class="btn btn-light ms-2">Inscription</a>
                @endif
            </div>
        </div>
    </div>
</nav>
