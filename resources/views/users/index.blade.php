@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
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
              <div class="pull-right">
                {{-- <button type="button" class="btn btn-success mb-2 " href="{{ route('users.create') }}">Nuevo</button>                 --}}
                <a href="{{ route('users.create') }}" class="btn btn-success">Nuevo</a>
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
                  <h3 class="card-title">Usuarios</h3>
                </div>
                <div class="card-body">
                  <table id="tablaUsuarios" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Nombre</th>
                          <th>Correo electrónico</th>
                          <th>Ocupación</th>
                          <th>Roles</th>
                          <th width="280px"></th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->profession }} </td>
                            <td>
                                @if(!empty($usuario->getRoleNames()))
                                    @foreach($usuario->getRoleNames() as $v)
                                        <label class="badge badge-success">{{ $v }}</label>
                                    @endforeach
                                @endif
                            </td>
                             <td>
                               <div>
                                    @can('gestion_usuarios')
                                        <a href="{{ route('users.edit',$usuario) }}" class="btn btn-link text-primary">Editar</a>
                                        <a class="btn btn-link text-danger deleteUser" data-id="{{$usuario->id}}">Eliminar</a>
                                    @endcan
                               </div>
                            </td>
                        </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo electrónico</th>
                            <th>Ocupación</th>
                            <th>Roles</th>
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

<div class="modal fade" aria-modal="false" id="deleteUserModal">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirmación</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>¿Desea eliminar el usuario?</p>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <form action="{{route('users.destroy')}}" method="POST">
          @csrf
          @method('DELETE')
          <input type="hidden", name="id" id="user_id">
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
  $(function () {
    $('#tablaUsuarios').DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });

$(document).on('click','.deleteUser',function(){
  var userID=$(this).attr('data-id');
  $('#user_id').val(userID);
  $('#deleteUserModal').modal('show');
});
</script>
@endsection
