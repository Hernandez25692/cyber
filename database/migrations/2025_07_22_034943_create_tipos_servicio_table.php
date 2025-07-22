<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tipos_servicio', function (Blueprint $table) {
            $table->id();
            $table->string('categoria'); // 'remesa', 'retiro', etc.
            $table->string('nombre');
            $table->string('banco')->nullable();
            $table->decimal('monto_min', 10, 2)->nullable();
            $table->decimal('monto_max', 10, 2)->nullable();
            $table->decimal('comision', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipos_servicio');
    }
};
