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
                    <strong>QR de Cobro: </strong>
                    {!! QrCode::size(200)
                    ->generate($qrcobro); !!}
                </div>
                <div class="col-12">
                    <strong>QR comprobante: </strong>
                    {!! QrCode::size(200)
                    ->generate($qr); !!}
                </div>


                <div class="col-12">
                    <div class="col-12">
                        <div class="form-group">
                            <strong for="my-select2-2">Estado: </strong>
                            @switch($solicitude->estado)
                            @case(0)
                                En proceso
                                @break
                            @case(1)
                                Confirmada
                                  @break
                            @case(2)
                              Terminada
                                @break
                            @case(3)
                              Entregada
                                 @break
                            @default
                                Cancelada
                          @endswitch
                        </div>
                    </div>
                    <div class="col-12">
                      <div class="form-group">
                          <strong>Cliente: </strong>{{ $solicitude->cliente }}
                      </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Teléfono:</strong> {{ $solicitude->telefono }}
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>A cobrar:</strong> ${{ $acobrar }}
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Fecha solicitante:</strong> {{ date('d/m/Y', strtotime($solicitude->fechasolicitud)) }}
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Fecha entrega:</strong> {{ date('d/m/Y', strtotime($solicitude->fechaentrega)) }}
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Descripción:</strong> {{ $solicitude->descripcion }}
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Productos de la solicitud</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="pull-left mb-2">
                {{-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalAddproducto">Adicionar</button> --}}
              </div>
              <table id="tablaSolicitudProductoss" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Importe</th>
                    <th>Observaciones</th>
                    <th>Terminados</th>
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
                        @if ($sproducto->terminado == 1)
                            <b class="text-success">Si</b>
                        @else
                            <b class="text-danger">No</b>
                        @endif
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
                    <th>Terminados</th>
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
@endsection
@section('scripts')
<script type="text/javascript">

  $(function () {
    $('#tablaSolicitudProductoss').DataTable({
        "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

</script>
@endsection
