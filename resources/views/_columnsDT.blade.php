@if($cicloEnroll!=null)
  <span class="badge badge-success">
    {!! $cicloEnroll !!}
  </span>
@endif
@if($groupEnroll!=null)
  <span class="badge badge-info">
    {!! $groupEnroll !!}
  </span>
@endif
@if($urlHoja!=null)
  <button type="button" class="btn btn-outline-primary btn-sm" onclick="window.open('{!! $urlHoja !!}')">
    <i class="far fa-address-card"></i>
    <i class="fas fa-arrow-right"></i>
    <i class="far fa-file-pdf text-danger"></i>
  </button>
@endif
@if($urlRecibo!=null)
  <button type="button" class="btn btn-outline-primary btn-sm" onclick="window.open('{!! $urlRecibo !!}')">
    <i class="fas fa-dollar-sign"></i>
    <i class="fas fa-arrow-right"></i>
    <i class="far fa-file-pdf text-danger"></i>
  </button>
@endif
@if($urlPago!=null)
  <button type="button" class="btn btn-outline-primary btn-sm" onclick="location.href=('{!! $urlPago !!}')">
    <i class="far fa-user-circle"></i>
    <i class="fas fa-arrow-right"></i>
    <i class="fas fa-dollar-sign"></i>
  </button>
@endif
