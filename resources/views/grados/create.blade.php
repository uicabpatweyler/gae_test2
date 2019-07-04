@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Nuevo Grado Escolar')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-md-8 col-sm-12 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-plus-circle text-info"></i> nuevo grado escolar
      </h5>
      <a href="{{ route('grados.index') }}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
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
    <form action="{{route('grados.store')}}" method="POST" id="form_grado" name="form_grado">
      <input type="hidden" id="user_created" name="user_created" value="{{Auth::id()}}">
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
        <label for="nombre" class="col-sm-3 col-form-label">Nombre <span class="text-danger">*</span></label>
        <div class="col-sm-6">
          <input type="text" class="form-control" id="nombre" name="nombre" style="text-transform: capitalize" placeholder="Nombre del grado" required>
        </div>
      </div>
      <div class="form-group row">
        <label for="abreviacion" class="col-sm-3 col-form-label">Abrev.</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" id="abreviacion" name="abreviacion" placeholder="Abreviacion del grado">
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
  <script src="{{ asset('modulos/grados.js') }}"></script>
  <script>
    $('#btn_cancelar').click(function(){
      event.preventDefault();
      showCancel('{{ route('grados.index') }}')
    });
  </script>
@endpush
