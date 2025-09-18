<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a class="navbar-brand text-success" href="index.html">
            <i class="bi bi-tree-fill me-2"></i>
            <span class="logo-name">Small Land</span>
        </a>
    </div>

    <ul class="sidebar-menu">
        <li class="menu-header">Tableau de bord</li>
        <li class="dropdown active">
            <a href="dashboard.html" class="nav-link">
                <i data-feather="monitor"></i><span>Dashboard</span>
            </a>
        </li>

        <!-- Gestion Produits -->
        <li class="menu-header">Boutique</li>
        <li class="dropdown">
            <a href="#" class="menu-toggle nav-link has-dropdown">
                <i data-feather="shopping-cart"></i><span>Produits</span>
            </a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="produits-index.html">Liste des Produits</a></li>
                <li><a class="nav-link" href="produits-create.html">Ajouter Produit</a></li>
                <li><a class="nav-link" href="categories.html">Catégories</a></li>
                <li><a class="nav-link" href="commandes.html">Commandes</a></li>
                <li><a class="nav-link" href="paiements.html">Paiements</a></li>
            </ul>
        </li>

        <!-- Gestion Formations -->
        <li class="menu-header">Formations</li>
        <li class="dropdown">
            <a href="#" class="menu-toggle nav-link has-dropdown">
                <i data-feather="book-open"></i><span>Formations</span>
            </a>
            <ul class="dropdown-menu">
                <li class="{{request()->routeIs('lists_formation') ? 'active':''}}"><a class="nav-link" href="{{route('lists_formation')}}">Liste des Formations</a></li>
                {{-- <li class="{{request()->routeIs('add_formation_page') ? 'active':''}}"><a class="nav-link" href="{{route('add_formation_page')}}">Ajouter Formation</a></li> --}}
                <li><a class="nav-link" href="{{ route("modules.list") }}">Modules</a></li>
                <li><a class="nav-link" href="modules.html">Lecons</a></li>
                <li><a class="nav-link" href="modules.html">Quizz</a></li>
                <li><a class="nav-link" href="attestations.html">Attestations</a></li>
                <li><a class="nav-link" href="modules.html">Paiments-formations</a></li>
            </ul>
        </li>

        <!-- Gestion Quiz -->
        <li class="menu-header">Quiz</li>
        <li class="dropdown">
            <a href="#" class="menu-toggle nav-link has-dropdown">
                <i data-feather="help-circle"></i><span>Quiz</span>
            </a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="quiz-index.html">Liste des Quiz</a></li>
                <li><a class="nav-link" href="quiz-create.html">Créer Quiz</a></li>
                <li><a class="nav-link" href="questions.html">Questions</a></li>
            </ul>
        </li>

        <!-- Gestion Blog -->
        <li class="menu-header">Blog</li>
        <li class="dropdown">
            <a href="#" class="menu-toggle nav-link has-dropdown">
                <i data-feather="file-text"></i><span>Articles</span>
            </a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="articles-index.html">Liste des Articles</a></li>
                <li><a class="nav-link" href="articles-create.html">Créer Article</a></li>
                <li><a class="nav-link" href="categories-blog.html">Catégories</a></li>
            </ul>
        </li>

        <!-- Gestion Utilisateurs -->
        <li class="menu-header">Utilisateurs</li>
        <li class="dropdown">
            <a href="#" class="menu-toggle nav-link has-dropdown">
                <i data-feather="users"></i><span>Utilisateurs</span>
            </a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="users-index.html">Liste des Utilisateurs</a></li>
                <li><a class="nav-link" href="roles.html">Rôles & Permissions</a></li>
            </ul>
        </li>

        <!-- Pages annexes -->
        <li class="menu-header">Autres</li>
        <li><a class="nav-link" href="a-propos.html"><i data-feather="info"></i><span>À propos</span></a></li>
        <li><a class="nav-link" href="contact.html"><i data-feather="phone"></i><span>Contact</span></a></li>
        <li><a class="nav-link" href="cgu.html"><i data-feather="file"></i><span>CGU / Politique</span></a></li>
    </ul>
</aside>
