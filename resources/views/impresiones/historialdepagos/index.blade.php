@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Historial de Pagos')

{{--Contenido de la seccion--}}
@section('content')
  
  <!-- Contenedor de la seccion -->
  <div class="col-12 col-md-12 mt-2 pb-3 rounded shadow bg-white border">
    
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-print text-info"></i> Historial de pagos: Elegir Alumno
      </h5>
    
    </div>
    <!-- Titulo de la seccion -->
    
    <div class="border-bottom border-gray pb-2 mb-2"></div>
  
    <!-- Formulario, Tablas...etc -->
    <div class="table-responsive col-12">
      <table class="table table-striped" id="alumnos">
        <thead>
        <tr>
          <th scope="col" class="text-left">NOMBRE</th>
          <th scope="col" class="text-left"></th>
          <th scope="col" class="text-left">APELLIDO P.</th>
          <th scope="col" class="text-left">APELLIDO M.</th>
          <th scope="col" class="text-left">ACCIONES</th>
        </tr>
        </thead>
      </table>
    </div>
    <!-- Formulario, Tablas...etc -->
  
  </div>
  <!-- Contenedor de la seccion -->

@endsection
@push('scripts')
<script>
$(document).ready(function(){
    $('#alumnos').DataTable({
        processing: true,
        serverSide: true,
        ordering:false,
        ajax: '{{ route('index.historialdepagos1.data') }}',
        language: {
            url: "{{ asset('datatables-1.10.19/lang/Spanish.json') }}"
        },
        columns: [
            {data: 'nombre1', name: 'nombre1'},
            {data: 'nombre2', name: 'nombre2'},
            {data: 'apellido1', name: 'apellido1'},
            {data: 'apellido2', name: 'apellido2'},
            { data: "actions", className:"text-center",
                render: function(data){
                    return htmlDecode(data);
                }
            }
        ]
    });
});
</script>
@endpush