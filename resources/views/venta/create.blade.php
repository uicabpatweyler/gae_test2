@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Nueva Venta')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-md-12 col-sm-12 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-plus-circle text-info"></i> nueva venta
      </h5>
      <a href="{{route('ventas.index')}}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
        <i class="far fa-arrow-alt-circle-left"></i> regresar
      </a>
    </div>
    <!-- Titulo de la seccion -->

    <div class="border-bottom border-gray pb-2 mb-2">
        <span class="font-weight-bold">
            Elija uno o mas productos. Presione el botón Lista de Productos para visualizar los productos por categoría.
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
            <td class="bg-success text-white font-weight-bold" style="width: 50%">Fecha del recibo</td>
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
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" id="btn_listaproductos" name="btn_listaproductos" data-toggle="modal" data-target="#modalProductos">
          <i class="fas fa-table"></i>
          Lista de Productos
        </button>
        <button type="button" class="btn red600 text-white mr-1" id="btn_cancelar" name="btn_cancelar">
          <i class="fas fa-times-circle"></i>
          Cancelar
        </button>
        <button type="button" class="btn blue700 text-white" id="btn_guardar" name="btn_guardar" disabled>
          <i class="fas fa-hand-holding-usd"></i>
          Realizar Venta
        </button>
        <button type="button" class="btn btn-info" id="btn_recibo" name="btn_recibo" disabled>
          <i class="far fa-file-pdf"></i>
          Imprimir Recibo
        </button>
      </div>
    </div>

    <form action="{{route('ventas.store')}}" method="POST" id="form_venta" name="form_venta">
      <input type="hidden" id="rows_salida" name="rows_salida" value="">
      <input type="hidden" id="escuela_id" name="escuela_id" value="{{$inscripcion->escuela_id}}">
      <input type="hidden" id="ciclo_id" name="ciclo_id" value="{{$inscripcion->ciclo_id}}">
      <input type="hidden" id="alumno_id" name="alumno_id" value="{{$inscripcion->alumno_id}}">
      <input type="hidden" id="grupo_id" name="grupo_id" value="{{$inscripcion->grupo_id}}">
      <input type="hidden" id="user_created" name="user_created" value="{{Auth::id()}}">
      <input type="hidden" id="grado_id" name="grado_id" value="{{$inscripcion->grado_id}}">
      <input type="hidden" id="serie_recibo" name="serie_recibo" value="{{$recibo->serie}}">
      <input type="hidden" id="folio_recibo" name="folio_recibo" value="{{$recibo->folio}}">
      <input type="hidden" id="fecha_venta" name="fecha_venta" value="{{$fecha}}">
      <input type="hidden" id="cantidad_recibida_mxn" name="cantidad_recibida_mxn" value="">
      <input type="hidden" id="urlRecibo" value="">
      @csrf
      <table class="table table-striped" id="dtCartItems">
        <thead>
          <tr>
            <th scope="col" class="text-center" style="width: 60%">Producto</th>
            <th scope="col" class="text-center" style="width: 10%">Precio</th>
            <th scope="col" class="text-center" style="width: 10%">Cantidad</th>
            <th scope="col" class="text-center" style="width: 10%">Importe</th>
            <th scope="col" class="text-center" style="width: 10%">Eliminar</th>
          </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
        <tr>
          <th style="width: 60%"></th>
          <th style="width: 10%" class="text-center font-weight-bold">Total</th>
          <th style="width: 10%" class="text-center">
            <input type="text" class="form-control form-control-sm text-center font-weight-bold" value="" id="_totalCartItems" name="_totalCartItems" disabled>
          </th>
          <th style="width: 10%" class="text-center">
            <input type="text" class="form-control form-control-sm text-center font-weight-bold" value="" id="_totalPago" name="_totalPago" disabled>
          </th>
          <th style="width: 10%"></th>
        </tr>
        </tfoot>
      </table>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="modalProductos" tabindex="-1" role="dialog" aria-labelledby="modalProductosTitle" aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalProductosTitle">Elegir Producto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="card border-0">
              <div class="form-row align-items-center">
                <div class="col-sm-4 my-1">
                  <label class="sr-only" for="categoria_id">Categoría</label>
                  <select id="categoria_id" name="categoria_id" class="form-control">
                    @foreach($categorias as $categoria)
                      @if($loop->first)
                        <option value="" selected>[Categoría]</option>
                      @endif
                      <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-sm-4 my-1">
                  <label class="sr-only" for="categoria_id">Sub-Categoría</label>
                  <select id="subcategoria_id" name="subcategoria_id" class="form-control" required disabled>
                    <option value="" selected>[Sub-Categoría]</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="border-bottom border-gray pb-2 mb-2"></div>

            <table class="table table-striped" id="tableProductos">
              <thead>
              <tr>
                <th scope="col" class="text-center">CICLO</th>
                <th scope="col" class="text-center">NOMBRE</th>
                <th scope="col" class="text-center">EXISTENCIA</th>
                <th scope="col" class="text-center">PRECIO VTA.</th>
                <th scope="col" class="text-center"></th>
              </tr>
              </thead>
              <tbody></tbody>
            </table>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>


  </div>
  <!-- Contenedor de la seccion -->

@endsection

@push('scripts')
  <!-- Archivo(s) javascript del modulo -->
  <script src="{{ asset('jqueryvalidate-1.19.0/jquery.validate.js') }}"></script>
  <script src="{{ asset('jquerymask-1.14.15/jquery.mask.js') }}"></script>
  <script src="{{ asset('gijgo-datepicker-1.9.1.13/js/gijgo.js')}}"></script>
  <script src="{{ asset('gijgo-datepicker-1.9.1.13/js/messages/messages.es-es.js') }}"></script>
  <script>

    $().ready(function(){
      let dtProductosModal;
      let dtCartItems;
      let datos = [];
      let item = {};
      let escuela = $("#escuela_id").val();
      let ciclo = $("#ciclo_id").val();

      $("#btn_guardar").click(function(){
        datos = [];
        let linea = 1;
        let totalItems = parseFloat($("#_totalCartItems").val());
        $(".cantidad").each(function (index, data) {
          let fila = $(this).attr("name").slice(9);
          item = {};
          item['numero_linea'] = linea++;
          item['categoria'] = $("#categoria_"+fila).val();
          item['producto']  = fila;
          item['precio_unitario'] = parseFloat($("#precioUnitario_"+fila).val());
          item['cantidad'] = parseFloat($(this).val());
          datos.push(item);
        });
        let message = totalItems === 1
          ? '1 producto. Total: '+$("#_totalPago").val()
          : totalItems + ' productos. Total: '+$("#_totalPago").val();


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
            '<i class="fas fa-hand-holding-usd"></i> Realizar Venta',
          confirmButtonAriaLabel: 'Realizar Venta',
        }).then((result) => {
          if (result.value) {
            $("#rows_salida").val(JSON.stringify(datos));
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
            $("#urlRecibo").val(data.urlRecibo);
            showSwal('success', 'OK', data.message);
          })
          .fail(function( jqXHR, textStatus, errorThrown){
            var message = 'Ocurrio un error al procesar la venta de productos';
            showSwal('error', 'ERROR', message);
            $("#btn_guardar").removeAttr('disabled');
          });
      }

      $("#btn_recibo").click(function(){
        event.preventDefault();
        window.open($("#urlRecibo").val());
        return false;
      });

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

      $('#_fecha').datepicker({
        locale: 'es-es',
        format: 'dd-mm-yyyy',
        showOtherMonths: true,
        disableDaysOfWeek: [0, 6]
      }).change(function(){
        $("#fecha_venta").val($(this).val());
      });

      $("#modalProductos").on('show.bs.modal', function (event){
        //console.log('show.bs.modal');
      }).on('hidden.bs.modal', function(event){
        $("#categoria_id").val($("#categoria_id option:first").val());
        $("#subcategoria_id").enableControl(true,false);
        //console.log('hidden.bs.modal');
      });

      $("#categoria_id").change(function(){
        if($(this).val()!==''){
            $("#subcategoria_id").enableControl(true,true);
            $.getJSON(urlRoot+'/data/categorias/childs/'+$(this).val(), null, function (values) {
              $('#subcategoria_id').populateSelect(values);
            });
        }else{
          $("#subcategoria_id").enableControl(true,false);
        }
      });

      $("#subcategoria_id").change(function(){
        if($(this).val()!==''){
          loadModalProducts();
        }else{
        }
      });

      dtCartItems = $("#dtCartItems").DataTable({
        paging: false,
        lengthChange: false,
        searching: false,
        ordering: false,
        info: false,
        autoWidth: true,
        language: {
            url: "{{ asset('datatables-1.10.19/lang/Spanish.json') }}"
        },
        columnDefs:[
          { width: "50%", targets: 0, className: "text-left font-weight-bold" },
          { width: "10%", targets: 1, className: "text-center" },
          { width: "10%", targets: 2, className: "text-center" },
          { width: "10%", targets: 3, className: "text-center" },
          { width: "10%", targets: 4, className: "text-center" }
        ]
      });

      function loadModalProducts(){
        let parent = $("#categoria_id").val();
        let parentid = $("#subcategoria_id").val();

        dtProductosModal = $('#tableProductos').DataTable({
          processing: true,
          serverSide: true,
          ordering: false,
          searching: true,
          destroy: true,
          paging: false,
          autoWidth: true,
          scrollY: "250px",
          scrollCollapse: true,
          ajax: urlRoot + '/data/productos/'+escuela+'/'+ciclo+'/'+parent+'/'+parentid,
          language: {
              url: "{{ asset('datatables-1.10.19/lang/Spanish.json') }}"
          },
          columns: [
            {
              data: null, name: 'periodo', className: "text-center", searchable: false,
              render: function(data) {
                  return '<span class="badge badge-info">'+data.periodo+'</span>';
              }
            },
            {data: 'nombre', name: 'nombre', className: "text-left"},
            {data: 'existencia', name: 'existencia', className: 'text-center'},
            {data: 'precio_venta', name: 'precio_venta', className: "text-center", searchable: false,
                render: $.fn.dataTable.render.number( ',', '.', 2, '$ ' )
            },
            { "data" : null,
                "render": function ( data, type, full, meta ) {
                  let button='';
                  button += '<button type="button" class="btn bg-transparent">';
                  button += '<i class="fas fa-cart-plus text-primary"></i>';
                  button += '';
                  button += '</button>';
                  return button;
                }
            }
          ]
        });
      }

      $('#tableProductos tbody').on( 'click', 'button', function (){
        let data = dtProductosModal.row( $(this).parents('tr') ).data();

        dtCartItems.row.add([
          data['nombre'],
          '$ '+parseFloat(data['precio_venta']).format(2),
          inputCantidad(data['id']),
          inputImporte(data['id'],data['precio_venta'], data['categoria_id']),
          btnDelete()
        ]).draw();

        countItems();

        $(".cantidad").bind('change keyup',function(){
          calcularImportePorFila($(this).attr("name").slice(9));
          countItems();
        });

        checkRows();

      });

      $('#dtCartItems tbody').on( 'click', 'button', function () {
        dtCartItems.row( $(this).parents('tr') ).remove().draw();
        countItems();
        checkRows();
      });

      function calcularImportePorFila(rowId){
        let _cantidad = parseFloat($("#cantidad_"+rowId).val());
        let _precUnit  = parseFloat($("#precioUnitario_"+rowId).val());
        let _importe = _cantidad * _precUnit;
        $("#importe_"+rowId).empty().val('$ '+parseFloat(_importe).format(2));
      }

      function countItems(){
        let cantidad = 0;
        let rowCantidad = 0;
        let row;
        let precio;
        let total = 0;
        $(".cantidad").each(function (index, data) {
          rowCantidad = parseFloat($(this).val());
          cantidad = cantidad + rowCantidad;
          row = $(this).attr("name").slice(9);
          precio = parseFloat($("#precioUnitario_"+row).val());
          total = total + (precio * rowCantidad);
        });
        $("#_totalCartItems").empty().val(cantidad);
        $("#_totalPago").empty().val('$ '+parseFloat(total).format(2));
        $("#cantidad_recibida_mxn").empty().val(total);
      }

      function checkRows(){
        let cantidad = 0;
        let rowCantidad = 0;
        $(".cantidad").each(function (index, data) {
          rowCantidad = parseFloat($(this).val());
          cantidad = cantidad + rowCantidad;
        });
        if(cantidad!==0){
          $("#btn_guardar").enableControl(false, true);
        }
        else{
          $("#btn_guardar").enableControl(false, false);
        }
      }

      function inputCantidad(_idProducto){
        let input = '';
        input += '<input type="number" class="form-control-sm form-control text-center cantidad" ';
        input += 'value="1" step="1" min="1"';
        input += 'id="'+"cantidad_"+_idProducto+'" name="'+"cantidad_"+_idProducto+'" required>';
        return input;
      }

      function inputImporte(_idProducto,_precio_venta,_categoria){
        let input = '';
        input += '<input type="text" class="form-control-sm form-control text-center font-weight-bold" ';
        input += 'value="$ '+parseFloat(_precio_venta).format(2)+'"';
        input += 'id="'+"importe_"+_idProducto+'" name="'+"importe_"+_idProducto+'" required disabled>';

        input += '<input type="hidden" class="form-control-sm form-control" ';
        input += 'value="'+_categoria+'" ';
        input += 'id="'+"categoria_"+_idProducto+'" name="'+"categoria_"+_idProducto+'">';

        input += '<input type="hidden" class="form-control-sm form-control" ';
        input += 'value="'+parseFloat(_precio_venta).format(2)+'" ';
        input += 'id="'+"precioUnitario_"+_idProducto+'" name="'+"precioUnitario_"+_idProducto+'">';
        return input;
      }

      function btnDelete(){
          let button = '<button name="'+"btn_delete"+'" id="'+"btn_delete"+'" ';
          button += 'type="'+"button"+'" class="'+"btn bg-transparent btn-sm btn_delete"+'">';
          button += '<i class="far fa-trash-alt text-danger"></i>';
          button += '</button>';
          return button;
      }

      Number.prototype.format = function(n, x) {
          var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
          return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
      };
    });
  </script>
@endpush

