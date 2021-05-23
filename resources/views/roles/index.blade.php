@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <div class="pull-right">
                {{-- <button type="button" class="btn btn-success mb-2 " href="{{ route('users.create') }}">Nuevo</button>                 --}}
                @can('gestion_roles')
                    <a class="btn btn-success" href="{{ route('roles.create') }}">Nuevo</a>
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
                  <h3 class="card-title">Roles</h3>
                </div>
                <div class="card-body">
                  <table id="tablaRoles" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                            <th>#</th>
                            <th>Rol</th>
                            <th>Permisos</th>
                            <th width="280px"></th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($roles as $key => $role)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                @if(!empty($role->permissions))
                                    @foreach($role->permissions as $v)
                                        <label class="badge badge-success">{{ $v->name }}</label>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                @can('gestion_roles')
                                    <a class="btn btn-link text-primary" href="{{ route('roles.edit',$role->id) }}">Editar</a>
                                    <a class="btn btn-link text-danger deleteRole" data-id={{ $role->id }}>Eliminar</a>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Rol</th>
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
          <p>¿Desea eliminar el rol?</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <form action="{{route('roles.destroy')}}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden", name="id" id="role_id">
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
$(document).on('click','.deleteRole',function(){
    var rol_id=$(this).attr('data-id');
    $('#role_id').val(rol_id);
    $('#deleteRolModal').modal('show');
});
  $(function () {
    $('#tablaRoles').DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
</script>
@endsection
