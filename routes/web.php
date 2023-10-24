<?php

use Illuminate\Support\Facades\Route;
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

/*
// productos
Route::get('productos', [CategoriaController::class, 'index'])->name('categorias.index');
Route::post('categoria/agregar', [CategoriaController::class, 'store'])->name('categoria.store');
Route::get('categoria/mostrar', [CategoriaController::class, 'fetchAll'])->name('categoria.fetchAll');
Route::delete('categoria/borrar', [CategoriaController::class, 'delete'])->name('categoria.delete');
Route::get('categoria/borrar', [CategoriaController::class, 'edit'])->name('categoria.edit');
Route::post('categoria/actualizar', [CategoriaController::class, 'update'])->name('categoria.update');

// ventas
Route::get('ventas', [CategoriaController::class, 'index'])->name('categorias.index');
Route::post('categoria/agregar', [CategoriaController::class, 'store'])->name('categoria.store');
Route::get('categoria/mostrar', [CategoriaController::class, 'fetchAll'])->name('categoria.fetchAll');
Route::delete('categoria/borrar', [CategoriaController::class, 'delete'])->name('categoria.delete');
Route::get('categoria/borrar', [CategoriaController::class, 'edit'])->name('categoria.edit');
Route::post('categoria/actualizar', [CategoriaController::class, 'update'])->name('categoria.update');

*/


