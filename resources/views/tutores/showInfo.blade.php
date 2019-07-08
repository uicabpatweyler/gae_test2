
@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Datos de inscripción')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-12 col-md-12 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-eye text-info"></i> Datos de inscripción
      </h5>
      <a href="{{route('alumnos.index')}}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
        <i class="far fa-arrow-alt-circle-left"></i> regresar
      </a>
    </div>
    <!-- Titulo de la seccion -->

    <div class="border-bottom border-gray pb-2 mb-2">
        <span class="font-weight-bold">
            Del Tutor:
        </span>
      {{$tutor->full_name}}
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="">Escuela</label>
        <input type="text" class="form-control form-control-sm" value="{{$escuela->nombre}}" style="text-transform:capitalize" disabled>
      </div>
      <div class="form-group col-md-2">
        <label for="">Ciclo</label>
        <input type="text" class="form-control form-control-sm" value="{{$ciclo->periodo}}" style="text-transform:capitalize" disabled>
      </div>
      <div class="form-group col-md-4">
        <label for="">Alumno</label>
        <input type="text" class="form-control form-control-sm" value="{{$alumno->full_name}}" style="text-transform:capitalize" disabled>
      </div>
    </div>

    <div class="accordion" id="accordionExample">
      <div class="card">
        <div class="card-header" id="headingOne">
          <h2 class="mb-0">
            <button class="btn btn-outline-primary collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              Dirección del Tutor
            </button>
            <a href="" class="btn btn-sm btn-primary" role="button" title="Editar" aria-pressed="true">
              <i class="fas fa-pencil-alt"></i> Editar
            </a>
          </h2>
        </div>

        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
          <div class="card-body">

          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingTwo">
          <h2 class="mb-0">
            <button class="btn btn-outline-primary collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              Teléfonos del Tutor
            </button>
            <a href="" class="btn btn-sm btn-primary" role="button" title="Editar" aria-pressed="true">
              <i class="fas fa-pencil-alt"></i> Editar
            </a>
          </h2>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
          <div class="card-body">

          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingThree">
          <h2 class="mb-0">
            <button class="btn btn-outline-primary collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              Información Adicional del Tutor
            </button>
            <a href="" class="btn btn-sm btn-primary" role="button" title="Editar" aria-pressed="true">
              <i class="fas fa-pencil-alt"></i> Editar
            </a>
          </h2>
        </div>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
          <div class="card-body">

          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- Contenedor de la seccion -->
@endsection

