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
        <i class="fas fa-plus"></i> nuevo PRODUCTO
      </a>

    </div>
    <!-- Titulo de la seccion -->

    <div class="table-responsive col-12">
      <table class="table table-striped" id="productos">
        <thead>
        <tr>
          <th scope="col" class="text-center"></th>
          <th scope="col" class="text-center">CICLO</th>
          <th scope="col" class="text-center">NOMBRE</th>
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
  <!-- Datatables JS -->
  <script>
    $('#productos').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        searching: true,
        destroy: true,
        paging: false,
        ajax: urlRoot + '/data/productos',
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
  </script>
@endpush
