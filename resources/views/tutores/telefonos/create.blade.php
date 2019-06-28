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
        <i class="fas fa-plus-circle text-info"></i> Telefonos del tutor
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
              Teléfonos del Tutor
            </button>
          </h2>
        </div>

        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
          <div class="card-body">
            <form method="POST" action="{{route('tutor.telefonos.update', $infoTutor->id)}}" name="form_telefonos" id="form_telefonos">
              @method('PATCH')
              @csrf
              <div class="form-row">
                <div class="form-group col-md-3">
                  <label for="telefcasa">Teléfono de Casa</label>
                  <input type="text" class="form-control form-control-sm telefono" value="{{$infoAlumno->telefcasa}}" id="telefcasa" name="telefcasa" placeholder="( 983 ) - 000 - 0000">
                </div>
                <div class="form-group col-md-2">
                  <label for="referencia1">Referencia</label>
                  <input type="text" class="form-control form-control-sm" value="{{$infoAlumno->referencia1}}" id="referencia1" name="referencia1" placeholder="" style="text-transform:capitalize">
                </div>
                <div class="form-group col-md-3">
                  <label for="teleftrabajo">Teléfono del Trabajo</label>
                  <input type="text" class="form-control form-control-sm telefono" id="teleftrabajo" name="teleftrabajo" placeholder="( 983 ) - 000 - 0000">
                </div>
                <div class="form-group col-md-2">
                  <label for="referencia2">Referencia</label>
                  <input type="text" class="form-control form-control-sm" id="referencia2" name="referencia2" placeholder="" style="text-transform:capitalize">
                </div>

              </div>
              <div class="form-row">
                <div class="form-group col-md-3">
                  <label for="telefcelular">Teléfono Celular</label>
                  <input type="text" class="form-control form-control-sm telefono" value="{{$infoAlumno->teleftutor}}" id="telefcelular" name="telefcelular" placeholder="( 983 ) - 000 - 0000">
                </div>
                <div class="form-group col-md-2">
                  <label for="referencia3">Referencia</label>
                  <input type="text" class="form-control form-control-sm" id="referencia3" name="referencia3" placeholder="" style="text-transform:capitalize">
                </div>
                <div class="form-group col-md-3">
                  <label for="telefotro">Otro</label>
                  <input type="text" class="form-control form-control-sm telefono" id="telefotro" name="telefotro" placeholder="( 983 ) - 000 - 0000">
                </div>
                <div class="form-group col-md-2">
                  <label for="referencia4">Referencia</label>
                  <input type="text" class="form-control form-control-sm" id="referencia4" name="referencia4" placeholder="" style="text-transform:capitalize">
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
  <script src="{{ asset('jqueryinputmask/jquery.inputmask.js') }}"></script>
  <script>
    $().ready(function() {
      $(".telefono").inputmask("( 9{3} ) - 9{3} - 9{4}",{
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

      $( "#form_telefonos" ).submit(function( event ) {
        event.preventDefault();
        saveUpdate();
      });

      function saveUpdate(){
        $("#btn_guardar").prop('disabled', 'disabled');
        $.ajax({
          method: "POST",
          url: $("#form_telefonos").attr('action'),
          data: $("#form_telefonos").serialize()
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


