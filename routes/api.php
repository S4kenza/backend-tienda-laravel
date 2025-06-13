<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\DireccionController;;

//rutas publicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//productos
Route::get('/productos', [ProductoController::class, 'index']);
Route::get('/productos/{id}', [ProductoController::class, 'show']);
Route::get('/categoria', [ProductoController::class, 'categoria']);
//carrito
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/carrito', [CarritoController::class, 'index'])->middleware('IsAdmin:cliente');
    Route::post('/carrito/{productoId}', [CarritoController::class, 'add'])->middleware('IsAdmin:cliente');
    Route::delete('/carrito/{productoId}', [CarritoController::class, 'remove'])->middleware('IsAdmin:cliente');
});

//Direcciones
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/direcciones', [DireccionController::class, 'direcciones'])->middleware('IsCliente:cliente');
    Route::get('/direcciones', [DireccionController::class, 'index'])->middleware('IsCliente:cliente');
    Route::put('/direcciones/{id}', [DireccionController::class, 'update'])->middleware('IsCliente:cliente');
    Route::delete('/direcciones/{id}', [DireccionController::class, 'destroy'])->middleware('IsCliente:cliente');
    Route::get('/direcciones/{id}', [DireccionController::class, 'show'])->middleware('IsCliente:cliente');
});
//rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/categorias', [ProductoController::class, 'storeCategoria'])->middleware('IsAdmin:admin');
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/productos', [ProductoController::class, 'store'])->middleware('IsAdmin:admin');
    Route::put('/productos/{id}', [ProductoController::class, 'update'])->middleware('IsAdmin:admin');
    Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->middleware('IsAdmin:admin');
});

