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
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
        
        .page-header {
            background-color: var(--primary-color);
            color: white;
            padding: 60px 0;
            margin-bottom: 40px;
        }
        
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
        
        .category-badge {
            position: absolute;
            top: 10px;
            right: 10px;
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
        
        .sidebar-widget {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .tag-cloud a {
            display: inline-block;
            padding: 5px 10px;
            background-color: #f1f1f1;
            border-radius: 4px;
            margin: 0 5px 5px 0;
            color: var(--dark-color);
            text-decoration: none;
        }
        
        .tag-cloud a:hover {
            background-color: var(--primary-color);
            color: white;
        }
</style>

    <!-- En-tête de page -->
    <div class="page-header">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Blog</h1>
            <p class="lead">Découvrez tous nos articles sur l'élevage et l'agriculture</p>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="container">
        <div class="row">
            <!-- Colonne principale -->
            <div class="col-lg-8">
                <!-- Filtres -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <span class="me-2">Filtrer par :</span>
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-primary active">Tous</button>
                            <button type="button" class="btn btn-outline-primary">Permaculture</button>
                            <button type="button" class="btn btn-outline-primary">Agriculture Bio</button>
                            <button type="button" class="btn btn-outline-primary">Techniques</button>
                        </div>
                    </div>
                    <div>
                        <span class="me-2">Trier par :</span>
                        <select class="form-select form-select-sm d-inline-block w-auto">
                            <option>Plus récents</option>
                            <option>Plus populaires</option>
                            <option>Plus commentés</option>
                        </select>
                    </div>
                </div>
               

                @if($publications->isEmpty())
                    <p class="text-center">Aucune publication disponible pour le moment.</p>
                @else
                    
               

                <!-- Liste des articles -->
                <div class="row">
                    @foreach($publications as $pub)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <span class="category-badge badge bg-primary">
                                    {{ $pub->category->name ?? 'Sans catégorie' }}
                                </span>
                                <img src="{{ asset('storage/'.$pub->image_path) }}" class="card-img-top" alt="{{ $pub->titre }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $pub->titre }}</h5>
                                    <p class="card-text">{{ Str::limit(strip_tags($pub->content), 120, '...') }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">{{ $pub->created_at->format('d M Y') }}</small>
                                        <a href="{{ route('blog.show', $pub->id) }}" class="btn btn-sm btn-primary">Lire la suite</a>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent d-flex justify-content-between">
                                    <small><i class="bi bi-person me-1"></i> {{ $pub->author }}</small>
                                    <small><i class="bi bi-tag me-1"></i> {{ $pub->tags }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination 
                <div class="mt-4 d-flex justify-content-center">
                    
                </div>-->

            @endif
                <!-- Pagination -->
                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-center">
                        {{ $publications->links() }}
                    </ul>
                </nav>
            </div>

           


            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Recherche -->
                <div class="sidebar-widget">
                    <h5 class="mb-3">Rechercher</h5>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Mot-clé...">
                        <button class="btn btn-primary" type="button"><i class="bi bi-search"></i></button>
                    </div>
                </div>

                <!-- Catégories -->
                <div class="sidebar-widget">
                    <h5 class="mb-3">Catégories</h5>
                   <ul class="list-group list-group-flush">
                        @foreach($categories as $cat)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="{{ route('blog.list', ['category' => $cat->id]) }}" class="text-decoration-none text-dark">
                                    {{ $cat->name }}
                                </a>
                                <span class="badge bg-primary rounded-pill">{{ $cat->publications_count }}</span>
                            </li>
                        @endforeach
                    </ul>

                </div>

               
            </div>
        </div>
    </div>

    
@endsection
