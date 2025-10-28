<!DOCTYPE html> 
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vérification de votre e-mail</title>
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
        .logo {
            max-width: 100px;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            padding: 14px 25px;
            background: #2563eb;
            color: #ffffff !important; /* texte blanc */
            font-weight: bold;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
            font-size: 16px;
        }
        .btn:hover {
            background: #1d4ed8;
        }
    </style>
</head>
<body>
    <div class="card">
        <!-- Logo -->
        <img src="{{ asset('images/tree.png') }}" alt="Logo" class="logo">

        <h2>Bonjour {{ $user->prenom ?? $user->name }},</h2>
        <p>Merci de vous être inscrit sur <strong>{{ config('app.name') }}</strong> !</p>
        <p>Veuillez confirmer votre adresse e-mail en cliquant sur le bouton ci-dessous :</p>

        <!-- Bouton amélioré -->
        <a href="{{ $url }}" class="btn">Vérifier mon e-mail</a>

        <p style="margin-top: 20px;">Si vous n’avez pas créé de compte, ignorez simplement ce message.</p>
        <p>À bientôt,<br>L’équipe {{ config('app.name') }}</p>
    </div>
</body>
</html>
