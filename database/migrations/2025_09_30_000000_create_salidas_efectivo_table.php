<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('salidas_efectivo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');              // Cajero que registra
            $table->foreignId('cierre_id')->nullable()->constrained('cierres'); // Turno/cierre abierto
            $table->string('motivo', 255);
            $table->decimal('monto', 12, 2);
            $table->text('observacion')->nullable();
            $table->timestamp('fecha_hora')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salidas_efectivo');
    }
};
