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
use App\Http\Controllers\AperturaController;
use App\Http\Controllers\CierreController;
use App\Http\Controllers\DepositoPOSController;
use App\Http\Controllers\DepositoConfigController;
use App\Http\Controllers\ReporteDepositosController;
use App\Http\Controllers\TipoServicioDepositoController;
use App\Http\Controllers\Admin\ReporteCierresController;
use App\Http\Controllers\SalidaEfectivoController;
use App\Http\Controllers\Admin\ReporteGananciasController;

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

Route::resource('productos', ProductoController::class)->names('productos');
Route::middleware(['auth', 'role:cajero'])->prefix('pos')->group(function () {
    Route::get('/', [POSController::class, 'index'])->name('pos');

    // Ventas (POS)
    Route::post('/ventas', [VentaController::class, 'store'])->name('ventas.store');

    // Remesas (POS)
    Route::get('/remesas', [RemesaPOSController::class, 'form'])->name('remesas.form');
    Route::post('/remesas', [RemesaPOSController::class, 'store'])->name('remesas.store');

    // Retiros (POS)
    Route::post('/retiros/calcular', [RetiroPOSController::class, 'calcularComision'])->name('pos.retiros.calcular');
    Route::post('/retiros/registrar', [RetiroPOSController::class, 'store'])->name('pos.retiros.store');



    // Impresiones (POS)
    Route::post('/impresiones', [ImpresionPOSController::class, 'store'])->name('impresiones.store');

    // Depósitos (POS)
    Route::post('/depositos/calcular-comision', [DepositoPOSController::class, 'calcularComision'])->name('pos.depositos.calcular-comision');
    Route::post('/depositos', [DepositoPOSController::class, 'store'])->name('pos.depositos.store');

    // Servicios (POS)
    Route::post('/servicio', [ServicioRealizadoController::class, 'store'])->name('pos.servicios.store');
});
// Recargas (POS)
Route::post('/recargas', [RecargaPOSController::class, 'store'])->name('recargas.store');
Route::get('/paquetes-por-proveedor/{id}', [RecargaPOSController::class, 'paquetesPorProveedor']);
// Endpoints auxiliares usados por POS (cajero)
Route::get('/bancos-por-tipo/{tipoId}', [ServicioDataController::class, 'bancosPorTipo'])
    ->middleware(['auth', 'role:cajero']);
Route::get('/comision-servicio/{tipoId}/{bancoId}', [ServicioDataController::class, 'comision'])
    ->middleware(['auth', 'role:cajero']);

// API producto para lector (POS)
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
})->middleware(['auth', 'role:cajero']);

// Aperturas/Cierres/Reporte Z (POS)
Route::get('/apertura/crear', [AperturaController::class, 'create'])->name('aperturas.create');
Route::post('/apertura', [AperturaController::class, 'store'])->name('aperturas.store');

Route::get('/cierre/crear', [CierreController::class, 'create'])->name('cierres.create');
Route::post('/cierre', [CierreController::class, 'store'])->name('cierres.store');
Route::post('/cierre/finalizar/{cierre}', [CierreController::class, 'finalizar'])->name('cierres.finalizar');

Route::get('/reporte-z/{apertura_id}', [CierreController::class, 'reporteZ'])->name('cierres.reporte_z');

// Salidas de efectivo (POS)
Route::get('/salidas-efectivo', [SalidaEfectivoController::class, 'index'])->name('salidas.index');
Route::post('/salidas-efectivo', [SalidaEfectivoController::class, 'store'])->name('salidas.store');

/*
|--------------------------------------------------------------------------
| MÓDULO ADMIN (ADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('index');

    // Usuarios
    Route::resource('usuarios', UsuarioController::class)->only(['index', 'create', 'store', 'destroy'])->names('usuarios');
    Route::get('/usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');

    // Inventario redirige a productos
    Route::get('/inventario', fn() => redirect()->route('admin.productos.index'))->name('inventario.index');

    // Productos
    Route::resource('productos', ProductoController::class)
        ->except(['show'])
        ->names('productos');

    // Reporte general
    Route::get('/reportes/general', [ReporteGeneralController::class, 'index'])->name('reportes.general');

    // Reportes Admin
    Route::get('/reportes/remesas', [ReporteRemesasController::class, 'index'])->name('reportes.remesas');
    Route::get('/reportes/retiros', [ReporteRetirosController::class, 'index'])->name('reportes.retiros');
    Route::get('/reporte-servicios', [ServicioRealizadoController::class, 'index'])->name('reporte.servicios');

    Route::get('/reportes/recargas', [ReporteRecargasController::class, 'index'])->name('reportes.recargas');
    Route::get('/reportes/impresiones', [ReporteImpresionesController::class, 'index'])->name('reportes.impresiones');
    Route::get('/reportes/cierres', [ReporteCierresController::class, 'index'])->name('reportes.cierres');
    Route::get('/reportes/cyber', [\App\Http\Controllers\Admin\ReporteCyberController::class, 'index'])->name('reportes.cyber');

    // Remesas (config)
    Route::resource('remesas', RemesaConfigController::class)
        ->only(['index', 'create', 'store', 'edit', 'update'])
        ->names('remesas');

    Route::delete('/remesas/{remesa}', [RemesaConfigController::class, 'destroy'])
        ->name('remesas.destroy');

    // Retiros (config + tipos)
    Route::resource('retiros/config', RetiroConfigController::class)
        ->only(['index', 'create', 'store', 'destroy', 'edit', 'update'])
        ->parameters(['config' => 'retiro']) // <-- clave para que el parámetro sea {retiro}
        ->names([
            'index'   => 'retiros.config.index',
            'create'  => 'retiros.config.create',
            'store'   => 'retiros.config.store',
            'destroy' => 'retiros.config.destroy',
            'edit'    => 'retiros.config.edit',
            'update'  => 'retiros.config.update',
        ]);

    Route::resource('retiros/servicios', TipoServicioRetiroController::class)->only(['index', 'create', 'store', 'destroy'])->names([
        'index' => 'retiros.servicios.index',
        'create' => 'retiros.servicios.create',
        'store' => 'retiros.servicios.store',
        'destroy' => 'retiros.servicios.destroy',
    ]);
    Route::get('/retiros/reportes', function () {
        $retiros = \App\Models\RetiroRealizado::with('usuario')->latest()->get();
        return view('admin.retiros.reportes.index', compact('retiros'));
    })->name('retiros.reportes');

    // Servicios (config)
    Route::resource('servicios/tipos', TipoServicioController::class)->only(['index', 'create', 'store', 'destroy'])->names('servicios.tipos');
    Route::resource('servicios/bancos', BancoController::class)->only(['index', 'create', 'store', 'destroy'])->names('servicios.bancos');
    Route::resource('servicios/config', ServicioConfigController::class)->only(['index', 'create', 'store', 'destroy'])->names('servicios.config');

    // Recargas (admin)
    Route::resource('recargas/proveedores', ProveedorRecargaController::class)->names('recargas.proveedores');
    Route::resource('recargas/paquetes', PaqueteRecargaController::class)->names('recargas.paquetes');

    // Impresiones (config)
    Route::resource('impresiones/servicios', ServicioImpresionController::class)->only(['index', 'create', 'store', 'destroy'])->names('impresiones.servicios');
    Route::resource('impresiones/tipos', TipoImpresionController::class)->only(['index', 'create', 'store', 'destroy'])->names('impresiones.tipos');

    // Depósitos (config + reportes)
    Route::get('/depositos/config', [DepositoConfigController::class, 'index'])->name('depositos.config.index');
    Route::get('/depositos/config/create', [DepositoConfigController::class, 'create'])->name('depositos.config.create');
    Route::post('/depositos/config', [DepositoConfigController::class, 'store'])->name('depositos.config.store');
    Route::delete('/depositos/config/{deposito}', [DepositoConfigController::class, 'destroy'])->name('depositos.config.destroy');
    Route::get('/depositos/config/{deposito}/edit', [DepositoConfigController::class, 'edit'])->name('depositos.config.edit');
    Route::put('/depositos/config/{deposito}', [DepositoConfigController::class, 'update'])->name('depositos.config.update');


    Route::get('/reportes/depositos', [ReporteDepositosController::class, 'index'])->name('reportes.depositos.index');

    // Ganancias
    Route::get('/reporte-ganancias', [ReporteGananciasController::class, 'index'])->name('reporte_ganancias.index');
    Route::get('/reporte-ganancias/data', [ReporteGananciasController::class, 'data'])->name('reporte_ganancias.data');
    Route::get('/productos/export', [ProductoController::class, 'export'])
        ->name('productos.export');
});

/*
|--------------------------------------------------------------------------
| RUTAS ADMIN QUE EN TU LAYOUT USAS SIN PREFIJO "admin."
| (Se mantienen los nombres originales pero ahora con protección de rol)
|--------------------------------------------------------------------------
*/

// Ventas (Admin) — conservamos nombres usados en el sidebar
Route::get('/ventas', [VentaController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('ventas.index');

Route::get('/ventas/reporte-productos', [VentaController::class, 'reporteProductos'])
    ->middleware(['auth', 'role:admin'])
    ->name('ventas.reporte.productos');

Route::get('/ventas/{venta}', [VentaController::class, 'show'])
    ->middleware(['auth', 'role:admin'])
    ->name('ventas.show');

// Inventario/Entradas/Ajustes — conservamos nombres
Route::get('productos/{id}/entrada', [ProductoController::class, 'entrada'])
    ->middleware(['auth', 'role:admin'])
    ->name('productos.entrada');

Route::get('/ajustes/inventario', [AjusteInventarioController::class, 'crear'])
    ->middleware(['auth', 'role:admin'])
    ->name('ajustes.formulario');



Route::post('productos/{id}/entrada', [ProductoController::class, 'registrarEntrada'])
    ->middleware(['auth', 'role:admin'])
    ->name('productos.registrarEntrada');

Route::get('/inventario/entrada', [OrdenEntradaController::class, 'create'])
    ->middleware(['auth', 'role:admin'])
    ->name('inventario.entrada');

Route::post('/inventario/entrada', [OrdenEntradaController::class, 'store'])
    ->middleware(['auth', 'role:admin'])
    ->name('inventario.entrada.store');

Route::match(['get', 'post'], '/inventario/ordenes-entrada', [OrdenEntradaController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('ordenes-entrada.index');

Route::get('/inventario/ajuste', [AjusteInventarioController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('inventario.ajuste.index');

Route::post('/inventario/ajuste', [AjusteInventarioController::class, 'store'])
    ->middleware(['auth', 'role:admin'])
    ->name('inventario.ajuste.store');

Route::get('/inventario/sugerencias', [InventarioController::class, 'sugerenciaPedido'])
    ->middleware(['auth', 'role:admin'])
    ->name('inventario.sugerencias');

Route::get('/admin/reportes/utilidad-productos', [\App\Http\Controllers\ReporteProductoController::class, 'reporteUtilidad'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.reportes.utilidad.productos');

// Ajustes (Admin) — conservamos prefijo/ nombres
Route::prefix('ajustes')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/crear', [AjusteInventarioController::class, 'crear'])->name('ajustes.crear');
    Route::post('/guardar', [AjusteInventarioController::class, 'guardar'])->name('ajustes.guardar');
    Route::get('/historial', [AjusteInventarioController::class, 'historial'])->name('ajustes.historial');
    Route::get('/detalle/{id}', [AjusteInventarioController::class, 'detalle'])->name('ajustes.detalle');
    Route::post('/buscar-producto', [AjusteInventarioController::class, 'buscarProducto'])->name('ajustes.buscar');
});

// Alias para conservar el nombre que usas en el layout: 'reportes.impresiones'
Route::get('/reportes/impresiones', function () {
    return redirect()->route('admin.reportes.impresiones');
})->middleware(['auth', 'role:admin'])->name('reportes.impresiones');

/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN (Laravel Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
