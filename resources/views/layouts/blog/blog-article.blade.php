@extends('master')

@section('title', ($article->titre ?? 'Article') . ' - Blog')

{{-- Inclusion des balises SEO --}}
@push('meta')
    @include('partials.seo')
@endpush

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        font-family: "Poppins", sans-serif;
    }

    /* ===== HEADER ===== */
    .article-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
        padding: 60px 0 40px;
        position: relative;
        overflow: hidden;
    }

    .article-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,138.7C960,139,1056,117,1152,101.3C1248,85,1344,75,1392,69.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
        background-size: cover;
    }

    .article-header h1 {
        font-weight: 700;
        font-size: 2.8rem;
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        position: relative;
        z-index: 1;
    }

    .article-meta {
        font-size: 1rem;
        color: #f0f0f0;
        position: relative;
        z-index: 1;
    }

    .article-meta i {
        margin-right: 5px;
        color: #ffd700;
    }

    /* ===== ARTICLE CONTAINER ===== */
    .article-container {
        background: #fff;
        padding: 40px;
        margin-top: -30px;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        position: relative;
        z-index: 2;
    }

    /* ===== IMAGE PRINCIPALE - CORRECTION DU DÉBORDEMENT ===== */
    .article-image-wrapper {
        width: 100%;
        max-height: 500px;
        overflow: hidden;
        border-radius: 16px;
        margin-bottom: 30px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        position: relative;
    }

    .article-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;
        transition: transform 0.3s ease;
    }

    .article-image-wrapper:hover img {
        transform: scale(1.05);
    }

    /* ===== CONTENU DE L'ARTICLE ===== */
    .article-content {
        line-height: 2;
        color: #2d3748;
        font-size: 1.1rem;
    }

    /* Formatage du contenu HTML */
    .article-content h1,
    .article-content h2,
    .article-content h3,
    .article-content h4,
    .article-content h5,
    .article-content h6 {
        font-weight: 700;
        margin-top: 30px;
        margin-bottom: 15px;
        color: #1a202c;
    }

    .article-content h1 { font-size: 2.2rem; }
    .article-content h2 { font-size: 1.8rem; }
    .article-content h3 { font-size: 1.5rem; }

    .article-content p {
        margin-bottom: 20px;
        text-align: justify;
    }

    .article-content strong {
        font-weight: 700;
        color: #10b981;
    }

    .article-content em {
        font-style: italic;
        color: #4a5568;
    }

    .article-content ul,
    .article-content ol {
        margin: 20px 0;
        padding-left: 30px;
    }

    .article-content li {
        margin-bottom: 10px;
    }

    .article-content a {
        color: #10b981;
        text-decoration: underline;
        transition: color 0.3s;
    }

    .article-content a:hover {
        color: #059669;
    }

    .article-content blockquote {
        border-left: 4px solid #10b981;
        padding-left: 20px;
        margin: 30px 0;
        font-style: italic;
        color: #4a5568;
        background: #f7fafc;
        padding: 20px;
        border-radius: 8px;
    }

    /* Images dans le contenu - CORRECTION */
    .article-content img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 30px auto;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    /* ===== TAGS ===== */
    .tags-section {
        margin-top: 30px;
        padding-top: 30px;
        border-top: 2px solid #e2e8f0;
    }

    .tag-badge {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
        font-size: 0.9rem;
        border-radius: 25px;
        padding: 8px 18px;
        margin: 5px;
        display: inline-block;
        transition: transform 0.2s, box-shadow 0.2s;
        text-decoration: none;
    }

    .tag-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        color: #fff;
    }

    /* ===== BOUTONS DE PARTAGE ===== */
    .share-section {
        background: #f7fafc;
        padding: 25px;
        border-radius: 12px;
        margin-top: 40px;
    }

    .btn-green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border-radius: 30px;
        padding: 12px 30px;
        transition: all 0.3s;
        border: none;
        font-weight: 600;
    }

    .btn-green:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .social-btn {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 5px;
        transition: all 0.3s;
        border: 2px solid #cbd5e0;
        color: #4a5568;
    }

    .social-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .social-btn.facebook:hover {
        background: #3b5998;
        border-color: #3b5998;
        color: white;
    }

    .social-btn.twitter:hover {
        background: #1da1f2;
        border-color: #1da1f2;
        color: white;
    }

    .social-btn.linkedin:hover {
        background: #0077b5;
        border-color: #0077b5;
        color: white;
    }

    .social-btn.whatsapp:hover {
        background: #25d366;
        border-color: #25d366;
        color: white;
    }

    /* ===== COMMENTAIRES ===== */
    .comment-section {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        padding: 35px;
        margin-top: 40px;
    }

    .comment {
        border-left: 4px solid #10b981;
        padding: 20px;
        margin-bottom: 20px;
        background: #f7fafc;
        border-radius: 8px;
        transition: all 0.3s;
    }

    .comment:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transform: translateX(5px);
    }

    .comment-author {
        font-weight: 600;
        color: #10b981;
        margin-bottom: 5px;
    }

    /* ===== SIDEBAR ===== */
    .sidebar {
        background: #fff;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        margin-bottom: 30px;
        transition: transform 0.3s;
    }

    .sidebar:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }

    .sidebar h5 {
        border-bottom: 3px solid #10b981;
        padding-bottom: 12px;
        margin-bottom: 25px;
        color: #10b981;
        font-weight: 700;
    }

    .recent-article-link {
        padding: 12px;
        border-radius: 8px;
        transition: all 0.3s;
        display: block;
        margin-bottom: 10px;
    }

    .recent-article-link:hover {
        background: #f7fafc;
        padding-left: 20px;
    }

    .author-card {
        text-align: center;
        padding: 20px;
    }

    .author-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        border: 4px solid #10b981;
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
        margin-bottom: 15px;
    }

    /* Formulaire de commentaire */
    .comment-form {
        background: #f7fafc;
        padding: 30px;
        border-radius: 12px;
        margin-top: 30px;
    }

    .form-control:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.25);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .article-header h1 {
            font-size: 2rem;
        }

        .article-container {
            padding: 25px;
        }

        .article-image-wrapper {
            max-height: 300px;
        }
    }
</style>

<!-- ===== HEADER ===== -->
<header class="article-header">
    <div class="container">
        <h1>{{ $article->titre ?? 'Article' }}</h1>
        <div class="article-meta">
            <i class="bi bi-person-circle"></i> {{ $article->author ?? 'Anonyme' }} &nbsp; | &nbsp;
            <i class="bi bi-calendar3"></i> {{ $article->created_at ? $article->created_at->format('d M Y') : date('d M Y') }} &nbsp; | &nbsp;
            <i class="bi bi-tag"></i> {{ $article->category->name ?? 'Non catégorisé' }}
        </div>
    </div>
</header>

<!-- ===== CONTENU ===== -->
<div class="container my-5">
    <div class="row g-4">
        <!-- Article Principal -->
        <div class="col-lg-8">
            <article class="article-container">
                
                <!-- IMAGE PRINCIPALE -->
                @if(isset($article->image_path) && !empty($article->image_path))
                    <div class="article-image-wrapper">
                        <img src="{{ asset('storage/' . $article->image_path) }}" 
                             alt="{{ $article->titre ?? 'Image article' }}"
                             loading="lazy">
                    </div>
                @endif

                <!-- CONTENU -->
                <div class="article-content">
                    {!! $article->content ?? '<p>Contenu non disponible.</p>' !!}
                </div>

                <!-- TAGS -->
                @if(isset($article->tags) && !empty($article->tags))
                    <div class="tags-section">
                        <h6 class="fw-bold mb-3"><i class="bi bi-tags-fill"></i> Mots-clés :</h6>
                        <div>
                            @php
                                $tagsList = explode(',', $article->tags);
                            @endphp
                            @foreach($tagsList as $tag)
                                @php
                                    $tag = trim($tag);
                                @endphp
                                @if(!empty($tag))
                                    <span class="tag-badge">
                                        #{{ $tag }}
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- PARTAGE / RETOUR -->
                <div class="share-section">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                        <a href="{{ route('blog.list') }}" class="btn btn-green">
                            <i class="bi bi-arrow-left-circle me-2"></i> Retour au blog
                        </a>

                        <div>
                            <span class="me-2 fw-bold text-muted">Partager :</span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                               target="_blank" 
                               class="social-btn facebook"
                               aria-label="Partager sur Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->titre ?? 'Article') }}" 
                               target="_blank" 
                               class="social-btn twitter"
                               aria-label="Partager sur Twitter">
                                <i class="bi bi-twitter"></i>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($article->titre ?? 'Article') }}" 
                               target="_blank" 
                               class="social-btn linkedin"
                               aria-label="Partager sur LinkedIn">
                                <i class="bi bi-linkedin"></i>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode(($article->titre ?? 'Article') . ' ' . url()->current()) }}" 
                               target="_blank" 
                               class="social-btn whatsapp"
                               aria-label="Partager sur WhatsApp">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </article>

          
        </div>

        <!-- Sidebar -->
        <aside class="col-lg-4">
            <!-- Carte Auteur -->
            <div class="sidebar">
                <h5><i class="bi bi-person-badge-fill"></i> À propos de l'auteur</h5>
                <div class="author-card">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($article->author ?? 'Auteur') }}&background=10b981&color=fff&size=200"
                         class="author-avatar" 
                         alt="{{ $article->author ?? 'Auteur' }}">
                    <h6 class="mb-1 fw-bold">{{ $article->author ?? 'Auteur' }}</h6>
                    <small class="text-muted">Ingénieur Agronome</small>
                    <p class="mt-3 small text-muted">Formateur , Passionné par le partage de connaissances et la création de contenu de qualité en Agriculture , Elevage ,etc.....</p>
                </div>
            </div>

            <!-- Articles récents -->
            @if(isset($recentArticles) && count($recentArticles) > 0)
            <div class="sidebar">
                <h5><i class="bi bi-newspaper"></i> Articles récents</h5>
                <nav>
                    <ul class="list-unstyled">
                        @foreach($recentArticles as $recent)
                            <li>
                                <a href="{{ route('articles.show', $recent->id) }}" 
                                   class="recent-article-link text-decoration-none text-dark">
                                    <i class="bi bi-chevron-right text-primary"></i> 
                                    {{ Str::limit($recent->titre ?? 'Article', 45) }}
                                    <br>
                                    <small class="text-muted">{{ $recent->created_at ? $recent->created_at->format('d M Y') : '' }}</small>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            </div>
            @endif

            <!-- Catégories -->
            
        </aside>
    </div>
</div>
@endsection