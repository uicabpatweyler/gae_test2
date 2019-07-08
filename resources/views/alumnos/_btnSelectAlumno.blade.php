@if($urlEdit!=null)
  <a href="{!! $urlEdit !!}" class="btn btn-primary btn-sm" role="button" title="Alumno" aria-pressed="true">
    <i class="fas fa-user-edit"></i> Alumno
  </a>
@endif
@if($urlDatosInscripcion!=null)
  <a href="{!! $urlDatosInscripcion !!}" class="btn btn-info btn-sm" role="button" title="Datos de inscripción" aria-pressed="true">
    <i class="fas fa-edit"></i> Datos de inscripción
  </a>
@endif
