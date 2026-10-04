<?php

use App\Http\Controllers\AjusteController;
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
