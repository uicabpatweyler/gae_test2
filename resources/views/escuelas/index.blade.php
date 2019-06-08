@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Escuelas')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-12 col-md-12 mt-2 pb-3 rounded shadow bg-white border">

    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-table text-info"></i> escuelas
      </h5>
      <a href="{{ route('escuelas.create') }}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
        <i class="fas fa-plus"></i> nueva escuela
      </a>
    </div>
    <!-- Titulo de la seccion -->

    <!-- Formulario, Tablas...etc -->
    <div class="table-responsive col-12">
      <table class="table table-striped" id="escuelas">
        <thead>
        <tr>
          <th scope="col" class="text-center">CCT</th>
          <th scope="col" class="text-center">ESCUELA</th>
          <th scope="col" class="text-center">NIVEL</th>
          <th scope="col" class="text-center">TURNO</th>
          <th scope="col" class="text-center">ESTADO</th>
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
      $('#escuelas').DataTable({
        processing: true,
        serverSide: true,
        ordering:false,
        ajax: '{{ route('escuelas.data') }}',
        language: {
          url: "{{ asset('datatables-1.10.19/lang/Spanish.json') }}"
        },
        columns: [
          {data: 'cct', name: 'cct', className:"font-weight-bold"},
          {data: 'nombre', name: 'nombre'},
          {data: 'nivel.nombre', name: 'nivel.nombre'},
          {data: 'turno', name: 'turno', className:"text-center"},
          {data: null, className:"text-center",
            render: function(data){
              if(data.status==="1"){
                return '<i class="fas fa-check text-success"></i>'
              }
              return '<i class="fas fa-times text-danger"></i>'
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