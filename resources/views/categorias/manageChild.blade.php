<div class="accordion" id="accordion{{$idAccordion}}">
    @foreach($childs as $child)
        <div class="card">
            <div class="card-header" id="heading{{$child->nombre}}">
                <h2 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{$child->id}}" aria-expanded="true" aria-controls="collapse{{$child->id}}">
                        {{$child->nombre}}
                    </button>
                  <a href="{{route('categoria.child.create', ['id' => $child->id])}}" class="btn btn-sm btn-primary" role="button" title="Agregar" aria-pressed="true">
                    <i class="fas fa-plus"></i>
                  </a>
                  <a href="{{route('categorias.edit', ['id' => $child->id])}}" class="btn btn-sm btn-primary" role="button" title="Editar" aria-pressed="true">
                    <i class="fas fa-pencil-alt"></i>
                  </a>
                </h2>
            </div>

            <div id="collapse{{$child->id}}" class="collapse" aria-labelledby="heading{{$child->nombre}}" data-parent="#accordion{{$idAccordion}}">
                <div class="card-body">
                    @if(count($child->childs))
                            <div class="table-responsive col-12">
                                <table class="table table-striped" id="categorias">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="text-center">CATEGORÍA</th>
                                        <th scope="col" class="text-center">DISPONIBLE</th>
                                        <th scope="col" class="text-center">ACCIONES</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($child->childs as $child2)
                                        <tr>
                                            <td class="text-center">{{$child2->nombre}}</td>
                                            <td class="text-center">
                                              @if($child2->disponible)
                                                <i class="fas fa-check text-success"></i>
                                              @else
                                                <i class="fas fa-times text-danger"></i>
                                              @endif
                                            </td>
                                          <td class="text-center">
                                            <a href="{{route('categorias.show', ['id' => $child2->id])}}" class="btn bg-transparent btn-sm" role="button" title="Ver" aria-pressed="true">
                                              <i class="far fa-eye text-secondary"></i>
                                            </a>
                                            <a href="{{route('categorias.edit', ['id' => $child2->id])}}" class="btn bg-transparent btn-sm" role="button" title="Editar" aria-pressed="true">
                                              <i class="fas fa-pencil-alt text-primary"></i>
                                            </a>
                                          </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>