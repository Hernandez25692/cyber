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
        Schema::create('recargas_realizadas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paquete_id')->constrained('paquetes_recarga')->onDelete('cascade');
            $table->string('numero')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recargas_realizadas');
    }
};
