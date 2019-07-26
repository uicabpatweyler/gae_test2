@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Editar Producto')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-md-12 col-sm-12 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-plus-circle text-info"></i> editar producto
      </h5>
      <a href="{{route('productos.index')}}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
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

    <form action="{{route('productos.update', $producto->id)}}" method="POST" id="form_producto" name="form_producto">
      <input type="hidden" id="user_updated" name="user_updated" value="{{Auth::id()}}">
      <input type="hidden" id="nombre_categoria" name="nombre_categoria" value="{{$producto->nombre_categoria}}">
      @method('PATCH')
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
                    <option value=""></option>
                  @endif
                  <option value="{{ $categoria->id }}" {{$producto->categoria_id === $categoria->id ? "selected" : ""}}>{{ $categoria->nombre }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="subcategoria_id">Sub-Categoría<span class="text-danger">*</span></label>
              <select class="form-control form-control-sm" name="subcategoria_id" id="subcategoria_id" required >
                @foreach($subcategorias as $subcategoria)
                  @if($loop->first)
                    <option value=""></option>
                  @endif
                  <option value="{{ $subcategoria->id }}" {{$producto->subcategoria_id === $subcategoria->id ? "selected" : ""}}>{{ $subcategoria->nombre }}</option>
                @endforeach
              </select>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="clasificacion1_id">Clasificación<span class="text-danger">*</span></label>
              <select class="form-control form-control-sm" name="clasificacion1_id" id="clasificacion1_id" required>
                @foreach($clasificaciones as $clasificacion)
                  @if($loop->first)
                    <option value=""></option>
                  @endif
                  <option value="{{ $clasificacion->id }}" {{$producto->clasificacion1_id === $clasificacion->id ? "selected" : ""}}>{{ $clasificacion->nombre }}</option>
                @endforeach
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
                    <option value="">[Elija una escuela]</option>
                  @endif
                  <option value="{{ $escuela->id }}" {{$producto->escuela_id === $escuela->id ? "selected" : ""}}>{{ $escuela->nombre }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="ciclo_id">Ciclo <span class="text-danger">*</span></label>
              <select id="ciclo_id" name="ciclo_id" class="form-control form-control-sm" required>
                @foreach($ciclos as $ciclo)
                  @if($loop->first)
                    <option value="">[Elegir ciclo]</option>
                  @endif
                  <option value="{{ $ciclo->id }}" {{$producto->ciclo_id === $ciclo->id ? "selected" : ""}}>{{ $ciclo->periodo }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-3">
              <label for="codigo">Código</label>
              <input type="text" class="form-control form-control-sm" id="codigo" name="codigo" value="{{$producto->codigo}}">
            </div>
            <div class="form-group col-md-5">
              <label for="nombre">Nombre <span class="text-danger">*</span></label>
              <input type="text" class="form-control form-control-sm" value="{{$producto->nombre}}" id="nombre" name="nombre" style="text-transform: capitalize" required>
            </div>
            <div class="form-group col-md-4">
              <label for="adicional">Info. Adicional</label>
              <input type="text" class="form-control form-control-sm" id="adicional" name="adicional" value="{{$producto->adicional}}">
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-3">
              <label for="precio_venta">Precio de Venta <span class="text-danger">*</span></label>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">$</div>
                </div>
                <input type="text" class="form-control text-right" value="{{$producto->precio_venta}}" id="precio_venta" name="precio_venta" required>
              </div>
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
    $('#btn_cancelar').click(function(){
      event.preventDefault();
      showCancel('{{ route('productos.index') }}')
    });

    $().ready(function(){
      $('#form_producto').validate({
        debug: false,
        errorElement: "div",
        rules: {
          categoria_id: "required",
          subcategoria_id: "required",
          clasificacion1_id: "required",
          escuela_id: "required",
          ciclo_id: "required",
          nombre: { required: true, minlength:2 },
          precio_venta:  "required"
        },
        messages: {
          categoria_id: "Falta la categoría",
          subcategoria_id: "Falta la sub-categoría",
          clasificacion1_id: "Falta la clasificación",
          escuela_id: "Falta la escuela",
          ciclo_id: "Falta el ciclo",
          nombre: { required: "Falta el nombre", minlength:"Min. 2 caracteres"},
          precio_venta:  "Falta el precio"
        },
        invalidHandler: function(event, validator) {
          // 'this' refers to the form
          var errors = validator.numberOfInvalids();
          if (errors) {
            var message = errors === 1
              ? 'Verifica el campo marcado en rojo'
              : 'Verifica los ' + errors + ' campos marcados en rojo';
            showAlert('error','ERROR',message,'');
          } else {
            // informar que se procedera a guardar el formulario
          }
        },
        submitHandler: function() { saveUpdate(); },
        errorPlacement: function ( error, element ) {
          error.addClass( "invalid-feedback" );
          if ( element.prop( "type" ) === "checkbox" ) {
            error.insertAfter( element.parent( "label" ) );
          } else {
            error.insertAfter( element );
          }
        },
        success: function(element){
          $( element ).remove();
        },
        highlight: function ( element, errorClass, validClass ) {
          $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
        },
        unhighlight: function (element, errorClass, validClass) {
          $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
        }
      });
      $("#categoria_id").change(function(){
        if($(this).val()!==""){
          $('#subcategoria_id').enableControl(true,true);
          $("#clasificacion1_id").enableControl(true,false);
          $("#nombre_categoria").val($(this).find("option:selected").text());
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
      function saveUpdate(){
        $("#btn_guardar").prop('disabled', 'disabled');
        $.ajax({
          method: "POST",
          url: $("#form_producto").attr('action'),
          data: $("#form_producto").serialize()
        })
          .done(function(data, textStatus, jqXHR){
            showAlert(textStatus, jqXHR.statusText, data.message, data.location);
          })
          .fail(function( jqXHR, textStatus, errorThrown){
            var errors = Object.keys(jqXHR.responseJSON.errors).length;
            var message = errors === 1
              ? 'Verifica el campo marcado en rojo'
              : 'Verifica los ' + errors + ' campos marcados en rojo';

            showAlert(textStatus, jqXHR.statusText, message, '');

            $.each(jqXHR.responseJSON.errors, function(key,value){
              $( "#"+key ).addClass( "is-invalid" ).removeClass( "is-valid" );
              $('<div id="'+key+'-error" class="error invalid-feedback">'+value+'</div>').insertAfter( $( "#"+key ) );
            });
            $("#btn_guardar").removeAttr('disabled');
          });
      }
    });
  </script>
@endpush


