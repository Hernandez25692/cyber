<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('recargas_realizadas', function (Blueprint $table) {
            $table->decimal('precio_compra', 10, 2)->after('numero')->default(0);
            $table->decimal('precio_venta', 10, 2)->after('precio_compra')->default(0);
            $table->decimal('comision', 10, 2)->after('precio_venta')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('recargas_realizadas', function (Blueprint $table) {
            $table->dropColumn(['precio_compra', 'precio_venta', 'comision']);
        });
    }
};
