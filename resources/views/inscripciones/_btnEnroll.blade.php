@if( $createUrl!=null)
  <a href="{!! $createUrl !!}" class="btn bg-transparent btn-sm" role="button" title="Inscribir Alumno" aria-pressed="true">
    <i class="fas fa-user text-info"></i>
    <i class="fas fa-arrow-right text-secondary"></i>
    <i class="fas fa-id-card text-info"></i>
  </a>
@else
  <i class="fas fa-ban text-danger"></i>
@endif