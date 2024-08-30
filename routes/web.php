<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ReferenciaGastoController;
use App\Http\Controllers\CentroCostoController;
use App\Http\Controllers\LineasGastoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UnidadesEquivalenteController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

// Rutas protegidas por el middleware 'auth'
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    #rutas de  excel
    Route::post('niveles-unos/import', [App\Http\Controllers\NivelesUnoController::class, 'import'])->name('niveles-unos.import');
    route::post('niveles-dos/import', [App\Http\Controllers\NivelesDosController::class, 'import'])->name('niveles-dos.import');Route::post('niveles-tres/import', [App\Http\Controllers\NivelesTresController::class, 'import'])->name('niveles-tres.import');
    Route::post('niveles-tres/import', [App\Http\Controllers\NivelesTresController::class, 'import'])->name('niveles-tres.import');
    route::post('centros-costos/import', [App\Http\Controllers\CentrosCostoController::class, 'import'])->name('centros-costos.import');
    route::post('clasificaciones-centros/import', [App\Http\Controllers\ClasificacionesCentroController::class, 'import'])->name('clasificaciones-centros.import');

    #rutas principales
    Route::resource('roles',App\Http\Controllers\RoleController::class);
    Route::resource('permissions',App\Http\Controllers\PermissionController::class);

    #rutas usuarios
    route::resource('users', App\Http\Controllers\UserController::class)->names('admin.users');
    Route::get('/NewPassword',  [App\Http\Controllers\UserSettingsController::class,'NewPassword'])->name('NewPassword');
    Route::post('/change/password',  [App\Http\Controllers\UserSettingsController::class,'changePassword'])->name('changePassword');
    route::post('referencias-gastos/import', [App\Http\Controllers\ReferenciasGastoController::class, 'import'])->name('referencias-gastos.import');
    #rutas para gestion de compras
    Route::resource('areas', App\Http\Controllers\AreaController::class);
    Route::resource('clasificaciones-centros', App\Http\Controllers\ClasificacionesCentroController::class); 
    Route::resource('niveles-unos', App\Http\Controllers\NivelesUnoController::class);
    Route::resource('niveles-dos', App\Http\Controllers\NivelesDosController::class);
    Route::resource('niveles-tres', App\Http\Controllers\NivelesTresController::class);
    Route::resource('centros-costos', App\Http\Controllers\CentrosCostoController::class)->parameters(['centros-costos' => 'codigo']);
    Route::resource('referencias-gastos', App\Http\Controllers\ReferenciasGastoController::class)->parameters(['referencias-gastos' => 'codigo']);
    Route::resource('agrupaciones-consolidaciones', App\Http\Controllers\AgrupacionesConsolidacioneController::class);
    Route::resource('solicitudes-ofertas', App\Http\Controllers\SolicitudesOfertaController::class);
    
    Route::post('agrupaciones-consolidacione/{agrupacionesConsolidacioneId}/solicitudes-compra', [App\Http\Controllers\AgrupacionesConsolidacioneController::class, 'storeSolicitudesCompra'])->name('agrupaciones-consolidacione.storeSolicitudesCompra');

    Route::post('/consolidaciones/actualizar-estado/{id}', [App\Http\Controllers\AgrupacionesConsolidacioneController::class, 'actualizarEstado']);

    Route::get('/api/niveles-dos/{idNivelUno}', [App\Http\Controllers\SolicitudesCompraController::class, 'getNivelesDos']);
    Route::get('/api/niveles-tres/{idNivelDos}', [App\Http\Controllers\SolicitudesCompraController::class, 'getNivelesTres']);
    Route::post('/solicitudes-compras/actualizar-estado/{id}', [App\Http\Controllers\SolicitudesCompraController::class, 'actualizarEstado'])->name('solicitudes-compras.actualizar-estado');
    Route::post('/cotizaciones/actualizar-estado/{id}', [App\Http\Controllers\CotizacioneController::class, 'actualizarEstado'])->name('cotizaciones.actualizar-estado');

    Route::post('/get-elementos-multiple', [App\Http\Controllers\AgrupacionesConsolidacioneController::class, 'getElementosMultiple'])->name('get-elementos-multiple');

    Route::resource('terceros', App\Http\Controllers\TerceroController::class)->parameters(['terceros' => 'nit']);
    Route::resource('impuestos', App\Http\Controllers\ImpuestoController::class);
    Route::resource('solicitudes-compras', App\Http\Controllers\SolicitudesCompraController::class);
    Route::resource('cotizaciones', App\Http\Controllers\CotizacioneController::class); 
    Route::resource('ordenes-compras', App\Http\Controllers\OrdenesCompraController::class);
    Route::resource('entradas', App\Http\Controllers\EntradaController::class);



    #cadena de suministros
    Route::resource('productos', ProductoController::class);
    Route::resource('productos.unidades-equivalentes', UnidadesEquivalenteController::class);

});

