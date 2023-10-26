<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', [CategoriaController::class, 'index'])->name('index');

Route::get('categorias', [CategoriaController::class, 'index'])->name('categorias.index');
Route::post('categoria/agregar', [CategoriaController::class, 'store'])->name('categoria.store');
Route::get('categoria/mostrar', [CategoriaController::class, 'fetchAll'])->name('categoria.fetchAll');
Route::delete('categoria/borrar', [CategoriaController::class, 'destroy'])->name('categoria.delete');
Route::get('categoria/editar', [CategoriaController::class, 'edit'])->name('categoria.edit');
Route::post('categoria/actualizar', [CategoriaController::class, 'update'])->name('categoria.update');


// productos
Route::get('productos', [ProductoController::class, 'index'])->name('productos.index');
Route::post('producto/agregar', [ProductoController::class, 'store'])->name('producto.store');
Route::get('productos/mostrar', [ProductoController::class, 'fetchAll'])->name('producto.fetchAll');
Route::delete('productos/borrar', [ProductoController::class, 'delete'])->name('producto.delete');
Route::get('productos/borrar', [ProductoController::class, 'edit'])->name('producto.edit');
Route::post('productos/actualizar', [ProductoController::class, 'update'])->name('producto.update'); 

/*
// ventas
Route::get('ventas', [CategoriaController::class, 'index'])->name('categorias.index');
Route::post('categoria/agregar', [CategoriaController::class, 'store'])->name('categoria.store');
Route::get('categoria/mostrar', [CategoriaController::class, 'fetchAll'])->name('categoria.fetchAll');
Route::delete('categoria/borrar', [CategoriaController::class, 'delete'])->name('categoria.delete');
Route::get('categoria/borrar', [CategoriaController::class, 'edit'])->name('categoria.edit');
Route::post('categoria/actualizar', [CategoriaController::class, 'update'])->name('categoria.update');

*/


