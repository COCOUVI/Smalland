@extends('master')

@section('content')
<div class="page-header text-center text-white bg-success py-5 mb-5">
    <div class="container">
        <h1 class="display-5 fw-bold">Catégories du blog</h1>
        <p class="lead">Explorez nos articles par thématiques</p>
    </div>
</div>
@php
    $bgColors = ['#e0f7fa', '#e8f5e9', '#fce4ec', '#fff3e0', '#ede7f6', '#f3e5f5', '#e3f2fd'];
@endphp

<div class="container">
    <div class="row">
        @foreach($categories as $category)
        @php
            $randomColor = $bgColors[array_rand($bgColors)];
        @endphp
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="p-4 text-center shadow-sm rounded h-100"
                 style="background-color: {{ $randomColor }}; border: 10px solid {{ $randomColor }};">
                 
                {{-- Cercle avec fond blanc pour contraste --}}
                <div class="mb-3">
                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center"
                         style="width: 60px; height: 60px; background-color: white;">
                        <i class="bi bi-journal-text fs-3 text-dark"></i>
                    </div>
                </div>

                <h5 class="fw-bold">{{ $category->name }}</h5>
                <p class="text-muted">{{ $category->publications_count }} articles publiés</p>
                <a href="{{ route('blog.articles', $category->id) }}" class="btn btn-outline-dark btn-sm">Voir les articles</a>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
