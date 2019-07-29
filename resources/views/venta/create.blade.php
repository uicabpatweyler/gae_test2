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

    <form action="">
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

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalProductos">
      Lista de Productos
    </button>

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
  <script>

    $().ready(function(){
      let dtProductosModal;
      let dtCartItems;
      let escuela = 1;
      let ciclo = 2;

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
          inputImporte(data['id'],data['precio_venta']),
          btnDelete()
        ]).draw();

        countItems();

        $(".cantidad").bind('change keyup',function(){
          calcularImportePorFila($(this).attr("name").slice(9));
          countItems();
        });

      });

      $('#dtCartItems tbody').on( 'click', 'button', function () {
          dtCartItems.row( $(this).parents('tr') ).remove().draw();
          countItems();
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
      }

      function inputCantidad(_idProducto){
        let input = '';
        input += '<input type="number" class="form-control-sm form-control text-center cantidad" ';
        input += 'value="1" step="1" min="1"';
        input += 'id="'+"cantidad_"+_idProducto+'" name="'+"cantidad_"+_idProducto+'" required>';
        return input;
      }

      function inputImporte(_idProducto,_precio_venta){
        let input = '';
        input += '<input type="text" class="form-control-sm form-control text-center font-weight-bold" ';
        input += 'value="$ '+parseFloat(_precio_venta).format(2)+'"';
        input += 'id="'+"importe_"+_idProducto+'" name="'+"importe_"+_idProducto+'" required disabled>';
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

