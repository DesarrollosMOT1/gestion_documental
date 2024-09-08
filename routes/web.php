<?php

use App\Http\Controllers\AlmacenesController;
use App\Http\Controllers\Api\RegistroController;
use App\Http\Controllers\Api\TercerosTestController;
use App\Http\Controllers\BodegaController;
use App\Http\Controllers\ClasesMovimientoController;
use App\Http\Controllers\MotivoController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\TiposMovimientoController;
use App\Http\Controllers\UnidadeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

// Rutas protegidas por el middleware 'auth'
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //rutas principales
    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::resource('permissions', App\Http\Controllers\PermissionController::class);

    //rutas usuarios
    route::resource('users', App\Http\Controllers\UserController::class)->names('admin.users');
    Route::get('/NewPassword', [App\Http\Controllers\UserSettingsController::class, 'NewPassword'])->name('NewPassword');
    Route::post('/change/password', [App\Http\Controllers\UserSettingsController::class, 'changePassword'])->name('changePassword');

    //rutas para gestion de compras
    Route::resource('areas', App\Http\Controllers\AreaController::class);
    Route::resource('clasificaciones-centros', App\Http\Controllers\ClasificacionesCentroController::class);
    Route::resource('niveles-unos', App\Http\Controllers\NivelesUnoController::class);
    Route::resource('niveles-dos', App\Http\Controllers\NivelesDosController::class);
    Route::resource('niveles-tres', App\Http\Controllers\NivelesTresController::class);
    Route::resource('consolidaciones', App\Http\Controllers\ConsolidacioneController::class);
    Route::resource('centros-costos', App\Http\Controllers\CentrosCostoController::class)->parameters(['centros-costos' => 'codigo']);
    Route::resource('referencias-gastos', App\Http\Controllers\ReferenciasGastoController::class)->parameters(['referencias-gastos' => 'codigo']);

    Route::get('/api/niveles-dos/{idNivelUno}', [App\Http\Controllers\SolicitudesCompraController::class, 'getNivelesDos']);
    Route::get('/api/niveles-tres/{idNivelDos}', [App\Http\Controllers\SolicitudesCompraController::class, 'getNivelesTres']);
    Route::post('/solicitudes-compras/actualizar-estado/{id}', [App\Http\Controllers\SolicitudesCompraController::class, 'actualizarEstado'])->name('solicitudes-compras.actualizar-estado');
    Route::post('/cotizaciones/actualizar-estado/{id}', [App\Http\Controllers\CotizacioneController::class, 'actualizarEstado'])->name('cotizaciones.actualizar-estado');

    Route::post('/get-elementos-multiple', [App\Http\Controllers\CotizacioneController::class, 'getElementosMultiple'])->name('get-elementos-multiple');

    Route::resource('terceros', App\Http\Controllers\TerceroController::class)->parameters(['terceros' => 'nit']);
    Route::resource('impuestos', App\Http\Controllers\ImpuestoController::class);
    Route::resource('solicitudes-compras', App\Http\Controllers\SolicitudesCompraController::class);
    Route::resource('cotizaciones', App\Http\Controllers\CotizacioneController::class);
    Route::resource('ordenes-compras', App\Http\Controllers\OrdenesCompraController::class);
    Route::resource('entradas', App\Http\Controllers\EntradaController::class);

    Route::post('registros/store-array/{movimientoId}', [RegistroController::class, 'storeArray'])->name('registros.store-array');
    Route::get('clases-movimientos/get-all-by-typeid/{typeId}', [ClasesMovimientoController::class, 'getAllClasesMovimientobyTipo'])->name('clases-movimientos.get-all-by-typeid');
    Route::get('productos/get-all', [ProductoController::class, 'getAllProductos'])->name('productos.get-all');
    Route::get('almacenes/get-all', [AlmacenesController::class, 'getAllAlmacenes'])->name('almacenes.get-all');
    Route::get('bodegas/get-all', [BodegaController::class, 'getAllBodegas'])->name('bodegas.get-all');
    Route::get('motivos/get-all', [MotivoController::class, 'getAllMotivos'])->name('motivos.get-all');
    Route::get('terceros-tests/get-all', [TercerosTestController::class, 'getAllTerceros'])->name('terceros-tests.get-all');
    Route::get('tipos-movimientos/get-all', [TiposMovimientoController::class, 'getAllTiposMovimiento'])->name('tipos-movimientos.get-all');
    Route::get('unidades/get-all', [UnidadeController::class, 'getAllUnidades'])->name('unidades.get-all');
    Route::resource('almacenes', AlmacenesController::class);
    Route::resource('bodegas', BodegaController::class);
    Route::resource('clases-movimientos', ClasesMovimientoController::class);
    Route::resource('tipos-movimientos', TiposMovimientoController::class);
    Route::resource('unidades', UnidadeController::class);
    Route::resource('productos', ProductoController::class);
    Route::resource('motivos', MotivoController::class);
    Route::resource('movimientos', MovimientoController::class);
    Route::apiResource('terceros-tests', TercerosTestController::class);
    Route::apiResource('registros', RegistroController::class);

});
