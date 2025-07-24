<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use Illuminate\Support\Str;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = ['Electrónica', 'Ropa', 'Alimentos', 'Limpieza', 'Papelería', 'Ferretería'];

        for ($i = 1; $i <= 100; $i++) {
            $precio_compra = round(mt_rand(100, 1000) / 10, 2);
            $precio_venta = $precio_compra + round($precio_compra * 0.25, 2);

            Producto::create([
                'codigo' => 'P' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'nombre' => 'Producto ' . $i,
                'categoria' => $categorias[array_rand($categorias)],
                'precio_compra' => $precio_compra,
                'precio_venta' => $precio_venta,
                'stock' => rand(0, 50),
            ]);
        }
    }
}
