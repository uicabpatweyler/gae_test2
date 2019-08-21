@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Cambio de Grupo')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-md-12 col-sm-12 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        cambio de grupo
      </h5>
      <a href="{{ route('alumnos.cambiodegrupo.index') }}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
        <i class="far fa-arrow-alt-circle-left"></i> regresar
      </a>
    </div>
    <!-- Titulo de la seccion -->

    <div class="border-bottom border-gray pb-2 mb-2">
        <span class="font-weight-bold">
            Complete los siguientes datos
        </span>
      <small class="text-danger"> (* campo obligatorio)</small>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="">Escuela</label>
        <input type="text" class="form-control form-control-sm" id="" name="" value="{{ $escuela->nombre }}" disabled>
      </div>
      <div class="form-group col-md-2">
        <label for="">Ciclo Escolar</label>
        <input type="text" class="form-control form-control-sm" id="" name="" value="{{$ciclo->periodo}}" disabled>
      </div>
      <div class="form-group col-md-4">
        <label for="">Alumno</label>
        <input type="text" class="form-control form-control-sm" id="" name="" value="{{$alumno->fullname }}" disabled>
      </div>
      <div class="form-group col-md-2">
        <label for="">Grupo Actual</label>
        <input type="text" class="form-control form-control-sm" id="" name="" value="{{$grupo->nombre}}" disabled>
      </div>
    </div>

    <!-- Formulario -->
    <form action="{{route('alumnos.cambiodegrupo.store')}}" method="POST" id="form_cambiodegrupo" name="form_cambiodegrupo">
      @csrf
      <input type="hidden" id="grupo_id" name="grupo_id" value="0">
      <input type="hidden" id="grado_id" name="grado_id" value="0">
      <input type="hidden" id="inscripcion_id" name="inscripcion_id" value="{{$inscripcion->id}}">
      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="nuevogrupo" class="font-weight-bold">Nuevo grupo del alumno <span class="text-danger">*</span></label>
          <input type="text" class="form-control form-control-sm" id="nuevogrupo" name="nuevogrupo" value="" readonly>
        </div>
      </div>
      <div class="border-top mt-2 mb-2"></div>
      <div class="float-right">
        <button class="btn red600 text-white mr-1" id="btn_cancelar" name="btn_cancelar">
          <i class="fas fa-times-circle"></i>
          Cancelar
        </button>
        <button type="button" class="btn blue700 text-white" id="btn_guardar" name="btn_guardar" disabled>
          <i class="fas fa-save"></i>
          Guardar
        </button>
      </div>
    </form>
    <!-- Formulario -->
  </div>
  <!-- Contenedor de la seccion -->

  <!-- Contenedor de la seccion -->
  <div class="col-md-12 col-sm-12 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        grupos disponibles
      </h5>
    </div>
    <div class="form-row align-items-center">
      <div class="col-sm-4 my-1">
        <label class="sr-only" for="_grado_id">Grado</label>
        <select id="_grado_id" name="_grado_id" class="form-control">
          @foreach($grados as $item)
            @if($loop->first)
              <option value="" selected>[Elija un grado]</option>
            @endif
            <option value="{{ $item->id }}">{{ $item->nombre }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <!-- Titulo de la seccion -->
    <div class="border-bottom border-gray pb-2 mb-2"></div>
    <div class="table-responsive col-12">
      <table class="table table-striped" id="grupos">
        <thead>
        <tr>
          <th scope="col" class="text-center">GRADO</th>
          <th scope="col" class="text-center">GRUPO</th>
          <th scope="col" class="text-center">CUPO</th>
          <th scope="col" class="text-center">ALUMNOS</th>
          <th scope="col" class="text-center">DISPONIBLE</th>
          <th scope="col" class="text-center">CUOTA</th>
          <th scope="col" class="text-center"></th>
        </tr>
        </thead>
      </table>
    </div>
  </div>
  <!-- Contenedor de la seccion -->

@endsection

@push('scripts')
<!-- Archivo(s) javascript del modulo -->
<script src="{{ asset('gijgo-datepicker-1.9.1.13/js/gijgo.js')}}"></script>
<script src="{{ asset('gijgo-datepicker-1.9.1.13/js/messages/messages.es-es.js') }}"></script>
<script>
$('#btn_cancelar').click(function(){
    event.preventDefault();
    showCancel('{{ route('alumnos.cambiodegrupo.index') }}')
});

function asignarGrupo(value){
    let detalles = value.split('-');
    $("#grado_id").val(detalles[2]);
    $("#grupo_id").val(detalles[3]);
    $("#btn_guardar").enableControl(false,true);
    $("#nuevogrupo").empty().val(detalles[4]);
    showGroup(detalles[4]);
}

function showGroup(grupo){
  Swal.fire({
      type: 'success',
      title: 'Nuevo grupo elegido: '+grupo,
      text: ''
  })
}

$().ready(function(){

  $("#_grado_id").change(function(){
    if($(this).val()!==''){
      filtrarGrupos(buildUrl());
    }
  });

  function buildUrl(){
      let escuela = '{{$escuela->id}}';
      let ciclo = '{{$ciclo->id}}';
      let grado = $("#_grado_id").val();
      return urlRoot + '/data/gruposinscripcion/'+escuela+'/'+ grado+'/'+ciclo
  }

  function filtrarGrupos(urlAjax){
    $('#grupos').DataTable({
      processing: true,
      serverSide: true,
      ordering: false,
      searching: false,
      destroy: true,
      ajax: urlAjax,
      language: {
        url: "{{ asset('datatables-1.10.19/lang/Spanish.json') }}"
      },
      columns: [
        {data: 'grado.nombre', name: 'grado.nombre', className: "text-center"},
        {data: 'nombre', name: 'nombre', className: "text-center"},
        {data: 'cupoalumnos', name: 'cupoalumnos', className: "text-center"},
        {data: 'inscritos', name: 'inscritos', className: "text-center"},
        {
          data: null, className: "text-center",
          render: function (data) {
              if(data.cupoalumnos - data.inscritos === 0){
                  return '<i class="fas fa-ban text-danger"></i>'
              }
              return data.cupoalumnos - data.inscritos;
          }
        },
        {data: 'cuotains', name: 'cuotains', className: "text-center"},
        { data: null, className:"text-center",
          render: function(data){
              if(data.cupoalumnos - data.inscritos === 0){
                  return '';
              }
              return htmlDecode(data.details);
          }
        }
      ]
    });
  }

  $("#btn_guardar").click(function(){
    Swal.fire({
      title: '¿Desea realizar el cambio de grupo?',
      text: "",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si',
      cancelButtonText: 'No'
    }).then((result) => {
      if (result.value) {
        saveUpdate();
      }
    });
  });

  function saveUpdate(){
    $("#btn_guardar").prop('disabled', 'disabled');
    $.ajax({
      method: "POST",
      url: $("#form_cambiodegrupo").attr('action'),
      data: $("#form_cambiodegrupo").serialize()
    })
    .done(function(data, textStatus, jqXHR){
      showSwal('success', 'OK', data.message, data.location);
      $("#btn_recibo").removeAttr('disabled');
    })
    .fail(function( jqXHR, textStatus, errorThrown){
      var message = 'Ocurrio un error al procesar el cambio de grupo.';
      showSwal('error', 'ERROR', message, '');
      console.log(jqXHR);
      $("#btn_guardar").removeAttr('disabled');
    });
  }

  function showSwal(_textStatus, _statusText, _message, _location){
    Swal.fire({
      type:  _textStatus,
      title: _statusText === 'OK' ? 'OK' : 'ERROR',
      text:  _message,
      allowOutsideClick:  false,
      showCancelButton:   _statusText !== 'OK',
      showConfirmButton:  _statusText === 'OK',
      confirmButtonColor: '#3085d6',
      cancelButtonColor:  '#d33',
      cancelButtonText:   'Corregir',
      confirmButtonText:  'Continuar'
    }).then((result) => {
      if (result.value) {
          window.location.replace(_location);
      }
    });
  }
});
</script>
@endpush

