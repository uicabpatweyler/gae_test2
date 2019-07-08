@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Mostrar Tutor')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-md-12 col-sm-12 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-plus-circle text-info"></i> mostrar tutor
      </h5>
      <a href="{{ route('tutores.index') }}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
        <i class="far fa-arrow-alt-circle-left"></i> regresar
      </a>
    </div>
    <!-- Titulo de la seccion -->

    <div class="border-bottom border-gray pb-2 mb-2">
        <span class="font-weight-bold">
             Si desea realizar algun cambio, presione el botón Editar.
        </span>
    </div>

    <div class="form-row">
      <div class="form-group col-md-3">
        <label for="nombre">Nombre</label>
        <input type="text" class="form-control form-control-sm" style="text-transform:capitalize" value="{{$tutor->nombre}}" disabled>
      </div>
      <div class="form-group col-md-3">
        <label for="apellido1">Apellido Paterno</label>
        <input type="text" class="form-control form-control-sm" style="text-transform:capitalize" value="{{$tutor->apellido1}}" disabled>
      </div>
      <div class="form-group col-md-3">
        <label for="apellido2">Apellido Materno</label>
        <input type="text" class="form-control form-control-sm" style="text-transform:capitalize" value="{{$tutor->apellido2}}" disabled>
      </div>
      <div class="form-group col-md-3">
        <label for="genero">Sexo</label>
        <input type="text" class="form-control form-control-sm" value="{{$tutor->genero==='H' ? 'Hombre' : 'Mujer'}}" disabled>
      </div>
    </div>
    <div class="border-top mt-2 mb-2"></div>
    <div class="float-right">
      <div class="float-right">
        <a class="btn blue700 text-white" href="{{route('tutores.edit', $tutor->id)}}" id="btn_edit" name="btn_edit" role="button">
          <i class="fas fa-pencil-alt"></i>
          Editar
        </a>
      </div>
    </div>

  </div>
  <!-- Contenedor de la seccion -->

  <div class="col-12 col-md-12 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-eye text-info"></i> datos de inscripción
      </h5>
      <a href="{{route('tutores.index')}}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
        <i class="far fa-arrow-alt-circle-left"></i> regresar
      </a>
    </div>
    <!-- Titulo de la seccion -->
    <div class="border-bottom border-gray pb-2 mb-2">
        <span class="font-weight-bold">
            Selecciona una fila para mostrar o editar
        </span>
    </div>

    <table class="table table-striped">
      <thead>
      <tr>
        <th scope="col" class="text-center">ESCUELA</th>
        <th scope="col" class="text-center">CICLO</th>
        <th scope="col" class="text-center">TUTOR DE</th>
        <th scope="col" class="text-center">ACCIONES</th>
      </tr>
      </thead>
      <tbody>
      @foreach($rows as $row)
        <tr>
          <td class="text-center">{{$row->escuela}}</td>
          <td class="text-center">{{$row->periodo}}</td>
          <td class="text-center">{{$row->alumno}}</td>
          <td class="text-center">
            <a href="{{ route('infotutor.show', ['id' => $row->infotutor_id]) }}" class="btn bg-transparent btn-sm" role="button" title="Ver" aria-pressed="true">
              <i class="far fa-eye text-secondary"></i>
            </a>
            <a href="{{ route('infotutor.edit', ['id' => $row->infotutor_id]) }}" class="btn bg-transparent btn-sm" role="button" title="Editar" aria-pressed="true">
              <i class="fas fa-pencil-alt text-primary"></i>
            </a>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>

@endsection

@push('scripts')
  <script>
    $().ready(function() {

    });
  </script>
@endpush



