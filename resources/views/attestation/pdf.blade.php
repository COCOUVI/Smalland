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
            background-color: #f8f9fa;
        }

        .certificat {
            border: 8px double #558B2F;
            padding: 60px 40px;
            max-width: 850px;
            margin: auto;
            background-color: white;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }

        h1 {
            color: #558B2F;
            font-size: 38px;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        h2 {
            font-size: 26px;
            margin-top: 10px;
            color: #333;
        }

        h3 {
            font-size: 22px;
            color: #444;
            margin-top: 10px;
        }

        .details {
            margin-top: 40px;
            font-size: 18px;
            color: #555;
        }

        .footer {
            margin-top: 60px;
            font-size: 14px;
            color: #888;
        }

        .signature {
            margin-top: 80px;
            text-align: right;
            font-style: italic;
            color: #333;
            font-size: 16px;
        }

        .line {
            width: 200px;
            border-top: 1px solid #333;
            margin-right: 0;
            float: right;
        }

        .platform-name {
            margin-top: 20px;
            font-size: 16px;
            font-weight: bold;
            color: #558B2F;
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

        <div class="signature">
            <div class="line"></div>
            Signature
        </div>

        <div class="platform-name">
            Délivré par la plateforme <strong>Small Land</strong>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} - Tous droits réservés</p>
        </div>
    </div>
</body>
</html>
