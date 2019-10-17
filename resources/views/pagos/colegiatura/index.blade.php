@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Pago de Colegiatura')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-12 col-md-12 mt-2 pb-3 rounded shadow bg-white border">

    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-table text-info"></i> pagos de colegiatura
      </h5>

    </div>
    <!-- Titulo de la seccion -->

    <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
          <i class="fas fa-hand-holding-usd"></i>
          Realizar Pago</a>
      </li>
      @can('cancelar_pago_colegiatura')
      <li class="nav-item">
        <a class="nav-link" id="cancel-tab" data-toggle="tab" href="#cancelar_pago" role="tab" aria-controls="cancelar_pago" aria-selected="false">
          <i class="fas fa-ban"></i>
          Cancelar Pago</a>
      </li>
      @endcan
      @can('editar_pago_colegiatura')
      <li class="nav-item">
        <a class="nav-link" id="edit-tab" data-toggle="tab" href="#editar_pago" role="tab" aria-controls="editar_pago" aria-selected="false">
          <i class="fas fa-pencil-alt"></i>
          Editar Pago</a>
      </li>
      @endcan
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="border-bottom border-gray pb-2 mb-2"></div>
        <div class="card border-0">
          <div class="form-row align-items-center">
            <div class="col-sm-5 my-1">
              <label class="sr-only" for="escuela_id">Escuela</label>
              <select id="escuela_id" name="escuela_id" class="form-control" required>
                @foreach($escuelas as $escuela)
                  @if($loop->first)
                    <option value="" selected>[Elija una escuela]</option>
                  @endif
                  <option value="{{ $escuela->id }}">{{ $escuela->nombre }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-2 my-1">
              <label class="sr-only" for="escuela_id">Ciclo</label>
              <select id="ciclo_id" name="ciclo_id" class="form-control" required>
                @foreach($ciclos as $ciclo)
                  @if($loop->first)
                    <option value="" selected>[Elegir ciclo]</option>
                  @endif
                  <option value="{{ $ciclo->id }}">{{ $ciclo->periodo }}</option>
                @endforeach
              </select>
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
              <th scope="col" class="text-left">NOMBRE</th>
              <th scope="col" class="text-left"></th>
              <th scope="col" class="text-left">APELLIDO P.</th>
              <th scope="col" class="text-left">APELLIDO M.</th>
              <th scope="col" class="text-left">GRUPO</th>
              <th scope="col" class="text-left">ACCIONES</th>
            </tr>
            </thead>
          </table>
        </div>
        <!-- Formulario, Tablas...etc -->

      </div>
      @can('cancelar_pago_colegiatura')
      <div class="tab-pane fade" id="cancelar_pago" role="tabpanel" aria-labelledby="cancel-tab">
        <div class="border-bottom border-gray pb-2 mb-2"></div>
        <div class="card border-0 mt-2">
          <div class="form-group row">
            <label for="fecha" class="col-sm-2 col-form-label">Seleccionar fecha</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" id="fecha" name="fecha" readonly>
            </div>
            <button type="button" class="btn btn-primary mr-2" id="btn_buscar" name="btn_buscar">
              <i class="fas fa-search"></i>
              Realizar Búsqueda</button>
          </div>
        </div>
        <div class="border-bottom border-gray pb-0 mb-2"></div>
        <div class="table-responsive col-12">
          <table class="table table-striped" id="pagos">
            <thead>
            <tr>
              <th scope="col" class="text-left">FECHA</th>
              <th scope="col" class="text-left">#</th>
              <th scope="col" class="text-left">ESTADO</th>
              <th scope="col" class="text-left">IMPORTE</th>
              <th scope="col" class="text-center">ALUMNO</th>
              <th scope="col" class="text-center">ACCIONES</th>
            </tr>
            </thead>
          </table>
        </div>
      </div>
      @endcan
      @can('editar_pago_colegiatura')
      <div class="tab-pane fade" id="editar_pago" role="tabpanel" aria-labelledby="edit-tab">...</div>
      @endcan
    </div>

  </div>
  <!-- Contenedor de la seccion -->

@endsection
@push('scripts')
  <script src="{{ asset('gijgo-datepicker-1.9.1.13/js/gijgo.js')}}"></script>
  <script src="{{ asset('gijgo-datepicker-1.9.1.13/js/messages/messages.es-es.js') }}"></script>
  <script>
    $(document).ready(function(){

      let dtPagos;

      $("select").change( function() {
        if(checkValSelects()===0){
          filtrarDatos(buildUrl());
        }
      });

      $('#fecha').datepicker({
        locale: 'es-es',
        format: 'yyyy-mm-dd',
        showOtherMonths: true,
        showRightIcon: false,
        disableDaysOfWeek: [0, 6],
        uiLibrary: 'bootstrap4',
        iconsLibrary: 'fontawesome'
      });

      function checkValSelects(){
        let selects = ["#escuela_id","#ciclo_id"];
        let count = 0;
        for(let i=0; i<=2; i++){
          if($(selects[i]).val()==='' || $(selects[i]).val()===null) count++;
        }
        return count;
      }

      function buildUrl(){
        let escuela = $("#escuela_id").val();
        let ciclo = $("#ciclo_id").val();
        return urlRoot + '/data/alumnos/'+escuela+'/'+ciclo
      }

      $("#btn_buscar").click(function(){
        if($("#fecha").val()!==""){
          filtrarPagos(urlRoot + '/data/pagos/colegiatura/porfecha/'+$("#fecha").val());
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
            {data: 'nombre1', name: 'nombre1'},
            {data: 'nombre2', name: 'nombre2'},
            {data: 'apellido1', name: 'apellido1'},
            {data: 'apellido2', name: 'apellido2'},
            {data: "group_enroll", className:"text-center", searchable: false,
              render: function(data){
                return htmlDecode(data);
              }
            },
            {data: "pago_colegiatura", className:"text-center", searchable: false,
              render: function(data){
                return htmlDecode(data);
              }
            }
          ]
        });
      }

      function filtrarPagos(urlAjax){
        dtPagos = $('#pagos').DataTable({
          processing: true,
          serverSide: true,
          ordering:false,
          ajax: urlAjax,
          destroy: true,
          language: {
            url: "{{ asset('datatables-1.10.19/lang/Spanish.json') }}"
          },
          columns: [
            {data: 'fecha_pago', name: 'fecha_pago', className:"text-center", searchable: false},
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
            {data: 'importe', name: 'importe', className:"text-center", searchable: false},
            {
              data: null, className:"text-left",
              render: function (data) {
                return data.nombre1+' '+data.nombre2+' '+data.apellido1+' '+data.apellido2;
              }
            },
            {
              data: "showpaytocancel", className:"text-center", searchable: false,
              render: function(data){
                return htmlDecode(data);
              }
            }
          ]
        });

      }

    });
  </script>
@endpush


