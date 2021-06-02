@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              {{-- <h1 class="m-0">Lista de productos</h1> --}}
              <div class="pull-right">
                  @can('gestion_solicitud')
                  <button type="button" class="btn btn-success mb-2 addSolicitudes">Nueva</button>
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
                  <h3 class="card-title">Solicitudes</h3>
                </div>
                <div class="card-body">
                  <table id="tablaFacturas" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Estado</th>
                          <th>A Entregar</th>
                          <th>Cliente</th>
                          <th>Solicitado</th>
                          <th>Detalles</th>
                          <th></th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($solicitudes as $solicitude)
                        <tr>
                            <td>{{ $solicitude->numero }}</td>
                            @switch($solicitude->estado)
                              @case(0)
                                  <td><b>1-En proceso</b></td>
                                  @break
                              @case(1)
                                <td><b class="text-primary">2-Confirmada</b></td>
                                  @break
                              @case(2)
                                <td><b class="text-warning">3-Terminada</b></td>
                                   @break
                              @case(3)
                                <td><b class="text-success">4-Entregada</b></td>
                                   @break
                              @default
                                <td><b class="text-danger">5-Cancelada</b></td>
                            @endswitch
                            <td>{{ date('d/m/Y', strtotime($solicitude->fechaentrega)) }}</td>
                            <td>{{ $solicitude->cliente }}</td>
                            <td>{{ date('d/m/Y', strtotime($solicitude->fechasolicitud))}} </td>
                            <td>{{ $solicitude->descripcion}} </td>
                             <td>
                               <div>
                                    <a href="{{ route('solicitudes.show',$solicitude) }}" class="btn btn-link text-info">Detalles</a>
                                    <a href="{{ route('solicitudes.pdf',$solicitude) }}" class="btn btn-link text-info">PDF</a>
                                   @can('gestion_solicitud')
                                    <a href="{{ route('solicitudes.edit',$solicitude) }}" {{ $solicitude->estado == 0 ? '' : 'hidden' }} class="btn btn-link text-primary">Editar</a>
                                    <a class="btn btn-link text-success confirmarSolicitudes" {{ $solicitude->estado == 0 ? '' : 'hidden' }}  data-id="{{$solicitude->id}}"><b>Confirmar</b></a>
                                    <a class="btn btn-link text-success entregarSolicitudes" {{ $solicitude->estado == 2 ? '' : 'hidden' }}  data-id="{{$solicitude->id}}"><b><i>Entregar</i></b></a>
                                    <a class="btn btn-link text-danger cancelarSolicitudes" {{ $solicitude->estado == 0 ? '' : 'hidden' }}  data-id="{{$solicitude->id}}">Cancelar</a>
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
                            <th>A Entregar</th>
                            <th>Cliente</th>
                            <th>Solicitado</th>
                            <th>Detalles</th>
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

<div class="modal fade" aria-modal="false" id="cancelarSolicitudesModal">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirmación</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>¿Desea cancelar la solicitud?</p>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <form action="{{route('solicitudes.cancelar')}}" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden", name="id" id="cancelarsolicitud_id">
          <button type="submit" class="btn btn-danger">Si, cancelar</button>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<div class="modal fade" aria-modal="false" id="confirmarSolicitudesModal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirmando</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>¿Desea marcar la solicitud como confirmada? No se prodrá editar.</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <form action="{{route('solicitudes.confirmar')}}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden", name="id" id="confirmarsolicitud_id">
            <button type="submit" class="btn btn-success">Si, confirmar</button>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

  <div class="modal fade" aria-modal="false" id="entregarSolicitudesModal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirmación</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>¿Desea marcar la solicitud como entregada?</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <form action="{{route('solicitudes.entregar')}}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden", name="id" id="entregarsolicitud_id">
            <button type="submit" class="btn btn-success">Si, entregada</button>
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
        <h4 class="modal-title">Adicionar solicitud</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addFactura" action="{{ route('solicitudes.store') }}" method="POST">
          @csrf
           <div class="row">
            {{-- <div class="col-12">
                <div class="form-group">
                    <input type="checkbox" class="switch-input" value="1" name="pagada" id="pagada"><label for="pagada"> Pagada</label>
                </div>
            </div> --}}
            <div class="col-12">
                <div class="form-group">
                    <strong>Pagada?</strong>
                    <select id="selectpagada" class="form-control" name="pagada">
                      <option value="0" selected>Sin pagar</option>
                      <option value="1">Pagada</option>
                    </select>
                </div>
            </div>
            <div class="col-12" >
                <div class="form-group">
                    <strong>Cliente (*):</strong>
                    <input type="text" name="cliente" id="cliente" class="form-control" placeholder="Cliente">
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                    <strong>Teléfono:</strong>
                    <input type="text" name="telefono" class="form-control" placeholder="Teléfono">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <strong>Fecha entrega (*):</strong>
                    <input type="date" value="{{ $tomorrow }}" name="fechaentrega" class="form-control" placeholder="Fecha entrega">
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
    $('#tablaFacturas').DataTable({
      "order": [[ 1, "asc" ],[0, "desc"]],
      "responsive": true,
      "autoWidth": false,
    });
  });

$(document).on('click','.cancelarSolicitudes',function(){
  var productoID=$(this).attr('data-id');
  $('#cancelarsolicitud_id').val(productoID);
  $('#cancelarSolicitudesModal').modal('show');
});
$(document).on('click','.addSolicitudes',function(){
  $('#btnInsertar').attr('disabled', false);
  $('#btnInsertar').html('Insertar');
  $('#modalAddSolicitudes').modal('show');
});
$(document).on('click','.confirmarSolicitudes',function(){
  var productoID=$(this).attr('data-id');
  $('#confirmarsolicitud_id').val(productoID);
  $('#confirmarSolicitudesModal').modal('show');
});
$(document).on('click','.entregarSolicitudes',function(){
  var productoID=$(this).attr('data-id');
  $('#entregarsolicitud_id').val(productoID);
  $('#entregarSolicitudesModal').modal('show');
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
        cliente: {
          required: true
        },
        fechasolicitud:{
            required: true
        },
        fechaentrega:{
            required: true
        },
        descripcion:{
            required: true
        }
      },
      messages: {
        cliente: {
          required: "seleccione el cliente"
        },
        fechasolicitud:{
            required: "Seleccione la fecha"
        },
        fechaentrega:{
            required: "Seleccione la fecha de entrega"
        },
        descripcion:{
            required: "Inserte una descripción"
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
