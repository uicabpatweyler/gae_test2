
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
            Del Alumno:
        </span>
      {{$alumno->full_name}}
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
      <div class="form-group col-md-2">
        <label for="">Grado</label>
        <input type="text" class="form-control form-control-sm" value="{{$grado->nombre}}" style="text-transform:capitalize" disabled>
      </div>
      <div class="form-group col-md-2">
        <label for="">Grupo</label>
        <input type="text" class="form-control form-control-sm" value="{{$grupo->nombre}}" style="text-transform:capitalize" disabled>
      </div>
    </div>

    <div class="accordion" id="accordionExample">
      <div class="card">
        <div class="card-header" id="headingOne">
          <h2 class="mb-0">
            <button class="btn btn-outline-primary" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              Dirección del Alumno
            </button>
            <a href="{{route('infoalumno.edit', ['id' => $info->id])}}" class="btn btn-sm btn-primary" role="button" title="Editar" aria-pressed="true">
              <i class="fas fa-pencil-alt"></i> Editar
            </a>
          </h2>
        </div>

        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
          <div class="card-body">
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="nombre_vialidad">Nombre de Vialidad</label>
                <input type="text" class="form-control form-control-sm" value="{{$info->nombre_vialidad}}" style="text-transform:capitalize" id="nombre_vialidad" name="nombre_vialidad" disabled>
              </div>
              <div class="form-group col-md-2">
                <label for="exterior">Exterior</label>
                <input type="text" class="form-control form-control-sm" value="{{$info->exterior}}" style="text-transform:capitalize" id="exterior" name="exterior" disabled>
              </div>
              <div class="form-group col-md-2">
                <label for="interior">Interior</label>
                <input type="text" class="form-control form-control-sm" value="{{$info->interior}}" style="text-transform:capitalize" id="interior" name="interior" disabled>
              </div>
              <div class="form-group col-md-4">
                <label for="entre_calles">Entre Calles</label>
                <input type="text" class="form-control form-control-sm" value="{{$info->entre_calles}}" style="text-transform:capitalize" id="entre_calles" name="entre_calles" disabled>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3">
                <label for="tipo_asentamiento">Tipo Asentamiento <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm detalle" value="{{$info->tipo_asentamiento}}" style="text-transform:capitalize" id="tipo_asentamiento" name="tipo_asentamiento" disabled>
              </div>
              <div class="form-group col-md-4">
                <label for="nombre_asentamiento">Nombre Asentamiento <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm detalle" value="{{$info->nombre_asentamiento}}" style="text-transform:capitalize" id="nombre_asentamiento" name="nombre_asentamiento" disabled>
              </div>
              <div class="form-group col-md-2">
                <label for="codigo_postal">Código Postal <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm detalle" value="{{$info->codigo_postal}}" id="codigo_postal" name="codigo_postal" disabled>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3">
                <label for="localidad">Localidad</label>
                <input type="text" class="form-control form-control-sm detalle" value="{{$info->localidad}}" style="text-transform:capitalize" id="localidad" name="localidad" disabled>
              </div>
              <div class="form-group col-md-3">
                <label for="_delegacion">Delegación/Municipio</label>
                <input type="text" class="form-control form-control-sm detalle" value="{{$info->delegacion}}" style="text-transform:capitalize" id="_delegacion" name="_delegacion" disabled>
              </div>
              <div class="form-group col-md-3">
                <label for="_estado">Delegación/Municipio</label>
                <input type="text" class="form-control form-control-sm detalle" value="{{$info->estado}}" style="text-transform:capitalize" id="_estado" name="_estado" disabled>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingTwo">
          <h2 class="mb-0">
            <button class="btn btn-outline-primary collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              Información Adicional
            </button>
            <a href="{{route('infoalumno.edit', ['id' => $info->id])}}" class="btn btn-sm btn-primary" role="button" title="Editar" aria-pressed="true">
              <i class="fas fa-pencil-alt"></i> Editar
            </a>
          </h2>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
          <div class="card-body">
            <div class="form-row">
              <div class="form-group col-md-3">
                <label for="telefcasa">Teléfono de Casa</label>
                <input type="text" class="form-control form-control-sm telefono" value="{{$info->telefcasa}}" id="telefcasa" name="telefcasa" disabled>
              </div>
              <div class="form-group col-md-2">
                <label for="referencia1">Referencia</label>
                <input type="text" class="form-control form-control-sm" value="{{$info->referencia1}}" id="referencia1" name="referencia1" style="text-transform:capitalize" disabled>
              </div>
              <div class="form-group col-md-3">
                <label for="teleftutor">Teléfono del Tutor</label>
                <input type="text" class="form-control form-control-sm telefono" value="{{$info->teleftutor}}" id="teleftutor" name="teleftutor" disabled>
              </div>
              <div class="form-group col-md-2">
                <label for="referencia2">Referencia</label>
                <input type="text" class="form-control form-control-sm" value="{{$info->referencia2}}" id="referencia2" name="referencia2"  style="text-transform:capitalize" disabled>
              </div>

            </div>
            <div class="form-row">
              <div class="form-group col-md-3">
                <label for="telefcelular">Teléfono Celular</label>
                <input type="text" class="form-control form-control-sm telefono" value="{{$info->telefcelular}}" id="telefcelular" name="telefcelular" disabled>
              </div>
              <div class="form-group col-md-2">
                <label for="referencia3">Referencia</label>
                <input type="text" class="form-control form-control-sm" value="{{$info->referencia3}}" id="referencia3" name="referencia3" placeholder="" style="text-transform:capitalize" disabled>
              </div>
              <div class="form-group col-md-3">
                <label for="telefotro">Otro</label>
                <input type="text" class="form-control form-control-sm telefono" value="{{$info->telefotro}}" id="telefotro" name="telefotro" disabled>
              </div>
              <div class="form-group col-md-2">
                <label for="referencia4">Referencia</label>
                <input type="text" class="form-control form-control-sm" value="{{$info->referencia4}}" id="referencia4" name="referencia4" style="text-transform:capitalize" disabled>
              </div>

            </div>
            <div class="form-row">
              <div class="form-group col-md-3">
                <label for="escuela">Escuela</label>
                <input type="text" class="form-control form-control-sm" value="{{$info->escuela}}" id="escuela" name="escuela" style="text-transform:capitalize" disabled>
              </div>
              <div class="form-group col-md-3">
                <label for="ultimogrado">Último Grado Escolar a Cursar</label>
                <input type="text" class="form-control form-control-sm" value="{{$info->ultimogrado}}" id="ultimogrado" name="ultimogrado" style="text-transform:capitalize" disabled>
              </div>
              <div class="form-group col-md-3">
                <label for="lugartrabajo">Lugar de Trabajo</label>
                <input type="text" class="form-control form-control-sm" value="{{$info->lugartrabajo}}" id="lugartrabajo" name="lugartrabajo" style="text-transform:capitalize" disabled>
              </div>
              <div class="form-group col-md-3">
                <label for="email">Correo Eléctronico del Alumno</label>
                <input type="text" class="form-control form-control-sm" value="{{$info->email}}" id="email" name="email" placeholder="ejemplo@dominio.com" disabled>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="pregunta1">¿Cómo te enteraste de la escuela?</label>
                <input type="text" class="form-control form-control-sm" value="{{$info->pregunta1}}" disabled>
              </div>
              <div class="form-group col-md-6">
                <label for="pregunta2">¿Por qué quieres estudiar inglés?</label>
                <input type="text" class="form-control form-control-sm" value="{{$info->pregunta2}}" disabled>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- Contenedor de la seccion -->
@endsection
