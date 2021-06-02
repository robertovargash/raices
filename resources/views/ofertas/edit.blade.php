@extends('layouts.main')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="col-lg-12 margin-tb">
            <div class="pull-left">
              <h2>Datos oferta</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('ofertas.index') }}"> Atrás</a>
            </div>
          </div>
        </div>
        @if ($errors->any())
        <div class="alert alert-danger">
          <strong>Vaya!</strong> Ocurrió un error.<br><br>
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
      </div>
    </div><!-- /.container-fluid -->
  </div>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Datos oferta</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                  <form role="form" id="ofertaData" action="{{ route('ofertas.update',$oferta->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-12">
                      <div class="form-group">
                          <strong>Estado:</strong>
                          <select name="estado" class="form-control col-12">
                              <option value="1" {{ $oferta->estado == 1 ? 'selected' : '' }}>Abierta</option>
                              <option value="0" {{ $oferta->estado == 0 ? 'selected' : '' }}>Cerrada</option>
                          </select>
                      </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-success btn-block">Actualizar</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
            <div class="card card-primary" id="cardProductos">
                <div class="card-header">
                <h3 class="card-title">Productos en oferta</h3>
                </div>
                <div class="card-body">
                    <div class="pull-left mb-2">
                        {{-- <a class="btn btn-success" href="{{ route('recepciones.create') }}"> Adicionar</a> --}}
                        @can('gestion_oferta')
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAddProducto">Adicionar</button>
                        @endcan
                    </div>
                    <table id="tablaProductos" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($oferta->ofertaproductos as $ofertaproducto)
                        <tr>
                            <td>{{ $ofertaproducto->tproducto->nombre }}</td>
                            <td>{{ $ofertaproducto->tproducto->valorbruto }}</td>
                            <td>{{ $ofertaproducto->cantidad }}</td>
                            <td>
                                @can('gestion_oferta')
                                    <a class="btn btn-link editProducto text-primary"
                                    oproducto-id="{{$ofertaproducto->id}}"
                                    oproducto-valor = "{{$ofertaproducto->tproducto->valorbruto}}"
                                    oproducto-pid="{{$ofertaproducto->tproducto_id}}"
                                    oproducto-cantidad="{{$ofertaproducto->cantidad}}"
                                    oproducto-nombre="{{$ofertaproducto->tproducto->nombre}}"
                                    @foreach ($tproductos as $prod)
                                        @if ($prod->id == $ofertaproducto->tproducto->id)
                                            producto-cantidadmax ="{{ $prod->cantidadd }}"
                                            @break
                                        @endif
                                    @endforeach
                                    >Editar</a>
                                    <a class="btn btn-link deleteProducto text-danger" data-id="{{$ofertaproducto->id}}">Eliminar</a>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
            <div class="card card-success">
                <div class="card-header">
                <h3 class="card-title">Mercancías en oferta</h3>
                </div>
                <div class="card-body">
                    <table id="tablaMercancias" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Mercancía</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($oferta->ofertamercancias as $ofertamercancia)
                        <tr>
                            <td>{{ $ofertamercancia->mercancia->nombremercancia }}</td>
                            <td>{{ $ofertamercancia->cantidad }}</td>
                            <td>$ {{ $ofertamercancia->mercancia->precio }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Mercancía</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
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
        <form action="{{route('ofertaproductos.destroy')}}" method="POST">
          @csrf
          @method('DELETE')
          <input type="hidden", name="id" id="ofertaproducto_id">
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
        <h4 class="modal-title">Producto a ofertar</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <form action="{{ route('ofertaproductos.store') }}" id="ofertaDialogData" method="POST">
              @csrf
               <div class="row">
                <div class="col-12">
                  <div class="form-group">
                      <input type="hidden" name="oferta_id" value="{{ $oferta->id }}" class="form-control">
                  </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label>Producto:</label>
                        <select id="selectProductos" class="form-control select2bs4" name="tproducto_id" onchange="refrescar_precio_cantidad()" style="width: 100%;">
                            <option value="" selected="selected" hidden="hidden">Selecciona producto</option>
                            @foreach ($tproductos as $tproducto)
                                @if ( $tproducto->existe == 0)
                                    <option valor="{{ $tproducto->valorbruto }}" cantidadd="{{ $tproducto->cantidadd }}" value="{{$tproducto->id}}" {{ $tproducto->disponible == 0 || $tproducto->disponiblemprima == 0 ? ' disabled ' : 'enabled' }}>{{$tproducto->nombre}} | {{$tproducto->tipotproducto->tipo}} {{ $tproducto->disponible == 0 ? "No disponible" : "" }} {{ $tproducto->disponiblemprima == 0 ? " | Sin material" : ""}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Cantidad a ofertar *:</strong>
                        <input type="number" name="cantidad" id="cantidad" class="form-control" placeholder="Cantidad">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Cantidad máxima a ofertar:</strong>
                        <input type="number" readonly id="cantidadmaxima"  class="form-control" placeholder="Max.">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Valor del producto:</strong>
                        <input type="number" readonly id="valorbruto" class="form-control" placeholder="Valor">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" id="btnInsert" class="btn btn-success btn-block">Insertar</button>
                </div>
              </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalEditproducto">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Editando Producto</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <form id="editOfertaProducto" action="{{ route('ofertaproductos.editar') }}" method="POST">
                @csrf
                @method('PUT')
                 <div class="row">
                    <input type="hidden" name="oferta_id" value="{{ $oferta->id }}" class="form-control">
                    <input type="hidden" name="id" id="edit_oproducto_id">
                    <input type="hidden" name="tproducto_id" class="form-control" id="edit_tproducto_id">
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Producto:</strong>
                            <input type="text" disabled id="edit_producto" class="form-control" placeholder="Cantidad">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Cantidad *:</strong>
                            <input type="number" name="cantidad" id="edit_cantidad" class="form-control" placeholder="Cantidad">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Cantidad máxima a ofertar:</strong>
                            <input type="number" readonly id="maximunnn" class="form-control" placeholder="Max.">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Valor del producto:</strong>
                            <input type="number" readonly id="brutoo" class="form-control" placeholder="Valor">
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-success btn-block">Actualizar</button>
                    </div>
                </div>
            </form>
          </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@endsection
@section('scripts')
<script type="text/javascript">
function refrescar_precio_cantidad() {
    let valorbruto = $('#selectProductos option:selected').attr('valor');
    let cantidad = $('#selectProductos option:selected').attr('cantidadd');
    $('#valorbruto').val(valorbruto);
    $('#cantidadmaxima').val(cantidad);
}

$(document).on('click','.deleteProducto',function(){
    var analisisID=$(this).attr('data-id');
    $('#ofertaproducto_id').val(analisisID);
    $('#deleteProductoModal').modal('show');
});

$(document).on('click','.editProducto',function(){
    var productoID=$(this).attr('oproducto-id');
    var producto_id=$(this).attr('oproducto-pid');
    var productocantidad=$(this).attr('oproducto-cantidad');
    var productonombre=$(this).attr('oproducto-nombre');
    var productomax=$(this).attr('producto-cantidadmax');
    var productoprecio=$(this).attr('oproducto-valor');
    $('#edit_oproducto_id').val(productoID);
    $('#edit_tproducto_id').val(producto_id);
    $('#edit_producto').val(productonombre);
    $('#edit_cantidad').val(productocantidad);
    $('#maximunnn').val(productomax);
    $('#brutoo').val(productoprecio);
    $('#modalEditproducto').modal('show');
});

  $(document).ready(function () {
    $('#btnInsert').click(function () {
            $('#btnInsert').attr('disabled', true);
            $('#btnInsert').html('Insertando...');
            $('#ofertaDialogData').submit();
            return true;
        });
    $('#ofertaDialogData').validate({
      rules: {
        tproducto_id: {
          required : true,
        },
        cantidad: {
          required: true,
          max: function() {
                return parseFloat($("#selectProductos option:selected").attr("cantidadd"));
            },
          min: function() {
                return 0;
            },
        },
      },
      messages: {
        tproducto_id: {
            required: "Debe seleccionar un producto",
        },
        cantidad: {
          required: "Inserte la cantidad",
          max: "debe ser menor o igual a la disponibilidad (disponibilidad: {0})",
          min: "la cantidad ser mayor o igual que 0",
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
    $('#editOfertaProducto').validate({
      rules: {
        cantidad: {
          required: true,
          max: function() {
                return parseFloat($("#maximunnn").val());
            },
          min: function() {
                return 0;
            },
        },
      },
      messages: {
        cantidad: {
          required: "Inserte la cantidad",
          max: "debe ser menor o igual a la disponibilidad (disponibilidad: {0})",
          min: "la cantidad ser mayor o igual que 0",
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

  $(function () {
    $('#tablaRecepciones').DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });

  $(function () {
    $('#tablaMercancias').DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
  $(function () {
    $('#tablaProductos').DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
  </script>
@endsection
