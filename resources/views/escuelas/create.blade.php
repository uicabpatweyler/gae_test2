@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Nueva Escuela')

{{--Contenido de la seccion--}}
@section('content')

      <!-- Contenedor de la seccion -->
      <div class="col-md-10 col-sm-12 mt-2 pb-3 rounded shadow bg-white border">
      <!-- Titulo de la seccion -->
      <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
        <h5 class="mb-0 lh-100 text-uppercase">
          <i class="fas fa-plus-circle text-info"></i> nueva escuela
        </h5>
        <a href="{{ route('escuelas.index') }}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
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
      <form action="{{route('escuelas.store')}}" method="POST" id="form_escuela" name="form_escuela">
        @csrf
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="cct">C.C.T. <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm" id="cct" name="cct" placeholder="C.C.T." required>
          </div>
          <div class="form-group col-md-6">
            <label for="incorporacion">Núm. de Incorporación</label>
            <input type="text" class="form-control form-control-sm" id="incorporacion" name="incorporacion" placeholder="Núm. de Incorporación">
          </div>
        </div>
        <div class="form-group">
          <label for="nombre">Nombre <span class="text-danger">*</span></label>
          <input type="text" class="form-control form-control-sm" id="nombre" name="nombre" placeholder="Nombre" required>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="tipo_id">Tipo de escuela <span class="text-danger">*</span></label>
            <select id="tipo_id" name="tipo_id" class="form-control form-control-sm" required>
            @foreach($tipos as $tipo)
              @if($loop->first)
                  <option value="" selected></option>
              @endif
                  <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
            @endforeach
            </select>
          </div>
          <div class="form-group col-md-4">
            <label for="nivel_id">Nivel de la escuela <span class="text-danger">*</span></label>
            <select id="nivel_id" name="nivel_id" class="form-control form-control-sm" required disabled>
            </select>
          </div>
          <div class="form-group col-md-4" >
            <label for="servicio_id">Tipo de servicio <span class="text-danger">*</span></label>
            <select id="servicio_id" name="servicio_id" class="form-control form-control-sm" required disabled>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="turno">Turno <span class="text-danger">*</span></label>
            <select id="turno" name="turno" class="form-control form-control-sm" required>
              <option selected value=""></option>
              <option value="No Aplica">No Aplica</option>
              <option value="Matutino">Matutino</option>
              <option value="Vespertino">Vespertino</option>
              <option value="Nocturno">Nocturno</option>
              <option value="Discontinuo">Discontinuo</option>
              <option value="Continuo">Continuo</option>
            </select>
          </div>
          <div class="form-group col-md-4">
            <label for="sostenimiento">Sostenimiento <span class="text-danger">*</span></label>
            <select id="sostenimiento" name="sostenimiento" class="form-control form-control-sm" required>
              <option selected value=""></option>
              <option value="Público">Público</option>
              <option value="Privado">Privado</option>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-3">
            <label for="email">E-mail</label>
            <input type="email" class="form-control form-control-sm" id="email" name="email">
          </div>
          <div class="form-group col-md-3">
            <label for="telefono">Teléfono</label>
            <input type="text" class="form-control form-control-sm" id="telefono" name="telefono" placeholder="(000) 000-0000">
          </div>
        </div>
        <hr class="mt-0 mb-0">
        <h5 class="text-center mb-1">Domicilio</h5>
        <hr class="mt-0">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="calle">Calle</label>
            <input type="text" class="form-control form-control-sm" id="calle" name="calle">
          </div>
          <div class="form-group col-md-3">
            <label for="exterior">Núm. Ext.</label>
            <input type="text" class="form-control form-control-sm" id="exterior" name="exterior" placeholder="">
          </div>
          <div class="form-group col-md-3">
            <label for="interior">Núm. Int.</label>
            <input type="text" class="form-control form-control-sm" id="interior" name="interior" placeholder="">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-5">
            <label for="entrecalles">Entre calles</label>
            <input type="text" class="form-control form-control-sm" id="entrecalles" name="entrecalles" placeholder="">
          </div>
          <div class="form-group col-md-5">
            <label for="colonia">Colonia</label>
            <input type="text" class="form-control form-control-sm" id="colonia" name="colonia">
          </div>
          <div class="form-group col-md-2">
            <label for="codpost">C.P.</label>
            <input type="text" class="form-control form-control-sm" id="codpost" name="codpost" placeholder="">
          </div>
        </div>
        <div class="form-row">

          <div class="form-group col-md-3">
            <label for="entidad">Entidad</label>
            <input type="text" class="form-control form-control-sm" id="entidad" name="entidad" value="Quintana Roo">
          </div>
          <div class="form-group col-md-3">
            <label for="municipio">Municipio</label>
            <input type="text" class="form-control form-control-sm" id="municipio" name="municipio" value="Othón. P. Blanco">
          </div>
          <div class="form-group col-md-3">
            <label for="localidad">Localidad</label>
            <input type="text" class="form-control form-control-sm" id="localidad" name="localidad" value="Chetumal">
          </div>
        </div>
        <div class="border-top mt-2 mb-2"></div>
        <div class="float-right">
          <button class="btn red600 text-white mr-1" id="btn_cancelar" name="btn_cancelar">
            <i class="fas fa-times-circle"></i>
            Cancelar
          </button>
          <button type="submit" class="btn blue700 text-white">
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
<script src="{{ asset('jquerymask-1.14.15/jquery.mask.js') }}"></script>
<script src="{{ asset('modulos/escuela.js') }}"></script>
<script>
  $('#btn_cancelar').click(function(){
    event.preventDefault();
    showCancel('{{ route('escuelas.index') }}')
  });
</script>
@endpush
