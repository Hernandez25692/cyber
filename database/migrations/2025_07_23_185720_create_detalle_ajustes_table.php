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
        Schema::create('detalle_ajustes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ajuste_id');
            $table->unsignedBigInteger('producto_id');
            $table->integer('stock_sistema');
            $table->integer('stock_fisico');
            $table->integer('diferencia');
            $table->text('observacion')->nullable();
            $table->timestamps();

            $table->foreign('ajuste_id')->references('id')->on('ajustes_inventario')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_ajustes');
    }
};
