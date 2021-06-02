@extends('layouts.main')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="col-lg-12 margin-tb">
            <div class="pull-left">
              <h2>Datos del cliente</h2>
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
              <h3 class="card-title">Generales del proveedor</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <form role="form" id="clienteData" action="{{ route('clientes.update',$cliente->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="col-12">
                  <div class="form-group">
                      <strong>Nombre (*):</strong>
                      <input type="text" name="nombre" value="{{ $cliente->nombre }}" id="idNombreProveedor" class="form-control" placeholder="Nombre">
                  </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Siglas:</strong>
                        <input type="text" value="{{ $cliente->siglas }}" name="siglas" class="form-control" placeholder="Siglas">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>REEUP:</strong>
                        <input type="text" value="{{ $cliente->reeup }}" name="reeup" class="form-control" placeholder="REEUP">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>NIT *:</strong>
                        <input type="text" value="{{ $cliente->nit }}" name="nit" class="form-control" placeholder="NIT">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Teléfono:</strong>
                        <input type="text" value="{{ $cliente->telefono }}" name="telefono" class="form-control" placeholder="Teléfono">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Dirección:</strong>
                        <textarea class="form-control" style="height:150px" name="direccion" placeholder="Dirección">{{ $cliente->direccion }}</textarea>
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
          <div class="card card-info" id="cardCuentas">
            <div class="card-header">
              <h3 class="card-title">Cuentas bancarias del proveedor</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="pull-left mb-2">
                <button type="button" class="btn btn-info addProducto">Adicionar</button>
              </div>
              <table id="tablaCuentasBancarias" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Banco</th>
                    <th>Sucursal</th>
                    <th>Cuenta</th>
                    <th>Moneda</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($cliente->cuentasbancariasclientes as $cuenta)
                  <tr>
                    <td>{{ $cuenta->banco }}</td>
                    <td>{{ $cuenta->sucursal }}</td>
                    <td>{{ $cuenta->cuenta }}</td>
                    <td>{{ $cuenta->moneda }}</td>
                    <td>
                        @can('gestion_proveedor')
                            <a class="btn btn-link text-primary editCuenta" data-id="{{$cuenta->id}}"
                                data-banco="{{ $cuenta->banco }}"
                                data-sucursal="{{ $cuenta->sucursal }}"
                                data-cuenta="{{ $cuenta->cuenta }}"
                                data-moneda="{{ $cuenta->moneda }}"><b>Editar</b></a>
                            <a class="btn btn-link text-danger deletecuenta" data-id="{{$cuenta->id}}"><b>Eliminar</b></a>
                        @endcan
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>Banco</th>
                    <th>Sucursal</th>
                    <th>Cuenta</th>
                    <th>Moneda</th>
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
<div class="modal fade" aria-modal="false" id="deletecuentaModal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirmación</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>¿Desea eliminar la cuenta?</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <form action="{{route('cuentasbancariasclientes.destroy')}}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden", name="id" id="delete_cuenta_id">
            <button type="submit" class="btn btn-danger">Eliminar</button>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modalAddCuenta">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Cuenta del cliente</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('cuentasbancariasclientes.store') }}" id="addCuentaData" method="POST">
            @csrf
             <div class="row">
                <input type="hidden" name="cliente_id" value="{{ $cliente->id }}" class="form-control"/>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Banco*:</strong>
                        <input type="text" name="banco" id="banco" class="form-control" placeholder="Banco">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Sucursal*:</strong>
                        <input type="text" id="sucursal" name="sucursal" class="form-control" placeholder="Sucursal">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Cuenta*:</strong>
                        <input type="text" id="cuenta" name="cuenta" class="form-control" placeholder="Cuenta">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Moneda*:</strong>
                        <input type="text" id="moneda" name="moneda" class="form-control" placeholder="Moneda">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" id="bntInsertar" class="btn btn-success btn-block">Insertar</button>
                </div>
            </div>
        </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modaleditCuenta">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Cuenta del proveedor</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('cuentasbancariasclientes.editar') }}" id="editCuentaDataForm" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <input type="hidden" name="id" id="edit_id" class="form-control"/>
                <input type="hidden" name="cliente_id" value="{{ $cliente->id }}" class="form-control"/>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Banco *:</strong>
                        <input type="text" name="banco" id="edit_banco" class="form-control" placeholder="Banco">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Sucursal*:</strong>
                        <input type="text" id="edit_sucursal" name="sucursal" class="form-control" placeholder="Sucursal">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Cuenta*:</strong>
                        <input type="text" id="edit_cuenta" name="cuenta" class="form-control" placeholder="Cuenta">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Moneda*:</strong>
                        <input type="text" id="edit_moneda" name="moneda" class="form-control" placeholder="Moneda">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" id="btnModificar" class="btn btn-success btn-block">Actualizar</button>
                </div>
            </div>
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

$(document).on('click','.addProducto',function(){
    $('#bntInsertar').attr('disabled', false);
    $('#bntInsertar').html('Insertar');
    $('#modalAddCuenta').modal('show');
});

$(document).on('click','.editCuenta',function(){
    var id = $(this).attr('data-id');
    var banco = $(this).attr('data-banco');
    var sucursal = $(this).attr('data-sucursal');
    var cuenta = $(this).attr('data-cuenta');
    var moneda = $(this).attr('data-moneda');
    $('#edit_id').val(id);
    $('#edit_banco').val(banco);
    $('#edit_sucursal').val(sucursal);
    $('#edit_cuenta').val(cuenta);
    $('#edit_moneda').val(moneda);
    $('#modaleditCuenta').modal('show');
});

$(document).on('click','.deletecuenta',function(){
    var cuenta_id=$(this).attr('data-id');
    $('#delete_cuenta_id').val(cuenta_id);
    $('#deletecuentaModal').modal('show');
});

  $(document).ready(function () {
    $('#bntInsertar').click(function () {
            $('#bntInsertar').attr('disabled', true);
            $('#bntInsertar').html('Insertando...');
            $('#addCuentaData').submit();
            return true;
    });
    $('#clienteData').validate({
      rules: {
        nombre: {
          required: true
        },
        direccion:{
            required: true
        },
      },
      messages: {
        nombre: {
          required: "Inserta un nombre para el producto"
        },
        direccion:{
            required: "Inserte la dirección del cliente"
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
    $('#editCuentaDataForm').validate({
      rules: {
        banco: {
          required: true,
        },
        sucursal: {
          required: true,
        },
        cuenta: {
          required: true
        },
        moneda: {
          required: true
        }
      },
      messages: {
        banco: {
          required: "Inserte el banco",
        },
        sucursal: {
          required: "Inserte la sucursal bancaria",
        },
        cuenta: {
          required: "Inserte el No. de cuenta"
        },
        moneda: {
          required: "Inserte la moneda"
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
    $('#addCuentaData').validate({
      rules: {
        banco: {
          required: true,
        },
        sucursal: {
          required: true,
        },
        cuenta: {
          required: true
        },
        moneda: {
          required: true
        }
      },
      messages: {
        banco: {
          required: "Inserte el banco",
        },
        sucursal: {
          required: "Inserte la sucursal bancaria",
        },
        cuenta: {
          required: "Inserte el No. de cuenta"
        },
        moneda: {
          required: "Inserte la moneda"
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
    $('#tablaCuentasBancarias').DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });

</script>
@endsection
