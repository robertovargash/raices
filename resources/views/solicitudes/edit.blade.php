@extends('layouts.main')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="col-lg-12 margin-tb">
            <div class="pull-left">
              <h2>Datos de la solicitud</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('solicitudes.index') }}"> Atrás</a>
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
              <h3 class="card-title">Generales de la solicitud {{ $solicitude->numero }}</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                    <form id="formUpdate" action="{{ route('solicitudes.update',$solicitude->id) }}" role="form" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" value="{{ $solicitude->estado }}" name="estado" class="form-control">
                        {{-- <div class="col-12">
                            <div class="form-group">
                                <input type="checkbox" class="switch-input" value="1" name="pagada" id="pagada" {{ $solicitude->pagada == true ? 'checked' : '' }}><label for="pagada"> Pagada</label>
                            </div>
                        </div> --}}
                        <div class="col-12">
                            <div class="form-group">
                                <strong>Pagada?</strong>
                                <select id="selectpagada" class="form-control" name="pagada">
                                  <option value="0" {{ $solicitude->pagada == 0 ? 'selected' : ''}}>Sin pagar</option>
                                  <option value="1" {{ $solicitude->pagada == 1 ? 'selected' : ''}}>Pagada</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                          <div class="form-group">
                              <strong>Cliente: </strong>*
                              <input type="text" value="{{ $solicitude->cliente }}" name="cliente" class="form-control" placeholder="Cliente">
                          </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <strong>Teléfono:</strong>
                                <input type="text" value="{{ $solicitude->telefono }}" name="telefono" class="form-control" placeholder="Teléfono">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <strong>Fecha solicitud:</strong>
                                <input type="date" value="{{ Carbon\Carbon::parse($solicitude->fechasolicitud)->format('Y-m-d') }}" name="fechasolicitud" class="form-control" placeholder="Fecha">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <strong>Fecha entrega:</strong>
                                <input type="date" value="{{ $solicitude->fechaentrega }}" name="fechaentrega" class="form-control" placeholder="Fecha entrega">

                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <strong>Descripción:</strong>
                                <textarea class="form-control" style="height:150px" name="descripcion" placeholder="Descripción">{{ $solicitude->descripcion }}</textarea>
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
          <div class="card card-info" id="cardProductos">
            <div class="card-header">
              <h3 class="card-title">Productos de la solicitud</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="pull-left mb-2">
                <button type="button" class="btn btn-info addProducto">Adicionar</button>
              </div>
              <table id="tablaSolicitudProductoss" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Importe</th>
                    <th>Observaciones</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($solicitude->solicitudproductos as $sproducto)
                  <tr>
                    <td>{{ $sproducto->tproducto->nombre }}</td>
                    <td>{{ $sproducto->cantidad }}</td>
                    <td>{{$sproducto->precio}}</td>
                    <td>{{$sproducto->precio * $sproducto->cantidad}}</td>
                    <td>{{ $sproducto->observaciones }}</td>
                    <td>
                        @can('gestion_solicitud')
                            <a class="btn btn-link editSolProducto text-primary"
                            data-id="{{$sproducto->id}}"
                            data-producto_id="{{$sproducto->tproducto->id}}"
                            data-producto="{{$sproducto->tproducto->nombre}}"
                            data-cantidad="{{$sproducto->cantidad}}"
                            data-observaciones="{{$sproducto->observaciones}}"
                            @foreach ($tproductos as $prod)
                                        @if ($prod->id == $sproducto->tproducto->id)
                                            producto-cantidadmax ="{{ $prod->cantidadd }}"
                                            @break
                                        @endif
                            @endforeach>
                            <b>Editar</b></a>
                            <a class="btn btn-link deleteSolProducto text-danger" data-id="{{$sproducto->id}}"><b>Eliminar</b></a>
                        @endcan
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Importe</th>
                    <th>Observaciones</th>
                    <th></th>
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

<div class="modal fade" aria-modal="false" id="deleteSolProductoModal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirmación</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>¿Desea eliminar el elemento?</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <form action="{{route('solicitudproductos.destroy')}}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden", name="id" id="rproducto_id">
            <button type="submit" class="btn btn-danger">Eliminar</button>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalAddproducto">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Producto</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="addSolicitudProducto" action="{{ route('solicitudproductos.store') }}" method="POST">
            @csrf
             <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <input type="hidden" name="solicitude_id" value="{{ $solicitude->id }}" class="form-control">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                    <strong for="selectProductos">Producto:</strong>
                    <select id="selectProductos" class="form-control select2bs4" name="tproducto_id" onchange="refrescar_precio_cantidad()" style="width: 100%;">
                        <option value="" selected="selected" hidden="hidden">Selecciona producto</option>
                        @foreach ($tproductos as $tproducto)
                            @if ($tproducto->existe == 0)
                                <option valor="{{ $tproducto->valorbruto }}" cantidadd="{{ $tproducto->cantidadd }}" value="{{$tproducto->id}}">{{$tproducto->nombre}} | {{$tproducto->tipotproducto->tipo}}</option>
                            @endif
                        @endforeach
                    </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Cantidad *:</strong>
                        <input type="number" name="cantidad" id="cantidad" class="form-control" placeholder="Cantidad">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Cantidad máxima:</strong>
                        <input type="number" readonly id="cantidadmax" class="form-control" placeholder="Cantidad">
                    </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                      <strong>Precio *:</strong>
                      <input readonly type="number" name="precio" id="precio" class="form-control" placeholder="Precio">
                  </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Observaciones:</strong>
                        <textarea class="form-control" style="height:150px" name="observaciones" placeholder="Obsrevaciones">Sin detalles</textarea>
                    </div>
                </div>
                <div class="col-12 text-center">
                    <button type="submit" id="btnInsert" class="btn btn-success btn-block">Adicionar</button>
                </div>
            </div>
        </form>
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
            <form id="editSolicitudProducto" action="{{ route('solicitudproductos.editar') }}" method="POST">
                @csrf
                @method('PUT')
                 <div class="row">
                    <input type="hidden" name="solicitude_id" value="{{ $solicitude->id }}" class="form-control">
                    <input type="hidden" name="id" id="edit_rproducto_id">
                    <input type="hidden" name="tproducto_id" class="form-control" id="edit_tproducto_id">
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Producto:</strong>
                            <input type="text" disabled  id="edit_producto" class="form-control" placeholder="Cantidad">
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
                            <strong>Cantidad máxima:</strong>
                            <input type="number" readonly id="editcantidadmax" class="form-control" placeholder="Cantidad">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Observaciones:</strong>
                            <textarea class="form-control" style="height:150px" name="observaciones" id="edit_observaciones" placeholder="Observaciones"></textarea>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" id="btnEdit" class="btn btn-success btn-block">Editar</button>
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
$(document).on('click','.deleteSolProducto',function(){
    var analisisID=$(this).attr('data-id');
    $('#rproducto_id').val(analisisID);
    $('#deleteSolProductoModal').modal('show');
});

$(document).on('click','.addProducto',function(){
    $('#btnInsert').attr('disabled', false);
    $('#btnInsert').html('Insertar');
    $('#modalAddproducto').modal('show');
});

$(document).on('click','.editSolProducto',function(){
    var analisisID = $(this).attr('data-id');
    var tproducto_id = $(this).attr('data-producto_id');
    var producto = $(this).attr('data-producto');
    var cantidad = $(this).attr('data-cantidad');
    var observaciones=$(this).attr('data-observaciones');
    var cantmax = $(this).attr('producto-cantidadmax');
    $('#edit_rproducto_id').val(analisisID);
    $('#edit_tproducto_id').val(tproducto_id);
    $('#edit_producto').val(producto);
    $('#edit_cantidad').val(cantidad);
    $('#editcantidadmax').val(cantmax);
    $('#edit_observaciones').val(observaciones);
    $('#modalEditproducto').modal('show');
});

function refrescar_precio_cantidad() {
    let valorbruto = $('#selectProductos option:selected').attr('valor');
    let cantidad = $('#selectProductos option:selected').attr('cantidadd');
    $('#precio').val(valorbruto);
    $('#cantidad').val(cantidad);
    $('#cantidadmax').val(cantidad);
}
  $(document).ready(function () {
    $('#btnInsert').click(function () {
            $('#btnInsert').attr('disabled', true);
            $('#btnInsert').html('Insertando...');
            $('#addSolicitudProducto').submit();
            return true;
    });
    $('#btnEdit').click(function () {
            $('#btnEdit').attr('disabled', true);
            $('#btnEdit').html('Actualizando...');
            $('#editSolicitudProducto').submit();
            return true;
    });
    $('#addSolicitudProducto').validate({
      rules: {
        tproducto_id: {
          required : true,
        },
        cantidad: {
          required: true,
          max: function() {
                return parseFloat($("#cantidadmax").val());
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
          max: "debe ser menor o igual a la cantidad ofertada (en oferta: {0})",
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
    $('#editSolicitudProducto').validate({
      rules: {
        cantidad: {
          required: true,
          max: function() {
                return parseFloat($("#editcantidadmax").val());
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
          max: "debe ser menor o igual a la cantidad ofertada (en oferta: {0})",
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
    $('#formUpdate').validate({
      rules: {
        cliente: {
          required: true
        },
        fechasolicitud:{
            required: true
        },
        descripcion:{
            required: true
        }
      },
      messages: {
        cliente: {
          required: "Inserte un cliente"
        },
        fechasolicitud:{
            required: "Seleccione una fecha"
        },
        descripcion:{
            required: "Debe insertar una descripción"
        }
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
    $('#tablaSolicitudProductoss').DataTable({
        "responsive": true,
      "autoWidth": false,
    });
  });

</script>
@endsection
