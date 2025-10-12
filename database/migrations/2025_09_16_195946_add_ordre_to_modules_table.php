<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->integer('ordre')->nullable()->after('id'); // ou après un autre champ pertinent
        });
    }

    public function down()
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn('ordre');
        });
    }
};
