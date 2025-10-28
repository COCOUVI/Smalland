<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réinitialisation du mot de passe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            color: #333;
            padding: 40px;
        }
        .card {
            background: #fff;
            border-radius: 8px;
            padding: 30px;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .btn {
            display: inline-block;
            padding: 14px 25px;
            background: #16a34a;
            color: #fff !important;
            font-weight: bold;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
            font-size: 16px;
        }
        .btn:hover {
            background: #138a3d;
        }
        .logo {
            max-width: 100px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="card">
        <img src="{{ asset('images/tree.png') }}" alt="Logo" class="logo">
        <h2>Bonjour {{ $user->prenom ?? $user->name }},</h2>
        <p>Vous avez demandé la réinitialisation de votre mot de passe pour <strong>{{ config('app.name') }}</strong>.</p>
        <p>Cliquez sur le bouton ci-dessous pour définir un nouveau mot de passe :</p>
        <a href="{{ $url }}" class="btn">Réinitialiser mon mot de passe</a>
        <p style="margin-top: 20px;">Si vous n’avez pas demandé cette réinitialisation, ignorez simplement ce message.</p>
        <p>À bientôt,<br>L’équipe {{ config('app.name') }}</p>
    </div>
</body>
</html>
