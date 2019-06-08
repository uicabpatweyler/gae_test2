@if($showUrl!=null)
<a href="{!! $showUrl !!}" class="btn bg-transparent btn-sm" role="button" title="Ver" aria-pressed="true">
  <i class="far fa-eye text-secondary"></i>
</a>
@endif
@if($editUrl!=null)
  <a href="{!! $editUrl !!}" class="btn bg-transparent btn-sm" role="button" title="Editar" aria-pressed="true">
    <i class="fas fa-pencil-alt text-primary"></i>
  </a>
@endif
@if($deleteUrl!=null)
  <button type="button" class="btn bg-transparent btn-sm" onclick="deleteItem('{!! $deleteUrl !!}')">
    <i class="far fa-trash-alt text-danger"></i>
  </button>
@endif