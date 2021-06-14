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
              <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <strong>Producto:</strong>{{ $ordentrabajo->tproducto->nombre }}
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                      <strong>Estado: </strong>
                          @switch($ordentrabajo->estado)
                              @case(0)
                                En proceso
                                  @break
                              @case(1)
                                Confirmada
                                  @break
                              @case(2)
                                Terminada
                                    @break
                              @default
                                Cancelada
                          @endswitch
                    </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                      <strong>Fecha:</strong> {{ date('d/m/Y', strtotime($ordentrabajo->fecha)) }}
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                      <strong>Cantidad:</strong> {{ $ordentrabajo->cantidad }}
                  </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Técnico:</strong> {{ $ordentrabajo->tecnico }}
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Operario:</strong> {{ $ordentrabajo->operario }}
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Observaciones:</strong>
                        <textarea class="form-control" readonly style="height:150px" name="observaciones" placeholder="Observaciones">{{ $ordentrabajo->observaciones }}</textarea>
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
              <h3 class="card-title">Materias primas en total</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="pull-left mb-2">
                {{-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalAddMateriaPrima">Adicionar</button> --}}
              </div>
              <table id="tablaMateriasPrimas" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Mat. prima</th>
                    <th>Cant. necesaria</th>
                    <th>Precio</th>
                    <th>Importe</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($otsolicitudegroup as $elemento)
                  <tr>
                    <td>{{$elemento->nombremercancia}}</td>
                    <td>{{$elemento->cantidadsumada}}</td>
                    <td>{{$elemento->precio}}</td>
                    <td>{{ round($elemento->importe,2)}}</td>
                  </tr>                     
                  @endforeach
                  {{-- @foreach ($ordentrabajo->otsolicitudes as $otsolicitud)                    
                      @foreach ($otsolicitud->solicitude->solicitudmateriasprimas as $smprima)
                      <tr>
                        @if ( $smprima->solicitudproducto->tproducto->id == $ordentrabajo->tproducto_id)
                        <td>{{ $otsolicitud->solicitude->numero }} {{ $otsolicitud->solicitude->cliente }}</td>
                        <td><b>{{ $smprima->mercancia->nombremercancia }}</b></td>
                        <td>{{ $smprima->cantidad }}</td>                      
                        @endif
                      </tr>
                      @endforeach                    
                  @endforeach--}}
                </tbody>
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
    $('#tablaMateriasPrimas').DataTable({
      "responsive": true,
      "autoWidth": false,
    });
     $('#tablaPorSolicitudes').DataTable({
       "responsive": true,
       "autoWidth": false,
     });
    // $('#tablaPorSolicitudes').DataTable({
    //   "paging": false,
    //   "lengthChange": false,
    //   "searching": false,
    //   "ordering": true,
    //   "info": true,
    //   "autoWidth": true,
    //   "responsive": true,
    // });
  });

</script>
@endsection
