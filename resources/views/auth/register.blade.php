@extends('master')
@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card shadow-lg" style="width: 400px;">

            <!-- En-tête verte -->
            <div class="card-header bg-success text-white text-center">
                <h4 class="mb-0">Inscription</h4>
            </div>

            <!-- Formulaire -->
            <div class="card-body">
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="nom" class="fw-bold">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom"
                               placeholder="Entrez votre nom" required>
                        @error('nom')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="prenom" class="fw-bold">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom"
                               placeholder="Entrez votre prénom" required>
                        @error('prenom')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="email" class="fw-bold">Adresse Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                               placeholder="Entrez votre email" required>
                        @error('email')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Mot de passe avec bouton voir/cacher -->
                    <div class="form-group mb-3">
                        <label for="password" class="fw-bold">Mot de passe</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="Mot de passe" required>
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('password')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirmation mot de passe avec bouton voir/cacher -->
                    <div class="form-group mb-3">
                        <label for="password_confirmation" class="fw-bold">Confirmation du mot de passe</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                                   placeholder="Confirmez le mot de passe" required>
                            <button type="button" class="btn btn-outline-secondary" id="togglePasswordConfirm">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success w-100">S'inscrire</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Script pour afficher/cacher le mot de passe -->
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

        document.getElementById('togglePasswordConfirm').addEventListener('click', function () {
            let pwd = document.getElementById('password_confirmation');
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
