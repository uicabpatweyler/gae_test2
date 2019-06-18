@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Detalles Cuota de Pago')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-md-8 col-sm-12 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-eye text-info"></i> detalle cuota de pago
      </h5>
      <a href="{{route('cuotas.index')}}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
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
    <form action="" method="POST" id="form_cuota" name="form_cuota">
      @csrf
      <div class="form-group row">
        <label for="escuela_id" class="col-sm-3 col-form-label">Escuela </label>
        <div class="col-sm-9">
          <input type="text" class="form-control" value="{{$escuela->nombre}} ({{$escuela->nivel->nombre}})" disabled>
        </div>
      </div>
      <div class="form-group row">
        <label for="ciclo_id" class="col-sm-3 col-form-label">Ciclo</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" value="{{$ciclo->periodo}}" disabled>
        </div>
      </div>
      <div class="form-group row">
        <label for="tipo" class="col-sm-3 col-form-label">Tipo de Cuota</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" value="{{ $cuota->tipo === 1 ? "Inscripción" : "Colegiatura" }}" disabled>
        </div>
      </div>
      <div class="form-group row">
        <label for="nombre" class="col-sm-3 col-form-label">Nombre</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" id="nombre" name="nombre" value="{{$cuota->nombre}}" style="text-transform: capitalize" disabled>
        </div>
      </div>
      <div class="form-group row">
        <label for="cantidad" class="col-sm-3 col-form-label">Cuota <span class="text-danger">*</span></label>
        <div class="col-sm-6">
          <input type="text" class="form-control" id="cantidad" name="cantidad" value="$ {{number_format($cuota->cantidad,2,'.',',')}}" disabled>
        </div>
      </div>
      <div class="border-top mt-2 mb-2"></div>
      <div class="float-right">
        <a class="btn blue700 text-white" href="{{ route('cuotas.edit', ['id' => $cuota->id]) }}" id="btn_edit" name="btn_edit" role="button">
          <i class="fas fa-pencil-alt"></i>
          Editar
        </a>
      </div>
    </form>
    <!-- Formulario -->

  </div>
  <!-- Contenedor de la seccion -->
@endsection

@push('scripts')
  <!-- Archivo(s) javascript del modulo -->
  <script src="{{ asset('jqueryvalidate-1.19.0/jquery.validate.js') }}"></script>
  <script>
    $('#btn_cancelar').click(function(){
      event.preventDefault();
      showCancel('{{ route('cuotas.index') }}')
    });
  </script>
@endpush
