@extends('Master')

@section('content')
<div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 80vh; background-color: #f0f8ff;">
    <div class="card border-0 shadow-sm" style="width: 100%; max-width: 500px; background-color: white; padding: 2rem; border-radius: 8px;">
        <h4 class="text-center mb-4 fw-bold" style="color: #2e7d32;">Connexion</h4>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label" style="color: #666; font-weight: 500;">Adresse e-mail <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email"
                       placeholder="exemple@domaine.com" required style="border-color: #ddd; border-radius: 6px; padding: 10px;">
            </div>

            <div class="mb-4">
                <label for="password" class="form-label" style="color: #666; font-weight: 500;">Mot de passe <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password"
                           placeholder="••••••••" required style="border-color: #ddd; border-radius: 6px; padding: 10px;">
                    <button type="button" class="btn btn-outline-secondary" id="togglePassword" style="border-radius: 0 6px 6px 0;">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2" style="background-color: #2e7d32; border: none; font-weight: 500; border-radius: 6px;">
                Se connecter
            </button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('password.request') }}" class="text-decoration-none" style="color: #666; font-size: 0.9rem;">
                Mot de passe oublié ?
            </a>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility(inputId, buttonId) {
        const input = document.getElementById(inputId);
        const button = document.getElementById(buttonId);
        const icon = button.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }

    document.getElementById('togglePassword').addEventListener('click', () => {
        togglePasswordVisibility('password', 'togglePassword');
    });
</script>
@endsection