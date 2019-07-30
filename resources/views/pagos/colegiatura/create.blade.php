@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Pago de colegiatura')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-md-12 col-sm-12 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-plus-circle text-info"></i> pago de colegiatura
      </h5>
      <a href="{{ route('pagocolegiaturas.index') }}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
        <i class="far fa-arrow-alt-circle-left"></i> regresar
      </a>
    </div>
    <!-- Titulo de la seccion -->

    <div class="border-bottom border-gray pb-2 mb-2">
        <span class="font-weight-bold">
            Seleccione el mes o los meses que desea realizar el pago. Puede modificar la columa recargo y descuento para
          ajustar el importe.
        </span>
    </div>

    <div class="row">
      <div class="col-md-6">
        <table class="table table-sm table-bordered">
          <thead></thead>
          <tbody>
          <tr>
            <td class="blue900 text-white font-weight-bold" style="width: 40%">Ciclo Escolar</td>
            <td>{{$ciclo->periodo}}</td>
          </tr>
          <tr>
            <td class="blue900 text-white font-weight-bold" style="width: 40%">Escuela</td>
            <td>{{$escuela->nombre}}</td>
          </tr>
          <tr>
            <td class="blue900 text-white font-weight-bold" style="width: 40%">Alumno</td>
            <td>{{$alumno->full_name}}</td>
          </tr>
          <tr>
            <td class="blue900 text-white font-weight-bold" style="width: 40%">Matrícula</td>
            <td>{{$alumno->matricula}}</td>
          </tr>
          </tbody>
        </table>
      </div>
      <div class="col-md-6">
        <table class="table table-sm table-bordered">
          <thead></thead>
          <tbody>
          <tr>
            <td class="bg-success text-white font-weight-bold" style="width: 50%">Recibo</td>
            <td class="text-center">
              <span class="font-weight-bold text-danger">
                {{$recibo->serie}}-{{$recibo->folio}}
              </span>
            </td>
          </tr>
          <tr>
            <td class="bg-success text-white font-weight-bold" style="width: 50%">Grado</td>
            <td class="text-center">{{$grado->nombre}}</td>
          </tr>
          <tr>
            <td class="bg-success text-white font-weight-bold" style="width: 50%">Grupo</td>
            <td class="text-center">{{$grupo->nombre}}</td>
          </tr>
          <tr>
            <td class="bg-success text-white font-weight-bold" style="width: 50%">Fecha del pago</td>
            <td class="text-center">
              <input type="text" class="form-control form-control-sm text-center" id="_fecha" name="_fecha" value="{{$fecha}}" readonly>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="col-md-12">
      <div class="text-center">
        <button type="button" class="btn red600 text-white mr-1" id="btn_cancelar" name="btn_cancelar">
          <i class="fas fa-times-circle"></i>
          Cancelar
        </button>
        <button type="button" class="btn blue700 text-white" id="btn_guardar" name="btn_guardar" disabled>
          <i class="fas fa-hand-holding-usd"></i>
          Realizar Pago
        </button>
        <button type="button" class="btn btn-info" id="btn_recibo" name="btn_recibo" disabled>
          <i class="far fa-file-pdf"></i>
          Imprimir Recibo
        </button>
      </div>
    </div>
    <div class="border-bottom mt-2 mb-2"></div>
    <form method="POST" action="{{route('pgocolegiaturas.store')}}" id="form_pagocolegiatura" name="form_pagocolegiatura">
      <input type="hidden" id="rows_detallepago" name="rows_detallepago" value="">
      <input type="hidden" id="cantidad_recibida_mxn" name="cantidad_recibida_mxn" value="">
      <input type="hidden" id="escuela_id" name="escuela_id" value="{{$inscripcion->escuela_id}}">
      <input type="hidden" id="ciclo_id" name="ciclo_id" value="{{$inscripcion->ciclo_id}}">
      <input type="hidden" id="alumno_id" name="alumno_id" value="{{$inscripcion->alumno_id}}">
      <input type="hidden" id="grupo_id" name="grupo_id" value="{{$inscripcion->grupo_id}}">
      <input type="hidden" id="grado_id" name="grado_id" value="{{$inscripcion->grado_id}}">
      <input type="hidden" id="user_created" name="user_created" value="{{Auth::id()}}">
      <input type="hidden" id="serie_recibo" name="serie_recibo" value="{{$recibo->serie}}">
      <input type="hidden" id="folio_recibo" name="folio_recibo" value="{{$recibo->folio}}">
      <input type="hidden" id="fecha_pago" name="fecha_pago" value="{{$fecha}}">
      <input type="hidden" id="urlRecibo" value="">
      @csrf()
      <div class="form-row">
        <div class="col-1"></div>
        <div class="col-2 text-center font-weight-bold">Mes</div>
        <div class="col-2 text-center font-weight-bold">Colegiatura</div>
        <div class="col-2 text-center font-weight-bold">Recargo</div>
        <div class="col-2 text-center font-weight-bold">Descuento</div>
        <div class="col-2 text-center font-weight-bold">Importe</div>
      </div>
      @foreach($rows as $row)
        <div class="form-row my-1 text-center" id="{{$row['nombreMes']}}">
          <div class="col-1 my-1">
            <div class="custom-control custom-checkbox mr-sm-2">
              <input type="checkbox" class="custom-control-input" id="chk_{{$row['nombreMes']}}" name="chk_{{$row['nombreMes']}}">
              <label class="custom-control-label" for="chk_{{$row['nombreMes']}}"></label>
            </div>
          </div>
          <div class="col-2">
            <input type="hidden" id="orden_{{$row['nombreMes']}}" name="orden_{{$row['nombreMes']}}" value="{{$row['orden']}}">
            <input type="text" class="form-control form-control-sm text-center" id="mes_{{$row['nombreMes']}}" name="mes_{{$row['nombreMes']}}" value="{{$row['nombreMes']}}" disabled>
          </div>
          <div class="col-2">
            <input type="text" class="form-control form-control-sm text-center colegiatura" id="cuota_{{$row['nombreMes']}}" name="cuota_{{$row['nombreMes']}}" value="{{$row['cuota']}}" disabled>
          </div>
          <div class="col-2">
            <input type="text" class="form-control form-control-sm text-center recargo" id="recargo_{{$row['nombreMes']}}" name="recargo_{{$row['nombreMes']}}" value="{{$row['recargo']}}" disabled>
          </div>
          <div class="col-2">
            <input type="text" class="form-control form-control-sm text-center descuento" id="desc_{{$row['nombreMes']}}" name="desc_{{$row['nombreMes']}}" value="{{$row['descuento']}}" disabled>
          </div>
          <div class="col-2">
            <input type="text" class="form-control form-control-sm text-center importe" id="importe_{{$row['nombreMes']}}" name="importe_{{$row['nombreMes']}}" value="" disabled>
          </div>
        </div>
      @endforeach
    </form>

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

    $('#btn_cancelar').click(function(){
      event.preventDefault();
      showCancel('{{ route('pagocolegiaturas.index') }}')
    });

    //https://stackoverflow.com/questions/149055/how-can-i-format-numbers-as-currency-string-in-javascript
    Number.prototype.format = function(n, x) {
      var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
      return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
    };

    $().ready(function() {

      let checked = 0;
      let datos = [];
      let item = {};

      $('#_fecha').datepicker({
        locale: 'es-es',
        format: 'dd-mm-yyyy',
        showOtherMonths: true,
        disableDaysOfWeek: [0, 6]
      }).change(function(){
        $("#fecha_pago").val($(this).val());
      });

      maskNumeric(".colegiatura");

      function maskNumeric(element){
        $(element).inputmask({
          alias: 'numeric',
          groupSeparator : ',',
          autoGroup : true,
          digits : 2,
          digitsOptional: false,
          placeholder: '0',
          prefix: '$ '
        });
      }

      $("#btn_guardar").click(function(){
        datos = [];
        $("input:checkbox:checked").each(function(){
          let fila = $(this).attr("name").slice(4);
          item = {};
          item['orden'] = parseInt($("#orden_"+fila).val());
          item['mes'] = fila;
          item['cuota'] = parseFloat($("#cuota_"+fila).inputmask('unmaskedvalue'));
          item['recargo'] = parseFloat($("#recargo_"+fila).val());
          item['descuento'] = parseFloat($("#desc_"+fila).val());
          item['importe'] = parseFloat($("#importe_"+fila).inputmask('unmaskedvalue'));
          datos.push(item);
        });
        let message = datos.length === 1
          ? '1 mes. Total: '+totalPagar(true)
          : datos.length + ' meses. Total: '+totalPagar(true);

        Swal.fire({
          type:  'info',
          title: message,
          text:  '¿Los datos son correctos?',
          allowOutsideClick:  false,
          showCancelButton:   true,
          showConfirmButton:  true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor:  '#d33',
          cancelButtonText:   'Verificar',
          confirmButtonText:
            '<i class="fas fa-hand-holding-usd"></i> Realizar Pago',
          confirmButtonAriaLabel: 'Realizar Pago',
        }).then((result) => {
          if (result.value) {
            $("#rows_detallepago").val(JSON.stringify(datos));
            $("#cantidad_recibida_mxn").val(totalPagar(false));
            saveUpdate();
          }
        });
      });

      function saveUpdate(){
        $("#btn_guardar").prop('disabled', 'disabled');
        $.ajax({
          method: "POST",
          url: $("#form_pagocolegiatura").attr('action'),
          data: $("#form_pagocolegiatura").serialize()
        })
          .done(function(data, textStatus, jqXHR){
            $("#urlRecibo").val(data.urlRecibo);
            $("#_fecha").prop('disabled','disabled');
              showSwal('success', 'OK', data.message);
            $("#btn_recibo").removeAttr('disabled');
          })
          .fail(function( jqXHR, textStatus, errorThrown){
            var message = 'Ocurrio un error al procesar el pago de colegiatura.';
            showSwal('error', 'ERROR', message);
            console.log(jqXHR);
            $("#btn_recibo").removeAttr('disabled');
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
          confirmButtonText:  'OK'
        }).then((result) => {
          if (result.value) {
            $(":checkbox").prop('disabled', 'disabled');
            $(".recargo").prop('disabled','disabled');
            $(".descuento").prop('disabled','disabled');
          }
        });
      }

      $("#btn_recibo").click(function(){
        event.preventDefault();
        window.open($("#urlRecibo").val());
        return false;
      });

      function totalPagar(format){
        let total=0;
        $.each(datos, function(key,value){
          total = total + parseFloat(value['importe']);
        });
        return format ? '$ '+total.format(2) : total;
      }

      $(":checkbox").change( function () {
        //El usuario selecciona el checbox
        if($(this).is(':checked')){
          enableRow($(this).attr("name").slice(4));
          importeFila($(this).attr("name").slice(4), true);
          checked++;
          inputsChecked();
        }
        else{
          disableRow($(this).attr("name").slice(4));
          importeFila($(this).attr("name").slice(4), false)
          checked--;
          inputsChecked();
        }
      });

      function inputsChecked(){
        if(checked===0){
          $("#btn_guardar").enableControl(false,false);
        }else{
          $("#btn_guardar").enableControl(false,true);
        }
      }

      function enableRow(fila){
        $("#recargo_"+fila).removeAttr('disabled');
        $("#desc_"+fila).removeAttr('disabled');
      }

      function disableRow(fila){
        $("#recargo_"+fila).prop('disabled','disabled');
        $("#desc_"+fila).prop('disabled','disabled');
      }

      function importeFila(fila, empty){
        let recargo = parseFloat($("#recargo_"+fila).val());
        let desc    = parseFloat($("#desc_"+fila).val());
        let cuota   = parseFloat($("#cuota_"+fila).inputmask('unmaskedvalue'));
        let importe = ( cuota + ( (recargo/100) * cuota ) ) - ( (desc/100) * cuota );
        if(empty===false){ importe = 0;}
        $("#importe_"+fila).val(importe);
        maskNumeric("#importe_"+fila);
      }

      $(".recargo").change( function () {
        if($(this).val()!=="" && $(this).val().length>0 && $.isNumeric($(this).val())){
          importeFila($(this).attr("name").slice(8), true);
        }
        else{
          $(this).val(0);
          importeFila($(this).attr("name").slice(8), true);
        }
      });

      $(".descuento").change( function () {
        if($(this).val()!=="" && $(this).val().length>0 && $.isNumeric($(this).val())){
          importeFila($(this).attr("name").slice(5), true);
        }
        else{
          $(this).val(0);
          importeFila($(this).attr("name").slice(5), true);
        }
      })
    });
  </script>
@endpush

