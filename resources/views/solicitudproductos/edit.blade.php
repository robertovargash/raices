@extends('layouts.main')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="col-lg-12 margin-tb">
            <div class="pull-left">
              <h2>Datos de la solicitud</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('solicitudes.edit',$solicitudproducto->solicitude->id) }}"> Atrás</a>
            </div>
          </div>
        </div>        
      </div>
    </div><!-- /.container-fluid -->
  </div>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Datos del producto {{ $solicitudproducto->tproducto->nombre }}</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                    <form id="formUpdate" action="{{ route('solicitudproductos.editar') }}" role="form" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $solicitudproducto->id }}">
                        <div class="col-12 form-group">
                            <strong>Producto:</strong>
                            <input type="text" disabled  value="{{ $solicitudproducto->tproducto->nombre }}" class="form-control" placeholder="Producto">
                        </div>
                        <div class="col-12 form-group">
                            <strong>Cantidad *:</strong>
                            <input type="number" name="cantidad" id="cantidad" value="{{ $solicitudproducto->cantidad }}" class="form-control" placeholder="Cantidad">
                        </div>
                        <div class="col-12 form-group">
                          <strong>Precio *:</strong>
                          <input type="number" name="precio" id="precio" value="{{ $solicitudproducto->precio }}" class="form-control" placeholder="Precio">
                        </div>
                        <div class="col-12 form-group">
                            <strong>Observaciones:</strong>
                            <textarea class="form-control" style="height:150px" name="observaciones" placeholder="Observaciones">{{ $solicitudproducto->observaciones }}</textarea>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-success btn-block">Actualizar</button>
                        </div>
                    </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card card-info" id="cardMercancias">
            <div class="card-header">
              <h3 class="card-title">Materias primas del producto</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <table id="tablaSolicitudmercancias" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Materia prima</th>
                    <th>Cantidad necesaria</th>
                    <th>Existencia</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($solicitudproducto->solicitudmateriasprimas as $materiaprima)
                  <tr>
                    <td>{{ $materiaprima->mercancia->nombremercancia }}</td>
                    <td>{{ $materiaprima->cantidad }} <b>{{ $materiaprima->mercancia->um }}</b></td>
                    <td>{{ $materiaprima->existencia }} <b>{{ $materiaprima->mercancia->um }}</b></td>
                    <td>
                        @can('gestion_solicitud')
                            <a class="btn btn-link editMateriaPrima text-primary"
                            data-id="{{$materiaprima->id}}"
                            data-mprima="{{$materiaprima->mercancia->nombremercancia}}"
                            data-cantidad="{{$materiaprima->cantidad}}"
                            mprima-existencia ="{{ $materiaprima->existencia }}">
                            <b>Editar</b></a>
                            <a class="btn btn-link deleteMateriaPrima text-danger" data-id="{{$materiaprima->id}}"><b>Eliminar</b></a>
                        @endcan
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>Materia prima</th>
                    <th>Cantidad necesaria</th>
                    <th>Existencia</th>
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

<div class="modal fade" aria-modal="false" id="deleteMateriaPrimaModal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirmación</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>¿Desea eliminar el elemento?</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <form action="{{route('solicitudmateriasprimas.destroy')}}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden", name="id" id="materiaprima_id">
            <button type="submit" class="btn btn-danger">Eliminar</button>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

{{-- <div class="modal fade" id="modalAddproducto">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Producto</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="addSolicitudProducto" action="{{ route('solicitudproductos.store') }}" method="POST">
            @csrf
             <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <input type="hidden" name="solicitude_id" value="{{ $solicitude->id }}" class="form-control">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                    <strong for="selectProductos">Producto:</strong>
                    <select id="selectProductos" class="form-control select2bs4" name="tproducto_id" onchange="refrescar_precio_cantidad()" style="width: 100%;">
                        <option value="" selected="selected" hidden="hidden">Selecciona producto</option>
                        @foreach ($tproductos as $tproducto)
                            @if ($tproducto->existe == 0)
                                <option valor="{{ $tproducto->valorbruto }}" cantidadd="{{ $tproducto->cantidadd }}" value="{{$tproducto->id}}">{{$tproducto->nombre}} | {{$tproducto->tipotproducto->tipo}}</option>
                            @endif
                        @endforeach
                    </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Cantidad *:</strong>
                        <input type="number" name="cantidad" id="cantidad" class="form-control" placeholder="Cantidad">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Cantidad máxima:</strong>
                        <input type="number" readonly id="cantidadmax" class="form-control" placeholder="Cantidad">
                    </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                      <strong>Precio *:</strong>
                      <input readonly type="number" name="precio" id="precio" class="form-control" placeholder="Precio">
                  </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Observaciones:</strong>
                        <textarea class="form-control" style="height:150px" name="observaciones" placeholder="Obsrevaciones">Sin detalles</textarea>
                    </div>
                </div>
                <div class="col-12 text-center">
                    <button type="submit" id="btnInsert" class="btn btn-success btn-block">Adicionar</button>
                </div>
            </div>
        </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>--}}

<div class="modal fade" id="editMateriaPrima">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Editando materia prima</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <form id="editMateriaprimaSolicitude" action="{{ route('solicitudmateriaprimas.editar') }}" method="POST">
                @csrf
                @method('PUT')
                 <div class="row">
                    <input type="hidden" name="id" id="edit_solicitud_mprima_id">
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Mercancía:</strong>
                            <input type="text" readonly  id="edit_mercancia" class="form-control" placeholder="Mercancía">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Cantidad *:</strong>
                            <input type="number" name="cantidad" id="edit_cantidad" class="form-control" placeholder="Cantidad">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Existencia:</strong>
                            <input type="number" readonly id="edit_existencia" class="form-control" placeholder="Existencia">
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" id="btnEdit" class="btn btn-success btn-block">Actualizar</button>
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
$(document).on('click','.deleteMateriaPrima',function(){
    var analisisID=$(this).attr('data-id');
    $('#materiaprima_id').val(analisisID);
    $('#deleteMateriaPrimaModal').modal('show');
});

$(document).on('click','.editMateriaPrima',function(){
    var id = $(this).attr('data-id');
    var solicitud_mprima_id = $(this).attr('data-mprima_id');
    var mprima = $(this).attr('data-mprima');
    var cantidad = $(this).attr('data-cantidad');
    var existencia = $(this).attr('mprima-existencia');
    $('#edit_solicitud_mprima_id').val(id);
    $('#edit_mercancia').val(mprima);
    $('#edit_cantidad').val(cantidad);
    $('#edit_existencia').val(existencia);
    $('#editMateriaPrima').modal('show');
});

  $(document).ready(function () {
    // $('#btnInsert').click(function () {
    //         $('#btnInsert').attr('disabled', true);
    //         $('#btnInsert').html('Insertando...');
    //         $('#addSolicitudProducto').submit();
    //         return true;
    // });
    $('#btnEdit').click(function () {
            $('#btnEdit').attr('disabled', true);
            $('#btnEdit').html('Actualizando...');
            $('#editMateriaprimaSolicitude').submit();
            return true;
    });
    $('#formUpdate').validate({
      rules: {
        cantidad: {
          required: true,
          min: function() {
                return 0;
            },
        },
        precio: {
          required: true,
          min: function() {
                return 0;
            },
        },
      },
      messages: {
        cantidad: {
          required: "Inserte la cantidad",
          min: "la cantidad debe ser mayor o igual que 0",
        },
        precio: {
          required: "Inserte el precio",
          min: "el precio debe ser mayor o igual que 0",
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
    $('#editMateriaprimaSolicitude').validate({
      rules: {
        cantidad: {
          required: true,
          max: function() {
                return parseFloat($("#edit_existencia").val());
            },
          min: function() {
                return 0;
            },
        },
      },
      messages: {
        cantidad: {
          required: "Inserte la cantidad",
          max: "debe ser menor o igual a la existencia en almacenes (existente: {0})",
          min: "la cantidad ser mayor o igual que 0",
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
  $(function () {
    $('#tablaSolicitudmercancias').DataTable({
        "responsive": true,
      "autoWidth": false,
    });
  });

</script>
@endsection
