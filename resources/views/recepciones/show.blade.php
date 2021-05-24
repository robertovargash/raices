@extends('layouts.main')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="col-lg-12 margin-tb">
            <div class="pull-left">
              <h2>Datos recepción</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('almacens.edit',$recepcion->almacen) }}"> Atrás</a>
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
              <h3 class="card-title">Datos recepción</h3>
              {{-- <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div> --}}
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <strong>Número: </strong>
                                {{ $recepcion->numero }}
                            </div>
                          </div>
                          <div class="col-xs-12 col-sm-6 col-md-6">
                              <div class="form-group">
                                  <strong>Fecha: </strong>
                                  {{ date('d/m/Y', strtotime($recepcion->fecha)) }}
                              </div>
                          </div>
                          <div class="col-xs-12 col-sm-6 col-md-6">
                              <div class="form-group">
                                  <strong>Recibe: </strong>
                                  {{ $recepcion->p_recibe }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                              <div class="form-group">
                                  <strong>Entrega: </strong>
                                  {{ $recepcion->p_entrega }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                              <div class="form-group">
                                  <strong>Autoriza: </strong>
                                  {{ $recepcion->p_autoriza }}
                                </div>
                            </div>

                          <div class="col-12">
                              <div class="form-group">
                                  <strong>Observaciones:</strong>
                                  {{ $recepcion->observaciones }}
                                </div>
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
          <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Mercancías recepcionadas</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <table id="tablaRecepcionmercancia" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Código</th>
                    <th>Mercancía</th>
                    <th>UM</th>
                    <th>Cantidad</th>
                    <th>Precio compra</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($recepcion->recepcionmercancias as $mercancia)
                  <tr>
                    <td>{{ $mercancia->mercancia->codigo }}</td>
                    <td>{{ $mercancia->mercancia->nombremercancia }}</td>
                    <td>{{ $mercancia->mercancia->um }}</td>
                    <td>{{ $mercancia->cantidad }}</td>
                    <td>{{ $mercancia->precio}} </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>Código</th>
                    <th>Mercancía</th>
                    <th>UM</th>
                    <th>Cantidad</th>
                    <th>Precio compra</th>
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
    $('#tablaRecepcionmercancia').DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });

  </script>
@endsection
