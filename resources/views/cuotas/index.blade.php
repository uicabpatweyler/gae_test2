@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Cuotas de Pago')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-12 col-md-12 mt-2 pb-3 rounded shadow bg-white border">

    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-table text-info"></i> cuotas de pago
      </h5>
      <a href="{{route('cuotas.create')}}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
        <i class="fas fa-plus"></i> nueva cuota
      </a>
      
    </div>
    <!-- Titulo de la seccion -->

    <!-- Formulario, Tablas...etc -->
    <div class="card border-0">
      <div class="form-row align-items-center">
        <div class="col-sm-5 my-1">
          <label class="sr-only" for="escuela_id">Escuela</label>
          <select id="escuela_id" name="escuela_id" class="form-control" required>
            @foreach($escuelas as $escuela)
              @if($loop->first)
                <option value="" selected>[Elija una escuela]</option>
              @endif
              <option value="{{ $escuela->id }}">{{ $escuela->nombre }} ({{$escuela->nivel->nombre}})</option>
            @endforeach
          </select>
        </div>
        <div class="col-sm-2 my-1">
          <label class="sr-only" for="escuela_id">Ciclo</label>
          <select id="ciclo_id" name="ciclo_id" class="form-control">
            @foreach($ciclos as $ciclo)
              @if($loop->first)
                <option value="" selected>[Elegir ciclo]</option>
              @endif
              <option value="{{ $ciclo->id }}">{{ $ciclo->periodo }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-sm-2 my-1">
          <label class="sr-only" for="tipo">[Tipo de cuota]</label>
          <select id="tipo" name="tipo" class="form-control">
            <option value="" selected>[Elegir tipo]</option>
            <option value="1">Cuota de Inscripción</option>
            <option value="2">Cuota de Colegiatura</option>
          </select>
        </div>
      </div>
    </div>
    <div class="border-bottom border-gray pb-2 mb-2">
    </div>

    <div class="table-responsive col-12">
      <table class="table table-striped" id="cuotas">
        <thead>
        <tr>
          <th scope="col" class="text-center">NOMBRE/DESCRIPCIÓN</th>
          <th scope="col" class="text-center">TIPO</th>
          <th scope="col" class="text-center">CUOTA</th>
          <th scope="col" class="text-center">ESTADO</th>
          <th scope="col" class="text-center">ACCIONES</th>
        </tr>
        </thead>
      </table>
    </div>

    <!-- Formulario, Tablas...etc -->

  </div>
  <!-- Contenedor de la seccion -->

@endsection
@push('scripts')
  <!-- Axios -->
  <script src="{{asset('axios-0.19.0/axios.js')}}"></script>
  <!-- Datatables JS -->
  <script>
    var escuela = 0;
    var ciclo   = 0;
    var tipo    = 0;

    $().ready(function(){
      $("#escuela_id").change(function () {
        if ($(this).val() !== '') {
          escuela = $(this).val();
        } else {
          escuela = 0;
        }
        filtrarCuotas();
      });

      $("#ciclo_id").change(function () {
        if ($(this).val() !== '') {
          ciclo = $(this).val();
        } else {
          ciclo = 0;
        }
        filtrarCuotas();
      });

      $("#tipo").change(function () {
        if ($(this).val() !== '') {
          tipo = $(this).val();
        } else {
          tipo = 0;
        }
        filtrarCuotas();
      });

      function filtrarCuotas(){
        if(escuela!==0 && ciclo!==0 && tipo!==0){
          $('#cuotas').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            searching: false,
            destroy: true,
            ajax: urlRoot+'/data/cuotas/'+escuela+'/'+ciclo+'/'+tipo,
            language: {
              url: "{{ asset('datatables-1.10.19/lang/Spanish.json') }}"
            },
            columns: [
              {data: 'nombre', name: 'nombre', className: "text-center"},
              {
                data: null, name: 'tipo', className: "text-center",
                render: function(data){
                  if(data.tipo === "1") return 'Inscripción';
                  return 'Colegiatura';
                }
              },
              {
                data: 'cantidad', name: 'cantidad', className: "text-center",
                render: $.fn.dataTable.render.number( ',', '.', 2, '$ ' )
              },
              {
                data: null, className: "text-center",
                render: function (data) {
                  if (data.status === "1") return '<i class="fas fa-check text-success"></i>';
                  return '<i class="fas fa-times text-danger"></i>'
                }
              },
              {
                data: "actions", className: "text-center",
                render: function (data) {
                  return htmlDecode(data);
                }
              }
            ]
          });
        }
      }
    });
  </script>
@endpush
