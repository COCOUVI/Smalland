@extends('master')

@section('content')
<div class="page-header text-center text-white bg-success py-5 mb-5">
    <div class="container">
        <h1 class="display-5 fw-bold">{{ $category->name }}</h1>
        <p class="lead">{{ $category->description }}</p>
    </div>
</div>

<div class="container">
    <div class="row">
        @forelse($articles as $article)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('storage/'.$article->image_path) }}" class="card-img-top" alt="{{ $article->titre }}">
                <div class="card-body">
                    <span class="badge bg-success mb-2">{{ $article->category->name }}</span>
                    <h5 class="card-title">{{ $article->titre }}</h5>
                    <p class="text-muted small">Par {{ $article->author }}</p>
                    <p class="card-text text-truncate">{{ Str::limit(strip_tags($article->content), 100) }}</p>
                    <a href="{{ route('blog.show', $article->id) }}" class="btn btn-outline-success btn-sm">Lire l’article</a>
                </div>
            </div>
        </div>
        @empty
        <p class="text-center">Aucun article dans cette catégorie pour le moment.</p>
        @endforelse
    </div>
</div>
@endsection
