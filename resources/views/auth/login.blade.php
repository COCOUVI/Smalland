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
                    <input type="email" class="form-control" id="email" name="email"
                           placeholder="Entrez votre email" required>
                </div>

                <!-- Champ mot de passe avec bouton voir/cacher -->
                <div class="form-group mb-3">
                    <label for="password" class="fw-bold">Mot de passe</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="Mot de passe" required>
                        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-success w-100">Se connecter</button>
            </form>

            <!-- Lien mot de passe oublié -->
            <div class="text-center mt-3">
                <a href="{{ route('password.request') }}" class="text-decoration-none">
                    Mot de passe oublié ?
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Script pour voir/cacher le mot de passe -->
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        let pwd = document.getElementById('password');
        let icon = this.querySelector('i');
        if (pwd.type === 'password') {
            pwd.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            pwd.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });
</script>
@endsection
