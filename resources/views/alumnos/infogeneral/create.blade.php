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

    <!-- Acordeon -->
    <div class="accordion" id="accordionExample">
      <div class="card">
        <div class="card-header" id="headingOne">
          <h2 class="mb-0">
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              Información General
            </button>
          </h2>
        </div>

        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
          <div class="card-body">
            <form method="POST" action="{{route('alumno.infoadicional.update',$infoAlumno->id)}}" name="form_infogral" id="form_infogral">
              @method('PATCH')
              @csrf
              <div class="form-row">
                <div class="form-group col-md-3">
                  <label for="telefcasa">Teléfono de Casa</label>
                  <input type="text" class="form-control form-control-sm telefono" id="telefcasa" name="telefcasa" placeholder="(983)-000-0000">
                </div>
                <div class="form-group col-md-2">
                  <label for="referencia1">Referencia</label>
                  <input type="text" class="form-control form-control-sm" id="referencia1" name="referencia1" placeholder="" style="text-transform:capitalize">
                </div>
                <div class="form-group col-md-3">
                  <label for="teleftutor">Teléfono del Tutor</label>
                  <input type="text" class="form-control form-control-sm telefono" id="teleftutor" name="teleftutor" placeholder="(983)-000-0000">
                </div>
                <div class="form-group col-md-2">
                  <label for="referencia2">Referencia</label>
                  <input type="text" class="form-control form-control-sm" id="referencia2" name="referencia2" placeholder="" style="text-transform:capitalize">
                </div>

              </div>
              <div class="form-row">
                <div class="form-group col-md-3">
                  <label for="telefcelular">Teléfono Celular</label>
                  <input type="text" class="form-control form-control-sm telefono" id="telefcelular" name="telefcelular" placeholder="(983)-000-0000">
                </div>
                <div class="form-group col-md-2">
                  <label for="referencia3">Referencia</label>
                  <input type="text" class="form-control form-control-sm" id="referencia3" name="referencia3" placeholder="" style="text-transform:capitalize">
                </div>
                <div class="form-group col-md-3">
                  <label for="telefotro">Otro</label>
                  <input type="text" class="form-control form-control-sm telefono" id="telefotro" name="telefotro" placeholder="(983)-000-0000">
                </div>
                <div class="form-group col-md-2">
                  <label for="referencia4">Referencia</label>
                  <input type="text" class="form-control form-control-sm" id="referencia4" name="referencia4" placeholder="" style="text-transform:capitalize">
                </div>

              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="escuela">Escuela</label>
                  <input type="text" class="form-control form-control-sm" id="escuela" name="escuela" style="text-transform:capitalize">
                </div>
                <div class="form-group col-md-6">
                  <label for="ultimogrado">Último Grado Escolar a Cursar</label>
                  <input type="text" class="form-control form-control-sm" id="ultimogrado" name="ultimogrado" style="text-transform:capitalize">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="lugartrabajo">Lugar de Trabajo</label>
                  <input type="text" class="form-control form-control-sm" id="lugartrabajo" name="lugartrabajo" style="text-transform:capitalize">
                </div>
                <div class="form-group col-md-6">
                  <label for="email">Correo Eléctronico del Alumno</label>
                  <input type="text" class="form-control form-control-sm" id="email" name="email" placeholder="ejemplo@dominio.com">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="pregunta1">¿Cómo te enteraste de la escuela?</label>
                  <select name="pregunta1" id="pregunta1" class="form-control form-control-sm">
                    <option value="" selected>[Elija una opción]</option>
                    <option value="Radio">Radio</option>
                    <option value="Periódico">Periódico</option>
                    <option value="Familiares">Familiares</option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="pregunta2">¿Por qué quieres estudiar inglés?</label>
                  <select name="pregunta2" id="pregunta2" class="form-control form-control-sm">
                    <option value="" selected>[Elija una opción]</option>
                    <option value="Escuela">Escuela</option>
                    <option value="Empleo">Empleo</option>
                    <option value="Tiempo Libre">Tiempo Libre</option>
                  </select>
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
        <div class="card-header" id="headingTwo">
          <h2 class="mb-0">
            <button class="btn btn-info collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              Dirección del Alumno
            </button>
          </h2>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
          <div class="card-body">
            <form>
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="">Nombre de Vialidad</label>
                  <input type="text" class="form-control form-control-sm" value="{{$infoAlumno->nombre_vialidad}}" style="text-transform:capitalize" disabled>
                </div>
                <div class="form-group col-md-2">
                  <label for="">Exterior</label>
                  <input type="text" class="form-control form-control-sm" value="{{$infoAlumno->exterior}}" style="text-transform:capitalize" disabled>
                </div>
                <div class="form-group col-md-2">
                  <label for="">Interior</label>
                  <input type="text" class="form-control form-control-sm" {{$infoAlumno->interior}} style="text-transform:capitalize" disabled>
                </div>
                <div class="form-group col-md-4">
                  <label for="">Entre Calles</label>
                  <input type="text" class="form-control form-control-sm" value="{{$infoAlumno->entre_calles}}" style="text-transform:capitalize" disabled>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="">Colonia</label>
                  <input type="text" class="form-control form-control-sm" value="{{$infoAlumno->tipo_asentamiento}} {{$infoAlumno->nombre_asentamiento}}" style="text-transform:capitalize" disabled>
                </div>
                <div class="form-group col-md-3">
                  <label for="">Código Postal</label>
                  <input type="text" class="form-control form-control-sm" value="{{$infoAlumno->codigo_postal}}" style="text-transform: capitalize" disabled>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="">Delegación</label>
                  <input type="text" class="form-control form-control-sm" value="{{$infoAlumno->delegacion}}" style="text-transform:capitalize" disabled>
                </div>
                <div class="form-group col-md-4">
                  <label for="">Localidad</label>
                  <input type="text" class="form-control form-control-sm" value="{{$infoAlumno->localidad}}" style="text-transform: capitalize" disabled>
                </div>
                <div class="form-group col-md-4">
                  <label for="">Estado</label>
                  <input type="text" class="form-control form-control-sm" value="{{$infoAlumno->estado}}" style="text-transform: capitalize" disabled>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingThree">
          <h2 class="mb-0">
            <button class="btn btn-success collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              Datos Personales del Alumno
            </button>
          </h2>
        </div>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
          <div class="card-body">
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
    <!-- Acordeon -->

  </div>
  <!-- Contenedor de la seccion -->
@endsection

@push('scripts')
  <!-- Archivo(s) javascript del modulo -->
  <script src="{{ asset('jqueryvalidate-1.19.0/jquery.validate.js') }}"></script>
  <script src="{{ asset('jqueryinputmask/jquery.inputmask.js') }}"></script>
  <script>
    $().ready(function() {

      $(".telefono").inputmask("(9{3})-9{3}-9{4}",{
        clearMaskOnLostFocus: true,
        greedy: false,
        jitMasking: true,
        onincomplete: function () {
          $(this).addClass("is-invalid").removeClass("is-valid");
          $("#btn_guardar").prop("disabled", true);
        },
        oncomplete: function () {
          $(this).removeClass("is-invalid");
          $("#btn_guardar").prop("disabled", false);
        }
      });

      $("#email").inputmask({
        clearMaskOnLostFocus: true,
        mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
        greedy: false,
        onBeforePaste: function (pastedValue, opts) {
          pastedValue = pastedValue.toLowerCase();
          return pastedValue.replace("mailto:", "");
        },
        definitions: {
          '*': {
            validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
            casing: "lower"
          }
        },
        onincomplete: function () {
          if($(this).val()!==""){
            isInValid("#email");
          }
          else{

          }
        },
        oncomplete: function () {
         isComplete("#email");
        }
      });

      function isInValid(element){
        $(element).addClass("is-invalid").removeClass("is-valid");
        $("#btn_guardar").prop("disabled", true);
      }

      function isComplete(element){
        $(element).removeClass("is-invalid");
        $("#btn_guardar").prop("disabled", false);
      }

      $( "#form_infogral" ).submit(function( event ) {
        event.preventDefault();
        saveUpdate();
      });

      function saveUpdate(){
        $("#btn_guardar").prop('disabled', 'disabled');
        $.ajax({
          method: "POST",
          url: $("#form_infogral").attr('action'),
          data: $("#form_infogral").serialize()
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

