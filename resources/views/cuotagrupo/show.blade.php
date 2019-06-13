@extends('master')

@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
@endpush

{{-- Titulo de la sección--}}
@section('title', 'Aplicar Cuota de Pago')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-md-10 col-sm-10 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-money-check-alt text-info"></i> aplicar cuota de pago : $ {{number_format($cuota->cantidad,2,'.',',')}}
      </h5>
      <a href="{{ route('cuotas.index') }}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
          <i class="far fa-arrow-alt-circle-left"></i> regresar
      </a>
    </div>
    <!-- Titulo de la seccion -->

    <div class="border-bottom border-gray pb-2 mb-2">
    </div>
    
    <div class="form-row">
      <div class="col-md-6 mt-1">
        <input type="text" class="form-control" value="{{$cuota->nombre}}" disabled>
      </div>
      <div class="col-md-6 mt-1">
        <input type="text" class="form-control" value="{{$escuela->nombre}} ({{$escuela->nivel->nombre}})" disabled>
      </div>
    </div>

    <div class="form-row mt-1">
      <div class="col-md-3">
        <input type="text" class="form-control" value="Ciclo escolar: {{$ciclo->periodo}}" disabled>
      </div>
      <div class="col-md-3"></div>
    </div>

    <div class="border-top border-gray pb-2 mb-2 mt-2 text-center">

    </div>
    
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            Aplicar por grado
          </div>
          <div class="card-body">
            <form action="{{route('test')}}" method="POST"  name="form_grados" id="form_grados">
              @csrf
              <select name="grados[]" id="select_grados" multiple="multiple" style="width: 100%">
                <option value="1">Principiante</option>
                <option value="2">Intermedio</option>
                <option value="3">Avanzados</option>
              </select>
              <div class="border-top mt-2 mb-2"></div>
              <div class="float-right">
                <button class="btn red600 text-white mr-1" id="btn_cancelar" name="btn_cancelar">
                  <i class="fas fa-times-circle"></i>
                  Cancelar
                </button>
                <button type="submit" class="btn blue700 text-white" id="btn_guardar" name="btn_guardar">
                  <i class="fas fa-save"></i>
                  Guardar
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            Aplicar por grupo
          </div>
          <div class="card-body">

          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Contenedor de la seccion -->
@endsection
@push('scripts')
<!-- Archivo(s) javascript del modulo -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
  <script>
    $(function() {
      $(document).ready(function() {
        $('#select_grados').select2();

        $('#select_grados').change(function(){
          var selections = ( JSON.stringify($('#select_grados').select2('data')));
          console.log(selections);
        });

      });
    })
  </script>
@endpush

