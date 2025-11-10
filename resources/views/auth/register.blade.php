@extends('master')

@section('content')
<div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 80vh; background-color: #f0f8ff; margin-top:40px">
    <div class="card border-0 shadow-sm " style="width: 100%; max-width: 500px; background-color: white; padding: 2rem; border-radius: 8px; ">
        <h4 class="text-center mb-4 fw-bold" style="color: #2e7d32;">Création de compte</h4>

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="nom" class="form-label" style="color: #666; font-weight: 500;">Nom <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nom" name="nom"
                           placeholder="Doe" required style="border-color: #ddd; border-radius: 6px; padding: 10px;">
                    @error('nom')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="prenom" class="form-label" style="color: #666; font-weight: 500;">Prénom <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="prenom" name="prenom"
                           placeholder="John" required style="border-color: #ddd; border-radius: 6px; padding: 10px;">
                    @error('prenom')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label" style="color: #666; font-weight: 500;">Adresse e-mail <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email"
                       placeholder="john.doe@exemple.com" required style="border-color: #ddd; border-radius: 6px; padding: 10px;">
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label" style="color: #666; font-weight: 500;">Mot de passe <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password"
                           placeholder="••••••••" required style="border-color: #ddd; border-radius: 6px; padding: 10px;">
                    <button type="button" class="btn btn-outline-secondary" id="togglePassword" style="border-radius: 0 6px 6px 0;">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label" style="color: #666; font-weight: 500;">Confirmer le mot de passe <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                           placeholder="••••••••" required style="border-color: #ddd; border-radius: 6px; padding: 10px;">
                    <button type="button" class="btn btn-outline-secondary" id="togglePasswordConfirm" style="border-radius: 0 6px 6px 0;">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('password_confirmation')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2" style="background-color: #2e7d32; border: none; font-weight: 500; border-radius: 6px;">
                S'inscrire
            </button>
        </form>
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

    document.getElementById('togglePasswordConfirm').addEventListener('click', () => {
        togglePasswordVisibility('password_confirmation', 'togglePasswordConfirm');
    });
</script>
@endsection
