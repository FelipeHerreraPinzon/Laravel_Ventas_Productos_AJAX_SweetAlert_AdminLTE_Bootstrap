@extends('layouts.layout')

@section('contenido')




{{-- add new employee modal start  addCategoriaModal  --}}
<div class="modal fade" id="addCategoriaModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Categoría</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="addCategoriaForm" novalidate>
        @csrf
        <div class="modal-body p-4 bg-light">
          <div class="row">
            <div class="col-lg">
              <label for="nombre_categoria">Nombre Categoría</label>
              <input type="text" name="nombre_categoria" class="form-control" placeholder="Nombre Categoría" required>
              <div class="invalid-feedback">Categoría es obligatoria...</div>
            </div>
           
          </div>
         
      
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" id="addCategoriaBoton" class="btn btn-primary">Agregar Categoría</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- add new employee modal end --}}

{{-- edit employee modal start --}}
<div class="modal fade" id="editarCategoriaModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Categoría</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="editarCategoriaForm" novalidate>
        @csrf
        <input type="hidden" name="categoria_id" id="categoria_id">
   
        <div class="modal-body p-4 bg-light">
          <div class="row">
            <div class="col-lg">
              <label for="nombre_categoria">Nombre Categoría</label>
              <input type="text" name="nombre_categoria" id="nombre_categoria" class="form-control" required>
              <div class="invalid-feedback">Categoría es obligatoria...</div>
            </div>
          </div>
        
     
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" id="editarCategoriaBoton" class="btn btn-success">Actualizar Categoría</button>
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
            <h3 class="text-light">Categorías</h3>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addCategoriaModal"><i
                class="bi-plus-circle me-2"></i>Crear nueva categoría</button>
          </div>
          <div class="card-body" id="mostrar_todas_categorias">
            <h1 class="text-center text-secondary my-5">Cargando categorías...</h1>
          </div>
        </div>
      </div>
    </div>
  </div>



  <script>
    $(function() {

      // crear categoria...
      $("#addCategoriaForm").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        if (!this.checkValidity()) {
          e.preventDefault();
          $(this).addClass('was-validated');
        } else {
        $("#addCategoriaBoton").text('Agregando...');
        $.ajax({
          url: '{{ route('categoria.store') }}',
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              Swal.fire(
                'Agregada!',
                'Categoría creada exitosamente!',
                'success'
              )
              
            mostrarCategorias();
            }
            $("#addCategoriaBoton").text('Add Employee');
            $("#addCategoriaForm")[0].reset();
            $("#addCategoriaModal").modal('hide');
          }
          
        });
      }
      });

     

      // editar categoría ...
      $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: '{{ route('categoria.edit') }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#nombre_categoria").val(response.nombre_categoria);
            $("#categoria_id").val(response.id);
           
          }
        });
      });

      // update employee ajax request
      $("#editarCategoriaForm").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        if (!this.checkValidity()) {
          e.preventDefault();
          $(this).addClass('was-validated');
        } else {
        $("#editarCategoriaBoton").text('Actualizando...');
        $.ajax({
          url: '{{ route('categoria.update') }}',
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
                'Categoría actualizada correctamente!',
                'success'
              )
              mostrarCategorias();
            }
            $("#editarCategoriaBoton").text('Actualizar Categoría');
            $("#editarCategoriaForm")[0].reset();
            $("#editarCategoriaModal").modal('hide');
          }
        });
      }
      });



       

      // delete employee ajax request
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
              url: '{{ route('categoria.delete') }}', 
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
                mostrarCategorias();
              }
            });
          }
        })
      });

      // mostrar categorias
      mostrarCategorias();

      function mostrarCategorias() {
        $.ajax({
          url: '{{ route('categoria.fetchAll') }}',
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