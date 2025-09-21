@push('styles')
<style>
    /* Styles existants conservés */
    .question-item {
        transition: all 0.3s ease;
    }

    .question-item:hover {
        background-color: #f8f9fa;
    }

    .reponse-item {
        margin-bottom: 0.5rem;
    }

    .badge {
        font-size: 0.8em;
    }

    /* ✅ UNIQUEMENT LE NOUVEAU SYSTÈME DE NOTIFICATIONS ÉLÉGANTES */
    .custom-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 350px;
        max-width: 450px;
        padding: 16px 20px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 500;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        backdrop-filter: blur(10px);
        transform: translateX(100%);
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .custom-notification.show {
        transform: translateX(0);
        opacity: 1;
    }

    .custom-notification.hide {
        transform: translateX(100%);
        opacity: 0;
        pointer-events: none;
    }

    .custom-notification-success {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.95), rgba(22, 163, 74, 0.95));
        color: white;
        border-left: 4px solid #10b981;
    }

    .custom-notification-error {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.95), rgba(220, 38, 38, 0.95));
        color: white;
        border-left: 4px solid #ef4444;
    }

    .custom-notification i {
        font-size: 20px;
        flex-shrink: 0;
    }

    .custom-notification span {
        flex: 1;
        line-height: 1.4;
    }

    .notification-close {
        background: none;
        border: none;
        color: currentColor;
        cursor: pointer;
        padding: 4px;
        border-radius: 6px;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0.8;
    }

    .notification-close:hover {
        opacity: 1;
        background: rgba(255, 255, 255, 0.2);
    }

    .notification-close i {
        font-size: 16px;
    }

    /* Animation de progression pour l'auto-fermeture */
    .custom-notification::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 0 0 12px 12px;
        animation: notificationProgress 4s linear forwards;
    }

    @keyframes notificationProgress {
        from { width: 0%; }
        to { width: 100%; }
    }

    .custom-notification:hover::after {
        animation-play-state: paused;
    }

    /* Responsive pour les notifications */
    @media (max-width: 768px) {
        .custom-notification {
            left: 20px;
            right: 20px;
            min-width: auto;
            max-width: none;
            transform: translateY(-100%);
        }

        .custom-notification.show {
            transform: translateY(0);
        }

        .custom-notification.hide {
            transform: translateY(-100%);
        }
    }

    /* Masquer les anciennes alertes Bootstrap */
    #ajax-success,
    #ajax-error {
        display: none !important;
    }

    /* Animation de rotation pour les icônes de chargement uniquement */
    button[disabled] i.bi-hourglass-split {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>
@endpush
