@extends('layouts.main')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="col-lg-12 margin-tb">
            <div class="pull-left">
              <h2>Datos de la OT</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('ordentrabajos.index') }}"> Atrás</a>
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
              <h3 class="card-title">Generales de la OT</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <form role="form" id="otData" action="{{ route('ordentrabajos.update',$ordentrabajo->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="col-12">
                    <div class="form-group">
                        <strong>Producto:</strong> {{ $ordentrabajo->tproducto->nombre }}
                        <input type="hidden" name="tproducto_id" readonly value="{{ $ordentrabajo->tproducto->id }}" class="form-control">
                    </div>
                </div>
                <input type="hidden" name="estado"  value="{{ $ordentrabajo->estado }}" class="form-control">
                <div class="col-12">
                  <div class="form-group">
                      <strong>Fecha:</strong>
                      <input type="date" readonly name="fecha" value="{{ $ordentrabajo->fecha }}" id="idfecha" class="form-control" placeholder="Fecha">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                      <strong>Cantidad:</strong>
                      <input readonly type="number" value="{{ $ordentrabajo->cantidad }}" name="cantidad" class="form-control" placeholder="Cantidad">
                  </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Técnico:</strong>
                        <input type="text" value="{{ $ordentrabajo->tecnico }}" name="tecnico" class="form-control" placeholder="Técnico">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Operario:</strong>
                        <input type="text" value="{{ $ordentrabajo->operario }}" name="operario" class="form-control" placeholder="Operario">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Observaciones:</strong>
                        <textarea class="form-control" style="height:150px" name="observaciones" placeholder="Observaciones">{{ $ordentrabajo->observaciones }}</textarea>
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
      <div class="row">
        <div class="col-12">
          <div class="card card-info" id="cardProductos">
            <div class="card-header">
              <h3 class="card-title">Productos por solicitudes de esta OT</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="pull-left mb-2">
                {{-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalAddMateriaPrima">Adicionar</button> --}}
              </div>
              <table id="tablaPorSolicitudes" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th># Solicitud</th>
                    <th>Cant. productos</th>
                    <th>Terminados</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($ordentrabajo->otsolicitudes as $otsolicitud)
                    <tr>
                      @foreach ($otsolicitud->solicitude->solicitudproductos as $solicitudproducto)
                        @if ( $solicitudproducto->tproducto->id == $ordentrabajo->tproducto_id)
                        <td>{{ $otsolicitud->solicitude->id }} {{ $otsolicitud->solicitude->cliente }} {{ $otsolicitud->solicitude->fechasolicitud }}</td>
                        <td><b>{{ $solicitudproducto->cantidad }} {{  $solicitudproducto->tproducto->nombre }}</b></td>
                        <td>
                            @if ($otsolicitud->terminado == 1)
                                <b class="text-success">Si</b>
                            @else
                                <b class="text-danger">No</b>
                            @endif
                        </td>
                        <td>
                            @if ($otsolicitud->terminado == 0)
                                <a class="btn btn-link terminarSolicitudProducto text-danger" data-id="{{$otsolicitud->id}}"><b>Terminar</b></a>
                            @endif
                        </td>
                        @endif
                      @endforeach
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th># Solicitud</th>
                    <th>Cant. productos</th>
                    <th>Terminados</th>
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
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Materias primas del producto</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="pull-left mb-2">
              </div>
              <table id="tablaMateriasPrimas" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Mat. prima</th>
                    <th>Cant. necesaria</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($ordentrabajo->tproducto->materiaprimas as $mprima)
                  <tr>
                    <td>{{ $mprima->mercancia->nombremercancia }}</td>
                    <td><b>{{ $mprima->cantidadnecesaria * $ordentrabajo->cantidad }} {{ $mprima->mercancia->um }} </b> </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>Mat. prima</th>
                    <th>Cant. necesaria</th>
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
<div class="modal fade" aria-modal="false" id="terminarSolicitudProductoModal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirmación</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>¿Desea marcar como terminada esta producción?</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <form action="{{route('otsolicitudes.terminar')}}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden", name="id" id="terminarotsolicitudes_id">
            <button type="submit" class="btn btn-success">Si, terminar</button>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
@endsection
@section('scripts')
<script type="text/javascript">
$(document).on('click','.terminarSolicitudProducto',function(){
  var productoID=$(this).attr('data-id');
  $('#terminarotsolicitudes_id').val(productoID);
  $('#terminarSolicitudProductoModal').modal('show');
});
  $(document).ready(function () {
    $('#otData').validate({
      rules: {
        fecha: {
          required: true
        },
        cantidad:{
            required: true
        },
        observaciones:{
            required: true
        }
      },
      messages: {
        fecha: {
          required: "Selecciona una fecha"
        },
        cantidad:{
            required: "Debe tener un valor, al menos 0"
        },
        observaciones:{
            required: "Debe insertar una observacion"
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
    $('#tablaPorSolicitudes').DataTable({
      "filter":false,
      "responsive": true,
      "autoWidth": false,
    });
    $('#tablaMateriasPrimas').DataTable({
      "filter":false,
      "responsive": true,
      "autoWidth": false,
    });
  });

</script>
@endsection
