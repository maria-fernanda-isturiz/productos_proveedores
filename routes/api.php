<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\ProductosController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/lista_proveedores',[ProveedoresController::class, 'ObtenerProveedores']);
    Route::post('/registrar_proveedores',[ProveedoresController::class, 'RegistrarProveedores']);    
    Route::put('/actualizar_proveedor/{id}',[ProveedoresController::class, 'ActualizarProveedores']);
    Route::delete('/eliminar_proveedor/{id}',[ProveedoresController::class, 'EliminarProveedores']);
    Route::post('/registrar_producto', [ProductosController::class, 'RegistrarProducto']);
    
});

// Declarando una ruta
// Pide el tipo de petición.
Route::post('/login_proveedor', [ProveedoresController::class, 'LogIn']);
Route::get('/proveedor_id/{id}',[ProveedoresController::class, 'GetID']);
Route::get('/lista_productos',[ProductosController::class, 'Index']);
Route::get('/busqueda_producto/{busqueda}', [ProductosController::class, 'BusquedaNombre']);
Route::get('/precio_productos', [ProductosController::class, 'ObtenerPrecio']);





