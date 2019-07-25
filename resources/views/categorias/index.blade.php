@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Categorías de productos')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-12 col-md-12 mt-2 pb-3 rounded shadow bg-white border">

    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-table text-info"></i> categorías de productos
      </h5>
      <a href="{{ route('categorias.create') }}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
        <i class="fas fa-plus"></i> nueva categoría
      </a>
    </div>
    <!-- Titulo de la seccion -->


      <div class="accordion" id="accordionCategorias">
        @foreach($categorias as $categoria)
          <div class="card">
            <div class="card-header" id="heading{{$categoria->nombre}}">
              <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{$categoria->id}}" aria-expanded="true" aria-controls="collapse{{$categoria->id}}">
                  {{$categoria->nombre}}
                </button>
                <a href="{{route('categoria.child.create', ['id' => $categoria->id])}}" class="btn btn-sm btn-primary" role="button" title="Agregar" aria-pressed="true">
                  <i class="fas fa-plus"></i>
                </a>
              </h2>
            </div>

            <div id="collapse{{$categoria->id}}" class="collapse" aria-labelledby="heading{{$categoria->nombre}}" data-parent="#accordionCategorias">
              <div class="card-body">
                @if(count($categoria->childs))
                  @include('categorias.manageChild',['childs' => $categoria->childs, 'idAccordion' => $categoria->id])
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>
  </div>
  <!-- Contenedor de la seccion -->

@endsection
@push('scripts')
  <!-- Axios -->
  <script src="{{asset('axios-0.19.0/axios.js')}}"></script>
  <!-- Datatables JS -->
  <script>
    $(document).ready(function(){

    });
  </script>
@endpush
