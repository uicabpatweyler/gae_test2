@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Mostrar Alumno')

{{--Contenido de la seccion--}}
@section('content')
  
  <!-- Contenedor de la seccion -->
  <div class="col-12 col-md-12 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        Historial de pagos
      </h5>
      <a href="{{route('alumnos.impresion.historialdepagos1')}}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
        <i class="far fa-arrow-alt-circle-left"></i> regresar
      </a>
    </div>
    <!-- Titulo de la seccion -->
    
    <div class="border-bottom border-gray pb-2 mb-2">
        <span class="font-weight-bold">
            Datos del alumno elegido
        </span>
    </div>
    
    <!-- Formulario -->
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="alumno">Alumno</label>
        <input type="text" class="form-control form-control-sm" value="{{$alumno->full_name}}" disabled>
      </div>
      <div class="form-group col-md-3">
        <label for="curp">C.U.R.P</label>
        <input type="text" class="form-control form-control-sm" id="curp" name="curp" value="{{$alumno->curp}}" disabled>
      </div>
      <div class="form-group col-md-3">
        <label for="fechanacimiento">Fecha de Nacimiento </label>
        <input type="text" class="form-control form-control-sm" value="{{$alumno->fechanacimiento->format('d-m-Y')}}" id="fechanacimiento" name="fechanacimiento"  disabled>
      </div>
      <div class="form-group col-md-2">
        <label for="genero">Género</label>
        <input type="text" class="form-control form-control-sm" value="{{$alumno->genero === "H" ? 'Hombre' : 'Mujer'}}" disabled>
      </div>
    </div>
    <div class="border-top mt-2 mb-2"></div>
    <!-- Formulario -->
  
  </div>
  <!-- Contenedor de la seccion -->
  
  <div class="col-12 col-md-12 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        datos de inscripción
      </h5>
    </div>
    <!-- Titulo de la seccion -->
    <div class="border-bottom border-gray pb-2 mb-2">
        <span class="font-weight-bold">
            Selecciona una fila para mostrar el historial de pagos
        </span>
    </div>
  
    <table class="table table-striped">
      <thead>
      <tr>
        <th scope="col" class="text-center">ESCUELA</th>
        <th scope="col" class="text-center">CICLO</th>
        <th scope="col" class="text-center">GRADO</th>
        <th scope="col" class="text-center">GRUPO</th>
        <th scope="col" class="text-center">ACCIONES</th>
      </tr>
      </thead>
      <tbody>
      @foreach($rows as $row)
        <tr>
          <td class="text-center">{{$row->escuela}}</td>
          <td class="text-center">
            <span class="badge badge-success">
              {{$row->periodo}}
            </span>
          </td>
          <td class="text-center">{{$row->grado}}</td>
          <td class="text-center">
            <span class="badge badge-info">
              {{$row->grupo}}
            </span>
          </td>
          <td class="text-center">
            <button type="button" class="btn btn-outline-primary btn-sm"
                    onclick="window.open('{{ route('print.historialdepagos',['inscripcion' => $row->id])}}')">
              <i class="fas fa-dollar-sign"></i>
              <i class="fas fa-arrow-right"></i>
              <i class="far fa-file-pdf text-danger"></i>
            </button>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  
  </div>
@endsection
