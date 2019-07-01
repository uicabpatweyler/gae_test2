@if($tutorUrl!=null)
  <a href="{!! $tutorUrl !!}" class="btn bg-transparent btn-sm" role="button" title="Asignar Tutor" aria-pressed="true">
    <i class="fas fa-question-circle text-danger"></i>
    <i class="fas fa-arrow-right text-secondary"></i>
    <i class="fas fa-user text-info"></i>
  </a>
@else
  <i class="fas fa-check text-success"></i>
@endif