@if($urlRecibo!=null)
  <button type="button" class="btn btn-outline-primary btn-sm" onclick="window.open('{!! $urlRecibo !!}')">
    <i class="fas fa-dollar-sign"></i>
    <i class="fas fa-arrow-right"></i>
    <i class="far fa-file-pdf text-danger"></i>
  </button>
@endif