@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              {{-- <h1 class="m-0">Lista de productos</h1> --}}
                <div class="pull-right">
                  @can('gestion_cuentas')
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAddCuenta">Nueva cuenta</button>
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
                  <h3 class="card-title">Cuentas</h3>
                </div>
                <div class="card-body">
                  <table id="tablaCuentas" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Clasificador</th>
                          <th>Cuenta</th>
                          <th>Descripción</th>
                          <th></th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($cuentas as $cuenta)
                        <tr>
                            <td>
                              @if ($cuenta->clasificadorcuenta)
                                {{ $cuenta->clasificadorcuenta->clasificacion }}
                              @else
                                  Sin clasificador
                              @endif
                            </td>
                            <td>{{ $cuenta->numero }}</td>
                            <td>{{ $cuenta->descripcion }}</td>
                             <td>
                                @can('gestion_cuentas')
                                    <a href="{{ route('ficuentas.edit',$cuenta) }}" class="btn btn-link text-primary">Editar</a>
                                    <a class="btn btn-link text-danger deleteCuenta" data-id="{{$cuenta->id}}">Eliminar</a>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>Clasificador</th>
                          <th>Cuenta</th>
                          <th>Descripción</th>
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

<div class="modal fade" aria-modal="false" id="deleteCuentaModal">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirmación</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>¿Desea eliminar la Cuenta?</p>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <form action="{{route('ficuentas.destroy')}}" method="POST">
          @csrf
          @method('DELETE')
          <input type="hidden", name="id" id="ficuenta_id">
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
        <h4 class="modal-title">Adicionar cuenta</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <form id="addcuenta" action="{{ route('ficuentas.store') }}" method="POST">
              @csrf
               <div class="row">
                  <div class="col-12">
                      <div class="form-group">
                          <strong>Cuenta (*):</strong>
                          <input type="text" name="numero" class="form-control" placeholder="Número">
                      </div>
                  </div>
                  <div class="col-12">
                      <div class="form-group">
                          <strong>Descripción (*):</strong>
                          <input type="text" name="descripcion" class="form-control" placeholder="Descripción">
                      </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <strong>Clasificador:</strong>
                      <select class="form-control select2bs4" name="clasificadorcuenta_id" style="width: 100%;">
                          <option value="" selected="selected" hidden="hidden">Selecciona clasificador de cuenta</option>
                          @foreach ($clasificadores as $clasif)
                              <option value="{{$clasif->id}}">{{$clasif->clasificacion}}</option>
                          @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                          <button type="submit" class="btn btn-primary btn-block">Insertar</button>
                  </div>
              </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection
@section('scripts')
<script>
  $(function () {
    $('#tablaCuentas').DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
  $(document).on('click','.deleteCuenta',function(){
    var analisisID=$(this).attr('data-id');
    $('#ficuenta_id').val(analisisID);
    $('#deleteCuentaModal').modal('show');
  });
  $(document).ready(function () {
    $('#addcuenta').validate({
      rules: {
        numero: {
          required: true,
        },
        descripcion: {
          required: true,
          maxLenght:250
        },
      },
      messages: {
        numero: {
          required: "Inserte el número de cuenta",
        },
        descripcion: {
          required:  "Inserte una descripcion",
          maxLenght:  "Máximo 250 caracteres",
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
  });
</script>
@endsection
