@extends('master')

{{-- Titulo de la sección--}}
@section('title', 'Inscripción de alumno')

{{--Contenido de la seccion--}}
@section('content')

  <!-- Contenedor de la seccion -->
  <div class="col-md-12 col-sm-12 mt-2 pb-3 rounded shadow bg-white border">
    <!-- Titulo de la seccion -->
    <div class="d-flex align-items-center justify-content-between p-2 my-2 rounded shadow-sm border">
      <h5 class="mb-0 lh-100 text-uppercase">
        <i class="fas fa-plus-circle text-info"></i> Inscripción: nuevo alumno
      </h5>
      <a href="" class="btn btn-sm blue600 text-white text-uppercase"  role="button" aria-pressed="true" >
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

    <!-- Formulario -->
    <div class="accordion" id="accordionAlumno">
      <div class="card">
        <div class="card-header" id="headingTwo">
          <h2 class="mb-0">
            <button class="btn btn-primary collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              Datos de Dirección
            </button>
          </h2>
        </div>
        <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionAlumno">
          <div class="card-body">
            <form>
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="nombre">Nombre de Vialidad</label>
                  <input type="text" class="form-control form-control-sm" id="nombre" name="nombre" required>
                </div>
                <div class="form-group col-md-2">
                  <label for="interior">Interior</label>
                  <input type="text" class="form-control form-control-sm" id="interior" name="interior" required>
                </div>
                <div class="form-group col-md-2">
                  <label for="exterior">Exterior</label>
                  <input type="text" class="form-control form-control-sm" id="exterior" name="exterior" required>
                </div>
                <div class="form-group col-md-4">
                  <label for="entre_calles">Entre Calles</label>
                  <input type="text" class="form-control form-control-sm" id="entre_calles" name="entre_calles" required>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="estado">Estado</label>
                  <select id="estado" name="estado" class="form-control form-control-sm" required>
                    @foreach($estados as $estado)
                      @if($loop->first)
                        <option value="" selected>Seleccione...</option>
                      @endif
                      <option value="{{$estado->id}}">{{$estado->estado_nombre}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-4">
                  <label for="delegacion">Delegación/Municipio</label>
                  <select id="delegacion" name="delegacion" class="form-control form-control-sm" required disabled>
                  </select>
                </div>
                <div class="form-group col-md-4">
                  <label for="colonia">Colonia</label>
                  <select id="colonia" name="colonia" class="form-control form-control-sm" required disabled>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-3">
                  <label for="localidad">Localidad</label>
                  <input type="text" class="form-control form-control-sm" id="localidad" name="localidad" required disabled>
                </div>
                <div class="form-group col-md-3">
                  <label for="tipo">&nbsp;</label>
                  <input type="text" class="form-control form-control-sm" id="tipo" name="tipo" required disabled>
                </div>
                <div class="form-group col-md-4">
                  <label for="asentamiento">&nbsp;</label>
                  <input type="text" class="form-control form-control-sm" id="asentamiento" name="asentamiento" required disabled>
                </div>
                <div class="form-group col-md-2">
                  <label for="codigo_postal">Código Postal</label>
                  <input type="text" class="form-control form-control-sm" id="codigo_postal" name="codigo_postal" required disabled>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingOne">
          <h2 class="mb-0">
            <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              Datos Personales
            </button>
          </h2>
        </div>

        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionAlumno">
          <div class="card-body">

          </div>
        </div>
      </div>
    </div>
    <!-- Formulario -->

  </div>
  <!-- Contenedor de la seccion -->
@endsection

@push('scripts')
  <!-- Archivo(s) javascript del modulo -->
  <script src="{{ asset('jqueryvalidate-1.19.0/jquery.validate.js') }}"></script>
  <script src="{{ asset('modulos/cuotas.js') }}"></script>
  <script>
    $().ready(function() {
      /* Evento change del select de los estados*/
      $("#estado").change(function(){
        if($(this).val()!==''){
          $("#delegacion").enableControl(true, true);
          $.getJSON(urlRoot+'/data/delegaciones/'+$(this).val(), null, function (values) {
            $("#delegacion").populateSelect(values);
          });
        }
        else{
          $("#delegacion").enableControl(true,false);
          $("#colonia").enableControl(true, false);
        }
      });

      /*Evento change del select de las delegaciones*/
      $("#delegacion").change(function () {
        if($(this).val()!==''){
          $("#colonia").enableControl(true, true);
          $.getJSON(urlRoot+'/data/colonias/'+$("#estado").val()+'/'+$(this).val(), null, function (values) {
            $("#colonia").populateSelect(values);
          });
        }
        else{}
      });

      /*Evento change del select de las colonias*/
      $("#colonia").change(function () {
        if($(this).val()!==''){
          $("#localidad").enableControl(true, true);
          $("#tipo").enableControl(true, true);
          $("#asentamiento").enableControl(true, true);
          $("#codigo_postal").enableControl(true, true);
          $.getJSON(urlRoot+'/data/colonia/'+$(this).val(), null, function (value) {
            $("#localidad").val(value.localidad);
            $("#tipo").val(value.tipo);
            $("#asentamiento").val(value.asentamiento);
            $("#codigo_postal").val(value.codigo)
          });
        }
        else{}
      });
    });
  </script>
@endpush

