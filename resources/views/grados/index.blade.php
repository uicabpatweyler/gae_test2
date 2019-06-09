@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Grados Escolares')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-12 col-md-12 mt-2 pb-3 rounded shadow bg-white border">

    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-table text-info"></i> grados escolares
      </h5>
      <a href="{{ route('grados.create') }}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
        <i class="fas fa-plus"></i> nuevo grado
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
      </div>
    </div>
    <div class="border-bottom border-gray pb-2 mb-2">
    </div>

    <div class="table-responsive col-12">
      <table class="table table-striped" id="grados">
        <thead>
        <tr>
          <th scope="col" class="text-center">GRADO</th>
          <th scope="col" class="text-center">ABREVIACION</th>
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

    $(document).ready(function() {
        /*Evento change. Select: Escuela*/
        $("#escuela_id").change(function () {
            if ($(this).val() !== '') {
                escuela = $(this).val();
                filtrarGrados()
            } else {
                escuela = 0;
            }
        });

        function filtrarGrados() {
            if (escuela !== 0) {
                $('#grados').DataTable({
                    processing: true,
                    serverSide: true,
                    ordering: false,
                    searching: false,
                    destroy: true,
                    ajax: urlRoot + '/data/grados/' + escuela,
                    language: {
                        url: "{{ asset('datatables-1.10.19/lang/Spanish.json') }}"
                    },
                    columns: [
                        {data: 'nombre', name: 'nombre', className: "text-center"},
                        {data: 'abreviacion', name: 'abreviacion', className: "text-center"},
                        {
                            data: null, className: "text-center",
                            render: function (data) {
                                if (data.status === "1") {
                                    return '<i class="fas fa-check text-success"></i>'
                                }
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
