<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécuter les migrations.
     */
    public function up(): void
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();

            // Relation avec l'utilisateur (client)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Informations de la commande
            $table->string('mode_livraison')->nullable(); // ex: 'standard', 'express'
            $table->dateTime('date_commande')->default(now());
            $table->string('statut')->default('en_attente'); // ex: en_attente, validée, livrée, annulée
            $table->string('address')->nullable();
            $table->string('telephone_number')->nullable();

            // Prix total de la commande
            $table->decimal('price_total_order', 10, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Annuler les migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
