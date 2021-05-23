@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              {{-- <h1 class="m-0">Lista de productos</h1> --}}
              <div class="pull-right">
                    @can('gestion_cliente')
                        <button type="button" class="btn btn-success mb-2 addCliente">Nuevo</button>
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
                  <h3 class="card-title">Cliente</h3>
                </div>
                <div class="card-body">
                  <table id="tablaClientes" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Nombre</th>
                          <th>Siglas</th>
                          <th>Dirección</th>
                          <th></th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->nombre }}</td>
                            <td>{{ $cliente->siglas }}</td>
                            <td>{{ $cliente->direccion }}</td>
                             <td>
                               <div>
                                  <a href="{{ route('clientes.show',$cliente) }}" class="btn btn-link text-info">Detalles</a>
                                  @can('gestion_cliente')
                                    <a href="{{ route('clientes.edit',$cliente) }}" class="btn btn-link text-primary">Editar</a>
                                    <a class="btn btn-link text-danger deleteCliente">Eliminar</a>
                                  @endcan
                               </div>
                            </td>
                        </tr>
                        @endforeach
                      </tbody>
                  </table>
                </div>
              </div>
              </div>
            </div>
          </div>
      </section>
</div>

<div class="modal fade" aria-modal="false" id="deleteClienteModal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirmación</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>¿Desea eliminar el producto?</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <form action="{{route('clientes.destroy')}}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="id" id="cliente_id"/>
            <button type="submit" class="btn btn-danger">Eliminar</button>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

  <div class="modal fade" id="modalAddCliente">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Adicionar producto</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="addClienteForm" action="{{ route('clientes.store') }}" method="POST">
            @csrf
            <div class="col-12">
                <div class="form-group">
                    <strong>Nombre (*):</strong>
                    <input type="text" name="nombre"  id="idNombreProveedor" class="form-control" placeholder="Nombre">
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Siglas:</strong>
                        <input type="text" name="siglas" class="form-control" placeholder="Siglas">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>REEUP:</strong>
                        <input type="text" name="reeup" class="form-control" placeholder="REEUP">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>NIT *:</strong>
                        <input type="text"name="nit" class="form-control" placeholder="NIT">
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
                        <strong>Dirección:</strong>
                        <textarea class="form-control" style="height:150px" name="direccion" placeholder="Dirección"></textarea>
                    </div>
                </div>
                <div class="col-12 text-center">
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


<!-- /.modal -->
@endsection
@section('scripts')
<script type="text/javascript">
$(document).on('click','.deleteCliente',function(){
  var clienteID=$(this).attr('data-id');
  $('#cliente_id').val(clienteID);
  $('#deleteClienteModal').modal('show');
});
$(document).on('click','.addCliente',function(){
    $('#bntInsertar').attr('disabled', false);
    $('#bntInsertar').html('Insertar');
  $('#modalAddCliente').modal('show');
});
$(document).ready(function () {
    $('#bntInsertar').click(function () {
            $('#bntInsertar').attr('disabled', true);
            $('#bntInsertar').html('Insertando...');
            $('#addClienteForm').submit();
            return true;
    });
    $('#addClienteForm').validate({
      rules: {
        nombre: {
          required: true,
        },
        direccion: {
          required: true,
        },
        nit: {
          required: true,
        }
      },
      messages: {
        nombre: {
          required: "Inserte el nombre del cliente",
        },
        direccion: {
          required: "Inserte la dirección",
        },
        nit: {
          required: "Inserte del NIT",
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
    $('#tablaClientes').DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
</script>
@endsection
