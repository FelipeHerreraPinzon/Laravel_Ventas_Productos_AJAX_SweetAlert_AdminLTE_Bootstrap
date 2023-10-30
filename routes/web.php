<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VentaController;
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
Route::get('getcategorias', [CategoriaController::class, 'getCategorias'])->name('getCategorias');


// ventas
Route::get('ventas', [VentaController::class, 'index'])->name('ventas.index');
Route::post('venta/agregar', [VentaController::class, 'store'])->name('venta.store');
Route::get('venta/mostrar', [VentaController::class, 'fetchAll'])->name('venta.fetchAll');
Route::delete('venta/borrar', [VentaController::class, 'delete'])->name('venta.delete');
Route::get('venta/borrar', [VentaController::class, 'edit'])->name('venta.edit');
Route::post('venta/actualizar', [VentaController::class, 'update'])->name('venta.update');
Route::get('getproductos', [ProductoController::class, 'getProductos'])->name('getProductos');

/*
<label>Producto</label>
              <select name="producto" class="form-control" id="producto" required>
             
                     <?php
                                foreach($productos as $producto)
                                {
                                      echo  '<option value="'.$producto["nombre_producto"].'">'.$producto["nombre_producto"].'</option>';
                                }
                    ?>
              </select>
              <div class="invalid-feedback">Producto es requerido!</div>
*/




