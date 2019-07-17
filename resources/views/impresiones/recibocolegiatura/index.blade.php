@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Imprimir Recibo de Colegiatura')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-12 col-md-12 mt-2 pb-3 rounded shadow bg-white border">

    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-table text-info"></i> Imprimir Recibo de Colegiatura
      </h5>

    </div>
    <!-- Titulo de la seccion -->

    <div class="card border-0">
      <div class="form-group row">
        <label for="fecha" class="col-sm-2 col-form-label">Seleccionar fecha</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" id="fecha" name="fecha" readonly>
        </div>
      </div>
    </div>

    <div class="border-bottom border-gray pb-2 mb-2"></div>

    <!-- Formulario, Tablas...etc -->
    <div class="table-responsive col-12">
      <table class="table table-striped" id="alumnos">
        <thead>
        <tr>
          <th scope="col" class="text-left">CICLO</th>
          <th scope="col" class="text-left">FECHA</th>
          <th scope="col" class="text-left">#</th>
          <th scope="col" class="text-left">ESTADO</th>
          <th scope="col" class="text-left">IMPORTE</th>
          <th scope="col" class="text-left">NOMBRE</th>
          <th scope="col" class="text-left"></th>
          <th scope="col" class="text-left">APELLIDO P.</th>
          <th scope="col" class="text-left">APELLIDO M.</th>
          <th scope="col" class="text-left">GRUPO</th>
          <th scope="col" class="text-left">IMPRESION</th>

        </tr>
        </thead>
      </table>
    </div>
    <!-- Formulario, Tablas...etc -->

  </div>
  <!-- Contenedor de la seccion -->

@endsection
@push('scripts') <script src="{{ asset('gijgo-datepicker-1.9.1.13/js/gijgo.js')}}"></script>
<script src="{{ asset('gijgo-datepicker-1.9.1.13/js/messages/messages.es-es.js') }}"></script>
  <script>
  $(document).ready(function(){
    $('#fecha').datepicker({
      locale: 'es-es',
      format: 'yyyy-mm-dd',
      showOtherMonths: true,
      showRightIcon: false,
      disableDaysOfWeek: [0, 6],
      uiLibrary: 'bootstrap4',
      iconsLibrary: 'fontawesome',
      change: function (e) {
        if($(this).val()!==''){
          filtrarDatos(urlRoot + '/data/pagos/colegiatura/porfecha/'+$(this).val());
        }else{
          console.log($(this).val());
        }
      },
      select: function (e, type) {

      },
      open: function (e) {

      },
      close: function (e) {

      }
    });



    function filtrarDatos(urlAjax){
      $('#alumnos').DataTable({
        processing: true,
        serverSide: true,
        ordering:false,
        ajax: urlAjax,
        destroy: true,
        language: {
          url: "{{ asset('datatables-1.10.19/lang/Spanish.json') }}"
        },
        columns: [
          {data: "ciclo_enroll", className:"text-center", searchable: false,
            render: function(data){
              return htmlDecode(data);
            }
          },
          {data: 'fecha_pago', name: 'fecha_pago', className:"text-center"},
          {data: 'folio_recibo', name: 'folio_recibo', className:"text-center"},
          {
            data: null, className: "text-center",
            render: function (data) {
              if(data.pago_cancelado  === "1"){
                return '<span class="text-danger font-weight-bold">Cancelado</span>'
              }
              return '';
            }
          },
          {data: 'importe', name: 'importe', className:"text-center"},
          {data: 'nombre1', name: 'nombre1'},
          {data: 'nombre2', name: 'nombre2'},
          {data: 'apellido1', name: 'apellido1'},
          {data: 'apellido2', name: 'apellido2'},
          {data: "group_enroll", className:"text-center", searchable: false,
            render: function(data){
              return htmlDecode(data);
            }
          },
          {data: "recibo_colegiatura", className:"text-center", searchable: false,
            render: function(data){
              return htmlDecode(data);
            }
          },

        ]
      });
    }
  });
  </script>
@endpush


