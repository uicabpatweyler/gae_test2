@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Inscripción de alumno')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-md-12 col-sm-12 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-plus-circle text-info"></i> Inscripción: Tutor del Alumno
      </h5>
      <a href="" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
        <i class="far fa-arrow-alt-circle-left"></i> regresar
      </a>
    </div>
    <!-- Titulo de la seccion -->

    <div class="border-bottom border-gray pb-2 mb-2">
        <span class="font-weight-bold">
            Complete los siguientes datos del tutor
        </span>
      <small class="text-danger"> (* campo obligatorio)</small>
    </div>

    <!-- Formulario -->
    <form method="POST" action="" name="form_tutor" id="form_tutor">
      @csrf
      <div class="form-row">
        <div class="form-group col-md-3">
          <label for="nombre">Nombre <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" style="text-transform:capitalize" required>
        </div>
        <div class="form-group col-md-3">
          <label for="apellido1">Apellido Paterno <span class="text-danger">*</span> </label>
          <input type="text" class="form-control" id="apellido1" name="apellido1" placeholder="Apellido Paterno" style="text-transform:capitalize">
        </div>
        <div class="form-group col-md-3">
          <label for="apellido2">Apellido Materno</label>
          <input type="text" class="form-control" id="apellido2" name="apellido2" placeholder="Apellido Materno" style="text-transform:capitalize">
        </div>
        <div class="form-group col-md-3">
          <label for="genero">Sexo <span class="text-danger">*</span></label>
          <select name="genero" id="genero" class="form-control" required>
            <option value="" selected>[Elegir]</option>
            <option value="H">Hombre</option>
            <option value="M">Mujer</option>
          </select>
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
  <script src="{{ asset('jqueryvalidate-1.19.0/jquery.validate.js') }}"></script>
  <script src="{{ asset('jqueryinputmask/jquery.inputmask.js') }}"></script>
  <script>
    $().ready(function() {

    });
  </script>
@endpush


