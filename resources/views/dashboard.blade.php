@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Dashboard A.G.E.')

{{--Contenido de la seccion--}}
@section('content')

      <!-- Contenedor de la seccion -->
      <div class="col-12 col-md-12 mt-2 px-2 rounded shadow bg-white border">

        <!-- Titulo de la seccion -->
        <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
          <h5 class="mb-0 lh-100 text-uppercase">
            <i class="fas fa-table text-info"></i> titulo sección
          </h5>
          <a href="" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
            <i class="fas fa-plus"></i> boton de acción
          </a>
        </div>
        <!-- Titulo de la seccion -->

        <!-- Formulario, Tablas...etc -->
        <!-- Formulario, Tablas...etc -->

      </div>
      <!-- Contenedor de la seccion -->

@endsection