<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('paiements', function (Blueprint $table) {
            // Ajouter la colonne order_id (nullable car certains paiements sont pour des formations)
            $table->foreignId('order_id')->nullable()->after('formation_id')->constrained()->onDelete('cascade');
            
            // Ajouter le type de paiement
            $table->enum('type', ['formation', 'order'])->default('formation')->after('order_id');
            
            // Modifier formation_id pour être nullable
            $table->unsignedBigInteger('formation_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('paiements', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropColumn(['order_id', 'type']);
        });
    }
};