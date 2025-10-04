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
        Schema::create('user_lessons', function (Blueprint $table) {
            $table->id();
            
            // Clés étrangères
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');

            // Suivi de progression
            $table->boolean('terminee')->default(false); // true si la leçon est terminée
            $table->timestamp('terminee_at')->nullable(); // date de fin de la leçon


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_lessons');
    }
};
