@extends('master')

@section('title', $article->titre)

@section('content')
<style>
    body {
        background-color: #f8f9fa;
        font-family: "Poppins", sans-serif;
    }

    /* ===== HEADER ===== */
    .article-header {
        background-color: #198754;
        color: #fff;
        text-align: center;
        padding: 80px 0 60px;
    }

    .article-header h1 {
        font-weight: 700;
        font-size: 2.5rem;
        margin-bottom: 15px;
    }

    .article-meta {
        font-size: 0.95rem;
        color: #e3e3e3;
    }

    /* ===== ARTICLE ===== */
    .article-container {
        background: #fff;
        padding: 40px;
        margin-top: -40px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .article-content {
        line-height: 1.8;
        color: #333;
    }

    .article-content img {
        display: block;
        margin: 30px auto;
        width: 100%;
        max-width: 900px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    /* ===== TAGS ===== */
    .tag-badge {
        background-color: #198754;
        color: #fff;
        font-size: 0.85rem;
        border-radius: 20px;
        padding: 6px 14px;
        margin: 5px;
        display: inline-block;
    }

    /* ===== COMMENTS ===== */
    .comment-section {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.05);
        padding: 30px;
    }

    .comment {
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
        margin-bottom: 15px;
    }

    .comment:last-child {
        border-bottom: none;
    }

    /* ===== SIDEBAR ===== */
    .sidebar {
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 3px 15px rgba(0,0,0,0.06);
    }

    .sidebar h5 {
        border-bottom: 2px solid #198754;
        padding-bottom: 8px;
        margin-bottom: 20px;
        color: #198754;
    }

    .btn-green {
        background-color: #198754;
        color: white;
        border-radius: 30px;
        padding: 10px 20px;
        transition: 0.3s;
    }

    .btn-green:hover {
        background-color: #157347;
        color: white;
    }
</style>

<!-- ===== HEADER ===== -->
<section class="article-header">
    <div class="container">
        <h1>{{ $article->titre }}</h1>
        <p class="article-meta">
            <i class="bi bi-person-circle"></i> {{ $article->author }} &nbsp; | &nbsp;
            <i class="bi bi-calendar3"></i> {{ $article->created_at->format('d M Y') }} &nbsp; | &nbsp;
            <i class="bi bi-tag"></i> {{ $article->category->name }}
        </p>
    </div>
</section>

<!-- ===== CONTENU ===== -->
<div class="container my-5">
    <div class="row g-5">
        <!-- Article -->
        <div class="col-lg-8">
            <div class="article-container">
                
                <!-- IMAGE PRINCIPALE -->
                @if($article->image_path)
                    <img src="{{ asset('storage/' . $article->image_path) }}" alt="{{ $article->titre }}">
                @endif

                <!-- CONTENU -->
                <div class="article-content mt-4">
                    {!! $article->content !!}
                </div>

                <!-- TAGS -->
                @if($article->tags)
                    <div class="mt-4">
                        <h6 class="fw-bold mb-2">Tags :</h6>
                        @foreach(explode(',', $article->tags) as $tag)
                            <span class="tag-badge">{{ trim($tag) }}</span>
                        @endforeach
                    </div>
                @endif

                <!-- PARTAGE / RETOUR -->
                <div class="d-flex justify-content-between align-items-center mt-5">
                    <a href="{{ route('blog.list') }}" class="btn btn-green">
                        <i class="bi bi-arrow-left-circle me-2"></i> Retour
                    </a>

                    <div>
                        <a href="#" class="btn btn-outline-secondary btn-sm"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="btn btn-outline-secondary btn-sm"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="btn btn-outline-secondary btn-sm"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
            </div>

            <!-- Commentaires -->
            <div class="comment-section mt-5">
                <h4 class="fw-bold mb-4">Commentaires (3)</h4>

                <div class="comment">
                    <h6 class="fw-bold mb-1">Marie Dupont <small class="text-muted">- 10 Oct 2025</small></h6>
                    <p>Article très instructif ! J’ai adoré la clarté de l’explication.</p>
                </div>

                <div class="comment">
                    <h6 class="fw-bold mb-1">Alexandre K. <small class="text-muted">- 9 Oct 2025</small></h6>
                    <p>Merci pour ce contenu, continuez à publier des articles comme celui-ci.</p>
                </div>

                <div class="comment">
                    <h6 class="fw-bold mb-1">Fatima B. <small class="text-muted">- 8 Oct 2025</small></h6>
                    <p>Très intéressant, j’aimerais en savoir plus sur ce sujet.</p>
                </div>

                <form class="mt-4">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom" placeholder="Votre nom">
                    </div>
                    <div class="mb-3">
                        <label for="commentaire" class="form-label">Commentaire</label>
                        <textarea id="commentaire" class="form-control" rows="4" placeholder="Votre message..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-green">Envoyer</button>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="sidebar mb-4">
                <h5><i class="bi bi-person-badge"></i> Auteur</h5>
                <div class="d-flex align-items-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($article->author) }}&background=198754&color=fff"
                         class="rounded-circle me-3" width="60" height="60">
                    <div>
                        <h6 class="mb-0">{{ $article->author }}</h6>
                        <small class="text-muted">Rédacteur</small>
                    </div>
                </div>
            </div>

            <div class="sidebar">
                <h5><i class="bi bi-newspaper"></i> Articles récents</h5>
                <ul class="list-unstyled">
                    @foreach($recentArticles ?? [] as $recent)
                        <li class="mb-3">
                            <a href="{{ route('articles.show', $recent->id) }}" class="text-decoration-none text-dark">
                                <i class="bi bi-chevron-right text-success"></i> {{ Str::limit($recent->titre, 40) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
