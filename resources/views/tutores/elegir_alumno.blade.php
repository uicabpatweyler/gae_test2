@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Asignar Tutor')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-md-12 col-sm-12 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-user-tie text-info"></i>
        <i class="fas fa-arrow-right text-danger"></i>
        <i class="fas fa-user text-info"></i>
        Asignar Tutor a Alumno
      </h5>
    </div>
    <!-- Titulo de la seccion -->

    <div class="border-bottom border-gray pb-2 mb-2">
        <span class="font-weight-bold">
            Seleccione un alumno de la lista
        </span>
      <small class="text-danger"> (* campo obligatorio)</small>
    </div>
    
    <div class="card border-0 mb-2">
      <form method="POST" action="{{route('asignar.tutor.alumno')}}" name="form_tutorAlumno" id="form_tutorAlumno">
        <input type="hidden" id="id_row" name="id_row" value="0">
        <input type="hidden" id="tutor_id" name="tutor_id" value="{{$tutor->id}}">
        @method('PATCH')
        @csrf
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="tutor" class="font-weight-bold">Tutor</label>
            <input type="text" class="form-control" id="tutor" name="tutor" value="{{$tutor->fullName}}" disabled="">
          </div>
          <div class="form-group col-md-6">
            <label for="alumno" class="font-weight-bold">Alumno <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="alumno" name="alumno" value="" disabled="">
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
    </div>

    <div class="card">
      <div class="card-header">
        <span class="font-weight-bold">Alumnos sin tutor</span>
      </div>
      <div class="card-body">
        <table class="table table-striped" id="alumnos">
          <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido P.</th>
            <th scope="col">Apellido M.</th>
            <th scope="col"></th>
          </tr>
          </thead>
          <tbody>
          @foreach($alumnos as $info)
            <tr>
              <th scope="row">{{$info->id}}</th>
              <td>{{$info->alumno->nombre1}} {{$info->alumno->nombre2}}</td>
              <td>{{$info->alumno->apellido1}}</td>
              <td>{{$info->alumno->apellido2}}</td>
              <td>
                <button type="button" class="btn btn-success btn-sm">
                  <i class="fas fa-user-check"></i> Elegir
                </button>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- Contenedor de la seccion -->

@endsection

@push('scripts')
  <script src="{{ asset('jqueryvalidate-1.19.0/jquery.validate.js') }}"></script>
  <script>
    $('#btn_cancelar').click(function(){
      event.preventDefault();
      showCancel('{{ route('tutores.index') }}')
    });
    $(document).ready(function(){
      let table =  $('#alumnos').DataTable({
        ordering:false,
        language: {
          url: "{{ asset('datatables-1.10.19/lang/Spanish.json') }}"
        }
      });

      $('#alumnos tbody').on('click', 'button', function () {
        let data = table.row( $(this).parents('tr') ).data();
        let nombre = data[1] +' '+ data[2] +' '+ data[3];
        $("#id_row").val(data[0]);
        $("#alumno").val(nombre);
        $("#btn_guardar").enableControl(false,true);
      } );

      $("#btn_guardar").click( function(){
        showConfirm();
      });

      function showConfirm(){
        Swal.fire({
          title: '¿Desea continuar?',
          text: "",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'No',
          confirmButtonText: 'Si'
        }).then((result) => {
          if (result.value) {
            saveUpdate();
          }
        });
      }

      function saveUpdate(){
        $("#btn_guardar").prop('disabled', 'disabled');
        $.ajax({
          method: "POST",
          url: $("#form_tutorAlumno").attr('action'),
          data: $("#form_tutorAlumno").serialize()
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
    });
  </script>
@endpush



