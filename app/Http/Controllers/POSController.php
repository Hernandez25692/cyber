<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\TipoServicio;
use App\Models\Banco;
use App\Models\ProveedorRecarga;
use App\Models\ServicioImpresion;
use App\Models\TipoImpresion;

class POSController extends Controller
{
    public function index()
    {
        // Datos necesarios para el POS
        $productos = Producto::select('id', 'codigo', 'nombre', 'precio_venta')->get();
        $tipos = TipoServicio::all();
        $bancos = Banco::all();
        $proveedores = ProveedorRecarga::all();
        $serviciosImpresion = ServicioImpresion::all();
        $tiposImpresion = TipoImpresion::all();

        // Retorna vista pos.blade.php con todos los datos
        return view('pos', compact('productos', 'tipos', 'bancos', 'proveedores', 'serviciosImpresion', 'tiposImpresion'));
    }
}
    