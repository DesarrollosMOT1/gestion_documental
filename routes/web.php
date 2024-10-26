<?php

use App\Http\Controllers\AlmacenesController;
use App\Http\Controllers\Api\EquivalenciaController;
use App\Http\Controllers\Api\RegistroController;
use App\Http\Controllers\BodegaController;
use App\Http\Controllers\ClasesMovimientoController;
use App\Http\Controllers\MotivoController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\TerceroController;
use App\Http\Controllers\TiposMovimientoController;
use App\Http\Controllers\UnidadeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['register' => false]);


// Rutas protegidas por el middleware 'auth'
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Rutas de importación
    Route::post('niveles-unos/import', [App\Http\Controllers\NivelesUnoController::class, 'import'])->name('niveles-unos.import');
    Route::post('niveles-dos/import', [App\Http\Controllers\NivelesDosController::class, 'import'])->name('niveles-dos.import');
    Route::post('niveles-tres/import', [App\Http\Controllers\NivelesTresController::class, 'import'])->name('niveles-tres.import');
    Route::post('centros-costos/import', [App\Http\Controllers\CentrosCostoController::class, 'import'])->name('centros-costos.import');
    Route::post('terceros/import', [App\Http\Controllers\TerceroController::class, 'import'])->name('terceros.import');
    Route::post('referencias-gastos/import', [App\Http\Controllers\ReferenciasGastoController::class, 'import'])->name('referencias-gastos.import');

    // Rutas principales
    Route::resource('roles', App\Http\Controllers\RoleController::class)->middleware('can:ver_administracion_roles');
    Route::resource('permissions', App\Http\Controllers\PermissionController::class)->middleware('can:ver_administracion_permisos');

    // Rutas usuarios
    Route::resource('users', App\Http\Controllers\UserController::class)->names('admin.users')->middleware('can:ver_administracion_usuarios');
    Route::get('/NewPassword', [App\Http\Controllers\UserSettingsController::class, 'NewPassword'])->name('NewPassword');
    Route::post('/change/password', [App\Http\Controllers\UserSettingsController::class, 'changePassword'])->name('changePassword');

    // Rutas para gestión de compras
    Route::resource('areas', App\Http\Controllers\AreaController::class)->middleware('can:ver_administracion_areas');
    Route::resource('clasificaciones-centros', App\Http\Controllers\ClasificacionesCentroController::class)->middleware('can:ver_clasificaciones_centros');
    Route::resource('niveles-unos', App\Http\Controllers\NivelesUnoController::class)->middleware('can:ver_niveles_jerarquicos');
    Route::resource('niveles-dos', App\Http\Controllers\NivelesDosController::class);
    Route::resource('niveles-tres', App\Http\Controllers\NivelesTresController::class);
    Route::resource('centros-costos', App\Http\Controllers\CentrosCostoController::class)->middleware('can:ver_centros_costos');
    Route::resource('referencias-gastos', App\Http\Controllers\ReferenciasGastoController::class)->middleware('can:ver_referencias_gastos');
    Route::resource('agrupaciones-consolidaciones', App\Http\Controllers\AgrupacionesConsolidacioneController::class)->middleware('can:ver_consolidaciones');
    Route::resource('solicitudes-ofertas', App\Http\Controllers\SolicitudesOfertaController::class)->middleware('can:ver_solicitudes_ofertas');
    Route::resource('terceros', App\Http\Controllers\TerceroController::class)->middleware('can:ver_terceros');
    Route::resource('impuestos', App\Http\Controllers\ImpuestoController::class)->middleware('can:ver_impuestos');
    Route::resource('solicitudes-compras', App\Http\Controllers\SolicitudesCompraController::class)->middleware('can:ver_solicitudes_compras');
    Route::resource('cotizaciones', App\Http\Controllers\CotizacioneController::class)->middleware('can:ver_cotizaciones');
    Route::resource('ordenes-compras', App\Http\Controllers\OrdenesCompraController::class)->middleware('can:ver_ordenes_compras');
    Route::resource('entradas', App\Http\Controllers\EntradaController::class)->middleware('can:ver_entrada_inventario');
    Route::resource('audits', App\Http\Controllers\AuditController::class)->except(['create', 'edit', 'delete'])->middleware('can:ver_registro_auditoria');

    // Rutas para agrupaciones y consolidaciones
    Route::post('agrupaciones-consolidacione/{agrupacionesConsolidacioneId}/solicitudes-compra', [App\Http\Controllers\AgrupacionesConsolidacioneController::class, 'storeSolicitudesCompra'])->name('agrupaciones-consolidacione.storeSolicitudesCompra');
    Route::post('/get-elementos-multiple', [App\Http\Controllers\AgrupacionesConsolidacioneController::class, 'getElementosMultiple'])->name('get-elementos-multiple');
    Route::post('/get-consolidaciones-detalles', [App\Http\Controllers\SolicitudesOfertaController::class, 'getConsolidacionesDetalles'])->name('get-consolidaciones-detalles');

    // Rutas para generación de PDF
    Route::get('solicitudes-ofertas/{id}/pdf/{terceroId}', [App\Http\Controllers\SolicitudesOfertaController::class, 'downloadPdf'])->name('solicitudes-ofertas.pdf');

    // Rutas API
    Route::get('/api/niveles-dos/{idNivelUno}', [App\Http\Controllers\SolicitudesCompraController::class, 'getNivelesDos']);
    Route::get('/api/niveles-tres/{idNivelDos}', [App\Http\Controllers\SolicitudesCompraController::class, 'getNivelesTres']);
    Route::post('/solicitudes-compras/actualizar-estado/{id}', [App\Http\Controllers\SolicitudesCompraController::class, 'actualizarEstado'])->name('solicitudes-compras.actualizar-estado');
    Route::post('/cotizaciones/actualizar-estado/{id}', [App\Http\Controllers\CotizacioneController::class, 'actualizarEstado'])->name('cotizaciones.actualizar-estado');
    route::get('api/solicitudes-oferta/{id}/elementos', [App\Http\Controllers\CotizacioneController::class, 'obtenerElementosConsolidaciones']);
    Route::get('/api/impuestos', [App\Http\Controllers\CotizacioneController::class, 'getImpuestos']);
    Route::get('/cotizaciones-precio/estado-jefe/{agrupacionId}', [App\Http\Controllers\CotizacioneController::class, 'getCotizacionesEstadoJefe']);
    Route::get('getAudits', [App\Http\Controllers\AuditController::class, 'getAudits'])->name('getAudits')->middleware('can:ver_registro_auditoria');

    //cadena de suministros
    Route::post('equivalencias/store-array/{unidadId}', [EquivalenciaController::class, 'storeEquivalencia'])->name('equivalencias.store-array');
    Route::post('equivalencias/store-request-equivalencia', [EquivalenciaController::class, 'storeRequestEquivalencia'])->name('equivalencias.store-request-equivalencia');
    Route::post('registros/store-array/{movimientoId}', [RegistroController::class, 'storeArray'])->name('registros.store-array');
    Route::get('clases-movimientos/get-all-by-typeid/{typeId}', [ClasesMovimientoController::class, 'getAllClasesMovimientobyTipo'])->name('clases-movimientos.get-all-by-typeid');
    Route::get('productos/get-all', [ProductoController::class, 'getAllProductos'])->name('productos.get-all');
    Route::get('almacenes/get-all', [AlmacenesController::class, 'getAllAlmacenes'])->name('almacenes.get-all');
    Route::get('bodegas/get-all', [BodegaController::class, 'getAllBodegas'])->name('bodegas.get-all');
    Route::get('motivos/get-all', [MotivoController::class, 'getAllMotivos'])->name('motivos.get-all');
    Route::get('terceros-api/get-all', [TerceroController::class, 'getAllTerceros'])->name('terceros-api.get-all');
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
    Route::apiResource('registros', RegistroController::class);
    Route::apiResource('equivalencias', EquivalenciaController::class);
});
