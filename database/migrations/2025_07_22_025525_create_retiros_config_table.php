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
        Schema::create('retiros_config', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->decimal('monto_min', 10, 2);
            $table->decimal('monto_max', 10, 2);
            $table->decimal('comision', 10, 2);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retiros_config');
    }
};
