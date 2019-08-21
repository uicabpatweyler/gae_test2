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
@if($urlShowToCancel!=null)
  <a href="{!! $urlShowToCancel !!}" class="btn btn-outline-danger btn-sm" role="button" title="Cancelar" aria-pressed="true">
    <i class="fas fa-dollar-sign"></i>
    <i class="fas fa-arrow-right"></i>
    <i class="fas fa-ban"></i>
  </a>
@endif
@if($urlVenta!=null)
  <button type="button" class="btn btn-outline-primary btn-sm" onclick="location.href=('{!! $urlVenta !!}')">
    <i class="far fa-user-circle"></i>
    <i class="fas fa-arrow-right"></i>
    <i class="fas fa-dollar-sign"></i>
  </button>
@endif
@if($urlCambioGrupo!=null)
  <button type="button" class="btn btn-outline-primary btn-sm" onclick="location.href=('{!! $urlCambioGrupo !!}')">
    <i class="far fa-user-circle"></i>
    <i class="fas fa-arrow-right"></i>
    <i class="fas fa-user-friends"></i>
  </button>
@endif

