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
        
        .article-header {
            background-color: var(--primary-color);
            color: white;
            padding: 80px 0;
            margin-bottom: 40px;
        }
        
        .article-meta {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .article-meta img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        
        .card {
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
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
        
        .article-content {
            line-height: 1.8;
            font-size: 1.1rem;
        }
        
        .article-content img {
            border-radius: 8px;
            margin: 30px 0;
        }
        
        .article-content blockquote {
            border-left: 4px solid var(--primary-color);
            padding-left: 20px;
            margin: 30px 0;
            font-style: italic;
            color: #555;
        }
        
        .social-share a {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            border-radius: 50%;
            color: white;
            margin-right: 10px;
        }
        
        .social-share .facebook { background-color: #3b5998; }
        .social-share .twitter { background-color: #1da1f2; }
        .social-share .linkedin { background-color: #0077b5; }
        
        .comment-form {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
        }
        
        .instructor-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }
    </style>
     <!-- En-tête de l'article -->
    <div class="article-header">
        
        <div class="article-header bg-success text-white py-5 mb-4">
            <div class="container text-center">
                <h1 class="fw-bold">{{ $article->titre }}</h1>
                <p class="lead mb-0">Par {{ $article->author }} — {{ $article->created_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>
     


    <!-- Contenu principal -->
    <div class="container">
        <div class="row">
            <!-- Colonne principale -->
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <img src="{{ asset('storage/'.$article->image_path) }}" class="img-fluid rounded " alt="{{ $article->titre }}">
                    <article class="article-content">
                        {!! $article->content !!}
                    </article>

                    <div class="mt-4">
                        <a href="{{ route('blog.articles', $article->category->id) }}" class="btn btn-outline-success">
                            <i class="bi bi-arrow-left"></i> Retour à {{ $article->category->name }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        </div>
    </div>

    
@endsection
