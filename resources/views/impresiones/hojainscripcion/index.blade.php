@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Imprimir Hoja de Inscripción')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-12 col-md-12 mt-2 pb-3 rounded shadow bg-white border">

    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-print text-info"></i> Impresión Hoja de Inscripción
      </h5>

    </div>
    <!-- Titulo de la seccion -->

    <div class="card border-0">
      <div class="form-row align-items-center">
        <div class="col-sm-5 my-1">
          <label class="sr-only" for="escuela_id">Escuela</label>
          <select id="escuela_id" name="escuela_id" class="form-control" required>
            @foreach($escuelas as $escuela)
              @if($loop->first)
                <option value="" selected>[Elija una escuela]</option>
              @endif
              <option value="{{ $escuela->id }}">{{ $escuela->nombre }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-sm-2 my-1">
          <label class="sr-only" for="escuela_id">Ciclo</label>
          <select id="ciclo_id" name="ciclo_id" class="form-control" required>
            @foreach($ciclos as $ciclo)
              @if($loop->first)
                <option value="" selected>[Elegir ciclo]</option>
              @endif
              <option value="{{ $ciclo->id }}">{{ $ciclo->periodo }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>

    <div class="border-bottom border-gray pb-2 mb-2"></div>

    <!-- Formulario, Tablas...etc -->
    <div class="table-responsive col-12">
      <table class="table table-striped" id="alumnos">
        <thead>
        <tr>
          <th scope="col" class="text-left">CICLO</th>
          <th scope="col" class="text-left">NOMBRE</th>
          <th scope="col" class="text-left"></th>
          <th scope="col" class="text-left">APELLIDO P.</th>
          <th scope="col" class="text-left">APELLIDO M.</th>
          <th scope="col" class="text-left">GRUPO</th>
          <th scope="col" class="text-left">IMPRIMIR</th>
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
  <script>
    $(document).ready(function(){

      $("select").change( function() {
        if(checkValSelects()===0){
          filtrarDatos(buildUrl());
        }
      });

      function checkValSelects(){
        let selects = ["#escuela_id","#ciclo_id"];
        let count = 0;
        for(let i=0; i<=2; i++){
          if($(selects[i]).val()==='' || $(selects[i]).val()===null) count++;
        }
        return count;
      }

      function buildUrl(){
        let escuela = $("#escuela_id").val();
        let ciclo = $("#ciclo_id").val();
        return urlRoot + '/data/alumnos/'+escuela+'/'+ciclo
      }

      function filtrarDatos(urlAjax){
        $('#alumnos').DataTable({
          processing: true,
          serverSide: true,
          ordering:false,
          ajax: urlAjax,
          destroy: true,
          language: {
            url: "{{ asset('datatables-1.10.19/lang/Spanish.json') }}"
          },
          columns: [
            {data: "ciclo_enroll", className:"text-center", searchable: false,
              render: function(data){
                return htmlDecode(data);
              }
            },
            {data: 'nombre1', name: 'nombre1'},
            {data: 'nombre2', name: 'nombre2'},
            {data: 'apellido1', name: 'apellido1'},
            {data: 'apellido2', name: 'apellido2'},
            {data: "group_enroll", className:"text-center", searchable: false,
              render: function(data){
                return htmlDecode(data);
              }
            },
            {data: "sheet_enroll", className:"text-center", searchable: false,
              render: function(data){
                return htmlDecode(data);
              }
            }
          ]
        });
      }

    });
  </script>
@endpush

