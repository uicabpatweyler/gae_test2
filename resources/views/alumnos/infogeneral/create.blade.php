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
            <form method="POST" action="{{route('alumno.infogeneral.update',$infoAlumno->id)}}" name="form_infogral" id="form_infogral">
              @method('PATCH')
              @csrf
              <div class="form-row">
                <div class="form-group col-md-3">
                  <label for="telefcasa">Teléfono de Casa</label>
                  <input type="text" class="form-control form-control-sm" id="telefcasa" name="telefcasa" placeholder="(983)-000-0000">
                </div>
                <div class="form-group col-md-2">
                  <label for="referencia1">Referencia</label>
                  <input type="text" class="form-control form-control-sm" id="referencia1" name="referencia1" placeholder="">
                </div>
                <div class="form-group col-md-3">
                  <label for="teleftutor">Teléfono del Tutor</label>
                  <input type="text" class="form-control form-control-sm" id="teleftutor" name="teleftutor" placeholder="(983)-000-0000">
                </div>
                <div class="form-group col-md-2">
                  <label for="referencia2">Referencia</label>
                  <input type="text" class="form-control form-control-sm" id="referencia2" name="referencia2" placeholder="">
                </div>

              </div>
              <div class="form-row">
                <div class="form-group col-md-3">
                  <label for="telefcelular">Teléfono Celular</label>
                  <input type="text" class="form-control form-control-sm" id="telefcelular" name="telefcelular" placeholder="(983)-000-0000">
                </div>
                <div class="form-group col-md-2">
                  <label for="referencia3">Referencia</label>
                  <input type="text" class="form-control form-control-sm" id="referencia3" name="referencia3" placeholder="">
                </div>
                <div class="form-group col-md-3">
                  <label for="telefotro">Otro</label>
                  <input type="text" class="form-control form-control-sm" id="telefotro" name="telefotro" placeholder="(983)-000-0000">
                </div>
                <div class="form-group col-md-2">
                  <label for="referencia4">Referencia</label>
                  <input type="text" class="form-control form-control-sm" id="referencia4" name="referencia4" placeholder="">
                </div>

              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="escuela">Escuela</label>
                  <input type="text" class="form-control form-control-sm" id="escuela" name="escuela">
                </div>
                <div class="form-group col-md-6">
                  <label for="ultimogrado">Último Grado Escolar a Cursar</label>
                  <input type="text" class="form-control form-control-sm" id="ultimogrado" name="ultimogrado">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="lugartrabajo">Lugar de Trabajo</label>
                  <input type="text" class="form-control form-control-sm" id="lugartrabajo" name="lugartrabajo">
                </div>
                <div class="form-group col-md-6">
                  <label for="email">Correo Eléctronico del Alumno</label>
                  <input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="ejemplo@dominio.com">
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
      <div class="card">
        <div class="card-header" id="headingTwo">
          <h2 class="mb-0">
            <button class="btn btn-info collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              Dirección
            </button>
          </h2>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
          <div class="card-body">
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingThree">
          <h2 class="mb-0">
            <button class="btn btn-info collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              Alumno
            </button>
          </h2>
        </div>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
          <div class="card-body">
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
  <script>
    $().ready(function() {
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

