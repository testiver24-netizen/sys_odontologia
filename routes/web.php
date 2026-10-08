<?php

use App\Http\Controllers\AjusteController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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
// Usuarios
Route::middleware('auth')->prefix('users')->name('users.')->group(function () {
   Route::get('/',[UserController::class,'index'])->name('index');
   Route::post('/crear',[UserController::class,'store'])->name('store');
   Route::put('/{id}/actualizar',[UserController::class,'update'])->name('update');
   Route::delete('/{id}/eliminar',[UserController::class,'destroy'])->name('destroy');
});
// Pacientes
Route::middleware('auth')->prefix('pacientes')->name('pacientes.')->group(function () {
   Route::get('/',[PacienteController::class,'index'])->name('index');
   Route::get('/crear',[PacienteController::class,'create'])->name('create');
   Route::post('/store',[PacienteController::class,'store'])->name('store');
   Route::get('/{id}/edit',[PacienteController::class,'edit'])->name('edit');
   Route::get('/{id}/show',[PacienteController::class,'show'])->name('show');
   Route::put('/{id}/actualizar',[PacienteController::class,'update'])->name('update');
   Route::delete('/{id}/eliminar',[PacienteController::class,'destroy'])->name('destroy');
});

