@extends('layouts.main')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="col-lg-12 margin-tb">
            <div class="pull-left">
              <h2>Datos del vale</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('almacens.edit',$vale->almacen) }}"> Atrás</a>
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
              <h3 class="card-title">Datos del vale de salida</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <strong>Número: </strong>
                                {{ $vale->numero }}
                            </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                              <div class="form-group">
                                  <strong>Fecha: </strong>
                                  {{ date('d/m/Y', strtotime($vale->fecha)) }}
                              </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                              <div class="form-group">
                                  <strong>Entrega: </strong>
                                  {{ $vale->p_entrega }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                              <div class="form-group">
                                  <strong>Solicita: </strong>
                                  {{ $vale->p_solicita }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                              <div class="form-group">
                                  <strong>Autoriza: </strong>
                                  {{ $vale->p_autoriza }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    @if ($vale->tipovale == 1)
                                        <strong>Vale de la OT:</strong> {{ $vale->ordentrabajo->id }}</strong>
                                    @else
                                    <strong>Vale de gastos</strong>
                                    @endif
                                  </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <strong>Observaciones:</strong>
                                    {{ $vale->observaciones }}
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
          <div class="card card-warning">
            <div class="card-header">
              <h3 class="card-title">Mercancías del vale</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <table id="tablaValeitems" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Código</th>
                    <th>Mercancía</th>
                    <th>UM</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($vale->valeitems as $vitem)
                  <tr>
                    <td>{{ $vitem->mercancia->codigo }}</td>
                    <td>{{ $vitem->mercancia->nombremercancia }}</td>
                    <td>{{ $vitem->mercancia->um }}</td>
                    <td>{{ $vitem->cantidad }}</td>
                    <td>{{ $vitem->precio}} </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>Código</th>
                    <th>Mercancía</th>
                    <th>UM</th>
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
@endsection
@section('scripts')
<script type="text/javascript">

  $(function () {
    $('#tablaValeitems').DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });

  </script>
@endsection
