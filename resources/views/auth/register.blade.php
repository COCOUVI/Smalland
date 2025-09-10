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
                        <label for="email" class="fw-bold">Adresse Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Entrez votre email" required>
                        @error('email')
                            <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="password" class="fw-bold">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Mot de passe" required>
                        @error('password')
                            <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="password_confirmation" class="fw-bold">Confirmation du mot de passe</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                            placeholder="Confirmez le mot de passe">
                        @error('password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success w-100">S'inscrire</button>
                </form>
            </div>
        </div>
    </div>
@endsection
