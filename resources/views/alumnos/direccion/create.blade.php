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
    <div class="accordion" id="accordionAlumno">
      <div class="card">
        <div class="card-header" id="headingTwo">
          <h2 class="mb-0">
            <button class="btn btn-primary collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              Dirección del Alumno
            </button>
          </h2>
        </div>
        <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionAlumno">
          <div class="card-body">
            <form method="POST" action="{{route('alumno.direccion.store')}}" id="form_direccion" name="form_direccion">
              <input type="hidden" id="user_created" name="user_created" value="{{Auth::id()}}">
              <input type="hidden" name="alumno_id" id="alumno_id" value="{{$alumno->id}}">
              <input type="hidden" name="estado" id="estado" value="">
              <input type="hidden" name="delegacion" id="delegacion" value="">
              @csrf
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="nombre_vialidad">Nombre de Vialidad <span class="text-danger">*</span></label>
                  <input type="text" class="form-control form-control-sm" style="text-transform:capitalize" id="nombre_vialidad" name="nombre_vialidad" required>
                </div>
                <div class="form-group col-md-2">
                  <label for="exterior">Exterior <span class="text-danger">*</span></label>
                  <input type="text" class="form-control form-control-sm" style="text-transform:capitalize" id="exterior" name="exterior" required>
                </div>
                <div class="form-group col-md-2">
                  <label for="interior">Interior</label>
                  <input type="text" class="form-control form-control-sm" style="text-transform:capitalize" id="interior" name="interior">
                </div>
                <div class="form-group col-md-4">
                  <label for="entre_calles">Entre Calles</label>
                  <input type="text" class="form-control form-control-sm" style="text-transform:capitalize" id="entre_calles" name="entre_calles">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="_estado">Estado <span class="text-danger">*</span></label>
                  <select id="_estado" name="_estado" class="form-control form-control-sm" required>
                    @foreach($estados as $estado)
                      @if($loop->first)
                        <option value="" selected>Seleccione...</option>
                      @endif
                      <option value="{{$estado->id}}">{{$estado->estado_nombre}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-4">
                  <label for="_delegacion">Delegación/Municipio <span class="text-danger">*</span></label>
                  <select id="_delegacion" name="_delegacion" class="form-control form-control-sm" required disabled>
                  </select>
                </div>
                <div class="form-group col-md-4">
                  <label for="colonia">Colonia <span class="text-danger">*</span></label>
                  <select id="colonia" name="colonia" class="form-control form-control-sm" required disabled>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-3">
                  <label for="localidad">Localidad <span class="text-danger">*</span></label>
                  <input type="text" class="form-control form-control-sm detalle" style="text-transform:capitalize" id="localidad" name="localidad" required disabled>
                </div>
                <div class="form-group col-md-3">
                  <label for="tipo_asentamiento">Tipo Asentamiento <span class="text-danger">*</span></label>
                  <input type="text" class="form-control form-control-sm detalle" style="text-transform:capitalize" id="tipo_asentamiento" name="tipo_asentamiento" required disabled>
                </div>
                <div class="form-group col-md-4">
                  <label for="nombre_asentamiento">Nombre Asentamiento <span class="text-danger">*</span></label>
                  <input type="text" class="form-control form-control-sm detalle" style="text-transform:capitalize" id="nombre_asentamiento" name="nombre_asentamiento" required disabled>
                </div>
                <div class="form-group col-md-2">
                  <label for="codigo_postal">Código Postal <span class="text-danger">*</span></label>
                  <input type="text" class="form-control form-control-sm detalle" id="codigo_postal" name="codigo_postal" required disabled>
                </div>
              </div>
              <div class="border-top mt-2 mb-2"></div>
              <div class="float-right mb-2">
                <button type="submit" class="btn blue700 text-white" id="btn_guardar" name="btn_guardar">
                  <i class="fas fa-save"></i>
                  Guardar
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingOne">
          <h2 class="mb-0">
            <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              Datos Personales del Alumno
            </button>
          </h2>
        </div>

        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionAlumno">
          <div class="card-body">
            <div class="border-bottom border-gray pb-2 mb-2">
            <span class="font-weight-bold">
                Datos del alumno
            </span>
            </div>
            <form>
              <div class="form-row">
                <div class="form-group col-md-5">
                  <label for="curp">C.U.R.P</label>
                  <input type="text" class="form-control form-control-sm" id="curp" name="curp" disabled value="{{$alumno->curp}}">
                </div>
                <div class="form-group col-md-2">
                  <label for="fechanacimiento">Fecha de Nacimiento</label>
                  <input type="text" class="form-control form-control-sm" value="{{$alumno->fechanacimiento->format('d-m-Y')}}" disabled>
                </div>
                <div class="form-group col-md-2">
                  <label for="edad">Edad</label>
                  <input type="text" class="form-control form-control-sm" value="{{$alumno->fechanacimiento->diffInYears(\Illuminate\Support\Carbon::now())}} años" disabled>
                </div>
                <div class="form-group col-md-3">
                  <label for="genero">Sexo</label>
                  <input type="text" class="form-control form-control-sm" value="{{$alumno->genero === "H" ? "Hombre" : "Mujer"}}" disabled>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-3">
                  <label for="nombre1">Primer Nombre</label>
                  <input type="text" class="form-control form-control-sm" id="nombre1" name="nombre1" value="{{$alumno->nombre1}}" disabled>
                </div>
                <div class="form-group col-md-3">
                  <label for="nombre2">Segundo Nombre </label>
                  <input type="text" class="form-control form-control-sm" id="nombre2" name="nombre2" value="{{$alumno->nombre2}}" disabled>
                </div>
                <div class="form-group col-md-3">
                  <label for="apellido1">Apellido Materno</label>
                  <input type="text" class="form-control form-control-sm" id="apellido1" name="apellido1" value="{{$alumno->apellido1}}" disabled>
                </div>
                <div class="form-group col-md-3">
                  <label for="apellido2">Apellido Paterno</label>
                  <input type="text" class="form-control form-control-sm" id="apellido2" name="apellido2" value="{{$alumno->apellido2}}" disabled>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Formulario -->

  </div>
  <!-- Contenedor de la seccion -->
@endsection

@push('scripts')
  <!-- Archivo(s) javascript del modulo -->
  <script src="{{ asset('jqueryvalidate-1.19.0/jquery.validate.js') }}"></script>
  <script>
    $().ready(function() {

      $('#form_direccion').validate({
        debug: false,
        errorElement: "div",
        rules: {
          nombre_vialidad:  "required",
          exterior: "required",
          tipo_asentamiento: "required",
          nombre_asentamiento: "required",
          codigo_postal: "required",
          localidad: "required",
          _delegacion: "required",
          _estado: "required",
          colonia: "required"

        },
        messages: {
          nombre_vialidad:  "Obligatorio",
          exterior: "Obligatorio",
          tipo_asentamiento: "Obligatorio",
          nombre_asentamiento: "Obligatorio",
          codigo_postal: "Obligatorio",
          localidad: "Obligatorio",
          _delegacion: "Seleccione un valor",
          _estado: "Seleccione un valor",
          colonia: "Seleccione un valor"

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

      function saveUpdate(){
        $("#btn_guardar").prop('disabled', 'disabled');
        $.ajax({
          method: "POST",
          url: $("#form_direccion").attr('action'),
          data: $("#form_direccion").serialize()
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

      /* Evento change del select de los estados*/
      $("#_estado").change(function(){
        if($(this).val()!==''){
          $("#estado").val($(this).children("option:selected").text());
          $("#_delegacion").enableControl(true, true);
          detalleColoniaDisabled();
          $.getJSON(urlRoot+'/data/delegaciones/'+$(this).val(), null, function (values) {
            $("#_delegacion").populateSelect(values);
          });
        }
        else{
          $("#estado").val("");
          detalleColoniaDisabled();
          $("#_delegacion").enableControl(true,false);
          $("#colonia").enableControl(true, false);
        }
      });

      /*Evento change del select de las delegaciones*/
      $("#_delegacion").change(function () {
        if($(this).val()!==''){
          $("#delegacion").val($(this).children("option:selected").text());
          $("#colonia").enableControl(true, true);
          detalleColoniaDisabled();
          $.getJSON(urlRoot+'/data/colonias/'+$("#_estado").val()+'/'+$(this).val(), null, function (values) {
            $("#colonia").populateSelect(values);
          });
        }
        else{
          $("#delegacion").val("");
          detalleColoniaDisabled();
          $("#colonia").enableControl(true,false);
        }
      });

      /*Evento change del select de las colonias*/
      $("#colonia").change(function () {
        if($(this).val()!==''){
          detalleColoniaEnabled();
          $.getJSON(urlRoot+'/data/colonia/'+$(this).val(), null, function (value) {
            $("#localidad").val(value.localidad);
            $("#tipo_asentamiento").val(value.tipo);
            $("#nombre_asentamiento").val(value.asentamiento);
            $("#codigo_postal").val(value.codigo)
          });
        }
        else{
          detalleColoniaDisabled();
        }
      });

      function detalleColoniaEnabled(){
        $(".detalle ").val("");
        $("#localidad").enableControl(true, true);
        $("#tipo_asentamiento").enableControl(true, true);
        $("#nombre_asentamiento").enableControl(true, true);
        $("#codigo_postal").enableControl(true, true);

      }

      function detalleColoniaDisabled(){
        $(".detalle ").val("");
        $("#localidad").enableControl(true, false);
        $("#tipo_asentamiento").enableControl(true, false);
        $("#nombre_asentamiento").enableControl(true, false);
        $("#codigo_postal").enableControl(true, false);
      }

    });
  </script>
@endpush


