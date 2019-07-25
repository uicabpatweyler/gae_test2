@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Nuevo Producto')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-md-12 col-sm-12 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-plus-circle text-info"></i> nuevo producto
      </h5>
      <a href="" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
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

    <form action="{{route('productos.store')}}" method="POST" id="form_producto" name="form_producto">
      <input type="hidden" id="user_created" name="user_created" value="{{Auth::id()}}">
      @csrf
      <div class="card">
        <div class="card-header">
          Clasificación
        </div>
        <div class="card-body">
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="categoria_id">Categoría<span class="text-danger">*</span></label>
              <select class="form-control form-control-sm" name="categoria_id" id="categoria_id" required>
                @foreach($categorias as $categoria)
                  @if($loop->first)
                    <option value="" selected></option>
                  @endif
                  <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="subcategoria_id">Sub-Categoría<span class="text-danger">*</span></label>
              <select class="form-control form-control-sm" name="subcategoria_id" id="subcategoria_id" required disabled>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="clasificacion1_id">Clasificación<span class="text-danger">*</span></label>
              <select class="form-control form-control-sm" name="clasificacion1_id" id="clasificacion1_id" required disabled>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="card mt-2">
        <div class="card-header">
          Datos del producto
        </div>
        <div class="card-body">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="escuela_id">Escuela <span class="text-danger">*</span></label>
              <select id="escuela_id" name="escuela_id" class="form-control form-control-sm" required>
                @foreach($escuelas as $escuela)
                  @if($loop->first)
                    <option value="" selected>[Elija una escuela]</option>
                  @endif
                  <option value="{{ $escuela->id }}">{{ $escuela->nombre }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="ciclo_id">Ciclo <span class="text-danger">*</span></label>
              <select id="ciclo_id" name="ciclo_id" class="form-control form-control-sm" required>
                @foreach($ciclos as $ciclo)
                  @if($loop->first)
                    <option value="" selected>[Elegir ciclo]</option>
                  @endif
                  <option value="{{ $ciclo->id }}">{{ $ciclo->periodo }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="cct">Nombre <span class="text-danger">*</span></label>
              <input type="text" class="form-control form-control-sm" id="nombre" name="nombre" placeholder="nombre" style="text-transform: capitalize" required>
            </div>
          </div>
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
  </div>
  <!-- Contenedor de la seccion -->

@endsection

@push('scripts')
  <!-- Archivo(s) javascript del modulo -->
  <script src="{{ asset('jqueryvalidate-1.19.0/jquery.validate.js') }}"></script>
  <script src="{{ asset('jquerymask-1.14.15/jquery.mask.js') }}"></script>
  <script>
    $().ready(function(){
      $("#categoria_id").change(function(){
        if($(this).val()!==""){
          $('#subcategoria_id').enableControl(true,true);
          $("#clasificacion1_id").enableControl(true,false);
          $.getJSON(urlRoot+'/data/categorias/childs/'+$(this).val(), null, function (values) {
            $('#subcategoria_id').populateSelect(values);
          });
        }
        else{
          $("#subcategoria_id").enableControl(true,false);
          $("#clasificacion1_id").enableControl(true,false);
        }
      });
      $("#subcategoria_id").change(function(){
        if($(this).val()!==""){
          $("#clasificacion1_id").enableControl(true,true);
          $.getJSON(urlRoot+'/data/categorias/childs/'+$(this).val(), null, function (values) {
            $('#clasificacion1_id').populateSelect(values);
          });
        }
        else{
          $("#clasificacion1_id").enableControl(true,false);
        }
      });
    });
  </script>
@endpush

