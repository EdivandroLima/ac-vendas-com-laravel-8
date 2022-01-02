<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VendaController;

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/vendas', [VendaController::class, 'index'])->name('vendas');
Route::get('/vendas/exportar', [VendaController::class, 'viewExportar'])->name('viewExportar');
Route::post('/vendas/exportar', [VendaController::class, 'exportar'])->name('exportar');
Route::get('/vendas/importar', [VendaController::class, 'viewImportar'])->name('viewImportar');
Route::post('/vendas/importar', [VendaController::class, 'importar'])->name('importar');
Auth::routes();
