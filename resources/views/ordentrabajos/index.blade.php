@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              {{-- <h1 class="m-0">Lista de productos</h1> --}}
              <div class="pull-right">
                {{-- <button disabled type="button" class="btn btn-success mb-2 " data-toggle="modal" data-target="#modalAddOT">Nueva</button> --}}
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
                  <h3 class="card-title">Órdenes de trabajo</h3>
                </div>
                <div class="card-body">
                  <table id="tablaOT" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Estado</th>
                          <th>Fecha</th>
                          <th>Producto</th>
                          <th>Cantidad</th>
                          <th>Observaciones</th>
                          <th></th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($ordentrabajos as $ot)
                        <tr>
                            <td>{{ $ot->numero }}</td>
                            <td>
                                @switch($ot->estado)
                                    @case(0)
                                        <b>1-En proceso</b>
                                        @break
                                    @case(1)
                                        <b class="text-warning">2-Confirmada</b>
                                        @break
                                    @case(2)
                                        <b class="text-success">3-Terminada</b>
                                        @break
                                    @default
                                        <b class="text-danger">4-Cancelada</b>
                                @endswitch
                            </td>
                            <td>{{ date('d/m/Y', strtotime($ot->fecha)) }} </td>
                            <td>{{ $ot->tproducto->nombre }}</td>
                            <td>{{ $ot->cantidad }}</td>
                            <td>{{ $ot->observaciones }}</td>
                             <td>
                                <div>
                                  <a href="{{ route('ordentrabajos.show',$ot) }}" class="btn btn-link text-info">Detalles</a>
                                  <a href="{{ route('ordentrabajos.pdf',$ot) }}" class="btn btn-link text-info">PDF</a>
                                    @can('gestion_ot')                                    
                                    <a href="{{ route('ordentrabajos.edit',$ot) }}" class="btn btn-link text-primary" {{ $ot->estado == 0 || $ot->estado == 1 ? '' : 'hidden'}}>Editar</a>
                                    {{-- <a class="btn btn-link text-danger disabled cancelarOT" {{ $ot->estado == 0 ? '' : 'hidden'}} data-id="{{$ot->id}}"><s>Cancelar</s></a> --}}
                                    <a class="btn btn-link text-success terminarOT" {{ $ot->estado == 1 ? '' : 'hidden'}} data-id="{{$ot->id}}">Terminar</a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Observaciones</th>
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

<div class="modal fade" aria-modal="false" id="cancelarOTModal">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirmación</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>¿Desea cancelar la OT?</p>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <form action="{{route('ordentrabajos.cancelar')}}" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden", name="id" id="cancelarot_id">
          <button type="submit" class="btn btn-danger">Si, cancelar</button>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" aria-modal="false" id="terminarOTModal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirmación</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>¿Desea marcar la OT como terminada?</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <form action="{{route('ordentrabajos.terminar')}}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden", name="id" id="terminarot_id">
            <button type="submit" class="btn btn-warning">Si, terminar</button>
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
    $('#tablaOT').DataTable({
      "order": [[ 1, "asc" ],[0, "desc"]],
      "responsive": true,
      "autoWidth": false,
    });
  });

$(document).on('click','.cancelarOT',function(){
  var productoID=$(this).attr('data-id');
  $('#cancelarot_id').val(productoID);
  $('#cancelarOTModal').modal('show');
});

$(document).on('click','.terminarOT',function(){
  var productoID=$(this).attr('data-id');
  $('#terminarot_id').val(productoID);
  $('#terminarOTModal').modal('show');
});
</script>
@endsection
