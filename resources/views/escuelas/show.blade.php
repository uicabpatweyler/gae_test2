@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Mostrar Escuela')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-10 col-md-10 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-eye text-info"></i> detalles escuela
      </h5>
      <a href="{{ route('escuelas.index') }}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
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
        <div class="form-group col-md-6">
          <label for="cct">C.C.T.</label>
          <input type="text" class="form-control form-control-sm" id="cct" name="cct" value="{{ $escuela->cct }}" disabled>
        </div>
        <div class="form-group col-md-6">
          <label for="incorporacion">Núm. de Incorporación</label>
          <input type="text" class="form-control form-control-sm" id="incorporacion" name="incorporacion" value="{{$escuela->incorporacion}}" disabled>
        </div>
      </div>
      <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" class="form-control form-control-sm" id="nombre" name="nombre" value="{{$escuela->nombre}}" disabled>
      </div>
      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="tipo_id">Tipo de escuela</label>
          <input type="text" id="tipo_id" name="tipo_id" class="form-control form-control-sm" value="{{ $escuela->tipo->nombre }}" disabled>
        </div>
        <div class="form-group col-md-4">
          <label for="nivel_id">Nivel de la escuela</label>
          <input type="text" id="nivel_id" name="nivel_id" class="form-control form-control-sm" value="{{ $escuela->nivel->nombre }}" disabled>
        </div>
        <div class="form-group col-md-4" >
          <label for="servicio_id">Tipo de servicio</label>
          <input type="text" id="servicio_id" name="servicio_id" class="form-control form-control-sm" value="{{ $escuela->servicio->nombre }}" disabled>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="turno">Turno</label>
          <input type="text" id="turno" name="turno" class="form-control form-control-sm" value="{{ $escuela->turno }}" disabled>
        </div>
        <div class="form-group col-md-4">
          <label for="sostenimiento">Sostenimiento</label>
          <input type="text" id="sostenimiento" name="sostenimiento" class="form-control form-control-sm" value="{{ $escuela->sostenimiento }}" disabled>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-3">
          <label for="email">E-mail</label>
          <input type="email" class="form-control form-control-sm" id="email" name="email" value="{{$escuela->email}}" disabled>
        </div>
        <div class="form-group col-md-3">
          <label for="telefono">Teléfono</label>
          <input type="text" class="form-control form-control-sm" id="telefono" name="telefono" value="{{$escuela->telefono}}" disabled>
        </div>
      </div>
      <hr class="mt-0 mb-0">
      <h5 class="text-center mb-1">Domicilio</h5>
      <hr class="mt-0">
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="calle">Calle</label>
          <input type="text" class="form-control form-control-sm" id="calle" name="calle" value="{{$escuela->calle}}" disabled>
        </div>
        <div class="form-group col-md-3">
          <label for="exterior">Núm. Ext.</label>
          <input type="text" class="form-control form-control-sm" id="exterior" name="exterior" value="{{$escuela->exterior}}" disabled>
        </div>
        <div class="form-group col-md-3">
          <label for="interior">Núm. Int.</label>
          <input type="text" class="form-control form-control-sm" id="interior" name="interior" value="{{$escuela->interior}}" disabled>
        </div>

      </div>
      <div class="form-row">
        <div class="form-group col-md-5">
          <label for="entrecalles">Entre calles</label>
          <input type="text" class="form-control form-control-sm" id="entrecalles" name="entrecalles" value="{{$escuela->entrecalles}}" disabled>
        </div>
        <div class="form-group col-md-5">
          <label for="colonia">Colonia</label>
          <input type="text" class="form-control form-control-sm" id="colonia" name="colonia" value="{{$escuela->colonia}}" disabled>
        </div>
        <div class="form-group col-md-2">
          <label for="codpost">Código postal</label>
          <input type="text" class="form-control form-control-sm" id="codpost" name="codpost" value="{{$escuela->codpost}}" disabled>
        </div>
      </div>
      <div class="form-row">

        <div class="form-group col-md-3">
          <label for="entidad">Entidad</label>
          <input type="text" class="form-control form-control-sm" id="entidad" name="entidad" value="{{$escuela->entidad}}" disabled>
        </div>
        <div class="form-group col-md-3">
          <label for="municipio">Municipio</label>
          <input type="text" class="form-control form-control-sm" id="municipio" name="municipio" value="{{$escuela->municipio}}" disabled>
        </div>
        <div class="form-group col-md-3">
          <label for="localidad">Localidad</label>
          <input type="text" class="form-control form-control-sm" id="localidad" name="localidad" value="{{$escuela->localidad}}" disabled>
        </div>
      </div>
      <div class="border-top mt-2 mb-2"></div>
      <div class="float-right">
        <a class="btn blue700 text-white" href="{{ route('escuelas.edit', ['id' => $escuela->id]) }}" id="btn_edit" name="btn_edit" role="button">
          <i class="fas fa-pencil-alt"></i>
          Editar
        </a>
      </div>
    <!-- Formulario -->

  </div>
  <!-- Contenedor de la seccion -->

@endsection
