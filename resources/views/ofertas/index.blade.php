@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              {{-- <h1 class="m-0">Lista de productos</h1> --}}
              <div class="pull-right">
                  @can('gestion_oferta')
                    <button type="button" class="btn btn-success addOferta">Abrir nueva oferta</button>
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
                  <h3 class="card-title">Ofertas</h3>
                </div>
                <div class="card-body">
                  <table id="tablaOfertas" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th># Oferta</th>
                          <th>Estado</th>
                          <th>Fecha creada</th>
                          <th></th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($ofertas as $oferta)
                        <tr>
                            <td>{{ $oferta->id }}</td>
                            <td>
                                @if ($oferta->estado == 1)
                                    <b class="text-success"> Abierta</b>
                                @else
                                    <b class="text-danger"> Cerrada</b>
                                @endif
                            </td>
                            <td>{{ $oferta->created_at->format('d/m/Y') }}</td>
                             <td>
                               <div>
                                   @if ($oferta->estado == 1)
                                        @can('gestion_oferta')
                                        <a href="{{ route('ofertas.edit',$oferta) }}" class="btn btn-link text-primary">Editar</a>
                                        <a href="{{ route('ofertas.recalcular',$oferta) }}" class="btn btn-link text-success">Recalcular</a>
                                        @endcan
                                   @endif
                               </div>
                            </td>
                        </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                            <th># Oferta</th>
                            <th>Estado</th>
                            <th>Fecha creada</th>
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
<div class="modal fade" aria-modal="false" id="deleteProductoModal">
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
          <form action="{{route('ofertaproductos.destroy')}}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden", name="id" id="ofertaproducto_id">
            <button type="submit" class="btn btn-danger">Eliminar</button>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<div class="modal fade" id="modalAddOferta">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Abrir nueva oferta</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>¿Desea abrir una nueva oferta? Se cerrará la oferta anterior</p>
        <div class="row">
          <form action="{{ route('ofertas.store') }}" id="ofertaData" method="POST">
              @csrf
              <input type="hidden", name="estado" value="1">
              <div class="col-12 text-center">
                  <button type="submit" id="btnInsertar" class="btn btn-success btn-block">Abrir</button>
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
$(document).on('click','.addOferta',function(){
        $('#btnInsertar').attr('disabled', false);
        $('#btnInsertar').html('Insertar');
        $('#modalAddOferta').modal('show');
    });
$(document).ready(function () {
    $('#btnInsertar').click(function () {
            $('#btnInsertar').attr('disabled', true);
            $('#btnInsertar').html('Insertando...');
            $('#ofertaData').submit();
            return true;
        });
});
  $(function () {
    $('#tablaOfertas').DataTable({
        "order": [[ 0, "desc" ]],
      "responsive": true,
      "autoWidth": false,
    });
  });
</script>
@endsection
