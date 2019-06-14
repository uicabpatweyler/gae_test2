@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Mostrar Grupo Escolar')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-md-8 col-sm-12 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-eye text-info"></i> detalles grupo escolar
      </h5>
      <a href="{{route('grupos.index')}}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
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
        <input type="text" class="form-control" id="escuela_id" name="escuela_id" value="{{$escuela->nombre}} ({{$escuela->nivel->nombre}})" disabled>
      </div>
    </div>
    <div class="form-group row">
      <label for="ciclo_id" class="col-sm-3 col-form-label">Ciclo</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="ciclo_id" name="ciclo_id" value="{{$ciclo->periodo}}" disabled>
      </div>
    </div>
    <div class="form-group row">
      <label for="grado_id" class="col-sm-3 col-form-label">Grado</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="grado_id" name="grado_id" value="{{$grado->nombre}}" disabled>
      </div>
    </div>
    <div class="form-group row">
      <label for="cuotai" class="col-sm-3 col-form-label">Cuota Inscripción</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="cuotai" name="cuota" value="$ {{number_format($cuotai,2,'.',',')}}" disabled>
      </div>
    </div>
    <div class="form-group row">
      <label for="cuotac" class="col-sm-3 col-form-label">Cuota Colegiatura</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="cuotac" name="cuotac" value="$ {{number_format($cuotac,2,'.',',')}}" disabled>
      </div>
    </div>
    <div class="form-group row">
      <label for="nombre" class="col-sm-3 col-form-label">Nombre</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="nombre" name="nombre" value="{{$grupo->nombre}}" disabled>
      </div>
    </div>
    <div class="form-group row">
      <label for="cupoalumnos" class="col-sm-3 col-form-label">Alumnos permitidos </label>
      <div class="col-sm-6">
        <input type="number" min="1" max="50" class="form-control" value="{{$grupo->cupoalumnos}}" id="cupoalumnos" name="cupoalumnos" disabled>
      </div>
    </div>
    <div class="border-top mt-2 mb-2"></div>
    <div class="float-right">
      <a class="btn blue700 text-white" href="{{ route('grupos.edit', ['id' => $grupo->id]) }}" id="btn_edit" name="btn_edit" role="button">
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
  <script src="{{asset('modulos/grupos.js')}}"></script>
  <script>
    $('#btn_cancelar').click(function(){
      event.preventDefault();
      showCancel('{{ route('grupos.index') }}')
    });
  </script>
@endpush
