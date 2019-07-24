@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Mostrar Categoría')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-12 col-md-12 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-eye text-info"></i> mostrar categoría
      </h5>
      <a href="{{ route('categorias.index') }}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
        <i class="far fa-arrow-alt-circle-left"></i> regresar
      </a>
    </div>
    <!-- Titulo de la seccion -->

    <div class="border-bottom border-gray pb-2 mb-2">
        <span class="font-weight-bold">
            Si desea realizar algun cambio, presione el botón Editar.
        </span>
    </div>

    <!-- Formulario -->
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="">Nombre de la categoría</label>
          <input type="text" class="form-control form-control-sm" value="{{$categoria->nombre}}" disabled>
        </div>
      </div>
      <div class="border-top mt-2 mb-2"></div>
      <div class="float-right">
        <a class="btn blue700 text-white" href="{{ route('categorias.edit', ['id' => $categoria->id]) }}" id="btn_edit" name="btn_edit" role="button">
          <i class="fas fa-pencil-alt"></i>
          Editar
        </a>
      </div>
    <!-- Formulario -->

  </div>
  <!-- Contenedor de la seccion -->
@endsection