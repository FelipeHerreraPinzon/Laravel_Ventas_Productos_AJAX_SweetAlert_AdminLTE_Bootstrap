<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('productos.index');
    }

    public function fetchAll()
    {
        $productos = Producto::all();
		$output = '';
		if ($productos->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre Producto</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
			foreach ($productos as $producto) {
				$output .= '<tr>
                <td>' . $producto->id . '</td>
                <td>' . $producto->nombre_producto . '</td>
                <td>' . $producto->precio . '</td>
                <td>' . $producto->stock . '</td>
                <td>
                  <a href="#" id="' . $producto->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editarCategoriaModal"><i class="bi-pencil-square h4"></i></a>

                  <a href="#" id="' . $producto->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
              </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
		}
    }

    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datos = ['nombre_producto' => $request->nombre_producto, 'precio' => $request->precio, 'stock' => $request->stock ];
		Producto::create($datos);
		return response()->json([
			'status' => 200,
		]);
    }

    

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        //
    }

       /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request) {
		$id = $request->id;
		$producto = Producto::find($id);
		return response()->json($producto);
	}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request) {
		
		$producto = Producto::find($request->producto_id);


		$datosActualizadoos = ['nombre_producto' => $request->nombre_producto, 'precio' => $request->precio, 'stock' => $request->stock];

		$producto->update($datosActualizadoos);
		return response()->json([
			'status' => 200,
		]);
	}

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request) {
		$id = $request->id;
		$emp = Producto::find($id);
		
        Producto::destroy($id);
		
	}
}
