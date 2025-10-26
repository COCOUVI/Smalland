<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Supprime d’abord la contrainte de clé étrangère
            $table->dropForeign(['paiement_id']);

            // Puis supprime la colonne
            $table->dropColumn('paiement_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // On recrée la colonne
            $table->unsignedBigInteger('paiement_id')->nullable();

            // Et on rétablit la clé étrangère si besoin
            $table->foreign('paiement_id')->references('id')->on('paiements')->onDelete('cascade');
        });
    }
};
