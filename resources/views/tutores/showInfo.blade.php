
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
      <a href="{{route('tutores.index')}}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
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
        <label for="">Tutor de</label>
        <input type="text" class="form-control form-control-sm" value="{{$alumno->full_name}}" style="text-transform:capitalize" disabled>
      </div>
    </div>

    <div class="accordion" id="accordionExample">
      <div class="card">
        <div class="card-header" id="headingOne">
          <h2 class="mb-0">
            <button class="btn btn-outline-primary collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
              Dirección del Tutor
            </button>
            <a href="{{route('infotutor.edit.direccion', ['id' => $infoTutor->id])}}" class="btn btn-sm btn-primary" role="button" title="Editar" aria-pressed="true">
              <i class="fas fa-pencil-alt"></i> Editar
            </a>
          </h2>
        </div>

        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
          <div class="card-body">
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="nombre_vialidad">Nombre de Vialidad</label>
                <input type="text" class="form-control form-control-sm" value="{{$infoTutor->nombre_vialidad}}" style="text-transform:capitalize" disabled>
              </div>
              <div class="form-group col-md-2">
                <label for="exterior">Exterior</label>
                <input type="text" class="form-control form-control-sm" value="{{$infoTutor->exterior}}" style="text-transform:capitalize" disabled>
              </div>
              <div class="form-group col-md-2">
                <label for="interior">Interior</label>
                <input type="text" class="form-control form-control-sm" value="{{$infoTutor->interior}}" style="text-transform:capitalize" disabled>
              </div>
              <div class="form-group col-md-4">
                <label for="entre_calles">Entre Calles</label>
                <input type="text" class="form-control form-control-sm" value="{{$infoTutor->entre_calles}}" style="text-transform:capitalize" disabled>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3">
                <label for="tipo_asentamiento">Tipo Asentamiento</label>
                <input type="text" class="form-control form-control-sm detalle" value="{{$infoTutor->tipo_asentamiento}}" style="text-transform:capitalize" disabled>
              </div>
              <div class="form-group col-md-4">
                <label for="nombre_asentamiento">Nombre Asentamiento</label>
                <input type="text" class="form-control form-control-sm detalle" value="{{$infoTutor->nombre_asentamiento}}" style="text-transform:capitalize" disabled>
              </div>
              <div class="form-group col-md-2">
                <label for="codigo_postal">Código Postal</label>
                <input type="text" class="form-control form-control-sm detalle" value="{{$infoTutor->codigo_postal}}" disabled>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3">
                <label for="localidad">Localidad</label>
                <input type="text" class="form-control form-control-sm detalle" value="{{$infoTutor->localidad}}" style="text-transform:capitalize" disabled>
              </div>
              <div class="form-group col-md-3">
                <label for="delegacion">Delegación/Municipio</label>
                <input type="text" class="form-control form-control-sm detalle" value="{{$infoTutor->delegacion}}" style="text-transform:capitalize" disabled>
              </div>
              <div class="form-group col-md-3">
                <label for="estado">Estado</label>
                <input type="text" class="form-control form-control-sm detalle" value="{{$infoTutor->estado}}" style="text-transform:capitalize" disabled>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingTwo">
          <h2 class="mb-0">
            <button class="btn btn-outline-primary collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              Teléfonos del Tutor
            </button>
            <a href="{{route('infotutor.edit.telefonos', ['id' => $infoTutor->id])}}" class="btn btn-sm btn-primary" role="button" title="Editar" aria-pressed="true">
              <i class="fas fa-pencil-alt"></i> Editar
            </a>
          </h2>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
          <div class="card-body">
            <div class="form-row">
              <div class="form-group col-md-3">
                <label for="telefcasa">Teléfono de Casa</label>
                <input type="text" class="form-control form-control-sm telefono" value="{{$infoTutor->telefcasa}}" disabled>
              </div>
              <div class="form-group col-md-2">
                <label for="referencia1">Referencia</label>
                <input type="text" class="form-control form-control-sm" value="{{$infoTutor->referencia1}}" style="text-transform:capitalize" disabled>
              </div>
              <div class="form-group col-md-3">
                <label for="teleftrabajo">Teléfono del Trabajo</label>
                <input type="text" class="form-control form-control-sm telefono" value="{{$infoTutor->teleftrabajo}}" disabled>
              </div>
              <div class="form-group col-md-2">
                <label for="referencia2">Referencia</label>
                <input type="text" class="form-control form-control-sm" value="{{$infoTutor->referencia2}}" style="text-transform:capitalize" disabled>
              </div>

            </div>
            <div class="form-row">
              <div class="form-group col-md-3">
                <label for="telefcelular">Teléfono Celular</label>
                <input type="text" class="form-control form-control-sm telefono" value="{{$infoTutor->telefcelular}}" disabled>
              </div>
              <div class="form-group col-md-2">
                <label for="referencia3">Referencia</label>
                <input type="text" class="form-control form-control-sm" value="{{$infoTutor->referencia3}}" style="text-transform:capitalize" disabled>
              </div>
              <div class="form-group col-md-3">
                <label for="telefotro">Otro</label>
                <input type="text" class="form-control form-control-sm telefono" value="{{$infoTutor->telefotro}}" disabled>
              </div>
              <div class="form-group col-md-2">
                <label for="referencia4">Referencia</label>
                <input type="text" class="form-control form-control-sm" value="{{$infoTutor->referencia4}}" style="text-transform:capitalize" disabled>
              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingThree">
          <h2 class="mb-0">
            <button class="btn btn-outline-primary collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              Información Adicional del Tutor
            </button>
            <a href="{{route('infotutor.edit.infoadicional', ['id' => $infoTutor->id])}}" class="btn btn-sm btn-primary" role="button" title="Editar" aria-pressed="true">
              <i class="fas fa-pencil-alt"></i> Editar
            </a>
          </h2>
        </div>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
          <div class="card-body">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="adicional_trabajo">Nombre del lugar de trabajo</label>
                <input type="text" class="form-control form-control-sm" style="text-transform:capitalize" value="{{$infoTutor->adicional_trabajo}}" disabled>
              </div>
              <div class="form-group col-md-6">
                <label for="adicional_direccion">Dirección del lugar de trabajo</label>
                <input type="text" class="form-control form-control-sm" style="text-transform:capitalize" value="{{$infoTutor->adicional_direccion}}" disabled>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3">
                <label for="adicional_tipoasentamiento">Tipo Asentamiento</label>
                <input type="text" class="form-control form-control-sm detalle" value="{{$infoTutor->adicional_tipoasentamiento}}" disabled>
              </div>
              <div class="form-group col-md-4">
                <label for="adicional_nombreasentamiento">Nombre Asentamiento</label>
                <input type="text" class="form-control form-control-sm detalle" value="{{$infoTutor->adicional_nombreasentamiento}}" style="text-transform:capitalize" disabled>
              </div>
              <div class="form-group col-md-2">
                <label for="adicional_codpost">Código Postal</label>
                <input type="text" class="form-control form-control-sm detalle" value="{{$infoTutor->adicional_codpost}}" disabled>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3">
                <label for="adicional_localidad">Localidad</label>
                <input type="text" class="form-control form-control-sm detalle" value="{{$infoTutor->adicional_localidad}}" style="text-transform:capitalize" disabled>
              </div>
              <div class="form-group col-md-3">
                <label for="adicional_delegacion">Delegación/Municipio</label>
                <input type="text" class="form-control form-control-sm detalle" value="{{$infoTutor->adicional_delegacion}}" style="text-transform:capitalize" disabled>
              </div>
              <div class="form-group col-md-3">
                <label for="adicional_estado">Estado</label>
                <input type="text" class="form-control form-control-sm detalle" value="{{$infoTutor->adicional_estado}}" style="text-transform:capitalize" disabled>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="email">Correo Eléctronico</label>
                <input type="text" class="form-control form-control-sm" value="{{$infoTutor->email}}" disabled>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- Contenedor de la seccion -->
@endsection

