@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Kardex de Productos')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-12 col-md-12 mt-2 pb-3 rounded shadow bg-white border">

    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-print text-info"></i> Kardex de Productos
      </h5>

    </div>
    <!-- Titulo de la seccion -->
    <div class="card border-0">
      <div class="form-row align-items-center">
        <div class="col-sm-4 my-1">
          <label class="sr-only" for="escuela_id">Escuela</label>
          <select id="escuela_id" name="escuela_id" class="form-control" required>
            @foreach($escuelas as $escuela)
              @if($loop->first)
                <option value="" selected>[Escuela]</option>
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
                <option value="" selected>[Ciclo]</option>
              @endif
              <option value="{{ $ciclo->id }}">{{ $ciclo->periodo }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-sm-2 my-1">
          <label class="sr-only" for="categoria_id">Categoría</label>
          <select id="categoria_id" name="categoria_id" class="form-control" required disabled>
            @foreach($categorias as $categoria)
              @if($loop->first)
                <option value="" selected>[Categoría]</option>
              @endif
              <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>

    <div class="border-bottom border-gray pb-2 mb-2"></div>

    <div class="float-right">
      <button type="button" class="btn btn-success" id="btn_reporte" name="btn_reporte" disabled>
        <i class="far fa-file-pdf"></i>
        Ver Kardex PDF
      </button>
    </div>

  </div>
  <!-- Contenedor de la seccion -->

@endsection
@push('scripts')
<script>
  $().ready(function(){

    $("select").change( function() {
        enableCategories();
        if(checkValSelects()===0){
          $("#btn_reporte").enableControl(false,true);
        }else{
            $("#btn_reporte").enableControl(false,false);
        }
    });

      $("#btn_reporte").click(function(){
          window.open(buildUrl(), '_blank');
          return false;
      });

      function buildUrl(){
          let escuela = $("#escuela_id").val();
          let ciclo = $("#ciclo_id").val();
          let categoria = $("#categoria_id").val();
          return urlRoot + '/pdf/kardex/'+escuela+'/'+ciclo+'/'+categoria;
      }

    function enableCategories(){
        if($("#escuela_id").val()!=='' && $("#ciclo_id").val()!==''){
            $("#categoria_id").enableControl(false,true);
        }
        else{
            $("#categoria_id").val($("#categoria_id option:first").val());
            $("#categoria_id").enableControl(false,false);
        }
    }

    function checkValSelects(){
        let selects = ["#escuela_id","#ciclo_id", "#categoria_id"];
        let count = 0;
        for(let i=0; i<=2; i++){
            if($(selects[i]).val()==='' || $(selects[i]).val()===null) count++;
        }
        return count;
    }

  });
</script>
@endpush
