@extends('layouts.main')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="col-lg-12 margin-tb">
            <div class="pull-left">
              <h2>Datos cuenta</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('ficuentas.index') }}"> Atrás</a>
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
              <h3 class="card-title">Datos cuenta</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <form role="form" id="editData" action="{{ route('ficuentas.update',$ficuenta) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="col-12">
                  <div class="form-group">
                    <strong>Clasificador:</strong>
                    <select id="clasificador" class="form-control select2bs4" name="clasificadorcuenta_id" style="width: 100%;">
                        <option value="" selected="selected" hidden="hidden">Selecciona clasificador de cuenta</option>
                        @foreach ($clasificadores as $clasif)
                            <option value="{{$clasif->id}}" {{$ficuenta->clasificadorcuenta_id == $clasif->id ? ' selected ' : '' }}>{{$clasif->clasificacion}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                      <strong>Cuenta (*):</strong>
                      <input type="text" name="numero" value="{{ $ficuenta->numero }}" id="idnumero" class="form-control" placeholder="Número">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                      <strong>Descripción (*):</strong>
                      <textarea class="form-control" style="height:150px" id="iddescripcion" name="descripcion" placeholder="Descripción">{{ $ficuenta->descripcion }}</textarea>
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
          <div class="card card-info" id="cardSubCuentas">
            <div class="card-header">
              <h3 class="card-title">Subcuentas de la cuenta</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="pull-left mb-2">
                {{-- <a class="btn btn-success" href="{{ route('recepciones.create') }}"> Adicionar</a> --}}
                @can('gestion_cuentas')
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalAddSubcuenta">Adicionar</button>
                @endcan
              </div>
              <table id="tablaSubcuentas" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Subcuenta</th>
                    <th>Descripción</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($ficuenta->fisubcuentas as $subcuenta)
                  <tr>
                    <td>{{ $subcuenta->numero }}</td>
                    <td>{{ $subcuenta->descripcion }}</td>
                    <td>
                        @can('gestion_cuentas')
                        {{-- reparar aqui --}}
                        <a href="{{ route('fisubcuentas.edit',$subcuenta) }}" class="btn btn-link text-primary">Editar</a>
                        <a class="btn btn-link deleteSubcuenta text-danger" data-id="{{$subcuenta->id}}">Eliminar</a>
                        @endcan
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>Subcuenta</th>
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
  </div>
</div>
<div class="modal fade" aria-modal="false" id="deleteSubCuentaModal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirmación</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>¿Desea eliminar la subcuenta?</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <form action="{{route('fisubcuentas.destroy')}}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden", name="id" id="subcuenta_id">
            <button type="submit" class="btn btn-danger">Eliminar</button>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<div class="modal fade" id="modalAddSubcuenta">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Adicionar subcuenta</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <form action="{{ route('fisubcuentas.store') }}" id="addData" method="POST">
              @csrf
               <div class="row">
                <div class="col-12">
                  <div class="form-group">
                      <input type="hidden" name="ficuenta_id"  value="{{ $ficuenta->id }}" class="form-control">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <strong>Número subcuenta *:</strong>
                      <input type="text" name="numero" class="form-control" placeholder="Número">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                      <strong>Descripción subcuenta *:</strong>
                      <input type="text" name="descripcion" class="form-control" placeholder="Descripción">
                  </div>
                </div>
                  <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                          <button type="submit" class="btn btn-primary">Insertar</button>
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
@endsection
@section('scripts')
<script type="text/javascript">
  $(function () {
    $('#tablaSubcuentas').DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
  $(document).on('click','.deleteSubcuenta',function(){
    var subcuentaID=$(this).attr('data-id');
    $('#subcuenta_id').val(subcuentaID);
    $('#deleteSubCuentaModal').modal('show');
});

  $(document).ready(function () {
    $('#editData').validate({
      rules: {
        numero: {
          required: true,
        },
        descripcion: {
          required: true,
          maxlength: 250
        }
      },
      messages: {
        numero: {
          required: "Inserta un número para la cuenta"
        },
        descripcion: {
          required: "Inserta una descripción",
          maxlength: "Máximo 250 caracteres"
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

    $('#addData').validate({
      rules: {
        numero: {
          required: true,
        },
        descripcion: {
          required: true,
          maxlength: 250
        }
      },
      messages: {
        numero: {
          required: "Inserta un número para la subcuenta"
        },
        descripcion: {
          required: "Inserta una descripción",
          maxlength: "Máximo 250 caracteres"
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
</script>
@endsection
