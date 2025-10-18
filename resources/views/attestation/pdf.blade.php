<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Attestation de Formation</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            text-align: center;
            padding: 50px;
        }
        .certificat {
            border: 10px solid #558B2F;
            padding: 40px;
            max-width: 800px;
            margin: auto;
        }
        h1 {
            color: #558B2F;
            font-size: 32px;
        }
        .details {
            margin-top: 30px;
            font-size: 18px;
        }
        .footer {
            margin-top: 60px;
            font-size: 14px;
            color: gray;
        }
    </style>
</head>
<body>
    <div class="certificat">
        <h1>Attestation de Formation</h1>
        <p>Ce certificat est décerné à :</p>
        <h2>{{ $user->name }}</h2>

        <div class="details">
            <p>Pour avoir complété avec succès la formation :</p>
            <h3>{{ $formation->titre }}</h3>
            <p>Date de délivrance : {{ $date }}</p>
        </div>

        <div class="footer">
            <p>Plateforme de formation en ligne - {{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>
