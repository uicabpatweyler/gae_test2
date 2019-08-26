@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Imprimir Lista de Asistencia')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-md-10 col-sm-12 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-print text-info"></i> Imprimir lista de asistencia
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
    <form action="" method="POST" id="form_datos" name="form_datos">
      @csrf
      <div class="form-group row">
        <label for="escuela_id" class="col-sm-3 col-form-label">Escuela <span class="text-danger">*</span></label>
        <div class="col-sm-6">
          <select id="escuela_id" name="escuela_id" class="form-control" required>
            @foreach($escuelas as $escuela)
              @if($loop->first)
                <option value="" selected>[Elija una escuela]</option>
              @endif
              <option value="{{ $escuela->id }}">{{ $escuela->nombre }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="ciclo_id" class="col-sm-3 col-form-label">Ciclo <span class="text-danger">*</span></label>
        <div class="col-sm-6">
          <select id="ciclo_id" name="ciclo_id" class="form-control" required>
            @foreach($ciclos as $ciclo)
              @if($loop->first)
                <option value="" selected>[Elija un ciclo escolar]</option>
              @endif
              <option value="{{ $ciclo->id }}">{{ $ciclo->periodo }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="grado_id" class="col-sm-3 col-form-label">Grado <span class="text-danger">*</span></label>
        <div class="col-sm-6">
          <select name="grado_id" id="grado_id" class="form-control" disabled required>
            <option value="" selected></option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="grupo_id" class="col-sm-3 col-form-label">Grupo <span class="text-danger">*</span></label>
        <div class="col-sm-6">
          <select name="grupo_id" id="grupo_id" class="form-control" disabled required>
            <option value="" selected></option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="teacher" class="col-sm-3 col-form-label">Teacher <span class="text-danger">*</span></label>
        <div class="col-sm-6">
          <select name="teacher" id="teacher" class="form-control" required>
            <option value="" selected>[Elegir]</option>
            <option value="Ana Laura Manzanero Alamilla">Ana Laura Manzanero Alamilla</option>
            <option value="Fatima Concepción Manzanero Juarez">Fatima Concepción Manzanero Juarez</option>
            <option value="Estefanía Martínez Suárez">Estefanía Martínez Suárez</option>
            <option value="Laura Margarita Gutierrez">Laura Margarita Gutierrez</option>
            <option value="Monica Vannessa Martinez Cabrera">Monica Vannessa Martinez Cabrera</option>
            <option value="Noel Christopher Gough Witworth">Noel Christopher Gough Witworth</option>
            <option value="Rosa Elizabeth Bautista Gutierrez">Rosa Elizabeth Bautista Gutierrez</option>
            <option value="Wendy Ariel Chulim Lopez">Wendy Ariel Chulim Lopez</option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="mes" class="col-sm-3 col-form-label">Del mes de <span class="text-danger">*</span></label>
        <div class="col-sm-6">
          <input type="text" class="form-control" id="mes" name="mes" readonly required>
        </div>
      </div>
      <div class="form-group row">
        <label for="fechaentrega" class="col-sm-3 col-form-label">Fecha de entrega <span class="text-danger">*</span></label>
        <div class="col-sm-6">
          <input type="text" class="form-control" id="fechaentrega" name="fechaentrega" required readonly>
        </div>
      </div>
      <div class="border-top mt-2 mb-2"></div>
      <div class="float-right">
        <button type="button" class=" btn btn-primary" id="btn_generar" name="btn_generar">
          <i class="far fa-file-pdf"></i>
          Generar Lista de Asistencia
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.es.min.js"></script>
  <script>
    $('#btn_cancelar').click(function(){
      event.preventDefault();
      showCancel('{{ route('grupos.index') }}')
    });
    $().ready(function(){
      $("#mes").datepicker({
        language : 'es',
        autoclose : true,
        minViewMode : 'months',
        format : 'MM-yyyy'
      });
      $('#fechaentrega').datepicker({
        todayBtn: "linked",
        language: "es",
        daysOfWeekDisabled: "0,6",
        autoclose: true,
        todayHighlight: true,
        format: "dd-MM-yyyy"
      });

      $('#mes').datepicker('update', new Date());
      $('#fechaentrega').datepicker('update', new Date());

      $("#escuela_id").change( function (){
        if($(this).val()!==''){
          $('#grado_id').enableControl(true,true);
          $.getJSON(urlRoot+'/data/selectgrados/'+$(this).val(), null, function (values) {
            $('#grado_id').populateSelect(values);
          });
        }
        else{
          $('#grado_id').enableControl(true,false);
        }
      });
      $("#ciclo_id").change( function(){
        if($(this).val()!=='' && $("#grado_id").val()!==''){
          $("#grupo_id").enableControl(true, true);
          $.getJSON(urlRoot+'/data/selectgrupos/'+$("#escuela_id").val()+'/'+$(this).val()+'/'+$("#grado_id").val(), null, function (values) {
              $('#grupo_id').populateSelect(values);
          });
        }
        else{
          $("#grupo_id").enableControl(true,false);
        }
      });

      $("#grado_id").change( function(){
        if($(this).val()!=='' && $("#ciclo_id").val()!==''){
          $("#grupo_id").enableControl(true, true);
          $.getJSON(urlRoot+'/data/selectgrupos/'+$("#escuela_id").val()+'/'+$("#ciclo_id").val()+'/'+$(this).val(), null, function (values) {
            $('#grupo_id').populateSelect(values);
          });
        }
        else{
          $("#grupo_id").enableControl(true,false)
        }
      });

      $("#btn_generar").click(function(){
       if($("#form_datos").valid()){
         window.open(urlRoot+'/print/listadeasistencia/'+$("#grupo_id").val()+'/'+$("#mes").val()+'/'+$("#teacher").val()+'/'+$("#fechaentrega").val());
         return false;
       }
      });

        $("#form_datos").validate({
          debug: false,
          errorElement: "div",
          rules: {
            escuela_id: "required",
            ciclo_id: "required",
            grado_id: "required",
            grupo_id: "required",
            teacher: "required"
          },
          messages: {
            escuela_id: "Elija la escuela",
            ciclo_id: "Elija el ciclo escolar",
            grado_id: "Elija el grado",
            grupo_id: "Elija el grupo",
            teacher: "Elija un nombre de la lista"
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
          submitHandler: function()
          {
          },
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
  </script>
@endpush
