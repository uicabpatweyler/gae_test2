@if($dateEnroll!=null)
  <span class="badge badge-info">
    {!! $dateEnroll !!}
  </span>
@endif

@if($groupEnroll!=null)
  <span class="badge badge-success">
    {!! $groupEnroll !!}
  </span>
@endif

@if($urlRecibo!=null)
  <button type="button" class="btn btn-outline-primary btn-sm" onclick="window.open('{!! $urlRecibo !!}')">
    {!! $folioPago !!}
  </button>
@endif

@if($urlHoja!=null)
  <button type="button" class="btn btn-outline-primary btn-sm" onclick="window.open('{!! $urlHoja !!}')">
    <i class="far fa-address-card"></i> Imprimir
  </button>
@endif