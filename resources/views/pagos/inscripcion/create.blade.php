@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Pago de Inscripción')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-md-12 col-sm-12 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-plus-circle text-info"></i> Pago de Inscripción
      </h5>

    </div>
    <!-- Titulo de la seccion -->

    <div class="border-bottom border-gray pb-2 mb-2">
        <span class="font-weight-bold">
            Recuerda verificar si todos los datos son correctos: Alumno, Grupo, Fecha, Cuota
        </span>
      <small class="text-danger"> (* campo obligatorio)</small>
    </div>

    <div class="row">
      <div class="col-md-6">
        <table class="table table-bordered">
          <thead></thead>
          <tbody>
          <tr>
            <td class="blue900 text-white">Ciclo Escolar</td>
            <td>{{$ciclo->periodo}}</td>
          </tr>
          <tr>
            <td class="blue900 text-white">Escuela</td>
            <td>{{$escuela->nombre}}</td>
          </tr>
          <tr>
            <td class="blue900 text-white">Alumno</td>
            <td>{{$alumno->full_name}}</td>
          </tr>
          <tr>
            <td class="blue900 text-white">Matrícula</td>
            <td>{{$alumno->matricula}}</td>
          </tr>
          </tbody>
        </table>
      </div>
      <div class="col-md-6">
        <table class="table table-bordered">
          <thead></thead>
          <tbody>
          <tr>
            <td class="bg-success text-white">Recibo</td>
            <td class="text-center">
              <span class="font-weight-bold text-danger">
                {{$recibo->serie}}-{{$recibo->folio}}
              </span>
            </td>
          </tr>
          <tr>
            <td class="bg-success text-white">Grado</td>
            <td class="text-center">{{$grado->nombre}}</td>
          </tr>
          <tr>
            <td class="bg-success text-white">Grupo</td>
            <td class="text-center">{{$grupo->nombre}}</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        Detalles del pago
      </div>
      <div class="card-body">
        <form method="POST" action="{{route('pagos_inscripcion.store')}}" id="form_pago" name="form_pago">
          <input type="hidden" id="user_created" name="user_created" value="{{Auth::id()}}">
          <input type="hidden" id="inscripcion_id" name="inscripcion_id" value="{{$inscripcion->id}}">
          <input type="hidden" id="escuela_id" name="escuela_id" value="{{$inscripcion->escuela_id}}">
          <input type="hidden" id="ciclo_id" name="ciclo_id" value="{{$inscripcion->ciclo_id}}">
          <input type="hidden" id="grado_id" name="grado_id" value="{{$inscripcion->grado_id}}">
          <input type="hidden" id="grupo_id" name="grupo_id" value="{{$inscripcion->grupo_id}}">
          <input type="hidden" id="alumno_id" name="alumno_id" value="{{$inscripcion->alumno_id}}">
          <input type="hidden" id="serie_recibo" name="serie_recibo" value="{{$recibo->serie}}">
          <input type="hidden" id="folio_recibo" name="folio_recibo" value="{{$recibo->folio}}">
          <input type="hidden" id="cantidad_concepto" name="cantidad_concepto" value="1">
          <input type="hidden" id="importe_cuota" name="importe_cuota" value="{{$cuota->cantidad}}">
          <input type="hidden" id="cantidad_recibida_mxn" name="cantidad_recibida_mxn" value="{{$cuota->cantidad}}">
          <input type="hidden" id="urlRecibo" value="">
          <input type="hidden" id="urlHoja" value="">

          @csrf


          <table class="table">
            <thead>
            <tr>
              <th scope="col" class="text-left">Fecha</th>
              <th scope="col" class="text-center">Cantidad</th>
              <th scope="col" class="text-center">Concepto</th>
              <th scope="col" class="text-center">Importe</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>
                <div class="form-row">
                  <div class="form-group col-md-7">
                    <input type="text" class="form-control form-control-sm" id="fecha" name="fecha" value="{{$inscripcion->fecha->format('d-m-Y')}}" readonly>
                  </div>
                </div>
              </td>
              <td class="text-center">
                <span class="font-weight-bold">1</span>
              </td>
              <td class="text-center"><span class="font-italic">Cuota de inscripción del ciclo: {{$ciclo->periodo}}</span></td>
              <td class="text-right">$ {{number_format($cuota->cantidad,2,'.',',')}}</td>
            </tr>
            <tr>
              <td style="width: 25%;"></td>
              <td></td>
              <td class="text-right"><span class="font-weight-bold">Total</span></td>
              <td class="text-right"> <span class="font-weight-bold">$ {{number_format($cuota->cantidad,2,'.',',')}}</span> </td>
            </tr>
            </tbody>
          </table>
          <div class="mt-2 mb-2"></div>
          <div class="float-left">
            <button class="btn btn-info mr-1" id="btn_recibo" name="btn_recibo" disabled>
              <i class="fas fa-print"></i>
              Imprimir Recibo
            </button>
            <button class="btn btn-info mr-1" id="btn_hoja" name="btn_hoja" disabled>
              <i class="far fa-address-card"></i>
              Hoja de Inscripción
            </button>
          </div>
          <div class="float-right">
            <button type="button" class="btn blue700 text-white" id="btn_guardar" name="btn_guardar">
              <i class="fas fa-dollar-sign"></i>
              Pagar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Contenedor de la seccion -->

@endsection

@push('scripts')
  <!-- Archivo(s) javascript del modulo -->
  <script src="{{ asset('jqueryvalidate-1.19.0/jquery.validate.js') }}"></script>
  <script src="{{ asset('jqueryinputmask/jquery.inputmask.js') }}"></script>
  <script src="{{ asset('gijgo-datepicker-1.9.1.13/js/gijgo.js')}}"></script>
  <script src="{{ asset('gijgo-datepicker-1.9.1.13/js/messages/messages.es-es.js') }}"></script>
  <script>

    $().ready(function() {

      $('#btn_guardar').click(function(){
        event.preventDefault();
        saveUpdate();
      });

      function saveUpdate(){
        $("#btn_guardar").prop('disabled', 'disabled');
        $.ajax({
          method: "POST",
          url: $("#form_pago").attr('action'),
          data: $("#form_pago").serialize()
        })
          .done(function(data, textStatus, jqXHR){
            $("#urlRecibo").val(data.urlRecibo);
            $("#urlHoja").val(data.urlHoja);
            $("#fecha").prop('disabled','disabled');
            showSwal(textStatus, jqXHR.statusText, data.message);
            $("#btn_recibo, #btn_hoja").removeAttr('disabled');
          })
          .fail(function( jqXHR, textStatus, errorThrown){
            var message = 'Ocurrio un error al procesar el pago de inscripción';
            showSwal(textStatus, jqXHR.statusText, message);
            console.log(jqXHR);
            $("#btn_guardar").removeAttr('disabled');
          });
      }

      function showSwal(_textStatus, _statusText, _message){
        Swal.fire({
          type:  _textStatus,
          title: _statusText === 'OK' ? 'OK' : _statusText,
          text:  _message,
          allowOutsideClick:  false,
          showCancelButton:   _statusText !== 'OK',
          showConfirmButton:  _statusText === 'OK',
          confirmButtonColor: '#3085d6',
          cancelButtonColor:  '#d33',
          cancelButtonText:   'Corregir',
          confirmButtonText:  'Continuar'
        }).then((result) => {
          if (result.value) {

          }
        });
      }

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
      }).datepicker({
        locale: 'es-es',
        format: 'dd-mm-yyyy',
        showRightIcon: false,
        showOtherMonths: true,
        disableDaysOfWeek: [0, 6]
      });

      $("#btn_recibo").click(function(){
        event.preventDefault();
        window.open($("#urlRecibo").val());
        return false;
      });

      $("#btn_hoja").click(function(){
        event.preventDefault();
        window.open($("#urlHoja").val());
        return false;
      });

      function isInValid(element){
        $(element).addClass("is-invalid").removeClass("is-valid");
        $("#btn_guardar").prop("disabled", true);
      }
    });
  </script>
@endpush

