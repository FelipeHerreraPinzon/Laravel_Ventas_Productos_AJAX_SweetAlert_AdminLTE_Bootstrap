<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::all();
    
        return view('ventas.index', compact('productos'));
    }

    public function fetchAll()
    {
        $ventas = Venta::all();
		$output = '';
		if ($ventas->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
			foreach ($ventas as $venta) {
				$output .= '<tr>
                <td>' . $venta->id . '</td>
                <td>' . $venta->producto . '</td>
                <td>' . $venta->cantidad . '</td>
                <td>
                  <a href="#" id="' . $venta->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editarProductoModal"><i class="bi-pencil-square h4"></i></a>

                  <a href="#" id="' . $venta->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
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
        $datos = ['producto' => $request->producto, 'cantidad' => $request->cantidad ];
		Venta::create($datos);
		return response()->json([
			'status' => 200,
		]);
    }

 

        /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request) {
		$id = $request->id;
		$venta = Venta::find($id);
		return response()->json($venta);
   
	}

     /**
     * Update the specified resource in storage.
     */
    public function update(Request $request) {
		
		$venta = Venta::find($request->venta_id);


		$datosActualizados = ['producto' => $request->producto, 'cantidad' => $request->cantidad];

		$venta->update($datosActualizados);
		return response()->json([
			'status' => 200,
		]);
	}

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request) {
		$id = $request->id;
	//	$emp = Venta::find($id);
		
        Venta::destroy($id);
		
	}
}
