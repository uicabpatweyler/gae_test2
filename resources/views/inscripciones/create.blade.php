@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Inscripción - Asignar Grupo')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-md-12 col-sm-12 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-plus-circle text-info"></i> Inscripción - Asignar Grupo
      </h5>
      <a href="{{ route('inscripciones.index') }}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
        <i class="far fa-arrow-alt-circle-left"></i> regresar
      </a>
    </div>
    <!-- Titulo de la seccion -->

    <div class="card border-0">
      <form method="POST" action="{{route('inscripciones.store')}}" id="form_inscripcion" name="form_inscripcion">
        <input type="hidden" name="escuela_id" id="escuela_id" value="0">
        <input type="hidden" name="ciclo_id" id="ciclo_id" value="0">
        <input type="hidden" name="grado_id" id="grado_id" value="0">
        <input type="hidden" name="grupo_id" id="grupo_id" value="0">
        <input type="hidden" name="infoalumno_id" id="infoalumno_id" value="{{$info->id}}">
        <input type="hidden" name="alumno_id" id="alumno_id" value="{{$info->alumno_id}}">

        @csrf
        <div class="form-row">
          <div class="form-group col-md-3">
            <label for="" class="font-weight-bold">Matrícula</label>
            <input type="text" class="form-control form-control-sm" value="{{$alumno->matricula}}" disabled="">
          </div>
          <div class="form-group col-md-4">
            <label for="" class="font-weight-bold">Alumno</label>
            <input type="text" class="form-control form-control-sm" value="{{$alumno->full_name}}" disabled="">
          </div>
          <div class="form-group col-md-3">
            <label for="grado_grupo" class="font-weight-bold text-danger">Grupo Asignado <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm" id="grado_grupo" name="grado_grupo" placeholder="**Elegir Grupo**">
          </div>
          <div class="form-group col-md-2">
            <label for="fecha" class="font-weight-bold text-danger">Fecha Inscripción <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm" name="fecha" id="fecha" value="{{\Illuminate\Support\Carbon::now()->format('d-m-Y')}}">
          </div>
        </div>
        <div class="border-top mt-2 mb-2"></div>
        <div class="float-right">
          <button class="btn red600 text-white mr-1" id="btn_cancelar" name="btn_cancelar">
            <i class="fas fa-times-circle"></i>
            Cancelar
          </button>
          <button type="submit" class="btn blue700 text-white" id="btn_guardar" name="btn_guardar" disabled>
            <i class="fas fa-save"></i>
            Guardar
          </button>
        </div>
      </form>
    </div>

    <div class="pb-2 mb-2"></div>
    <div class="card">
      <div class="card-header">
        Elija un grupo
      </div>
      <div class="card-body">
        <div class="form-row align-items-center">
          <div class="col-sm-5 my-1">
            <label class="sr-only" for="_escuela">Escuela</label>
            <select id="_escuela" name="_escuela" class="form-control">
              @foreach($escuelas as $escuela)
                @if($loop->first)
                  <option value="" selected>[Elija una escuela]</option>
                @endif
                <option value="{{ $escuela->id }}">{{ $escuela->nombre }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-sm-2 my-1">
            <label class="sr-only" for="_grado">Grado</label>
            <select id="_grado" name="_grado" class="form-control" disabled>
            </select>
          </div>
          <div class="col-sm-2 my-1">
            <label class="sr-only" for="_ciclo">Ciclo</label>
            <select id="_ciclo" name="_ciclo" class="form-control">
              @foreach($ciclos as $ciclo)
                @if($loop->first)
                  <option value="" selected>[Elegir ciclo]</option>
                @endif
                <option value="{{ $ciclo->id }}">{{ $ciclo->periodo }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="table-responsive col-12">
          <table class="table table-striped" id="grupos">
            <thead>
            <tr>
              <th scope="col" class="text-center">GRADO</th>
              <th scope="col" class="text-center">GRUPO</th>
              <th scope="col" class="text-center">CUPO</th>
              <th scope="col" class="text-center">ALUMNOS</th>
              <th scope="col" class="text-center">DISPONIBLE</th>
              <th scope="col" class="text-center">CUOTA</th>
              <th scope="col" class="text-center"></th>
            </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- Contenedor de la seccion -->

@endsection

@push('scripts')
  <!-- Archivo(s) javascript del modulo -->
  <script src="{{ asset('jqueryvalidate-1.19.0/jquery.validate.js') }}"></script>
  <script src="{{ asset('jqueryinputmask/jquery.inputmask.js') }}"></script>
  <script>
    $('#btn_cancelar').click(function(){
      event.preventDefault();
      showCancel('{{ route('inscripciones.index') }}')
    });

    function asignarGrupo(value){
      let detalles = value.split('-');
      $("#escuela_id").val(detalles[0]);
      $("#ciclo_id").val(detalles[1]);
      $("#grado_id").val(detalles[2]);
      $("#grupo_id").val(detalles[3]);
      $("#grado_grupo").val(detalles[4]);
      $("#btn_guardar").enableControl(false,true);
    }

    function clearDetails(){
      $("#escuela_id").val(0);
      $("#ciclo_id").val(0);
      $("#grado_id").val(0);
      $("#grupo_id").val(0);
      $("#grado_grupo").val('').attr('placeholder','**Elegir Grupo**');
      $("#btn_guardar").enableControl(false,false);
    }

    /*
     *  https://juristr.com/blog/2008/08/javascript-onchange-event-handling/
     *  https://api.jquery.com/change/
     *  onChange event handler
    */

    $().ready(function() {
      $("select").change( function() {
        if( $(this).attr('name') === "_escuela"){
          if($(this).val()!==''){
            $("#_grado").enableControl(true,true);
            getGrados($(this).val());
          }
          else{
            $("#_grado").enableControl(true,false);
          }
        }
        if(checkValSelects()===0){
          filtrarGrupos(buildUrl());
          clearDetails();
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
          if($("#grado_grupo").val()!=='') { $("#btn_guardar").prop("disabled", false); }
        }
      });

      $('#form_inscripcion').validate({
        debug: false,
        errorElement: "div",
        rules: {
          grado_grupo: "required",
          fecha: "required"
        },
        messages: {
          grado_grupo: "Falta el grupo",
          fecha:       "Falta la fecha"
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
        submitHandler: function() { showConfirm(); },
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

      function saveUpdate(){
        $("#btn_guardar").prop('disabled', 'disabled');
        $.ajax({
          method: "POST",
          url: $("#form_inscripcion").attr('action'),
          data: $("#form_inscripcion").serialize()
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

      function showConfirm(){
        Swal.fire({
          title: '¿El grupo y la fecha son correctos?',
          text: "Presione Continuar para Guardar",
          type: 'warning',
          allowOutsideClick:  false,
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Continuar',
          cancelButtonText: 'Verificar'
        }).then((result) => {
          if (result.value) {
            saveUpdate();
          }
        })
      }

      function getGrados(value){
        $.getJSON(urlRoot+'/data/selectgrados/'+value, null, function (values) {
          $('#_grado').populateSelect(values);
        });
      }

      function filtrarGrupos(urlAjax){
        $('#grupos').DataTable({
          processing: true,
          serverSide: true,
          ordering: false,
          searching: false,
          destroy: true,
          ajax: urlAjax,
          language: {
            url: "{{ asset('datatables-1.10.19/lang/Spanish.json') }}"
          },
          columns: [
            {data: 'grado.nombre', name: 'grado.nombre', className: "text-center"},
            {data: 'nombre', name: 'nombre', className: "text-center"},
            {data: 'cupoalumnos', name: 'cupoalumnos', className: "text-center"},
            {data: 'inscritos', name: 'inscritos', className: "text-center"},
            {
              data: null, className: "text-center",
              render: function (data) {
                if(data.cupoalumnos - data.inscritos === 0){
                  return '<i class="fas fa-ban text-danger"></i>'
                }
                return data.cupoalumnos - data.inscritos;
              }
            },
            {data: 'cuotains', name: 'cuotains', className: "text-center"},
            { data: null, className:"text-center",
              render: function(data){
                if(data.cupoalumnos - data.inscritos === 0){
                  return '';
                }
                return htmlDecode(data.details);
              }

            }
          ]
        });
      }

      function checkValSelects(){
        let selects = ["#_escuela", "#_grado", "#_ciclo"];
        let count = 0;
        for(let i=0; i<=2; i++){
          if($(selects[i]).val()==='' || $(selects[i]).val()===null) count++;
        }
        return count;
      }

      function buildUrl(){
        let escuela = $("#_escuela").val();
        let ciclo = $("#_ciclo").val();
        let grado = $("#_grado").val();
        return urlRoot + '/data/gruposinscripcion/'+escuela+'/'+ grado+'/'+ciclo
      }

      function isInValid(element){
        $(element).addClass("is-invalid").removeClass("is-valid");
        $("#btn_guardar").prop("disabled", true);
      }
    });
  </script>
@endpush
