<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
});