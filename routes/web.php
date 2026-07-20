<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::redirect('/home', '/dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    Route::view('/dashboard/categorias', 'categorias.index')->name('dashboard.categorias');
    Route::view('/dashboard/productos', 'productos.index')->name('dashboard.productos');
    Route::view('/dashboard/compras', 'compras.index')->name('dashboard.compras');
    Route::view('/dashboard/marcas', 'marcas.index')->name('dashboard.marcas');
    Route::view('/dashboard/proveedores', 'proveedores.index')->name('dashboard.proveedores');
});
