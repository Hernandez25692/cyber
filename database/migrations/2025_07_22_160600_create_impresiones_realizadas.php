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
        Schema::create('impresiones_realizadas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicio_id')->constrained('servicios_impresion')->onDelete('cascade');
            $table->foreignId('tipo_id')->constrained('tipos_impresion')->onDelete('cascade');
            $table->decimal('precio', 10, 2);
            $table->string('descripcion')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('impresiones_realizadas');
    }
};
