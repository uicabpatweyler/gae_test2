@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Aplicar Cuota de Pago')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-md-10 col-sm-10 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-money-check-alt text-info"></i> aplicar cuota
      </h5>
      <a href="{{ route('cuotas.index') }}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
          <i class="far fa-arrow-alt-circle-left"></i> regresar
      </a>
    </div>
    <!-- Titulo de la seccion -->

    <div class="border-bottom border-gray pb-2 mb-2">
    </div>
    
    <div class="row">
      <div class="col">
        <div class="alert alert-info" role="alert">
          <h5 class="alert-heading">
            {{$cuota->nombre}} : $ {{number_format($cuota->cantidad,2,'.',',')}}
          </h5>
        </div>
      </div>
    </div>

    <div class="border-top border-gray mb-2  text-center">

    </div>
    
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            Aplicar por grado
          </div>
          <div class="card-body">
            <form action="{{route('cuota.grupo',$cuota->id)}}" method="POST" name="form_cuotagrupo" id="form_cuotagrupo">
              @csrf
              <div class="form-group row">
                <label for="grado_id" class="col-sm-3 col-form-label">Grados Escolares <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                  <select id="escuela_id" name="grado_id" class="form-control" required>
                    @foreach($grados as $grado)
                      @if($loop->first)
                        <option value="" selected>[Elija un grado escolar]</option>
                      @endif
                      <option value="{{ $grado->id }}">{{ $grado->nombre }}</option>
                    @endforeach
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
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Contenedor de la seccion -->
@endsection
@push('scripts')
<!-- Archivo(s) javascript del modulo -->
<script src="{{asset('jqueryvalidate-1.19.0/jquery.validate.js')}}"></script>
  <script>
    $(document).ready(function() {
      $('#form_cuotagrupo').validate({
        debug: false,
        errorElement: "div",
        rules: {
          grado_id: "required"
        },
        messages: {
          grado_id: "Elija un grado escolar"
        },
        invalidHandler: function (event, validator) {
          // 'this' refers to the form
          var errors = validator.numberOfInvalids();
          if (errors) {
            var message = errors === 1
              ? 'Verifica el campo marcado en rojo'
              : 'Verifica los ' + errors + ' campos marcados en rojo';
            showAlert('error', 'ERROR', message, '');
          } else {
            // informar que se procedera a guardar el formulario
          }
        },
        submitHandler: function() { saveUpdate(); },
        errorPlacement: function (error, element) {
          error.addClass("invalid-feedback");
          if (element.prop("type") === "checkbox") {
            error.insertAfter(element.parent("label"));
          } else {
            error.insertAfter(element);
          }
        },
        success: function (element) {
          $(element).remove();
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).addClass("is-valid").removeClass("is-invalid");
        }
      });
    });

    function saveUpdate(){
      $("#btn_guardar").prop('disabled', 'disabled');
      $.ajax({
        method: "POST",
        url: $("#form_cuotagrupo").attr('action'),
        data: $("#form_cuotagrupo").serialize()
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
  </script>
@endpush

