@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Inscripciones por Grado y Grupo')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-12 col-md-12 mt-2 pb-3 rounded shadow bg-white border">

    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-table text-info"></i> Reporte de Inscripciones por Grado y Grupo
      </h5>

    </div>
    <!-- Titulo de la seccion -->

    <div class="card border-0">

      <div class="form-group row">
        <label class="sr-only" for="escuela_id">Escuela</label>
        <div class="col-sm-5">
          <select id="escuela_id" name="escuela_id" class="form-control" required>
            @foreach($escuelas as $escuela)
              @if($loop->first)
                <option value="" selected>[Elija una escuela]</option>
              @endif
              <option value="{{ $escuela->id }}">{{ $escuela->nombre }}</option>
            @endforeach
          </select>
        </div>
        <label class="sr-only" for="escuela_id">Ciclo</label>
        <div class="col-sm-2">
          <select id="ciclo_id" name="ciclo_id" class="form-control" required>
            @foreach($ciclos as $ciclo)
              @if($loop->first)
                <option value="" selected>[Elegir ciclo]</option>
              @endif
              <option value="{{ $ciclo->id }}">{{ $ciclo->periodo }}</option>
            @endforeach
          </select>
        </div>
        <button type="button" class="btn btn-success" id="btn_reporte" name="btn_reporte" disabled>
          <i class="far fa-file-pdf"></i>
          Reporte Detallado</button>
      </div>


    </div>

    <div class="border-bottom border-gray pb-2 mb-2"></div>

  </div>
  <!-- Contenedor de la seccion -->

@endsection
@push('scripts')
  <!-- Axios -->
  <script>
    $(document).ready(function(){

      $("select").change( function() {
        if(checkValSelects()===0){
          $("#btn_reporte").enableControl(false, true);
        }
        else{
          $("#btn_reporte").enableControl(false, false);
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

      $("#btn_reporte").click(function(){
        window.open(buildUrl(), '_blank');
        return false;
      });

      function buildUrl(){
        let escuela = $("#escuela_id").val();
        let ciclo = $("#ciclo_id").val();
        return urlRoot + '/pdf/inscripciones_escuela_ciclo/'+escuela+'/'+ciclo
      }

    });
  </script>
@endpush



