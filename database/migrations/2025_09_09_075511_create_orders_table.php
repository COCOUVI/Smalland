<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string("mode_livraison");
            $table->enum('status',['paid','delivered']);
            $table->string("addresse");
            $table->string('telephone');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('paiement_id')->constrained()->onDelete('cascade');
            $table->integer('price_total_order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
