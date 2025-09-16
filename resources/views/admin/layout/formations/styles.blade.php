<style>
    /* Styles pour améliorer l'expérience mobile */
    @media (max-width: 768px) {
        .container {
            padding-left: 10px;
            padding-right: 10px;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        .card {
            margin-bottom: 10px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .gap-1 {
            gap: 0.25rem !important;
        }
    }

    /* Styles pour le tableau desktop */
    .table {
        border-collapse: separate;
        border-spacing: 0;
    }

    .table th {
        border-top: 1px solid #dee2e6;
        border-bottom: 2px solid #dee2e6;
        background-color: #f8f9fa;
        font-weight: 600;
        padding: 12px 8px;
    }

    .table td {
        padding: 12px 8px;
        border-bottom: 1px solid #e9ecef;
        vertical-align: middle;
    }

    .table tr:last-child td {
        border-bottom: none;
    }

    .table tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }

    /* Amélioration de l'accessibilité */
    .btn:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    /* Style pour les cartes mobiles */
    .card {
        transition: transform 0.2s;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    /* Styles pour les modales */
    .modal-header {
        border-bottom: 1px solid #dee2e6;
        background-color: #f8f9fa;
    }

    .modal-footer {
        border-top: 1px solid #dee2e6;
        background-color: #f8f9fa;
    }

    /* Animation pour la suppression */
    .fade-out {
        opacity: 0 !important;
        transform: scale(0.95);
        transition: all 0.3s ease-out;
    }

    /* Amélioration du bouton de suppression */
    #confirmDeleteBtn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Animation des alertes */
    .alert {
        animation: slideInDown 0.3s ease-out;
    }

    @keyframes slideInDown {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>
