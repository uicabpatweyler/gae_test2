@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Productos')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-12 col-md-12 mt-2 pb-3 rounded shadow bg-white border">

    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-table text-info"></i> PRODUCTOS
      </h5>
      <a href="{{route('productos.create')}}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
        <i class="fas fa-plus"></i> nuevo producto
      </a>

    </div>
    <!-- Titulo de la seccion -->
    <div class="card border-0">
      <div class="form-row align-items-center">
        <div class="col-sm-4 my-1">
          <label class="sr-only" for="escuela_id">Escuela</label>
          <select id="escuela_id" name="escuela_id" class="form-control" required>
            @foreach($escuelas as $escuela)
              @if($loop->first)
                <option value="" selected>[Escuela]</option>
              @endif
              <option value="{{ $escuela->id }}">{{ $escuela->nombre }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-sm-2 my-1">
          <label class="sr-only" for="ciclo_id">Ciclo</label>
          <select id="ciclo_id" name="ciclo_id" class="form-control" required>
            @foreach($ciclos as $ciclo)
              @if($loop->first)
                <option value="" selected>[Ciclo]</option>
              @endif
              <option value="{{ $ciclo->id }}">{{ $ciclo->periodo }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-sm-2 my-1">
          <label class="sr-only" for="categoria_id">Categoría</label>
          <select id="categoria_id" name="categoria_id" class="form-control" required disabled>
            @foreach($categorias as $categoria)
              @if($loop->first)
                <option value="" selected>[Categoría]</option>
              @endif
              <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-sm-2 my-1">
          <label class="sr-only" for="categoria_id">Sub-Categoría</label>
          <select id="subcategoria_id" name="subcategoria_id" class="form-control" required disabled>
            <option value="" selected>[Sub-Categoría]</option>
          </select>
        </div>
      </div>
    </div>

    <div class="border-bottom border-gray pb-2 mb-2"></div>

    <div class="table-responsive col-12">
      <table class="table table-striped" id="productos">
        <thead>
        <tr>
          <th scope="col" class="text-center"></th>
          <th scope="col" class="text-center">CICLO</th>
          <th scope="col" class="text-center">NOMBRE</th>
          <th scope="col" class="text-center">EXISTENCIA</th>
          <th scope="col" class="text-center">PRECIO VTA.</th>
          <th scope="col" class="text-center">DISPONIBLE</th>
          <th scope="col" class="text-center">ACCIONES</th>
        </tr>
        </thead>
      </table>
    </div>

  </div>
  <!-- Contenedor de la seccion -->

@endsection
@push('scripts')
  <!-- Axios -->
  <script src="{{asset('axios-0.19.0/axios.js')}}"></script>
  <script>
    $().ready(function(){

      $("select").change( function() {
        if($(this).prop('name')!=='categoria_id' || $(this).prop('name')!=='subcategoria_id'){
          enableCategories();
        }
        if($(this).prop('name')==='categoria_id'){
          if($(this).val()!==''){
            $("#subcategoria_id").enableControl(true,true);
            $.getJSON(urlRoot+'/data/categorias/childs/'+$(this).val(), null, function (values) {
              $('#subcategoria_id').populateSelect(values);
            });
          }else{
            $("#subcategoria_id").enableControl(true,false);
          }

        }
        if(checkValSelects()===0){
          filtrarProductos(buildUrl());
          //console.log(buildUrl());
        }
      });

      function enableCategories(){
        if($("#escuela_id").val()!=='' && $("#ciclo_id").val()!==''){
          $("#categoria_id").enableControl(false,true);
        }
        else{
          $("#categoria_id").val($("#categoria_id option:first").val());
          $("#categoria_id").enableControl(false,false);
          $("#subcategoria_id").enableControl(false,false);
        }
      }

      function checkValSelects(){
        let selects = ["#escuela_id","#ciclo_id", "#categoria_id", "#subcategoria_id"];
        let count = 0;
        for(let i=0; i<=3; i++){
          if($(selects[i]).val()==='' || $(selects[i]).val()===null) count++;
        }
        return count;
      }

      function buildUrl(){
        let escuela = $("#escuela_id").val();
        let ciclo = $("#ciclo_id").val();
        let parent = $("#categoria_id").val();
        let parentid = $("#subcategoria_id").val();
        return urlRoot + '/data/productos/'+escuela+'/'+ciclo+'/'+parent+'/'+parentid;
      }

      function filtrarProductos(url){
        $('#productos').DataTable({
          processing: true,
          serverSide: true,
          ordering: false,
          searching: true,
          destroy: true,
          paging: false,
          ajax: url,
          language: {
            url: "{{ asset('datatables-1.10.19/lang/Spanish.json') }}"
          },
          columns: [
            {
              data: null, name: 'categoria', className: "text-center", searchable: false,
              render: function(data) {
                if(data.categoria_id === "1"){
                  return '<i class="fas fa-book text-primary"></i>';
                }
                return '<i class="fas fa-tshirt text-primary"></i>';
              }
            },
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
            {
              data: null, className: "text-center",
              render: function (data) {
                if (data.disponible === "1") {
                  return '<i class="fas fa-check text-success"></i>'
                }
                return '<i class="fas fa-times text-danger"></i>'
              }
            },
            {data: "actions", className:"text-center", searchable: false,
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
