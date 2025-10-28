@extends('master')

@section('content')
<div class="container" style="max-width: 500px; margin-top: 50px;">
    <div class="card" style="padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); text-align: center;">

        <!-- Logo -->
        <img src="{{ asset('images/tree.png') }}" alt="Logo" style="width: 90px; margin-bottom: 20px;">

        <h2 style="color: #16a34a;">Réinitialisation du mot de passe</h2>

        <p style="margin: 15px 0; color: #555;">
            Entrez votre nouvel e-mail et votre nouveau mot de passe ci-dessous.
        </p>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Jeton -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email -->
            <div class="form-group" style="margin-bottom: 15px; text-align: left;">
                <label for="email" style="font-weight: bold;">Adresse e-mail</label>
                <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus
                    class="form-control" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;">

                @error('email')
                    <span style="color: red; font-size: 14px;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Nouveau mot de passe -->
            <div class="form-group" style="margin-bottom: 15px; text-align: left;">
                <label for="password" style="font-weight: bold;">Nouveau mot de passe</label>
                <input id="password" type="password" name="password" required
                    class="form-control" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;">

                @error('password')
                    <span style="color: red; font-size: 14px;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirmer mot de passe -->
            <div class="form-group" style="margin-bottom: 15px; text-align: left;">
                <label for="password_confirmation" style="font-weight: bold;">Confirmer le mot de passe</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="form-control" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;">
            </div>

            <!-- Bouton -->
            <button type="submit"
                style="background-color: #16a34a; color: #fff; padding: 12px 25px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; margin-top: 10px;">
                Réinitialiser le mot de passe
            </button>
        </form>

        <p style="margin-top: 20px;">
            <a href="{{ route('login') }}" style="color: #16a34a; text-decoration: none;">Retour à la page de connexion</a>
        </p>
    </div>
</div>
@endsection
