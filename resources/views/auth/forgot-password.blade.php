@extends('master')

@section('content')
<div class="container" style="max-width: 500px; margin-top: 50px;">
    <div class="card" style="padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); text-align: center;">
        <h2>Réinitialisation du mot de passe</h2>

        @if (session('status'))
            <div class="alert alert-success" style="margin-top: 15px; color: #155724; background-color: #d4edda; border: 1px solid #c3e6cb; padding: 10px; border-radius: 6px;">
                {{ session('status') }}
            </div>
        @endif

        <p style="margin: 20px 0;">
            Entrez votre adresse e-mail et nous vous enverrons un lien pour réinitialiser votre mot de passe.
        </p>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group" style="margin-bottom: 15px; text-align: left;">
                <label for="email">Adresse e-mail</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="form-control" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;">
                
                @error('email')
                    <span class="text-danger" style="color: red; font-size: 14px;">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" 
                    class="btn" 
                    style="background-color: #16a34a; color: #ffffff; padding: 12px 25px; border-radius: 6px; font-weight: bold; margin-top: 10px;">
                Envoyer le lien de réinitialisation
            </button>
        </form>

        <p style="margin-top: 20px;">
            <a href="{{ route('login') }}" style="color: #16a34a; text-decoration: none; font-weight: bold;">Retour à la page de connexion</a>
        </p>
    </div>
</div>
@endsection

