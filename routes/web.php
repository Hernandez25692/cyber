<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RemesaPOSController;
use App\Http\Controllers\RemesaConfigController;
use App\Http\Controllers\ReporteRemesasController;
use App\Http\Controllers\RetiroConfigController;
use App\Http\Controllers\RetiroPOSController;
use App\Http\Controllers\ReporteRetirosController;
use App\Http\Controllers\TipoServicioRetiroController;
use App\Http\Controllers\TipoServicioController;
use App\Http\Controllers\BancoController;
use App\Http\Controllers\ServicioConfigController;
use App\Http\Controllers\Api\ServicioDataController;
use App\Http\Controllers\ServicioRealizadoController;
use App\Http\Controllers\RecargaPOSController;
use App\Http\Controllers\ProveedorRecargaController;
use App\Http\Controllers\PaqueteRecargaController;
use App\Http\Controllers\ReporteRecargasController;
use App\Http\Controllers\ServicioImpresionController;
use App\Http\Controllers\TipoImpresionController;
use App\Http\Controllers\ImpresionPOSController;
use App\Http\Controllers\ReporteImpresionesController;
use App\Http\Controllers\Admin\ReporteGeneralController;
use App\Http\Controllers\OrdenEntradaController;
use App\Models\Producto;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\AjusteInventarioController;
use App\Http\Controllers\ReporteProductoController;



/*
|--------------------------------------------------------------------------
| RUTA PRINCIPAL Y REDIRECCIÓN POR ROL
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => redirect()->route('redirect'));

Route::get('/redirect', function () {
    $user = Auth::user();
    if (!$user) return redirect('/login');

    return match ($user->rol) {
        'admin' => redirect()->route('admin.index'),
        default => redirect()->route('pos'),
    };
})->middleware('auth')->name('redirect');

/*
|--------------------------------------------------------------------------
| PERFIL DE USUARIO
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| MÓDULO POS (CAJERO)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('pos')->group(function () {
    Route::get('/', [POSController::class, 'index'])->name('pos');
    Route::post('/ventas', [VentaController::class, 'store'])->name('ventas.store');

    Route::resource('productos', ProductoController::class)->names('productos');

    // Registrar remesa
    Route::get('/remesas', [RemesaPOSController::class, 'form'])->name('remesas.form');
    Route::post('/remesas', [RemesaPOSController::class, 'store'])->name('remesas.store');

    // Registrar retiro
    Route::post('/retiros/calcular', [RetiroPOSController::class, 'calcularComision'])->name('pos.retiros.calcular');
    Route::post('/retiros/registrar', [RetiroPOSController::class, 'store'])->name('pos.retiros.store');

    Route::post('/recargas', [RecargaPOSController::class, 'store'])->name('recargas.store');
    Route::get('/paquetes-por-proveedor/{id}', [RecargaPOSController::class, 'paquetesPorProveedor']);

    Route::post('/impresiones', [ImpresionPOSController::class, 'store'])->name('impresiones.store');
});

/*
|--------------------------------------------------------------------------
| MÓDULO ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('index');

    // Usuarios
    Route::resource('usuarios', UsuarioController::class)->only(['index', 'create', 'store', 'destroy'])->names('usuarios');

    // Inventario redirige a productos
    Route::get('/inventario', fn() => redirect()->route('admin.productos.index'))->name('inventario.index');

    // Productos
    Route::resource('productos', ProductoController::class)->names('productos');

    // Configuración de comisiones para remesas
    Route::resource('remesas', RemesaConfigController::class)->only(['index', 'create', 'store'])->names('remesas');


    // Reportes
    // Reporte general
    Route::get('/reportes/general', [ReporteGeneralController::class, 'index'])->name('reportes.general');


    Route::get('/reportes/remesas', [ReporteRemesasController::class, 'index'])->name('reportes.remesas');
    Route::get('/reportes/retiros', [ReporteRetirosController::class, 'index'])->name('reportes.retiros');
    Route::get('/reporte-servicios', [App\Http\Controllers\ServicioRealizadoController::class, 'index'])->name('reporte.servicios');
    // Configuración de tipos de retiro (admin define nombre y comisiones)
    Route::resource('retiros/config', RetiroConfigController::class)->only(['index', 'create', 'store', 'destroy'])->names([
        'index' => 'retiros.config.index',
        'create' => 'retiros.config.create',
        'store' => 'retiros.config.store',
        'destroy' => 'retiros.config.destroy',
    ]);

    // Tipos de servicio de retiro (por ahora usado si se quiere definir servicios fijos)
    Route::resource('retiros/servicios', TipoServicioRetiroController::class)->only(['index', 'create', 'store', 'destroy'])->names([
        'index' => 'retiros.servicios.index',
        'create' => 'retiros.servicios.create',
        'store' => 'retiros.servicios.store',
        'destroy' => 'retiros.servicios.destroy',
    ]);

    // Reporte visual de retiros
    Route::get('/retiros/reportes', function () {
        $retiros = \App\Models\RetiroRealizado::with('usuario')->latest()->get();
        return view('admin.retiros.reportes.index', compact('retiros'));
    })->name('retiros.reportes');

    // Servicios - Tipos
    Route::resource('servicios/tipos', TipoServicioController::class)->only(['index', 'create', 'store', 'destroy'])->names('servicios.tipos');

    // Servicios - Bancos
    Route::resource('servicios/bancos', BancoController::class)->only(['index', 'create', 'store', 'destroy'])->names('servicios.bancos');

    // Servicios - Configuración
    Route::resource('servicios/config', ServicioConfigController::class)->only(['index', 'create', 'store', 'destroy'])->names('servicios.config');

    // ADMIN - Proveedores y paquetes de recarga
    Route::resource('recargas/proveedores', ProveedorRecargaController::class)->names('recargas.proveedores');
    Route::resource('recargas/paquetes', PaqueteRecargaController::class)->names('recargas.paquetes');
    Route::get('/reportes/recargas', [ReporteRecargasController::class, 'index'])->name('reportes.recargas');

    // Servicios de impresión
    Route::resource('impresiones/servicios', ServicioImpresionController::class)->only([
        'index',
        'create',
        'store',
        'destroy'
    ])->names('impresiones.servicios');

    // Tipos de impresión
    Route::resource('impresiones/tipos', TipoImpresionController::class)->only([
        'index',
        'create',
        'store',
        'destroy'
    ])->names('impresiones.tipos');

    Route::get('/reportes/impresiones', [ReporteImpresionesController::class, 'index'])->name('reportes.impresiones');
});
Route::get('/bancos-por-tipo/{tipoId}', [ServicioDataController::class, 'bancosPorTipo']);
Route::get('/comision-servicio/{tipoId}/{bancoId}', [ServicioDataController::class, 'comision']);
Route::post('/pos/servicio', [ServicioRealizadoController::class, 'store'])->name('pos.servicios.store');
Route::get('/paquetes-por-proveedor/{id}', [RecargaPOSController::class, 'paquetesPorProveedor']);
Route::get('/reportes/impresiones', [ReporteImpresionesController::class, 'index'])->name('reportes.impresiones');


Route::get('productos/{id}/entrada', [ProductoController::class, 'entrada'])->name('productos.entrada');
Route::post('productos/{id}/entrada', [ProductoController::class, 'registrarEntrada'])->name('productos.registrarEntrada');
Route::get('/inventario/entrada', [OrdenEntradaController::class, 'create'])->name('inventario.entrada');
Route::post('/inventario/entrada', [OrdenEntradaController::class, 'store'])->name('inventario.entrada.store');
Route::match(['get', 'post'], '/inventario/ordenes-entrada', [OrdenEntradaController::class, 'index'])->name('ordenes-entrada.index');
Route::get('/inventario/ajuste', [App\Http\Controllers\AjusteInventarioController::class, 'index'])->name('inventario.ajuste.index');
Route::post('/inventario/ajuste', [App\Http\Controllers\AjusteInventarioController::class, 'store'])->name('inventario.ajuste.store');
Route::get('/inventario/sugerencias', [InventarioController::class, 'sugerenciaPedido'])->name('inventario.sugerencias');

Route::prefix('ajustes')->middleware(['auth'])->group(function () {
    Route::get('/crear', [AjusteInventarioController::class, 'crear'])->name('ajustes.crear');
    Route::post('/guardar', [AjusteInventarioController::class, 'guardar'])->name('ajustes.guardar');
    Route::get('/historial', [AjusteInventarioController::class, 'historial'])->name('ajustes.historial');
    Route::get('/detalle/{id}', [AjusteInventarioController::class, 'detalle'])->name('ajustes.detalle');
    Route::post('/buscar-producto', [AjusteInventarioController::class, 'buscarProducto'])->name('ajustes.buscar');
});

Route::get('/api/producto/{codigo}', function ($codigo) {
    $producto = Producto::where('codigo', $codigo)->first();

    if (!$producto) {
        return response()->json(['error' => 'No encontrado'], 404);
    }

    return response()->json([
        'id' => $producto->id,
        'codigo' => $producto->codigo,
        'nombre' => $producto->nombre,
        'stock' => $producto->stock,
    ]);
})->middleware('auth');


Route::get('/ajustes/inventario', [AjusteInventarioController::class, 'formulario'])->name('ajustes.formulario');
Route::get('/ajustes/inventario', [AjusteInventarioController::class, 'crear'])->name('ajustes.formulario');
Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');
Route::get('/ventas/reporte-productos', [VentaController::class, 'reporteProductos'])->name('ventas.reporte.productos');
Route::get('/ventas/{venta}', [VentaController::class, 'show'])->name('ventas.show');
Route::get('/admin/usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('admin.usuarios.edit');
Route::put('/admin/usuarios/{id}', [UsuarioController::class, 'update'])->name('admin.usuarios.update');
Route::get('/admin/reportes/utilidad-productos', [ReporteProductoController::class, 'reporteUtilidad'])->name('admin.reportes.utilidad.productos');


/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN (Laravel Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
