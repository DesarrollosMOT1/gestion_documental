<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ReferenciaGastoController;
use App\Http\Controllers\CentroCostoController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

// Rutas protegidas por el middleware 'auth'
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    #rutas principales
    Route::resource('centro-costos',App\Http\Controllers\CentroCostoController::class)->parameters(['centro-costos' => 'codigo']);
    Route::resource('referencia-gastos',App\Http\Controllers\ReferenciaGastoController::class)->parameters(['referencia-gastos' => 'codigo']);
    Route::resource('solicitud-compras',App\Http\Controllers\SolicitudCompraController::class);
    Route::resource('roles',App\Http\Controllers\RoleController::class);
    Route::resource('permissions',App\Http\Controllers\PermissionController::class);

    #importaciones de datos
    Route::post('referencia-gastos/import', [ReferenciaGastoController::class, 'import'])->name('import-referencia');
    Route::post('centro-costos/import', [CentroCostoController::class, 'import'])->name('import-centro');

});

