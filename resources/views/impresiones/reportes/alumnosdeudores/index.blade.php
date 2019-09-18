@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Grupos Escolares')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-12 col-md-12 mt-2 pb-3 rounded shadow bg-white border">

    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-table text-info"></i> alumnos deudores
      </h5>
    </div>
    <!-- Titulo de la seccion -->

    <!-- Formulario, Tablas...etc -->
    <div class="card border-0">
      <div class="form-row align-items-center">
        <div class="col-sm-4 my-1">
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
          <label class="sr-only" for="ciclo_id">Ciclo</label>
          <select id="ciclo_id" name="ciclo_id" class="form-control" required>
            @foreach($ciclos as $ciclo)
              @if($loop->first)
                <option value="" selected>[Elegir ciclo]</option>
              @endif
              <option value="{{ $ciclo->id }}">{{ $ciclo->periodo }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-sm-2 my-1">
          <label class="sr-only" for="grado_id">Grado</label>
          <select id="grado_id" name="grado_id" class="form-control" required>
            @foreach($grados as $grado)
              @if($loop->first)
                <option value="" selected>[Elegir grado]</option>
              @endif
              <option value="{{ $grado->id }}">{{ $grado->nombre }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-sm-2 my-1">
          <label class="sr-only" for="nombre_mes">Mes</label>
          <select id="nombre_mes" name="nombre_mes" class="form-control" required>
            <option value="" selected>[Elegir mes]</option>
            <option value="Agosto">Agosto</option>
            <option value="Septiembre">Septiembre</option>
            <option value="Octubre">Octubre</option>
            <option value="Noviembre">Noviembre</option>
            <option value="Diciembre">Diciembre</option>
            <option value="Enero">Enero</option>
            <option value="Febrero">Febrero</option>
            <option value="Marzo">Marzo</option>
            <option value="Abril">Abril</option>
            <option value="Mayo">Mayo</option>
            <option value="Junio">Junio</option>
            <option value="Julio">Julio</option>
          </select>
        </div>
        <button type="button" class="btn btn-success" id="btn_reporte" name="btn_reporte" disabled>
          <i class="far fa-file-pdf"></i>
          Reporte Detallado
        </button>
      </div>
    </div>
    <div class="border-bottom border-gray pb-2 mb-2">
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
      $("select").change( function() {
        if(checkValSelects()===0){
          $("#btn_reporte").enableControl(false,true);
        }else{
          $("#btn_reporte").enableControl(false,false);
        }
      });

      function checkValSelects(){
        let selects = ["#escuela_id","#ciclo_id","#grado_id","#nombre_mes"];
        let count = 0;
        for(let i=0; i<=3; i++){
          if($(selects[i]).val()==='' || $(selects[i]).val()===null) count++;
        }
        return count;
      }

      $("#btn_reporte").click(function(){
        window.open(urlRoot + '/print/alumnosdeudores/'+$("#escuela_id").val()+'/'+$("#ciclo_id").val()+'/'+$("#grado_id").val()+'/'+$("#nombre_mes").val(), '_blank');
        return false;
      });
    });
  </script>

@endpush
