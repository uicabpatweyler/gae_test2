@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Tutores')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-12 col-md-12 mt-2 pb-3 rounded shadow bg-white border">

    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-table text-info"></i> Tutores
      </h5>
      <a href="{{ route('tutores.create') }}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
        <i class="fas fa-plus"></i> nuevo tutor
      </a>
    </div>
    <!-- Titulo de la seccion -->

    <!-- Formulario, Tablas...etc -->
    <div class="table-responsive col-12">
      <table class="table table-striped" id="tutores">
        <thead>
        <tr>
          <th scope="col" class="text-left">NOMBRE</th>
          <th scope="col" class="text-left">APELLIDO P.</th>
          <th scope="col" class="text-left">APELLIDO M.</th>
          <th scope="col" class="text-center">ESTADO</th>
          <th scope="col" class="text-center">ASIGNAR ALUMNO</th>
          <th scope="col" class="text-center">ACCIONES</th>
        </tr>
        </thead>
      </table>
    </div>
    <!-- Formulario, Tablas...etc -->

  </div>
  <!-- Contenedor de la seccion -->

@endsection
@push('scripts')
  <!-- Axios -->
  <script src="{{asset('axios-0.19.0/axios.js')}}"></script>
  <!-- Datatables JS -->
  <script>
    $(document).ready(function(){
      $('#tutores').DataTable({
        processing: true,
        serverSide: true,
        ordering:false,
        ajax: '{{ route('tutores.data') }}',
        language: {
          url: "{{ asset('datatables-1.10.19/lang/Spanish.json') }}"
        },
        columns: [
          {data: 'nombre', name: 'nombre'},
          {data: 'apellido1', name: 'apellido1'},
          {data: 'apellido2', name: 'apellido2'},
          {data: null, className:"text-center",
            render: function(data){
              if(data.status==="1"){
                return '<i class="fas fa-check text-success"></i>'
              }
              return '<i class="fas fa-times text-danger"></i>'
            }
          },
          {
            data: "asignar", className: "text-center",
            render: function(data){
              return htmlDecode(data);
            }
          },
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