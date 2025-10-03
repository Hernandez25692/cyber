<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('paquetes_recarga', function (Blueprint $table) {
            // Agregamos nuevas columnas
            $table->decimal('precio_compra', 10, 2)->after('descripcion')->nullable();
            $table->decimal('precio_venta', 10, 2)->after('precio_compra')->nullable();
        });

        // Si existe la columna antigua 'precio', migramos sus valores a 'precio_venta'
        if (Schema::hasColumn('paquetes_recarga', 'precio')) {
            DB::statement('UPDATE paquetes_recarga SET precio_venta = precio');

            // Opcional: si quieres conservar los datos como compra inicial, pon compra=venta temporalmente (o déjalo null)
            DB::statement('UPDATE paquetes_recarga SET precio_compra = precio_venta WHERE precio_compra IS NULL');

            // Eliminamos la columna antigua
            Schema::table('paquetes_recarga', function (Blueprint $table) {
                $table->dropColumn('precio');
            });
        }

        // Aseguramos NOT NULL tras poblar
        DB::statement('UPDATE paquetes_recarga SET precio_compra = 0 WHERE precio_compra IS NULL');
        DB::statement('UPDATE paquetes_recarga SET precio_venta = 0 WHERE precio_venta IS NULL');

        Schema::table('paquetes_recarga', function (Blueprint $table) {
            $table->decimal('precio_compra', 10, 2)->nullable(false)->change();
            $table->decimal('precio_venta', 10, 2)->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('paquetes_recarga', function (Blueprint $table) {
            $table->decimal('precio', 10, 2)->nullable()->after('descripcion');
        });

        // Revertimos: copiamos precio_venta a precio
        DB::statement('UPDATE paquetes_recarga SET precio = precio_venta');

        Schema::table('paquetes_recarga', function (Blueprint $table) {
            $table->dropColumn(['precio_compra', 'precio_venta']);
        });
    }
};
