@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              {{-- <h1 class="m-0">Lista de productos</h1> --}}
              <div class="pull-right">
                  @can('gestion_almacen')
                  <button type="button" class="btn btn-success mb-2 addAlmacen">Nuevo almacén</button>
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
                  <h3 class="card-title">Almacenes</h3>
                </div>
                <div class="card-body">
                  <table id="tablaAlmacenes" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Almacén</th>
                          <th>Detalles</th>
                          <th></th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($almacenes as $almacen)
                        <tr>
                            <td>{{ $almacen->almacen }}</td>
                            <td>{{ $almacen->descripcion }}</td>
                             <td>
                               <div>
                                  <a href="{{ route('almacens.show',$almacen) }}" class="btn btn-link text-info">Detalles</a>
                                  @can('gestion_almacen')
                                    <a a href="{{ route('almacens.edit',$almacen) }}" class="btn btn-link text-primary">Editar</a>
                                  @endcan
                                  {{-- <button type="button" class="btn btn-link" data-toggle="modal" data-target="#deleteAlmacen{{ $almacen->id }}"><span class="fas fa-trash text-danger"></button>   --}}
                                  {{-- <a class="btn btn-link deleteAlmacen" data-id="{{$almacen->id}}"><span class="fas fa-trash text-danger"></a> --}}
                               </div>
                            </td>
                        </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>Almacén</th>
                          <th>Detalles</th>
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

<div class="modal fade" id="modalAddAlmacen">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Adicionar almacén</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <form action="{{ route('almacens.store') }}" id="almacenData" method="POST">
              @csrf
               <div class="row">
                  <div class="col-12">
                      <div class="form-group">
                          <strong>Almacén:</strong>
                          <input type="text" name="almacen" class="form-control" placeholder="Almacén">
                      </div>
                  </div>
                  <div class="col-12">
                      <div class="form-group">
                          <strong>Descripción:</strong>
                          <textarea class="form-control" style="height:150px" name="descripcion" placeholder="Descripción"></textarea>
                      </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" id="btnInsertar" class="btn btn-success btn-block">Insertar</button>
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
<script type="text/javascript">
    $(document).on('click','.deleteAlmacen',function(){
    var analisisID=$(this).attr('data-id');
    $('#almacen_id').val(analisisID);
    $('#deleteAlmacenModal').modal('show');
    });
    $(document).on('click','.addAlmacen',function(){
        $('#btnInsertar').attr('disabled', false);
        $('#btnInsertar').html('Insertar');
        $('#modalAddAlmacen').modal('show');
    });
  $(document).ready(function () {
    $('#btnInsertar').click(function () {
            $('#btnInsertar').attr('disabled', true);
            $('#btnInsertar').html('Insertando...');
            $('#almacenData').submit();
            return true;
        });
    $('#almacenData').validate({
      rules: {
        almacen: {
          required: true,
          minlength: 5,
        }
      },
      messages: {
        almacen: {
          required: "Inserta un nombre para el almacén",
          minlength: "Inserta un almacén de al menos 5 caracteres"
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
    $('#tablaAlmacenes').DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
</script>
@endsection
