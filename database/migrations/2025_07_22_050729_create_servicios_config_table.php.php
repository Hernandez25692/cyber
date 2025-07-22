<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('servicios_config', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_servicio_id')->constrained('tipos_servicio')->onDelete('cascade');
            $table->foreignId('banco_id')->constrained('bancos')->onDelete('cascade');
            $table->decimal('comision', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servicios_config');
    }
};
