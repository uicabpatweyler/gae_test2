@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Editar Datos del tutor')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-md-12 col-sm-12 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-plus-circle text-info"></i> Editar informacion adicional
      </h5>
      <a href="{{route('tutores.index')}}" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
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
      <div class="form-group col-md-3">
        <label for="">Tutor</label>
        <input type="text" class="form-control form-control-sm" value="{{$tutor->full_name}}" style="text-transform:capitalize" disabled>
      </div>
      <div class="form-group col-md-4">
        <label for="">Escuela</label>
        <input type="text" class="form-control form-control-sm" value="{{$escuela->nombre}}" style="text-transform:capitalize" disabled>
      </div>
      <div class="form-group col-md-2">
        <label for="">Ciclo</label>
        <input type="text" class="form-control form-control-sm" value="{{$ciclo->periodo}}" style="text-transform:capitalize" disabled>
      </div>
      <div class="form-group col-md-3">
        <label for="">Tutor de</label>
        <input type="text" class="form-control form-control-sm" value="{{$alumno->full_name}}" style="text-transform:capitalize" disabled>
      </div>
    </div>

    <!-- Formulario -->
    <form method="POST" action="{{route('infotutor.update.infoadicional', $infoTutor->id)}}" id="form_infoadicional" name="form_infoadicional">
      <input type="hidden" id="user_updated" name="user_updated" value="{{Auth::id()}}">
      <input type="hidden" name="adicional_estado" id="adicional_estado" value="{{$infoTutor->adicional_estado}}">
      <input type="hidden" name="adicional_delegacion" id="adicional_delegacion" value="{{$infoTutor->adicional_delegacion}}">
      @method('PATCH')
      @csrf
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="adicional_trabajo">Nombre del lugar de trabajo</label>
          <input type="text" class="form-control form-control-sm" value="{{$infoTutor->adicional_trabajo}}" style="text-transform:capitalize" id="adicional_trabajo" name="adicional_trabajo">
        </div>
        <div class="form-group col-md-6">
          <label for="adicional_direccion">Dirección del lugar de trabajo</label>
          <input type="text" class="form-control form-control-sm" value="{{$infoTutor->adicional_direccion}}" style="text-transform:capitalize" id="adicional_direccion" name="adicional_direccion">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="_estado">Estado</label>
          <select id="_estado" name="_estado" class="form-control form-control-sm">
            @foreach($estados as $estado)
              @if($loop->first)
                <option value="" selected>Seleccione...</option>
              @endif
              <option value="{{$estado->id}}">{{$estado->estado_nombre}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-md-4">
          <label for="_delegacion">Delegación/Municipio</label>
          <select id="_delegacion" name="_delegacion" class="form-control form-control-sm" disabled>
          </select>
        </div>
        <div class="form-group col-md-4">
          <label for="colonia">Colonia</label>
          <select id="colonia" name="colonia" class="form-control form-control-sm" disabled>
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-3">
          <label for="adicional_localidad">Localidad</label>
          <input type="text" class="form-control form-control-sm detalle" value="{{$infoTutor->adicional_localidad}}" style="text-transform:capitalize" id="adicional_localidad" name="adicional_localidad">
        </div>
        <div class="form-group col-md-3">
          <label for="adicional_tipoasentamiento">Tipo Asentamiento</label>
          <input type="text" class="form-control form-control-sm detalle" value="{{$infoTutor->adicional_tipoasentamiento}}" style="text-transform:capitalize" id="adicional_tipoasentamiento" name="adicional_tipoasentamiento">
        </div>
        <div class="form-group col-md-4">
          <label for="adicional_nombreasentamiento">Nombre Asentamiento </label>
          <input type="text" class="form-control form-control-sm detalle" value="{{$infoTutor->adicional_nombreasentamiento}}" style="text-transform:capitalize" id="adicional_nombreasentamiento" name="adicional_nombreasentamiento">
        </div>
        <div class="form-group col-md-2">
          <label for="adicional_codpost">Código Postal</label>
          <input type="text" class="form-control form-control-sm detalle" value="{{$infoTutor->adicional_codpost}}" id="adicional_codpost" name="adicional_codpost">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="email">Correo Eléctronico</label>
          <input type="text" class="form-control form-control-sm" value="{{$infoTutor->email}}" id="email" name="email" placeholder="ejemplo@dominio.com">
        </div>
      </div>
      <div class="border-top mt-2 mb-2"></div>
      <div class="float-right mb-2">
        <button class="btn red600 text-white mr-1" id="btn_cancelar" name="btn_cancelar">
          <i class="fas fa-times-circle"></i>
          Cancelar
        </button>
        <button type="submit" class="btn blue700 text-white" id="btn_guardar" name="btn_guardar">
          <i class="fas fa-save"></i>
          Guardar
        </button>
      </div>
    </form>
    <!-- Formulario -->

  </div>
  <!-- Contenedor de la seccion -->
@endsection

@push('scripts')
  <!-- Archivo(s) javascript del modulo -->
  <script src="{{ asset('jqueryvalidate-1.19.0/jquery.validate.js') }}"></script>
  <script>
    $('#btn_cancelar').click(function(){
      event.preventDefault();
      showCancel('{{ URL::previous() }}')
    });

    $().ready(function() {

      $( "#form_infoadicional" ).submit(function( event ) {
        event.preventDefault();
        saveUpdate();
      });

      function saveUpdate(){
        $("#btn_guardar").prop('disabled', 'disabled');
        $.ajax({
          method: "POST",
          url: $("#form_infoadicional").attr('action'),
          data: $("#form_infoadicional").serialize()
        })
          .done(function(data, textStatus, jqXHR){
            showAlert(textStatus, jqXHR.statusText, data.message, data.location);
          })
          .fail(function( jqXHR, textStatus, errorThrown){
            var errors = Object.keys(jqXHR.responseJSON.errors).length;
            var message = errors === 1
              ? 'Verifica el campo marcado en rojo'
              : 'Verifica los ' + errors + ' campos marcados en rojo';

            showAlert(textStatus, jqXHR.statusText, message, '');

            $.each(jqXHR.responseJSON.errors, function(key,value){
              $( "#"+key ).addClass( "is-invalid" ).removeClass( "is-valid" );
              $('<div id="'+key+'-error" class="error invalid-feedback">'+value+'</div>').insertAfter( $( "#"+key ) );
            });
            $("#btn_guardar").removeAttr('disabled');
          });
      }

      /* Evento change del select de los estados*/
      $("#_estado").change(function(){
        if($(this).val()!==''){
          $("#adicional_estado").val($(this).children("option:selected").text());
          $("#_delegacion").enableControl(true, true);
          $(".detalle ").val("");
          $.getJSON(urlRoot+'/data/delegaciones/'+$(this).val(), null, function (values) {
            $("#_delegacion").populateSelect(values);
          });
        }
        else{
          $("#adicional_estado").val("");
          $("#_delegacion").enableControl(true,false);
          $("#colonia").enableControl(true, false);
          $(".detalle ").val("");
        }
      });

      /*Evento change del select de las delegaciones*/
      $("#_delegacion").change(function () {
        if($(this).val()!==''){
          $("#adicional_delegacion").val($(this).children("option:selected").text());
          $("#colonia").enableControl(true, true);
          $(".detalle ").val("");
          $.getJSON(urlRoot+'/data/colonias/'+$("#_estado").val()+'/'+$(this).val(), null, function (values) {
            $("#colonia").populateSelect(values);
          });
        }
        else{
          $("#adicional_delegacion").val("");
          $("#colonia").enableControl(true,false);
          $(".detalle ").val("");
        }
      });

      /*Evento change del select de las colonias*/
      $("#colonia").change(function () {
        if($(this).val()!==''){
          $(".detalle ").val("");
          $.getJSON(urlRoot+'/data/colonia/'+$(this).val(), null, function (value) {
            $("#adicional_localidad").val(value.localidad);
            $("#adicional_tipoasentamiento").val(value.tipo);
            $("#adicional_nombreasentamiento").val(value.asentamiento);
            $("#adicional_codpost").val(value.codigo)
          });
        }
        else{
          $(".detalle ").val("");
        }
      });

    });
  </script>
@endpush


