@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Mostrar Grado Escolar')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-md-8 col-sm-12 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
          <i class="fas fa-eye text-info"></i> detalles grado escolar
      </h5>
      <a href="{{ route('grados.index') }}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
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
    <div class="form-group row">
      <label for="escuela_id" class="col-sm-3 col-form-label">Escuela</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" id="escuela" name="escuela" value="{{$escuela->nombre}} ({{$escuela->nivel->nombre}})" disabled>
      </div>
    </div>
    <div class="form-group row">
      <label for="nombre" class="col-sm-3 col-form-label">Nombre</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $grado->nombre }}" disabled>
      </div>
    </div>
    <div class="form-group row">
      <label for="abreviacion" class="col-sm-3 col-form-label">Abrev.</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="abreviacion" name="abreviacion" value="{{ $grado->abreviacion }}" disabled>
      </div>
    </div>
    <div class="border-top mt-2 mb-2"></div>
    <div class="float-right">
      <a class="btn blue700 text-white" href="{{ route('grados.edit', ['id' => $grado->id]) }}" id="btn_edit" name="btn_edit" role="button">
        <i class="fas fa-pencil-alt"></i>
        Editar
      </a>
    </div>
    <!-- Formulario -->

  </div>
  <!-- Contenedor de la seccion -->
@endsection

