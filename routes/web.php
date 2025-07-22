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
});
Route::get('/bancos-por-tipo/{tipoId}', [ServicioDataController::class, 'bancosPorTipo']);
Route::get('/comision-servicio/{tipoId}/{bancoId}', [ServicioDataController::class, 'comision']);
Route::post('/pos/servicio', [ServicioRealizadoController::class, 'store'])->name('pos.servicios.store');
Route::get('/paquetes-por-proveedor/{id}', [RecargaPOSController::class, 'paquetesPorProveedor']);

/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN (Laravel Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
