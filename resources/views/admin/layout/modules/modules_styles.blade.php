<style>
    /* ============================
       STYLES DES CARTES MODULES
    ============================ */
    .card-module {
        transition: transform 0.2s, box-shadow 0.2s;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.08);
    }

    .card-module:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
    }

    .card-module .card-header {
        padding: 12px 15px 0;
    }

    /* ============================
       ACTIONS ET BOUTONS
    ============================ */
    .module-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        justify-content: center;
    }

    .btn-action {
        min-width: 40px;
    }

    .btn:focus {
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    /* ============================
       CONTENU DES MODULES
    ============================ */
    .module-info {
        padding: 15px;
    }

    .module-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 12px;
        line-height: 1.4;
    }

    .module-details {
        color: #666;
        font-size: 0.9rem;
    }

    /* ============================
       BADGES
    ============================ */
    .badge-ordre {
        background-color: #6c757d;
        color: white;
    }

    .badge-formation {
        background-color: #0d6efd;
        color: white;
        font-weight: 500;
    }

    /* ============================
       MODALS
    ============================ */
    .modal-content {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        border-radius: 15px 15px 0 0;
    }

    .modal-lg {
        max-width: 600px;
    }

    /* ============================
       ANIMATIONS DE SUPPRESSION
    ============================ */
    .module-card.deleting {
        opacity: 0.5;
        transform: scale(0.95);
        transition: all 0.3s ease;
    }

    .module-card.deleted {
        opacity: 0;
        transform: scale(0.8) translateY(-20px);
        transition: all 0.5s ease;
    }

    /* ============================
       ÉTATS DE CHARGEMENT
    ============================ */
    .btn-delete.loading {
        position: relative;
        color: transparent !important;
    }

    .btn-delete.loading::after {
        content: "";
        position: absolute;
        width: 16px;
        height: 16px;
        top: 50%;
        left: 50%;
        margin-left: -8px;
        margin-top: -8px;
        border-radius: 50%;
        border: 2px solid transparent;
        border-top-color: #ffffff;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* ============================
       ZONES D'UPLOAD
    ============================ */
    .upload-zone {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .upload-zone:hover {
        border-color: #0d6efd;
        background-color: #f8f9ff;
    }

    .upload-placeholder {
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        min-height: 120px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .upload-placeholder:hover .upload-icon i {
        color: #0d6efd !important;
        transform: scale(1.1);
        transition: all 0.3s ease;
    }

    .upload-preview {
        display: none;
    }

    /* ============================
       RESPONSIVE - TABLETTES ET MOBILES
    ============================ */
    @media (max-width: 768px) {
        .container {
            padding-left: 12px;
            padding-right: 12px;
        }

        .card-module {
            margin-bottom: 16px;
            border-radius: 10px;
        }

        .module-title {
            font-size: 1.1rem;
        }

        .module-actions {
            margin-top: 16px;
            gap: 6px;
        }

        .module-actions .btn {
            padding: 0.35rem 0.7rem;
            font-size: 0.85rem;
            border-radius: 6px;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
        }

        .alert {
            margin: 0.5rem;
            border-radius: 8px;
        }

        /* Upload zones responsives */
        .upload-placeholder {
            padding: 1.5rem;
            min-height: 100px;
        }

        .upload-placeholder .fa-3x {
            font-size: 2rem !important;
        }
    }

    /* ============================
       RESPONSIVE - TRÈS PETITS ÉCRANS
    ============================ */
    @media (max-width: 480px) {
        .module-title {
            font-size: 1rem;
        }

        .module-actions .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }

        .upload-placeholder {
            padding: 1rem;
            min-height: 80px;
        }

        .modal-dialog {
            margin: 0.5rem;
        }
    }

    /* ============================
       ANIMATIONS D'ENTRÉE
    ============================ */
    .card-module {
        animation: fadeInUp 0.5s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ============================
       AMÉLIORATIONS VISUELLES
    ============================ */
    .card-module .card-body {
        position: relative;
    }

    .card-module .card-footer {
        background: linear-gradient(to right, #f8f9fa, #ffffff);
    }

    /* États hover pour les boutons d'action */
    .btn-action:hover {
        transform: scale(1.1);
        transition: transform 0.2s ease;
    }

    /* Progress bars personnalisées */
    .progress {
        height: 6px;
        border-radius: 3px;
    }

    .progress-bar {
        border-radius: 3px;
        transition: width 0.3s ease;
    }

    /* Amélioration des alertes */
    .alert {
        border-left: 4px solid;
        border-radius: 0.375rem;
    }

    .alert-success {
        border-left-color: #198754;
    }

    .alert-danger {
        border-left-color: #dc3545;
    }

    .alert-info {
        border-left-color: #0dcaf0;
    }
</style>
