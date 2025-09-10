<nav class="navbar navbar-expand-lg main-navbar sticky">
    <div class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <!-- Bouton sidebar -->
            <li>
                <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn">
                    <i data-feather="align-justify"></i>
                </a>
            </li>
            <!-- Bouton plein écran -->
            <li>
                <a href="#" class="nav-link nav-link-lg fullscreen-btn">
                    <i data-feather="maximize"></i>
                </a>
            </li>
            <!-- Barre de recherche -->
            <li>
                <form class="form-inline mr-auto">
                    <div class="search-element">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="200">
                        <button class="btn" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </li>
        </ul>
    </div>

    <ul class="navbar-nav navbar-right">
        <!-- Section Admin -->
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <i class="fas fa-user-shield mr-1 text-success"></i>
                <span class="d-sm-none d-lg-inline-block text-dark align-middle">Administrateur</span>  
                <i class="dropdown-toggle ml-1 text-dark d-lg-inline-block align-middle"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
                <!-- Option Déconnexion -->
                <a href="auth-login.html" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </a>
            </div>
        </li>
    </ul>
</nav>
