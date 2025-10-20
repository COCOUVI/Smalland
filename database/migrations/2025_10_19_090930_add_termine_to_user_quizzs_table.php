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
    Schema::table('user__quizzs', function (Blueprint $table) {
        $table->boolean('termine')->default(false)->after('score');
    });
}

public function down()
{
    Schema::table('user__quizzs', function (Blueprint $table) {
        $table->dropColumn('termine');
    });
}
};
