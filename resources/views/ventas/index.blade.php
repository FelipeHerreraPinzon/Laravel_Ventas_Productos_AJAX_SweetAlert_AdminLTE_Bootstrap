@extends('layouts.layout')

@section('contenido')




{{-- agregar Producto modal  --}}
<div class="modal fade" id="agregarProductoModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Crear Venta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="agregarProductoForm" novalidate>
        @csrf
        <div class="modal-body p-4 bg-light">
          <div class="row">
            <div class="col-lg">

              
              <label>Producto</label>
              <select name="producto" class="form-control" id="producto" required>
                  <option disabled readonly selected>Selecciona Producto</option>
              </select>
              <div class="invalid-feedback">Producto requerido !</div>


              <label for="precio">Cantidad</label>
              <input type="number" name="cantidad" class="form-control" placeholder="Stock" required>
              <div class="invalid-feedback">Cantidad Obligatoria...</div>


            </div>
           
          </div>
         
      
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" id="agregarProductoBoton" class="btn btn-success">Crear Venta</button>
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
        <h5 class="modal-title" id="exampleModalLabel">Editar Venta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="editarProductoForm" novalidate>
        @csrf
        <input type="hidden" name="venta_id" id="venta_id">
   
        <div class="modal-body p-4 bg-light">
          <div class="row">
            <div class="col-lg">


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



              <label for="cantidad">Cantidad</label>
              <input type="number" name="cantidad" id="cantidad" class="form-control" required>
              <div class="invalid-feedback">Precio Obligatorio...</div>

             

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
          <div class="card-header bg-success d-flex justify-content-between align-items-center">
            <h3 class="text-light">Ventas</h3>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#agregarProductoModal"><i
                class="bi-plus-circle me-2"></i>Crear Venta</button>
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

      /// obtener productos en SELECT
      $(document).ready(function() {
        $.get("{{ route('getProductos') }}", function(data) {
            var select = $("#producto");
            select.empty();
            select.append($('<option>', {
                value: '',
                text: 'Selecciona Producto',
                selected: 'selected',
                disabled: 'disabled'
            })); 
            $.each(data, function(key, value) {
                select.append($('<option>', {
                    value: value.nombre_producto,
                    text: value.nombre_producto,
                    
                }));
            });
        });
    });

    

      // crear venta...
      $("#agregarProductoForm").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        if (!this.checkValidity()) {
          e.preventDefault();
          $(this).addClass('was-validated');
        } else {
        $("#agregarProductoBoton").text('Agregando...');
        $.ajax({
          url: '{{ route('venta.store') }}',
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
                'Venta creada exitosamente!',
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
          url: '{{ route('venta.edit') }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {

            $("#producto").val(response.producto);
            $("#cantidad").val(response.cantidad);
            $("#venta_id").val(response.id);

            var productoActual = response.producto;
            $("#producto option").each(function() {
                if ($(this).val() == productoActual) {
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
          url: '{{ route('venta.update') }}',
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
                'Venta actualizada correctamente!',
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
              url: '{{ route('venta.delete') }}', 
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
          url: '{{ route('venta.fetchAll') }}',
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

      


  </script>
</body>










@endsection