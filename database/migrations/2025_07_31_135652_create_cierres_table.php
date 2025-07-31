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
        Schema::create('cierres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apertura_id')->constrained()->onDelete('cascade');
            $table->decimal('efectivo_final', 10, 2);
            $table->json('pos_final')->nullable(); // {"1":150.00, "2":200.00, ...}
            $table->decimal('total_ingresos', 10, 2)->default(0);
            $table->decimal('total_egresos', 10, 2)->default(0);
            $table->decimal('diferencia', 10, 2)->nullable();
            $table->boolean('reporte_z_generado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cierres');
    }
};
