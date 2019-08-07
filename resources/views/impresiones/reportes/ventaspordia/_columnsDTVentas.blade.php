@if($urlRecibo!=null)
  <button type="button" class="btn btn-outline-primary btn-sm" onclick="window.open('{!! $urlRecibo !!}')">
    <i class="fas fa-dollar-sign"></i>
    <i class="fas fa-arrow-right"></i>
    <i class="far fa-file-pdf text-danger"></i>
  </button>
@endif
@if($urlShowToCancel!=null)
  <a href="{!! $urlShowToCancel !!}" class="btn btn-outline-danger btn-sm" role="button" title="Cancelar" aria-pressed="true">
    <i class="fas fa-dollar-sign"></i>
    <i class="fas fa-arrow-right"></i>
    <i class="fas fa-ban"></i>
  </a>
@endif