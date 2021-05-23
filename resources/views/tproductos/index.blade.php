@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              {{-- <h1 class="m-0">Lista de productos</h1> --}}
              <div class="pull-right">
                  @can('gestion_productos')
                    <button type="button" class="btn btn-success mb-2 addProducto">Nuevo</button>
                  @endcan
              </div>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <section class="content">
        <div class="content-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Productos</h3>
                </div>
                <div class="card-body">
                  <table id="tablaProductos" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Nombre</th>
                          <th>Descripción</th>
                          <th>Tipo</th>
                          <th>Precio</th>
                          <th>En oferta</th>
                          <th>Disp. material</th>
                          <th></th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($tproductos as $tproducto)
                        <tr>
                            <td>{{ $tproducto->nombre }}</td>
                            <td>{{ $tproducto->descripcion }}</td>
                            <td>{{ $tproducto->tipotproducto->tipo}} </td>
                            <td>{{ $tproducto->valorbruto }}</td>
                            <td>
                              @switch($tproducto->disponible)
                                  @case(0)
                                      <b class="text-danger">No</b>
                                      @break
                                  @default
                                      <b class="text-success">Si</b>
                              @endswitch
                            </td>
                            <td>
                              @switch($tproducto->disponiblemprima)
                                  @case(0)
                                      <b class="text-danger">No</b>
                                      @break
                                  @default
                                      <b class="text-success">Si</b>
                              @endswitch
                            </td>
                            <td>
                               <div>
                                  <a href="{{ route('tproductos.show',$tproducto) }}" class="btn btn-link text-info">Detalles</a>
                                  @can('gestion_productos')
                                    <a href="{{ route('tproductos.edit',$tproducto) }}" class="btn btn-link text-primary">Editar</a>
                                    <a class="btn btn-link deleteProducto text-danger" data-id="{{$tproducto->id}}">Eliminar</a>
                                  @endcan
                               </div>
                            </td>
                        </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Tipo</th>
                            <th>Precio</th>
                            <th>En producción</th>
                            <th>Disp. material</th>
                            <th></th>
                        </tr>
                      </tfoot>
                  </table>
                </div>
              </div>
              </div>
            </div>
          </div>
      </section>
</div>

<div class="modal fade" aria-modal="false" id="deleteProductoModal">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirmación</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>¿Desea eliminar el producto?</p>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <form action="{{route('tproductos.destroy')}}" method="POST">
          @csrf
          @method('DELETE')
          <input type="hidden", name="id" id="producto_id">
          <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalAddProducto">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Adicionar producto</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addproducto" action="{{ route('tproductos.store') }}" method="POST">
          @csrf
           <div class="row">
            <input type="hidden" value="0" name="preciomanoobra">
              <div class="col-12">
                <div class="form-group">
                  <strong>Tipo:</strong>
                  <select id="tipo" class="form-control select2bs4" name="tipotproducto_id">
                      <option value="" selected="selected" hidden="hidden">Selecciona tipo de producto</option>
                      @foreach ($tipotproductos as $tipo)
                          <option value="{{$tipo->id}}">{{$tipo->tipo}}</option>
                      @endforeach
                  </select>
                </div>
              </div>
              <div class="col-12">
                  <div class="form-group">
                      <strong>Nombre:</strong>
                      <input type="text" name="nombre" class="form-control" placeholder="Nombre">
                  </div>
              </div>
              <div class="col-12">
                  <div class="form-group">
                      <strong>Precio:</strong>
                      <input type="number" value="0" name="valorbruto" class="form-control" placeholder="Precio">
                  </div>
              </div>
              <div class="col-12">
                  <div class="form-group">
                      <strong>Descripción:</strong>
                      <textarea class="form-control" style="height:150px" name="descripcion" placeholder="Descripción">Sin detalles</textarea>
                  </div>
              </div>
              <div class="col-12 text-center">
                <button type="submit" id="bntInsertar" class="btn btn-success btn-block">Insertar</button>
              </div>
          </div>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@endsection
@section('scripts')
<script type="text/javascript">
  $(function () {
    $('#tablaProductos').DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });

$(document).on('click','.deleteProducto',function(){
  var productoID=$(this).attr('data-id');
  $('#producto_id').val(productoID);
  $('#deleteProductoModal').modal('show');
});
$(document).on('click','.addProducto',function(){
    $('#bntInsertar').attr('disabled', false);
    $('#bntInsertar').html('Insertar');
  $('#modalAddProducto').modal('show');
});

  $(document).ready(function () {
    $('#bntInsertar').click(function () {
            $('#bntInsertar').attr('disabled', true);
            $('#bntInsertar').html('Insertando...');
            $('#addproducto').submit();
            return true;
    });
    $('#addproducto').validate({
      rules: {
        tipotproducto_id: {
          required: true,
        },
        nombre: {
          required: true,
        },
        valorbruto: {
          required: true,
        },
        descripcion: {
          required: true,
        },
      },
      messages: {
        tipotproducto_id: {
          required: "Elija el tipo de produto",
        },
        nombre: {
          required: "Inserte el nombre",
        },
        valorbruto: {
          required: "Valor al menos 0",
        },
        descripcion: {
          required: "Inserte una descripción",
        },
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });
  });
</script>
@endsection
