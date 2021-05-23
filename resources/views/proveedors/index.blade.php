@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              {{-- <h1 class="m-0">Lista de productos</h1> --}}
              <div class="pull-right">

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
                  <h3 class="card-title">Proveedor</h3>
                </div>
                <div class="card-body">
                  <table id="tablaProveedor" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Nombre</th>
                          <th>Siglas</th>
                          <th>Dirección</th>
                          <th></th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($proveedores as $proveedor)
                        <tr>
                            <td>{{ $proveedor->nombre }}</td>
                            <td>{{ $proveedor->siglas }}</td>
                            <td>{{ $proveedor->direccion }}</td>
                             <td>
                               <div>
                                  <a href="{{ route('proveedors.show',$proveedor) }}" class="btn btn-link text-info">Detalles</a>
                                  @can('gestion_proveedor')
                                    <a a href="{{ route('proveedors.edit',$proveedor) }}" class="btn btn-link text-primary">Editar</a>
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


<!-- /.modal -->
@endsection
@section('scripts')
<script type="text/javascript">
  $(function () {
    $('#tablaProveedor').DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
</script>
@endsection
