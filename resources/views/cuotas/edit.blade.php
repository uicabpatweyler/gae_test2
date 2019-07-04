@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Editar Cuota de Pago')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-md-8 col-sm-12 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-pencil-alt text-info"></i> editar cuota de pago
      </h5>
      <a href="{{route('cuotas.index')}}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
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
    <form action="{{route('cuotas.update', $cuota->id)}}" method="POST" id="form_cuota" name="form_cuota">
      <input type="hidden" id="user_updated" name="user_updated" value="{{Auth::id()}}">
      @method('PATCH')
      @csrf
      <div class="form-group row">
        <label for="escuela_id" class="col-sm-3 col-form-label">Escuela <span class="text-danger">*</span></label>
        <div class="col-sm-9">
          <select id="escuela_id" name="escuela_id" class="form-control" required>
            @foreach($escuelas as $escuela)
              @if($loop->first)
                <option value="">[Elija una escuela]</option>
              @endif
              <option value="{{ $escuela->id }}" {{$cuota->escuela_id === $escuela->id ? "selected" : ""}}>{{ $escuela->nombre }} ({{$escuela->nivel->nombre}})</option>
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
                <option value="">[Elija un ciclo escolar]</option>
              @endif
              <option value="{{ $ciclo->id }}" {{$cuota->ciclo_id === $ciclo->id ? "selected" : ""}}>{{ $ciclo->periodo }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="tipo" class="col-sm-3 col-form-label">Tipo de Cuota <span class="text-danger">*</span></label>
        <div class="col-sm-6">
          <select id="tipo" name="tipo" class="form-control">
            <option value="">[Elegir]</option>
            <option value="1" {{$cuota->tipo === 1 ? "selected" : "" }}>Cuota de Inscripción</option>
            <option value="2" {{$cuota->tipo === 2 ? "selected" : "" }}>Cuota de Colegiatura</option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="nombre" class="col-sm-3 col-form-label">Nombre <span class="text-danger">*</span></label>
        <div class="col-sm-6">
          <input type="text" class="form-control" id="nombre" name="nombre" value="{{$cuota->nombre}}" placeholder="Nombre/Descripción" style="text-transform: capitalize" required>
        </div>
      </div>
      <div class="form-group row">
        <label for="cantidad" class="col-sm-3 col-form-label">Cuota <span class="text-danger">*</span></label>
        <div class="col-sm-6">
          <input type="text" class="form-control" id="cantidad" name="cantidad" value="{{$cuota->cantidad}}" required>
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
  <script src="{{ asset('modulos/cuotas.js') }}"></script>
  <script>
    $('#btn_cancelar').click(function(){
      event.preventDefault();
      showCancel('{{ route('cuotas.index') }}')
    });
  </script>
@endpush
