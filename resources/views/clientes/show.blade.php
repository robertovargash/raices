@extends('layouts.main')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="col-lg-12 margin-tb">
            <div class="pull-left">
              <h2>Datos del proveedor</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('clientes.index') }}"> Atrás</a>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </div>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Generales del cliente</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Nombre:</strong>
                            <input type="text" readonly name="nombre" value="{{ $cliente->nombre }}" id="idNombreProveedor" class="form-control" placeholder="Nombre">
                        </div>
                      </div>
                      <div class="col-12">
                          <div class="form-group">
                              <strong>Siglas:</strong>
                              <input type="text" readonly value="{{ $cliente->siglas }}" name="siglas" class="form-control" placeholder="Siglas">
                          </div>
                      </div>
                      <div class="col-12">
                          <div class="form-group">
                              <strong>REEUP:</strong>
                              <input type="text" readonly value="{{ $cliente->reeup }}" name="reeup" class="form-control" placeholder="REEUP">
                          </div>
                      </div>
                      <div class="col-12">
                          <div class="form-group">
                              <strong>NIT:</strong>
                              <input type="text" readonly value="{{ $cliente->nit }}" name="nit" class="form-control" placeholder="NIT">
                          </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                            <strong>Teléfono:</strong>
                            <input type="text" readonly value="{{ $cliente->telefono }}" name="telefono" class="form-control" placeholder="Teléfono">
                        </div>
                    </div>
                      <div class="col-12">
                          <div class="form-group">
                              <strong>Dirección:</strong>
                              <textarea readonly class="form-control" style="height:150px" name="direccion" placeholder="Dirección">{{ $cliente->direccion }}</textarea>
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
              <h3 class="card-title">Cuentas bancarias del proveedor</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="pull-left mb-2">
                {{-- <button type="button" class="btn btn-info addProducto">Adicionar</button> --}}
              </div>
              <table id="tablaCuentasBancarias" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Banco</th>
                    <th>Sucursal</th>
                    <th>Cuenta</th>
                    <th>Moneda</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($cliente->cuentasbancariasclientes as $cuenta)
                  <tr>
                    <td>{{ $cuenta->banco }}</td>
                    <td>{{ $cuenta->sucursal }}</td>
                    <td>{{ $cuenta->cuenta }}</td>
                    <td>{{ $cuenta->moneda }}</td>

                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>Banco</th>
                    <th>Sucursal</th>
                    <th>Cuenta</th>
                    <th>Moneda</th>
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
    $('#tablaCuentasBancarias').DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });

</script>
@endsection
