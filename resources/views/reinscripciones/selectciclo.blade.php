@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Re-Inscripciones')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-12 col-md-12 mt-2 pb-3 rounded shadow bg-white border">

    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-table text-info"></i> re-inscripciones: elegir información
      </h5>
      <a href="{{route('reinscripciones.index')}}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
        <i class="far fa-arrow-alt-circle-left"></i> cambiar alumno
      </a>
    </div>
    <!-- Titulo de la seccion -->

    <div class="border-bottom border-gray pb-2 mb-2">
        <span class="font-weight-bold">
            Alumno seleccionado:
        </span>
      {{$alumno->full_name}}
    </div>

    <div class="card">
      <div class="card-header">
        Información del alumno
      </div>
      <div class="card-body">
        <table class="table table-striped" id="alumnos">
          <thead>
          <tr>
            <th scope="col" class="text-center">ESCUELA</th>
            <th scope="col" class="text-center">CICLO</th>
            <th scope="col" class="text-center">GRADO</th>
            <th scope="col" class="text-center">GRUPO</th>
            <th scope="col" class="text-center">ELEGIR INFORMACION</th>
          </tr>
          </thead>
          <tbody>
          @foreach($rows as $row)
            <tr>
              <td class="text-center">{{$row->escuela}}</td>
              <td class="text-center">{{$row->periodo}}</td>
              <td class="text-center">{{$row->grado}}</td>
              <td class="text-center">{{$row->grupo}}</td>
              <td class="text-center">
                <a href="{{route('reinscripcion.infoalumno.create', ['alumno' => $alumno->id, 'infoAlumno' => $row->infoalumno_id])}}"
                   class="btn btn-success btn-sm" role="button" title="" aria-pressed="true">
                  <i class="far fa-hand-point-right"></i> Seleccionar
                </a>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </div>
  <!-- Contenedor de la seccion -->

@endsection
@push('scripts')
  <script>

  </script>
@endpush

