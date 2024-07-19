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

    #rutas principales
   
    Route::resource('roles',App\Http\Controllers\RoleController::class);
    Route::resource('permissions',App\Http\Controllers\PermissionController::class);

    #rutas usuarios
    route::resource('users', App\Http\Controllers\UserController::class)->names('admin.users');
    Route::get('/NewPassword',  [App\Http\Controllers\UserSettingsController::class,'NewPassword'])->name('NewPassword');
    Route::post('/change/password',  [App\Http\Controllers\UserSettingsController::class,'changePassword'])->name('changePassword');

    #cadena de suministros
    Route::resource('productos', ProductoController::class);
    Route::resource('productos.unidades-equivalentes', UnidadesEquivalenteController::class);

});

