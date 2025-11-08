<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a class="navbar-brand text-success" href="index.html">
            <span class="logo-name"><img src="{{ asset('storage/logo/small_land.png') }}" 
                        class="img-fluid" 
                        style="height: 80px;
                        width:120px" 
                        alt="Logo smalland"> </span>
        </a>
    </div>

    <ul class="sidebar-menu">
        <li class="menu-header">Tableau de bord</li>
        <li class="dropdown {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{route('dashboard')}}" class="nav-link">
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
                <li><a class="nav-link" href="{{ route('products.index') }}">Liste des Produits</a></li>
                <li><a class="nav-link" href="{{ route('products.create') }}">Ajouter Produit</a></li>
                <li><a class="nav-link" href="{{ route('admin.categories.index') }}">Catégories</a></li>
                <li><a class="nav-link" href="{{ route('admin.order.index') }}">Commandes</a></li>
                <li><a class="nav-link" href="{{ route('admin.paiements.boutique.index') }}">Paiements</a></li>
                <li><a class="nav-link" href="{{ route('admin.clients.index') }}">Liste des Clients</a></li>
                <li><a class="nav-link" href="paiements.html">Paiements</a></li>
            </ul>
        </li>

        <!-- Gestion Formations -->
        <li class="menu-header">Formations</li>
        @php
            $isFormationActive =
                request()->routeIs('certif-list') ||
                request()->routeIs('lists_formation') ||
                request()->routeIs('modules.list') ||
                request()->routeIs('lessons.list') ||
                request()->routeIs('admin.paiements.index');
        @endphp

        <li class="dropdown {{ $isFormationActive ? 'active' : '' }}">
            <a href="#" class="menu-toggle nav-link has-dropdown {{ $isFormationActive ? 'toggled' : '' }}">
                <i data-feather="book-open"></i><span>Formations</span>
            </a>
            <ul class="dropdown-menu {{ $isFormationActive ? 'show' : '' }}">
                <li class="{{ request()->routeIs('lists_formation') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('lists_formation') }}">Liste des Formations</a>
                </li>

                <li class="{{ request()->routeIs('modules.list') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('modules.list') }}">Modules</a>
                </li>

                <li class="{{ request()->routeIs('lessons.list') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('lessons.list') }}">Leçons</a>
                </li>

                <li class="{{ request()->routeIs('admin.paiements.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.paiements.index') }}">Paiements-formations</a>
                </li>
                <li class="{{ request()->routeIs('certif-list') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('certif-list') }}">certifications</a>
                </li>
            </ul>
        </li>


        <!-- Gestion Quiz -->
        <li class="menu-header">Quiz</li>
        <li class="dropdown">
            <a href="#" class="menu-toggle nav-link has-dropdown">
                <i data-feather="help-circle"></i><span>Quiz</span>
            </a>
            <ul class="dropdown-menu">
                {{-- <li><a class="nav-link" href="{{ route('quizz.manage', $module->id) }}">Quizz</a></li> --}}
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
                <li><a class="nav-link" href="{{ route('publications.index') }}">Liste des Articles</a></li>
                <li><a class="nav-link" href="{{ route('publications.create') }}">Créer Article</a></li>
                <li><a class="nav-link" href="{{ route('admin.listCategories') }}">Catégories</a></li>
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
