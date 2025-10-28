@extends('master')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh; background-color: #f8f9fa;">
    <div class="card shadow-lg" style="width: 100%; max-width: 500px; border-radius: 15px;">
        <div class="card-body text-center p-4">
            <h3 class="card-title mb-3 text-primary">Vérification de l'adresse e-mail</h3>

            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success mt-2">
                    ✅ Un nouveau lien de vérification a été envoyé à votre adresse e-mail.
                </div>
            @endif

            <p class="mt-3">
                Avant de continuer, veuillez vérifier votre e-mail et cliquer sur le lien de confirmation.
                <br>
                Si vous n’avez pas reçu le message, vous pouvez demander un nouveau lien ci-dessous.
            </p>

            <form method="POST" action="{{ route('verification.send') }}" class="mt-4">
                @csrf
                <button type="submit" class="btn btn-primary w-100">
                    🔄 Renvoyer l’e-mail de vérification
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100">
                    🚪 Se déconnecter
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
