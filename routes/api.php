<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\CompraController;
use App\Http\Controllers\Api\MarcaController;
use App\Http\Controllers\Api\ProveedorController;

Route::apiResource('categorias', CategoriaController::class);
Route::apiResource('productos', ProductoController::class);
Route::apiResource('compras', CompraController::class);
Route::apiResource('marcas', MarcaController::class);
Route::apiResource('proveedores', ProveedorController::class);