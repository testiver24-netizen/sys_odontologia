<?php

use App\Http\Controllers\AjusteController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
require __DIR__.'/auth.php';

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
// modulo ajustes
Route::middleware('auth')->prefix('ajustes')->name('ajustes.')->group(function () {
   Route::get('/',[AjusteController::class,'index'])->name('index');
   Route::post('/create',[AjusteController::class,'store'])->name('store');

});
// Roles
Route::middleware('auth')->prefix('roles')->name('roles.')->group(function () {
   Route::get('/',[RoleController::class,'index'])->name('index');
   Route::post('/crear',[RoleController::class,'store'])->name('store');
   Route::put('/{id}/actualizar',[RoleController::class,'update'])->name('update');
   Route::delete('/{id}/eliminar',[RoleController::class,'destroy'])->name('destroy');
});

