<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('consumos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // quien registra
            $table->foreignId('producto_id')->nullable()->constrained('productos')->nullOnDelete(); // enlace opcional
            $table->string('codigo_barra')->index(); // para escáner
            $table->string('nombre')->nullable();    // copia “nombre del producto” al momento del consumo
            $table->decimal('cantidad', 10, 2)->default(1);
            $table->decimal('costo_unitario', 12, 2)->default(0); // costo de reposición o costo promedio
            $table->decimal('total_costo', 14, 2)->default(0);    // cantidad * costo_unitario
            $table->string('observacion')->nullable();
            $table->timestamps();

            // Evitar duplicar accidentalmente el mismo escaneo exactamente igual en el mismo segundo (opcional)
            $table->unique(['codigo_barra', 'created_at', 'user_id'], 'consumos_codigo_fecha_user_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consumos');
    }
};
