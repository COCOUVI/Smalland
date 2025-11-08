<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #2e7d32;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 30px;
            border: 1px solid #ddd;
        }
        .order-details {
            background-color: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
            border: 1px solid #e0e0e0;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            color: white;
        }
        .status-confirmed { background-color: #28a745; }
        .status-processing { background-color: #007bff; }
        .status-shipped { background-color: #6f42c1; }
        .status-delivered { background-color: #28a745; }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: #2e7d32;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            color: #666;
            font-size: 12px;
            margin-top: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Smalland</h1>
            <p>Mise à jour de votre commande</p>
        </div>

        <div class="content">
            <h2>Bonjour {{ $order->user->name }},</h2>
            
            <p>Le statut de votre commande <strong>{{ $order->order_code }}</strong> a été mis à jour.</p>

            <div class="order-details">
                <h3>Statut de la commande</h3>
                
                @if($newStatus === 'confirmed')
                    <span class="status-badge status-confirmed">✓ Commande Confirmée</span>
                    <p style="margin-top: 15px;">
                        Votre commande a été confirmée et est en cours de traitement. 
                        Nous préparons vos articles avec soin.
                    </p>
                @elseif($newStatus === 'processing')
                    <span class="status-badge status-processing">📦 En Préparation</span>
                    <p style="margin-top: 15px;">
                        Votre commande est actuellement en cours de préparation. 
                        Ils seront bientôt expédiés !
                    </p>
                @elseif($newStatus === 'shipped')
                    <span class="status-badge status-shipped">🚚 Expédiée</span>
                    <p style="margin-top: 15px;">
                        Bonne nouvelle ! Votre commande a été expédiée et est en route vers vous.
                    </p>
                @elseif($newStatus === 'delivered')
                    <span class="status-badge status-delivered">✓ Livrée</span>
                    <p style="margin-top: 15px;">
                        Votre commande a été livrée avec succès ! 
                        Nous espérons que vous êtes satisfait de votre achat.
                    </p>
                @endif

                <hr style="margin: 20px 0;">

                <table>
                    <tr>
                        <td><strong>Numéro de commande</strong></td>
                        <td>{{ $order->order_code }}</td>
                    </tr>
                    <tr>
                        <td><strong>Date de commande</strong></td>
                        <td>{{ $order->created_at->format('d/m/Y à H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Montant total</strong></td>
                        <td><strong>{{ number_format($order->price_total_order, 0, ',', ' ') }} FCFA</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Mode de livraison</strong></td>
                        <td>
                            @if($order->mode_livraison == 'standard')
                                Livraison Standard
                            @elseif($order->mode_livraison == 'express')
                                Livraison Express
                            @else
                                Retrait en magasin
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <div style="text-align: center;">
                <a href="{{ route('orders.show', $order->id) }}" class="btn">
                    Voir ma commande
                </a>
            </div>

            <p style="margin-top: 30px;">
                Si vous avez des questions concernant votre commande, 
                n'hésitez pas à nous contacter.
            </p>

            <p>
                Cordialement,<br>
                <strong>L'équipe Smalland</strong>
            </p>
        </div>

        <div class="footer">
            <p>
                Cet email a été envoyé automatiquement. Merci de ne pas y répondre.<br>
                © {{ date('Y') }} Smalland. Tous droits réservés.
            </p>
        </div>
    </div>
</body>
</html>