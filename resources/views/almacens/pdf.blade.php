
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <table id="tablaAlmacenes" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Almacén</th>
            <th>Detalles</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
          @foreach ($almacenes as $almacen)
          <tr>
              <td>{{ $almacen->almacen }}</td>
              <td>{{ $almacen->descripcion }}</td>
               <td>
                 <div>
                    <a href="{{ route('almacens.show',$almacen) }}" class="btn btn-link text-info">Detalles</a>
                    @can('gestion_almacen')
                      <a a href="{{ route('almacens.edit',$almacen) }}" class="btn btn-link text-primary">Editar</a>
                    @endcan
                    {{-- <button type="button" class="btn btn-link" data-toggle="modal" data-target="#deleteAlmacen{{ $almacen->id }}"><span class="fas fa-trash text-danger"></button>   --}}
                    <a class="btn btn-link deleteAlmacen" data-id="{{$almacen->id}}"><span class="fas fa-trash text-danger"></a>
                 </div>
              </td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th>Almacén</th>
            <th>Detalles</th>
            <th></th>
          </tr>
        </tfoot>
    </table>
  </body>
</html>
