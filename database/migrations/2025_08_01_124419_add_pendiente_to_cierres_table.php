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
        Schema::table('cierres', function (Blueprint $table) {
            $table->boolean('pendiente')->default(true);
        });
    }

    public function down()
    {
        Schema::table('cierres', function (Blueprint $table) {
            $table->dropColumn('pendiente');
        });
    }
};
