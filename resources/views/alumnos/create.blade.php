@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Inscripción de alumno')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-md-12 col-sm-12 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-plus-circle text-info"></i> Inscripción: nuevo alumno
      </h5>
    </div>
    <!-- Titulo de la seccion -->

    <div class="border-bottom border-gray pb-2 mb-2">
        <span class="font-weight-bold">
            Complete los siguientes datos
        </span>
      <small class="text-danger"> (* campo obligatorio)</small>
    </div>

    <!-- Formulario -->
    <form method="POST" action="{{ route('alumnos.store') }}" name="form_alumno" id="form_alumno">
      <input type="hidden" id="user_created" name="user_created" value="{{Auth::id()}}">
      @csrf
      <div class="form-row">
        <div class="form-group col-md-3">
          <label for="fecha" class="font-weight-bold text-danger">Fecha Inscripción <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="fecha" name="fecha" value="{{\Illuminate\Support\Carbon::now()->format('d-m-Y')}}" required>
        </div>
        <div class="form-group col-md-3">
          <label for="curp">C.U.R.P <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="curp" name="curp" placeholder="" required>
        </div>
        <div class="form-group col-md-3">
          <label for="fechanacimiento">Fecha de Nacimiento <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="fechanacimiento" name="fechanacimiento"  required>
        </div>
        <div class="form-group col-md-3">
          <label for="genero">Sexo <span class="text-danger">*</span></label>
          <select name="genero" id="genero" class="form-control" required>
            <option value="" selected>[Elegir]</option>
            <option value="H">Hombre</option>
            <option value="M">Mujer</option>
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-3">
          <label for="nombre1">Primer Nombre <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="nombre1" name="nombre1" placeholder="Primer Nombre" style="text-transform:capitalize" required>
        </div>
        <div class="form-group col-md-3">
          <label for="nombre2">Segundo Nombre </label>
          <input type="text" class="form-control" id="nombre2" name="nombre2" placeholder="Segundo Nombre" style="text-transform:capitalize">
        </div>
        <div class="form-group col-md-3">
          <label for="apellido1">Apellido Paterno <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="apellido1" name="apellido1" placeholder="Apellido Paterno" style="text-transform:capitalize" required>
        </div>
        <div class="form-group col-md-3">
          <label for="apellido2">Apellido Materno</label>
          <input type="text" class="form-control" id="apellido2" name="apellido2" placeholder="Apellido Materno" style="text-transform:capitalize">
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
  <script src="{{ asset('jqueryvalidate-1.19.0/jquery.validate.js') }}"></script>
  <script src="{{ asset('jqueryinputmask/jquery.inputmask.js') }}"></script>
  <script>
    $().ready(function() {

      $('#btn_cancelar').click(function(){
        event.preventDefault();
        showCancel('{{ route('inscripciones.index') }}')
      });

      $('#form_alumno').validate({
        debug: false,
        errorElement: "div",
        rules: {
          curp: { required: true, minlength:23, maxlength:23 },
          fechanacimiento: { required: true, minlength:10, maxlength:10},
          genero: "required",
          nombre1: { required: true, minlength:2, maxlength:60 },
          apellido1: { required: true, minlength:2, maxlength:60 }
        },
        messages: {
          curp: { required: "Falta la CURP", minlength:"CURP Incorrecta", maxlength:"CURP Incorrecta" },
          fechanacimiento: { required: "Falta la fecha nac.", minlength:"Incorrecto", maxlength:"Incorrecto" },
          genero: "Elija el genero",
          nombre1: { required: "Falta el nombre", minlength:"Incorrecto", maxlength:"Incorrecto" },
          apellido1: { required: "Falta el apellido", minlength:"Incorrecto", maxlength:"Incorrecto" }
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

      $("#curp").inputmask("A{4} 9{6} A{1} A{2} A{3} (99)|(AA)|(9A)|(A9)", {
        clearMaskOnLostFocus: true,
        onKeyValidation: function (key, result) {
          if (!result) {
            isInValid("#curp");
          }
        },
        onincomplete: function () {
          isInValid("#curp");
        },
        oncomplete: function () {
          $("#curp").removeClass("is-invalid");
          $("#btn_guardar").prop("disabled", false);
        }
      });

      $('#fechanacimiento').inputmask('datetime',{
        inputFormat: "dd-mm-yyyy",
        onKeyValidation: function (key, result) {
          if (!result) {
            isInValid("#fechanacimiento");
          }
        },
        onincomplete : function(){
          isInValid("#fechanacimiento");
        },
        oncomplete : function(){
          $("#fechanacimiento").removeClass("is-invalid");
          $("#btn_guardar").prop("disabled", false);
        }
      });

      $('#fecha').inputmask('datetime',{
        inputFormat: "dd-mm-yyyy",
        onKeyValidation: function (key, result) {
          if (!result) { isInValid("#fecha"); }
        },
        onincomplete : function(){
          isInValid("#fecha");
        },
        oncomplete : function(){
          $("#fecha").removeClass("is-invalid");
          $("#btn_guardar").prop("disabled", false);
        }
      });

      function isInValid(element){
        $(element).addClass("is-invalid").removeClass("is-valid");
        $("#btn_guardar").prop("disabled", true);
      }

      function saveUpdate(){
        $("#btn_guardar").prop('disabled', 'disabled');
        $.ajax({
          method: "POST",
          url: $("#form_alumno").attr('action'),
          data: $("#form_alumno").serialize()
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

