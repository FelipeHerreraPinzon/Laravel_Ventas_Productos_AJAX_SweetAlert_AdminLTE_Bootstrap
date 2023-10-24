<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('categorias.index');
    }

    public function fetchAll()
    {
        $categorias = Categoria::all();
		$output = '';
		if ($categorias->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre Categoria</th>
               
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
			foreach ($categorias as $categoria) {
				$output .= '<tr>
                <td>' . $categoria->id . '</td>
                <td>' . $categoria->nombre_categoria . '</td>
                <td>
                  <a href="#" id="' . $categoria->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i></a>

                  <a href="#" id="' . $categoria->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
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
        $datos = ['nombre_categoria' => $request->nombre_categoria];
		Categoria::create($datos);
		return response()->json([
			'status' => 200,
		]);
    }

  
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request) {
		$id = $request->id;
		$categoria = Categoria::find($id);
		return response()->json($categoria);
	}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request) {
		
		$categoria = Categoria::find($request->categoria_id);


		$datosActualizadoos = ['nombre_categoria' => $request->nombre_categoria];

		$categoria->update($datosActualizadoos);
		return response()->json([
			'status' => 200,
		]);
	}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
		$categoria = Categoria::find($id);
		
		Categoria::destroy($id);
    }
}
