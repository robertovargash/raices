@extends('layouts.main')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>Detalles del almacén {{ $almacen->almacen }}</h2>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('almacens.index') }}"> Atrás</a>
                    </div>
                </div>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
        <div class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card card-default">
                  <div class="card-header">
                    <h3 class="card-title">Datos almacén</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12">
                        <div class="col-12">
                          <div class="form-group">
                              <strong>Almacén (*):</strong>
                              {{ $almacen->almacen }}
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="form-group">
                              <strong>Descripción:</strong>
                              {{ $almacen->descripcion }}
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
                    <h3 class="card-title">Mercancía en almacén</h3>              
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                  </div>
                  <div class="card-body">              
                    <table id="tablaExistencia" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Código</th>
                          <th>Producto</th>
                          <th>UM</th>
                          <th>Existencia</th>                    
                          <th>Precio Prom.</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($almacen->almacenmercancias as $mercancia)
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
                          <th>Producto</th>
                          <th>UM</th>
                          <th>Existencia</th>                    
                          <th>Precio Prom.</th>
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
                    <h3 class="card-title">Recepciones del almacén</h3>              
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                  </div>
                  <div class="card-body">
                    <table id="tablaRecepciones" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Observaciones</th>
                          <th>Recibido</th>
                          <th>Entregado</th>
                          <th>Fecha</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($almacen->recepciones as $recepcion)
                        <tr>
                          <td>{{ $recepcion->numero }}</td>
                          <td>{{ $recepcion->observaciones }}</td>
                          <td>{{ $recepcion->p_recibe }}</td>
                          <td>{{ $recepcion->p_entrega}} </td>
                          <td>{{ $recepcion->fecha }}</td>
                        </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>#</th>
                          <th>Observaciones</th>
                          <th>Recibido</th>
                          <th>Entregado</th>
                          <th>Fecha</th>
                        </tr>
                      </tfoot>
                  </table>
                  </div>
                </div>
              </div>        
            </div>
            <div class="row">
              <div class="col-12">
                <div class="card card-warning">
                  <div class="card-header">
                    <h3 class="card-title">Vales de salida del almacén</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                  </div>
                  <div class="card-body">
                    <table id="tablaVales" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Observaciones</th>
                          <th>Recibido</th>
                          <th>Entregado</th>
                          <th>Fecha</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($almacen->vales as $vale)
                        <tr>
                          <td>{{ $vale->numero }}</td>
                          <td>{{ $vale->observaciones }}</td>
                          <td>{{ $vale->p_recibe }}</td>
                          <td>{{ $vale->p_entrega}} </td>
                          <td>{{ $vale->fecha }}</td>
                        </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>#</th>
                          <th>Observaciones</th>
                          <th>Recibido</th>
                          <th>Entregado</th>
                          <th>Fecha</th>
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
    $('#tablaRecepciones').DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });

  $(function () {
    $('#tablaVales').DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
  $(function () {
    $('#tablaExistencia').DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
  </script>
@endsection