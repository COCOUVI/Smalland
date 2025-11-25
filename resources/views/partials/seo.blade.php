{{-- 
    Fichier: resources/views/partials/seo.blade.php
    Description: Balises META pour le référencement SEO et réseaux sociaux
    
    Variables requises:
    - $article (objet avec: titre, content, author, tags, image_path, category, created_at, updated_at)
--}}

{{-- Balises META de base pour le SEO --}}
<meta name="description" content="{{ Str::limit(strip_tags($article->content ?? ''), 160) }}">
<meta name="keywords" content="{{ $article->tags ?? '' }}">
<meta name="author" content="{{ $article->author ?? '' }}">
<meta name="robots" content="index, follow">
<link rel="canonical" href="{{ url()->current() }}">

{{-- Open Graph pour Facebook et autres réseaux sociaux --}}
<meta property="og:type" content="article">
<meta property="og:title" content="{{ $article->titre ?? 'Article' }}">
<meta property="og:description" content="{{ Str::limit(strip_tags($article->content ?? ''), 200) }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:site_name" content="{{ config('app.name', 'Blog') }}">

@if(isset($article->image_path) && !empty($article->image_path))
<meta property="og:image" content="{{ asset('storage/' . $article->image_path) }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
@endif

<meta property="article:published_time" content="{{ $article->created_at ? $article->created_at->toIso8601String() : '' }}">
<meta property="article:modified_time" content="{{ $article->updated_at ? $article->updated_at->toIso8601String() : '' }}">
<meta property="article:author" content="{{ $article->author ?? '' }}">
<meta property="article:section" content="{{ $article->category->name ?? '' }}">

@if(isset($article->tags) && !empty($article->tags))
    @php
        $tagsList = explode(',', $article->tags);
    @endphp
    @foreach($tagsList as $tag)
        @php
            $tag = trim($tag);
        @endphp
        @if(!empty($tag))
<meta property="article:tag" content="{{ $tag }}">
        @endif
    @endforeach
@endif

{{-- Twitter Card pour Twitter --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $article->titre ?? 'Article' }}">
<meta name="twitter:description" content="{{ Str::limit(strip_tags($article->content ?? ''), 200) }}">

@if(isset($article->image_path) && !empty($article->image_path))
<meta name="twitter:image" content="{{ asset('storage/' . $article->image_path) }}">
@endif

{{-- Données structurées JSON-LD pour Google (Schema.org) --}}
<script type="application/ld+json">
@php
    $schemaData = [
        '@context' => 'https://schema.org',
        '@type' => 'BlogPosting',
        'headline' => $article->titre ?? '',
        'description' => Str::limit(strip_tags($article->content ?? ''), 200),
        'author' => [
            '@type' => 'Person',
            'name' => $article->author ?? ''
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => config('app.name', 'Blog'),
        ],
        'datePublished' => $article->created_at ? $article->created_at->toIso8601String() : '',
        'dateModified' => $article->updated_at ? $article->updated_at->toIso8601String() : '',
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id' => url()->current()
        ],
        'keywords' => $article->tags ?? '',
        'articleSection' => $article->category->name ?? ''
    ];
    
    // Ajouter l'image seulement si elle existe
    if (isset($article->image_path) && !empty($article->image_path)) {
        $schemaData['image'] = [
            '@type' => 'ImageObject',
            'url' => asset('storage/' . $article->image_path),
            'width' => 1200,
            'height' => 630
        ];
    }
@endphp
{!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>

{{-- Breadcrumb Schema pour Google --}}
<script type="application/ld+json">
@php
    $breadcrumbData = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => []
    ];
    
    // Ajouter l'accueil seulement si la route existe
    try {
        $breadcrumbData['itemListElement'][] = [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Accueil',
            'item' => url('/')
        ];
    } catch (\Exception $e) {
        // Si la route n'existe pas, on ignore
    }
    
    // Ajouter le blog
    try {
        $breadcrumbData['itemListElement'][] = [
            '@type' => 'ListItem',
            'position' => count($breadcrumbData['itemListElement']) + 1,
            'name' => 'Blog',
            'item' => route('blog.list')
        ];
    } catch (\Exception $e) {
        // Si la route n'existe pas, on ignore
    }
    
    // Ajouter l'article actuel
    $breadcrumbData['itemListElement'][] = [
        '@type' => 'ListItem',
        'position' => count($breadcrumbData['itemListElement']) + 1,
        'name' => Str::limit($article->titre ?? 'Article', 50),
        'item' => url()->current()
    ];
@endphp
{!! json_encode($breadcrumbData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>