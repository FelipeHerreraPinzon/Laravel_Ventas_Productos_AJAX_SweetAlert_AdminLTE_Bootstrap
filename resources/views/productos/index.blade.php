@extends('layouts.layout')

@section('contenido')




{{-- agregar Producto modal  --}}
<div class="modal fade" id="agregarProductoModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="agregarProductoForm" novalidate>
        @csrf
        <div class="modal-body p-4 bg-light">
          <div class="row">
            <div class="col-lg">

              <label for="nombre_producto">Nombre Producto</label>
              <input type="text" name="nombre_producto" class="form-control" placeholder="Nombre Producto" required>
              <div class="invalid-feedback">Producto es obligatorio...</div>


              

              <label>Categoría</label>
              <select name="categoria" class="form-control" id="categoria" required>
                  <option disabled readonly selected>Selecciona Categoría</option>
              </select>
              <div class="invalid-feedback">Categoría de producto es requerida!</div>

            

              <label for="precio">Precio</label>
              <input type="number" name="precio" class="form-control" placeholder="Precio" required>
              <div class="invalid-feedback">Precio Obligatorio...</div>

              <label for="precio">Stock</label>
              <input type="number" name="stock" class="form-control" placeholder="Stock" required>
              <div class="invalid-feedback">Precio Obligatorio...</div>


            </div>
           
          </div>
         
      
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" id="agregarProductoBoton" class="btn btn-primary">Agregar Producto</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- add new employee modal end --}}

{{-- edit employee modal start --}}
<div class="modal fade" id="editarProductoModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="editarProductoForm" novalidate>
        @csrf
        <input type="hidden" name="producto_id" id="producto_id">
   
        <div class="modal-body p-4 bg-light">
          <div class="row">
            <div class="col-lg">

              <label for="nombre_producto">Nombre Producto</label>
              <input type="text" name="nombre_producto" id="nombre_producto" class="form-control"  required>
              <div class="invalid-feedback">Producto es obligatorio...</div>

              <label>Categoría Producto</label>
              <select name="categoria" class="form-control" id="categoria" required>
             
                     <?php
                                foreach($categorias as $categoria)
                                {
                                      echo  '<option value="'.$categoria["nombre_categoria"].'">'.$categoria["nombre_categoria"].'</option>';
                                }
                    ?>
              </select>
              <div class="invalid-feedback">Categoria de producto es requerida!</div>



              <label for="precio">Precio</label>
              <input type="number" name="precio" id="precio" class="form-control" required>
              <div class="invalid-feedback">Precio Obligatorio...</div>

              <label for="precio">Stock</label>
              <input type="number" name="stock" id="stock"  class="form-control"  required>
              <div class="invalid-feedback">Stock Obligatorio...</div>

            </div>
          </div>
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" id="editarProductoBoton" class="btn btn-success">Actualizar Producto</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- edit employee modal end --}}

<body class="bg-light">
  <div class="container">
    <div class="row my-3">
      <div class="col-lg-12">
        <div class="card shadow">
          <div class="card-header bg-primary d-flex justify-content-between align-items-center">
            <h3 class="text-light">Productos</h3>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#agregarProductoModal"><i
                class="bi-plus-circle me-2"></i>Agregar Producto</button>
          </div>
          <div class="card-body" id="mostrar_todas_categorias">
            <h1 class="text-center text-secondary my-5">Cargando productos...</h1>
          </div>
        </div>
      </div>
    </div>
  </div>







  <script>



    
    $(function() {

    

      // crear producto...
      $("#agregarProductoForm").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        if (!this.checkValidity()) {
          e.preventDefault();
          $(this).addClass('was-validated');
        } else {
        $("#agregarProductoBoton").text('Agregando...');
        $.ajax({
          url: '{{ route('producto.store') }}',
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              Swal.fire(
                'Agregado!',
                'Producto creado exitosamente!',
                'success'
              )
              
            mostrarProductos();
            }
            $("#agregarProductoBoton").text('Agregar Producto');
            $("#agregarProductoForm")[0].reset();
            $("#agregarProductoModal").modal('hide');
          }
          
        });
      }
      });

     

      // editar producto ...
      $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: '{{ route('producto.edit') }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {

            $("#nombre_producto").val(response.nombre_producto);
            $("#precio").val(response.precio);
            $("#stock").val(response.stock);
            $("#producto_id").val(response.id);

            var categoriaActual = response.categoria;
            $("#categoria option").each(function() {
                if ($(this).val() == categoriaActual) {
                    $(this).prop('selected', true);
                }
            });
    
          }
        });
      });

      // actualizar producto
      $("#editarProductoForm").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        if (!this.checkValidity()) {
          e.preventDefault();
          $(this).addClass('was-validated');
        } else {
        $("#editarProductoBoton").text('Actualizando...');
        $.ajax({
          url: '{{ route('producto.update') }}',
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              Swal.fire(
                'Actualizado!',
                'Producto actualizado correctamente!',
                'success'
              )
              mostrarProductos();
            }
            $("#editarProductoBoton").text('Actualizar Producto');
            $("#editarProductoForm")[0].reset();
            $("#editarProductoModal").modal('hide');
          }
        });
      }
      });



       

      // borrar producto
      $(document).on('click', '.deleteIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
          title: 'Seguro que deseas borrar ?',
          text: "Esta acción es irreversible !",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '{{ route('producto.delete') }}', 
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                console.log(response);
                Swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )
                mostrarProductos();
              }
            });
          }
        })
      });

      // mostrar productos
      mostrarProductos();

      function mostrarProductos() {
        $.ajax({
          url: '{{ route('producto.fetchAll') }}',
          method: 'get',
          success: function(response) {
            $("#mostrar_todas_categorias").html(response);
            $("table").DataTable({
              order: [0, 'desc']
            });
          }
        });
      }
    });

      /// obtener categorias en SELECT
      $(document).ready(function() {
        $.get("{{ route('getCategorias') }}", function(data) {
            var select = $("#categoria");
            select.empty();
            select.append($('<option>', {
                value: '',
                text: 'Selecciona Categoría',
                selected: 'selected',
                   disabled: 'disabled'
            })); 
            $.each(data, function(key, value) {
                select.append($('<option>', {
                    value: value.nombre_categoria,
                    text: value.nombre_categoria,
                    
                }));
            });
        });
    });


  </script>
</body>










@endsection