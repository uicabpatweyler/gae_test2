@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Nuevo Grupo Escolar')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-md-8 col-sm-12 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-plus-circle text-info"></i> nuevo grupo escolar
      </h5>
      <a href="{{route('grupos.index')}}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
        <i class="far fa-arrow-alt-circle-left"></i> regresar
      </a>
    </div>
    <!-- Titulo de la seccion -->

    <div class="border-bottom border-gray pb-2 mb-2">
        <span class="font-weight-bold">
            Complete los siguientes datos
        </span>
      <small class="text-danger"> (* campo obligatorio)</small>
    </div>

    <!-- Formulario -->
    <form action="{{route('grupos.store')}}" method="POST" id="form_grupo" name="form_grupo">
      @csrf
      <div class="form-group row">
        <label for="escuela_id" class="col-sm-3 col-form-label">Escuela <span class="text-danger">*</span></label>
        <div class="col-sm-9">
          <select id="escuela_id" name="escuela_id" class="form-control" required>
            @foreach($escuelas as $escuela)
              @if($loop->first)
                <option value="" selected>[Elija una escuela]</option>
              @endif
              <option value="{{ $escuela->id }}">{{ $escuela->nombre }} ({{$escuela->nivel->nombre}})</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="ciclo_id" class="col-sm-3 col-form-label">Ciclo <span class="text-danger">*</span></label>
        <div class="col-sm-6">
          <select id="ciclo_id" name="ciclo_id" class="form-control" required>
            @foreach($ciclos as $ciclo)
              @if($loop->first)
                <option value="" selected>[Elija un ciclo escolar]</option>
              @endif
              <option value="{{ $ciclo->id }}">{{ $ciclo->periodo }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="grado_id" class="col-sm-3 col-form-label">Grado <span class="text-danger">*</span></label>
        <div class="col-sm-6">
          <select name="grado_id" id="grado_id" class="form-control" disabled>
            <option value="" selected></option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="cuotainscripcion_id" class="col-sm-3 col-form-label">Cuota Inscrip.</label>
        <div class="col-sm-6">
          <select name="cuotainscripcion_id" id="cuotainscripcion_id" class="form-control" disabled>
            <option value="" selected></option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="cuotacolegiatura_id" class="col-sm-3 col-form-label">Cuota Coleg.</label>
        <div class="col-sm-6">
          <select name="cuotacolegiatura_id" id="cuotacolegiatura_id" class="form-control" disabled>
            <option value="" selected></option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="nombre" class="col-sm-3 col-form-label">Nombre <span class="text-danger">*</span></label>
        <div class="col-sm-6">
          <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del grupo" style="text-transform: uppercase" required>
        </div>
      </div>
      <div class="form-group row">
        <label for="cupoalumnos" class="col-sm-3 col-form-label">Alumnos permitidos <span class="text-danger">*</span></label>
        <div class="col-sm-6">
          <input type="number" min="1" max="50" class="form-control" id="cupoalumnos" name="cupoalumnos" required>
        </div>
      </div>
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
    <!-- Formulario -->

  </div>
  <!-- Contenedor de la seccion -->
@endsection

@push('scripts')
  <!-- Archivo(s) javascript del modulo -->
  <script src="{{ asset('jqueryvalidate-1.19.0/jquery.validate.js') }}"></script>
  <script src="{{ asset('modulos/grupos.js') }}"></script>
  <script>
    $('#btn_cancelar').click(function(){
      event.preventDefault();
      showCancel('{{ route('grupos.index') }}')
    });
  </script>
@endpush
