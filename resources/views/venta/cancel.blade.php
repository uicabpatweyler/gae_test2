@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Cancelar venta')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-md-12 col-sm-12 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-plus-circle text-info"></i> Cancelar recibo de venta
      </h5>
      <a href="{{ route('ventas.index') }}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
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

    <!-- Formulario -->
    <form action="{{route('cancelar.venta',['salida' => $salida->id])}}" method="POST" id="form_venta" name="form_venta">
      <input type="hidden" id="cancelado_por" name="cancelado_por" value="{{Auth::id()}}">
      @method('PATCH')
      @csrf
      <div class="form-row">
        <div class="form-group col-md-3">
          <label for="">Recibo de venta #</label>
          <input type="text" class="form-control form-control-sm text-center font-weight-bold" value="{{$salida->folio_recibo}}" disabled>
        </div>
        <div class="form-group col-md-3">
          <label for="">Fecha del recibo</label>
          <input type="text" class="form-control form-control-sm" value="{{$salida->fecha_venta->format('Y-m-d')}}" disabled>
        </div>
        <div class="form-group col-md-3">
          <label for="fecha_cancelacion">Fecha de Cancelación <span class="text-danger">*</span></label>
          <input type="text" class="form-control form-control-sm" id="fecha_cancelacion" name="fecha_cancelacion" readonly>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-8">
          <label for="motivo_cancelacion">Motivo de Cancelación</label>
          <input type="text" class="form-control form-control-sm" id="motivo_cancelacion" name="motivo_cancelacion" style="text-transform: capitalize;">
        </div>
        <div class="form-group col-md-4">
          <label for="">Cancelado Por</label>
          <input type="text" class="form-control form-control-sm" value="{{Auth::user()->name}}" disabled>
        </div>
      </div>

      <div class="border-top mt-2 mb-2"></div>
      <div class="float-right">
        <button class="btn red600 text-white mr-1" id="btn_cancelar" name="btn_cancelar">
          <i class="fas fa-times-circle"></i>
          Cancelar
        </button>
        <button type="button" class="btn btn-info" id="btn_recibo" name="btn_recibo">
          <i class="far fa-file-pdf"></i>
          Detalles del Recibo
        </button>
        <button type="button" class="btn blue700 text-white" id="btn_guardar" name="btn_guardar" disabled>
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
  <!-- Archivo(s) javascript del modulo -->
  <script src="{{ asset('gijgo-datepicker-1.9.1.13/js/gijgo.js')}}"></script>
  <script src="{{ asset('gijgo-datepicker-1.9.1.13/js/messages/messages.es-es.js') }}"></script>
  <script>
    $('#btn_cancelar').click(function(){
      event.preventDefault();
      showCancel('{{ route('ventas.index') }}')
    });
    $("#btn_recibo").click(function(){
      event.preventDefault();
      window.open('{{route('print.reciboventa',['salida' => $salida->id])}}');
      return false;
    });
    $().ready(function() {

      $('#fecha_cancelacion').datepicker({
        locale: 'es-es',
        format: 'yyyy-mm-dd',
        showOtherMonths: true,
        showRightIcon: false,
        disableDaysOfWeek: [0, 6],
        uiLibrary: 'bootstrap4',
        iconsLibrary: 'fontawesome'
      }).change( function(){
        $("#btn_guardar").enableControl(false, true);
      });

      $("#btn_guardar").click(function(){
        Swal.fire({
          type:  'question',
          title: 'Cancelar recibo de venta # ' + '{{$salida->folio_recibo}}',
          text:  '',
          allowOutsideClick:  false,
          showCancelButton:   true,
          showConfirmButton:  true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor:  '#d33',
          cancelButtonText:   'No, me equivoque',
          confirmButtonText: 'Si',
        }).then((result) => {
          if (result.value) {
            saveUpdate();
          }
        });
      });

      function saveUpdate(){
        $("#btn_guardar").prop('disabled', 'disabled');
        $.ajax({
          method: "POST",
          url: $("#form_venta").attr('action'),
          data: $("#form_venta").serialize()
        })
          .done(function(data, textStatus, jqXHR){
            showAlert(textStatus, jqXHR.statusText, data.message, data.location);
          })
          .fail(function( jqXHR, textStatus, errorThrown){
            var message = 'Ocurrio un error al cancelar el recibo de venta';
            showAlert(textStatus, jqXHR.statusText, message, '');
            console.log(jqXHR);
            $("#btn_guardar").removeAttr('disabled');
          });
      }

    });
  </script>
@endpush


