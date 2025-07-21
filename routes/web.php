<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UsuarioController;

/*
|--------------------------------------------------------------------------
| RUTA PRINCIPAL
|--------------------------------------------------------------------------
| Redirige según el rol del usuario.
*/

Route::get('/', function () {
    return redirect()->route('redirect');
});

/*
|--------------------------------------------------------------------------
| REDIRECCIÓN SEGÚN ROL
|--------------------------------------------------------------------------
| Detecta si el usuario es admin o cajero y lo lleva al módulo adecuado.
*/
Route::get('/redirect', function () {
    $user = Auth::user();

    if (!$user) {
        return redirect('/login');
    }

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
| MÓDULO POS (Cajeros)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('pos')->group(function () {
    Route::get('/', [POSController::class, 'index'])->name('pos');
    Route::post('/ventas', [VentaController::class, 'store'])->name('ventas.store');
    Route::resource('productos', ProductoController::class)->names('productos');
});

/*
|--------------------------------------------------------------------------
| MÓDULO ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // Gestión de usuarios
    Route::resource('usuarios', UsuarioController::class)->names([
        'index' => 'usuarios.index',
        'create' => 'usuarios.create',
        'store' => 'usuarios.store',
        'destroy' => 'usuarios.destroy',
    ])->only(['index', 'create', 'store', 'destroy']);

    // Aquí se agregarán: comisiones, inventario, reportes...
});

/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN (Laravel Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
