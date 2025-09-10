@extends('master')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg" style="width: 400px;">

        
        <!-- En-tête verte -->
        <div class="card-header bg-success text-white text-center">
            <h4 class="mb-0">Connexion</h4>
        </div>

        <!-- Formulaire -->
        <div class="card-body">
             @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="email" class="fw-bold">Adresse Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Entrez votre email" required>
                </div>

                <div class="form-group mb-3">
                    <label for="password"  class="fw-bold">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe">
                </div>

                <button type="submit" class="btn btn-success w-100">Se connecter</button>
            </form>
        </div>
    </div>
</div>
@endsection

