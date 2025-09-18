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
.modal-content {
    border: none;
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    overflow: hidden;
    background: #ffffff;
}

.modal-header {
    background: #3b82f6;
    color: white;
    padding: 24px 32px;
    border-bottom: none;
    position: relative;
}

.modal-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin: 0;
    letter-spacing: -0.025em;
}

.modal-close {
    position: absolute;
    right: 24px;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.2);
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    cursor: pointer;
    transition: all 0.2s ease;
}

.modal-close:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-50%) scale(1.1);
}

.modal-body {
    padding: 32px;
    background: #fafbfc;
}

.module-item {
    margin-bottom: 16px;
}

.module-input-group {
    display: flex;
    align-items: center;
    background: #fff;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    padding: 0 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    transition: border 0.2s ease;
}

.module-input-group:focus-within {
    border-color: #3b82f6;
}
.module-input {
    flex: 1;
    border: none;
    outline: none;
    font-size: 14px;
    padding: 10px 8px;
    background: transparent;
    color: #1f2937;
}
.module-input::placeholder {
    color: #a0aec0;
}

.remove-module-btn {
    background: none;
    border: none;
    color: #9ca3af;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 6px;
    border-radius: 50%;
    cursor: pointer;
    transition: color 0.2s ease, background-color 0.2s ease;
}

.remove-module-btn:hover {
    background-color: #fee2e2;
    color: #dc2626;
}

.add-module-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #3b82f6;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-top: 16px;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.add-module-btn:hover {
    background: #2563eb;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
}

.modal-footer {
    background: white;
    padding: 24px 32px;
    border-top: 1px solid #e1e8ed;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}

.btn-secondary {
    background: #e2e8f0;
    color: #4a5568;
    border: none;
    padding: 12px 24px;
    border-radius: 10px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-secondary:hover {
    background: #cbd5e0;
    transform: translateY(-1px);
}

.btn-primary {
    background: #22c55e;
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 10px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
}

.btn-primary:hover {
    background: #16a34a;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(34, 197, 94, 0.4);
}

/* Responsive */
@media (max-width: 576px) {
    .modal-header,
    .modal-body,
    .modal-footer {
        padding: 20px;
    }

    .modal-title {
        font-size: 1.25rem;
    }

    .module-input-group {
        flex-direction: column;
        gap: 8px;
    }

    .remove-module-btn {
        align-self: flex-end;
        margin-right: 0;
    }
}

/* Animation d'entrée */
.modal.fade .modal-dialog {
    transform: translate(0, -50px);
    transition: all 0.3s ease-out;
}

.modal.show .modal-dialog {
    transform: translate(0, 0);
}




#addModuleModal .modal-content {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        #addModuleModal .modal-header {
            border-bottom: 1px solid #f0f0f0;
            padding: 20px 24px;
            background: #fff;
        }

        #addModuleModal .modal-title {
            font-weight: 500;
            font-size: 1.25rem;
            color: #333;
        }

        #addModuleModal .modal-close {
            background: none;
            border: none;
            padding: 4px;
            opacity: 0.6;
            transition: opacity 0.2s;
        }

        #addModuleModal .modal-close:hover {
            opacity: 1;
        }

        #addModuleModal .modal-body {
            padding: 24px;
        }

        #addModuleModal #modulesContainer {
            margin-bottom: 16px;
        }

        #addModuleModal .module-item {
            margin-bottom: 12px;
        }

        #addModuleModal .module-input-group {
            display: flex;
            align-items: center;
            position: relative;
        }

        #addModuleModal .module-input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.2s;
            background: #fafafa;
        }

        #addModuleModal .module-input:focus {
            outline: none;
            border-color: #888;
            background: #fff;
        }

        #addModuleModal .remove-module-btn {
            position: absolute;
            right: 8px;
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
            padding: 4px;
            transition: color 0.2s;
        }

        #addModuleModal .remove-module-btn:hover {
            color: #ff4d4d;
        }

        #addModuleModal #addModuleField {
            display: flex;
            align-items: center;
            gap: 6px;
            background: none;
            border: 1px dashed #ccc;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 13px;
            color: #666;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 8px;
        }

        #addModuleModal #addModuleField:hover {
            border-color: #888;
            color: #333;
        }

        #addModuleModal .modal-footer {
            border-top: 1px solid #f0f0f0;
            padding: 20px 24px;
            background: #fff;
        }

        #addModuleModal .btn-secondary {
            background: none;
            border: 1px solid #e0e0e0;
            color: #666;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.2s;
        }

        #addModuleModal .btn-secondary:hover {
            background: #f5f5f5;
        }

        #addModuleModal .btn-primary {
            background: #333;
            border: none;
            color: #fff;
            padding: 8px 20px;
            border-radius: 6px;
            font-size: 14px;
            transition: background 0.2s;
        }

        #addModuleModal .btn-primary:hover {
            background: #000;
        }

        #addModuleModal #ajaxAlert {
            margin-bottom: 16px;
        }

        /* Animation pour la suppression des modules */
        .module-item.fade-out {
            opacity: 0;
            transform: translateX(-10px);
            transition: all 0.3s ease;
        }

</style>
