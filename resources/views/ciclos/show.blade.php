@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Mostrar Ciclo')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-10 col-md-10 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-eye text-info"></i> mostrar ciclo
      </h5>
      <a href="{{ route('ciclos.index') }}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
        <i class="far fa-arrow-alt-circle-left"></i> regresar
      </a>
    </div>
    <!-- Titulo de la seccion -->

    <div class="border-bottom border-gray pb-2 mb-2">
        <span class="font-weight-bold">
            Si desea realizar algun cambio, presione el botón Editar.
        </span>
    </div>

    <!-- Formulario -->
    <div class="form-row">
      <div class="form-group col-md-2">
        <label for="periodo">Periodo Escolar <span class="text-danger">*</span></label>
        <input type="text" class="form-control form-control-sm" id="periodo" name="periodo" value="{{ $ciclo->periodo }}" disabled>
      </div>
    </div>
    <div class="border-top mt-2 mb-2"></div>
    <div class="float-right">
      <a class="btn blue700 text-white" href="{{ route('ciclos.edit', ['id' => $ciclo->id]) }}" id="btn_edit" name="btn_edit" role="button">
        <i class="fas fa-pencil-alt"></i>
        Editar
      </a>
    </div>
    <!-- Formulario -->

  </div>
  <!-- Contenedor de la seccion -->
@endsection

@push('scripts')
  <!-- Archivo(s) javascript del modulo -->
  <script src="{{ asset('jqueryvalidate-1.19.0/jquery.validate.js') }}"></script>
  <script src="{{ asset('jquerymask-1.14.15/jquery.mask.js') }}"></script>
  <script src="{{ asset('modulos/ciclos.js') }}"></script>
  <script>
    $('#btn_cancelar').click(function(){
      event.preventDefault();
      showCancel('{{ route('ciclos.index') }}')
    });
  </script>
@endpush