<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation de paiement - Small Land</title>
    <!-- Icônes Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f9f6;
            color: #333;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            background-color: #ffffff;
            border-radius: 10px;
            margin: auto;
            overflow: hidden;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #28a745; /* ✅ Vert Small Land */
            color: white;
            text-align: center;
            padding: 25px;
        }
        .header i {
            font-size: 2rem;
            margin-bottom: 5px;
        }
        .header h1 {
            font-size: 1.5rem;
            margin: 0;
        }
        .content {
            padding: 20px;
        }
        .btn {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }
        .btn:hover {
            background-color: #218838;
        }
        .footer {
            text-align: center;
            font-size: 0.9rem;
            color: #777;
            padding: 15px;
            border-top: 1px solid #eee;
        }
        @media (max-width: 600px) {
            .header h1 {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- HEADER avec icône 🌳 -->
        <div class="header">
            <i class="bi bi-tree-fill"></i>
            <h1>Small Land</h1>
        </div>

        <!-- CONTENU -->
        <div class="content">
            <h2>Bonjour {{ $user->name }},</h2>
            <p>Félicitations 🎉 ! Votre paiement pour la formation <strong>{{ $formation->titre }}</strong> a été confirmé avec succès.</p>

            <p>Vous pouvez dès maintenant accéder à votre espace étudiant pour commencer votre apprentissage.</p>

            <p style="text-align: center; margin-top: 20px;">
                <a href="{{ url('/espace-etudiant') }}" class="btn">Accéder à ma formation</a>
            </p>
        </div>

        <!-- PIED DE PAGE -->
        <div class="footer">
            © {{ date('Y') }} Small Land 🌳 — Merci pour votre confiance.
        </div>
    </div>
</body>
</html>
