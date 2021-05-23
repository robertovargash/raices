@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <div class="pull-right">
                  @can('gestion_permisos')
                    <a class="btn btn-success" href="{{ route('permissions.create') }}">Nuevo</a>
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
                  <h3 class="card-title">Permisos</h3>
                </div>
                <div class="card-body">
                  <table id="tablaPermisos" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                            <th>#</th>
                            <th>Permisos</th>
                            <th width="280px"></th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($permisos as $key => $permiso)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $permiso->name }}</td>
                            <td>
                                @can('gestion_permisos')
                                    <a class="btn btn-link text-primary" href="{{ route('permissions.edit',$permiso->id) }}">Editar</a>
                                    <a class="btn btn-link text-danger deletepermiso" data-id="{{ $permiso->id }}">Eliminar</a>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Permisos</th>
                            <th width="280px"></th>
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

<div class="modal fade" aria-modal="false" id="deleteRolModal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirmación</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>¿Desea eliminar el permiso?</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <form action="{{route('permissions.destroy')}}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden", name="id" id="permiso_id">
            <button type="submit" class="btn btn-danger">Eliminar</button>
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
$(document).on('click','.deletepermiso',function(){
    var rol_id=$(this).attr('data-id');
    $('#permiso_id').val(rol_id);
    $('#deleteRolModal').modal('show');
});
  $(function () {
    $('#tablaPermisos').DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
</script>
@endsection
