@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              {{-- <h1 class="m-0">Lista de productos</h1> --}}
              <div class="pull-right">
                  @can('gestion_facturas')
                  <button type="button" class="btn btn-success mb-2 addFacturas">Nueva</button>
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
                  <h3 class="card-title">Facturas</h3>
                </div>
                <div class="card-body">
                  <table id="tablaSolicitudes" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Estado</th>
                          <th>Cliente</th>
                          <th>Emisión</th>
                          <th>Elaborado</th>
                          <th>Entrega</th>
                          <th></th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($facturas as $factura)
                        <tr>
                            <td>{{ $factura->numero }}</td>
                            @switch($factura->estado)
                              @case(0)
                                  <td><b>1-En proceso</b></td>
                                  @break
                              @case(1)
                                <td><b class="text-primary">2-Firmada</b></td>
                                  @break
                              @case(2)
                                <td><b class="text-success">3-Pagada</b></td>
                                   @break
                              @default
                                <td><b class="text-danger">4-Cancelada</b></td>
                            @endswitch
                            <td>{{ $factura->cliente->siglas }}  {{ $factura->cliente->nombre }}</td>
                            <td>{{ date('d/m/Y', strtotime($factura->fecha)) }}</td>
                            <td>{{ $factura->elabora}} </td>
                            <td>{{ $factura->entrega}} </td>
                             <td>
                               <div>
                                   @can('gestion_facturas')
                                    <a href="{{ route('facturas.imprimir',$factura) }}" class="btn btn-link text-info ">Imprimir</a>
                                    <a href="{{ route('facturas.edit',$factura) }}" {{ $factura->estado == 0 ? '' : 'hidden' }} class="btn btn-link text-primary">Editar</a>
                                    <a class="btn btn-link text-success firmarFactura" {{ $factura->estado == 0 ? '' : 'hidden' }}  data-id="{{$factura->id}}"><b>Firmar</b></a>
                                    <a class="btn btn-link text-success pagarFactura" {{ $factura->estado == 1 ? '' : 'hidden' }}  data-id="{{$factura->id}}"><b><i>Pagar</i></b></a>
                                    <a class="btn btn-link text-danger cancelarFactura" {{ $factura->estado == 0 ? '' : 'hidden' }}  data-id="{{$factura->id}}">Cancelar</a>
                                   @endcan
                               </div>
                            </td>
                        </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                                <th>#</th>
                                <th>Estado</th>
                                <th>Cliente</th>
                                <th>Emisión</th>
                                <th>Elaborado</th>
                                <th>Entrega</th>
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

<div class="modal fade" aria-modal="false" id="cancelarFacturaModal">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirmación</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>¿Desea cancelar la factura?</p>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <form action="{{route('facturas.cancelar')}}" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden", name="id" id="cancelarfactura_id">
          <button type="submit" class="btn btn-danger">Si, cancelar</button>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<div class="modal fade" aria-modal="false" id="firmarFacturaModal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirmando</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>¿Desea marcar la factura como firmada? No se podrá editar.</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <form action="{{route('facturas.firmar')}}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden", name="id" id="firmarfactura_id">
            <button type="submit" class="btn btn-success">Si, firmar</button>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

  <div class="modal fade" aria-modal="false" id="pagarFacturaModal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirmación</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>¿Desea marcar la factura como pagada?</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <form action="{{route('facturas.pagar')}}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden", name="id" id="pagarfactura_id">
            <button type="submit" class="btn btn-success">Si, pagada</button>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

<div class="modal fade" id="modalAddSolicitudes">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Adicionar factura</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addFactura" action="{{ route('facturas.store') }}" method="POST">
          @csrf
           <div class="row">
            <input type="hidden" name="proveedor_id" id="proveedor" class="form-control" value="{{ $proveedor->id }}">
            <input type="hidden" name="estado" class="form-control" value="0">
            <div class="col-12">
                <div class="form-group">
                  <strong>Cliente:</strong>*
                  <select id="cliente_id" class="form-control select2bs4" name="cliente_id" style="width: 100%;">
                      <option value="" selected="selected" disabled hidden="hidden">Selecciona el cliente</option>
                      @foreach ($clientes as $cliente)
                          <option value="{{$cliente->id}}">{{$cliente->siglas}} {{ $cliente->nombre }}</option>
                      @endforeach
                  </select>
                </div>
            </div>
            <div class="col-12 form-group">
              <strong>Recibe:</strong>
              <input type="text" name="recibe" class="form-control" placeholder="Recibe">
            </div>
            <div class="col-12">
                <div class="form-group">
                    <strong>Elabora (*):</strong>
                    <input type="text" readonly value="{{ Auth::user()->name }}" name="elabora" class="form-control" placeholder="Elabora">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <strong>Transportista:</strong>
                    <input type="text" name="transporta" class="form-control" placeholder="Transportista">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <strong>CI del transportista:</strong>
                    <input type="text" name="tci" class="form-control" placeholder="CI">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <strong>Chapa del transportista:</strong>
                    <input type="text" name="tchapa" class="form-control" placeholder="Chapa">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <strong>Descripción:</strong>
                    <textarea class="form-control" style="height:150px" name="descripcion" placeholder="Descripción">Sin detalles</textarea>
                </div>
            </div>
              <div class="col-12 text-center">
                <button type="submit" id="btnInsertar" class="btn btn-success btn-block">Insertar</button>
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
    $('#tablaSolicitudes').DataTable({
      "order": [[ 1, "asc" ],[0, "desc"]],
      "responsive": true,
      "autoWidth": false,
    });
  });

$(document).on('click','.cancelarFactura',function(){
  var productoID=$(this).attr('data-id');
  $('#cancelarfactura_id').val(productoID);
  $('#cancelarFacturaModal').modal('show');
});
$(document).on('click','.addFacturas',function(){
  $('#btnInsertar').attr('disabled', false);
  $('#btnInsertar').html('Insertar');
  $('#modalAddSolicitudes').modal('show');
});
$(document).on('click','.firmarFactura',function(){
  var productoID=$(this).attr('data-id');
  $('#firmarfactura_id').val(productoID);
  $('#firmarFacturaModal').modal('show');
});
$(document).on('click','.pagarFactura',function(){
  var productoID=$(this).attr('data-id');
  $('#pagarfactura_id').val(productoID);
  $('#pagarFacturaModal').modal('show');
});

  $(document).ready(function () {
    $('#btnInsertar').click(function () {
            $('#btnInsertar').attr('disabled', true);
            $('#btnInsertar').html('Insertando...');
            $('#addFactura').submit();
            return true;
        });
    $('#addFactura').validate({
        rules: {
        cliente_id: {
          required: true
        }
      },
      messages: {
        cliente_id: {
          required: "Inserte el nombre o datos del cliente"
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
</script>
@endsection
