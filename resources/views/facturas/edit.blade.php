@extends('layouts.main')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="col-lg-12 margin-tb">
            <div class="pull-left">
              <h2>Datos de la Factura</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('facturas.index') }}"> Atrás</a>
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
              <h3 class="card-title">Datos de la factura {{ $factura->numero }}</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <form id="formUpdate" action="{{ route('facturas.update',$factura->id) }}" role="form" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" value="{{ $factura->estado }}" name="estado" class="form-control">
                <div class="col-12">
                  <div class="form-group">
                      <strong>Cliente: </strong>*
                      <input type="text" readonly value="{{ $factura->cliente->nombre }}" class="form-control" placeholder="Cliente">
                  </div>
                </div>
                <div class="col-12 form-group">
                    <strong>Recibe: </strong>
                    <input type="text" value="{{ $factura->recibe }}" name="recibe" class="form-control" placeholder="Recibe">
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Elaborado por:</strong>
                        <input type="text" readonly value="{{ $factura->elabora }}" name="elabora" class="form-control" placeholder="Elabora">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Transportista:</strong>
                        <input type="text" value="{{ $factura->transporta }}" name="transporta" class="form-control" placeholder="Transportista">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>CI del transportista:</strong>
                        <input type="text" value="{{ $factura->tci }}" name="tci" class="form-control" placeholder="CI">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Chapa del transportista:</strong>
                        <input type="text" value="{{ $factura->tchapa }}" name="tchapa" class="form-control" placeholder="Chapa">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Descripción:</strong>
                        <textarea class="form-control" style="height:150px" name="descripcion" placeholder="Descripción">{{ $factura->descripcion }}</textarea>
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
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Elementos de la factura</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="pull-left mb-2">
                <button type="button" class="btn m-2 btn-info importarSolicitud" id="cardfacturaelementos">Importar solicitud</button>
                <button type="button" class="btn m-2 btn-info addElemento">Adicionar producto</button>
                <button type="button" class="btn m-2 btn-success addRecargo">Adicionar Recargo</button>
                <button type="button" class="btn m-2 btn-warning addDescuento">Adicionar Descuento</button>
              </div>
              <table id="tablaFacturaElementos" class="table table-bordered table-hover">
                <thead>
                  <tr>
                        <th>#</th>
                        <th>Descripción</th>
                        <th>UM</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Importe</th>
                        <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($factura->facturaelementos as $key => $facturaelemento)
                  <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $facturaelemento->descripcion }}</td>
                        <td>{{ $facturaelemento->um }}</td>
                        @if ($facturaelemento->tipo === 0)
                          <td>{{ $facturaelemento->cantidad }}</td>
                        @else
                          <td>-</td>
                        @endif                        
                        <td>{{ $facturaelemento->precio }}</td>
                        <td>{{ $facturaelemento->precio * $facturaelemento->cantidad}}</td>
                        <td>
                          @can('gestion_facturas')
                              @if ($facturaelemento->tipo === 0)
                                <a class="btn btn-link editFacturaElemento text-primary"
                                data-id="{{$facturaelemento->id}}"
                                data-descripcion="{{$facturaelemento->descripcion}}"
                                data-um="{{$facturaelemento->um}}"
                                data-cantidad="{{$facturaelemento->cantidad}}"
                                data-precio="{{$facturaelemento->precio}}">
                                <b>Editar</b></a>
                              @else
                                <a class="btn btn-link editFacturaRD text-primary"
                                data-id="{{$facturaelemento->id}}"
                                data-descripcion="{{$facturaelemento->descripcion}}"
                                data-um="{{$facturaelemento->um}}"
                                data-cantidad="{{$facturaelemento->cantidad}}"
                                data-precio="{{$facturaelemento->precio}}">
                                <b>Editar</b></a>
                              @endif                                  
                              <a class="btn btn-link deleteFacturaElemento text-danger" data-id="{{$facturaelemento->id}}"><b>Eliminar</b></a>
                          @endcan                            
                        </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                    <tr>
                          <th>#</th>
                          <th>Descripción</th>
                          <th>UM</th>
                          <th>Cantidad</th>
                          <th>Precio</th>
                          <th>Importe</th>
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

<div class="modal fade" aria-modal="false" id="deleteFacturaElementoModal">
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
          <form action="{{ route('facturaelementos.eliminar') }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden", name="id" id="facturaelemento_id">
            <button type="submit" class="btn btn-danger">Eliminar</button>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modaladdElemento">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Producto</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <form id="addFacturaElemento" action="{{ route('facturaelementos.store') }}" method="POST">
                @csrf
                 <div class="row">
                    <input type="hidden" name="factura_id" value="{{ $factura->id }}" class="form-control">
                    <input type="hidden" name="tipo" value="0" class="form-control">
                    <div class="col-12">
                        <div class="form-group">
                        <strong for="selectProductos">Producto:</strong>
                        <select id="selectProductos" class="form-control select2bs4" onchange="refrescar_precio_cantidad_descripcion()" style="width: 100%;">
                            <option value="" selected="selected" hidden="hidden">Selecciona producto</option>
                            @foreach ($tproductos as $tproducto)
                                <option valor="{{ $tproducto->valorbruto }}" value="{{$tproducto->nombre}}">{{$tproducto->nombre}}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Descripción del producto *:</strong>
                            <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Descripción">
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
                          <strong>Precio *:</strong>
                          <input type="number" name="precio" id="precio" class="form-control" placeholder="Precio">
                      </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>UM *:</strong>
                            <input type="text" name="um" value="U" id="um" class="form-control" placeholder="UM">
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" id="btnInsert" class="btn btn-success btn-block">Adicionar</button>
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

<div class="modal fade" id="modalAddRecargo">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Recargo</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <form id="addFacturaRecargo" action="{{ route('facturaelementos.store') }}" method="POST">
                @csrf
                 <div class="row">
                    <input type="hidden" name="factura_id" value="{{ $factura->id }}" class="form-control">
                    <input type="hidden" name="tipo" value="1" class="form-control">
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Motivo del recargo:</strong>*
                            <input type="text" name="descripcion" id="r_descripcion" class="form-control" placeholder="Descripción">
                        </div>
                    </div>
                    <input type="hidden" name="cantidad" value="1" id="r_cantidad" class="form-control" placeholder="Cantidad">

                    <div class="col-12">
                      <div class="form-group">
                          <strong>Importe *:</strong>
                          <input type="number" name="precio" id="r_precio" class="form-control" placeholder="Precio">
                      </div>
                    </div>
                    <input type="hidden" name="um" value="" id="um" class="form-control" placeholder="UM">

                    <div class="col-12 text-center">
                        <button type="submit" id="btnRInsert" class="btn btn-success btn-block">Adicionar</button>
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

<div class="modal fade" id="modalAddDescuento">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Descuento</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <form id="addFacturaDescuento" action="{{ route('facturaelementos.store') }}" method="POST">
              @csrf
               <div class="row">
                  <input type="hidden" name="factura_id" value="{{ $factura->id }}" class="form-control">
                  <input type="hidden" name="tipo" value="2" class="form-control">
                  <div class="col-12">
                      <div class="form-group">
                          <strong>Motivo del descuento:</strong>*
                          <input type="text" name="descripcion" id="r_descripcion" class="form-control" placeholder="Descripción">
                      </div>
                  </div>
                  <input type="hidden" name="cantidad" value="1" id="r_cantidad" class="form-control" placeholder="Cantidad">

                  <div class="col-12">
                    <div class="form-group">
                        <strong>Importe *:</strong>
                        <input type="number" name="precio" id="r_precio" class="form-control" placeholder="Precio">
                    </div>
                  </div>
                  <input type="hidden" name="um" value="" id="um" class="form-control" placeholder="UM">

                  <div class="col-12 text-center">
                      <button type="submit" id="btnDInsert" class="btn btn-success btn-block">Adicionar</button>
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

<div class="modal fade" id="modalImportarSolicitud">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Seleccione una solicitud a facturar</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="importarSolicitud" action="{{ route('facturas.importar',$factura->id) }}" role="form" method="POST">
          @csrf
          @method('PUT')
           <div class="row">
            <div class="col-12">
              <div class="form-group">
                <strong>Solicitud:</strong>
                <select id="solicitud" class="form-control select2bs4" name="solicitud_id" style="width: 100%;">
                    <option value="" selected="selected" disabled hidden="hidden">Selecciona una solicitud a importar</option>
                    @foreach ($solicitudes as $solicitud)
                        <option value="{{$solicitud->id}}">{{$solicitud->numero}} {{ $solicitud->cliente}}</option>
                    @endforeach
                </select>
              </div>
            </div>
            <div class="col-12 text-center">
                  <button type="submit" id="btnImportar" class="btn btn-success btn-block">Importar datos</button>
            </div>
          </div>
      </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalEditproducto">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Editando Producto</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <form id="editFacturaElemento" action="{{ route('facturaelementos.editar') }}" method="POST">
                @csrf
                @method('PUT')
                 <div class="row">
                    <input type="hidden" name="factura_id" value="{{ $factura->id }}" class="form-control">
                    <input type="hidden" name="id" id="edit_facturaelemento_id">
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Descripción del producto *:</strong>
                            <input type="text" name="descripcion" id="edit_descripcion" class="form-control" placeholder="Descripción">
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
                          <strong>Precio *:</strong>
                          <input type="number" name="precio" id="edit_precio" class="form-control" placeholder="Precio">
                      </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>UM *:</strong>
                            <input type="text" name="um" id="edit_um" class="form-control" placeholder="UM">
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" id="btnEdit" class="btn btn-success btn-block">Editar</button>
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

<div class="modal fade" id="modalEditRD">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Editando Recargo-descuento</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <form id="editFacturaElementoRD" action="{{ route('facturaelementos.editar') }}" method="POST">
              @csrf
              @method('PUT')
               <div class="row">
                  <input type="hidden" name="factura_id" value="{{ $factura->id }}" class="form-control">
                  <input type="hidden" name="id" id="editrd_facturaelemento_id">
                  <div class="col-12">
                      <div class="form-group">
                          <strong>Motivo recargo/descuento *:</strong>
                          <input type="text" name="descripcion" id="editrd_descripcion" class="form-control" placeholder="Descripción">
                      </div>
                  </div>
                  <input type="hidden" name="cantidad" id="editrd_cantidad" class="form-control" placeholder="Cantidad">
                  <div class="col-12">
                    <div class="form-group">
                        <strong>Importe *:</strong>
                        <input type="number" name="precio" id="editrd_precio" class="form-control" placeholder="Precio">
                    </div>
                  </div>
                  <input type="hidden" name="um" id="editrd_um" class="form-control" placeholder="UM">
                  <div class="col-12 text-center">
                      <button type="submit" id="btnRDEdit" class="btn btn-success btn-block">Editar</button>
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
function refrescar_precio_cantidad_descripcion() {
    let valorbruto = $('#selectProductos option:selected').attr('valor');
    let descripcion = $('#selectProductos option:selected').val();
    $('#precio').val(valorbruto);
    $('#descripcion').val(descripcion);
}
$(document).on('click','.deleteFacturaElemento',function(){
    var analisisID=$(this).attr('data-id');
    $('#facturaelemento_id').val(analisisID);
    $('#deleteFacturaElementoModal').modal('show');
});

$(document).on('click','.addElemento',function(){
    $('#btnInsert').attr('disabled', false);
    $('#btnInsert').html('Insertar');
    $('#modaladdElemento').modal('show');
});

$(document).on('click','.importarSolicitud',function(){
    $('#btnImportar').attr('disabled', false);
    $('#btnImportar').html('Importar');
    $('#modalImportarSolicitud').modal('show');
});

$(document).on('click','.addRecargo',function(){
    $('#btnRInsert').attr('disabled', false);
    $('#btnRInsert').html('Insertar');
    $('#modalAddRecargo').modal('show');
});

$(document).on('click','.addDescuento',function(){
    $('#btnDInsert').attr('disabled', false);
    $('#btnDInsert').html('Insertar');
    $('#modalAddDescuento').modal('show');
});

$(document).on('click','.editFacturaElemento',function(){
    var analisisID = $(this).attr('data-id');
    var decripcion = $(this).attr('data-descripcion');
    var um = $(this).attr('data-um');
    var cantidad = $(this).attr('data-cantidad');
    var precio=$(this).attr('data-precio');
    $('#edit_facturaelemento_id').val(analisisID);
    $('#edit_descripcion').val(decripcion);
    $('#edit_um').val(um);
    $('#edit_cantidad').val(cantidad);
    $('#edit_precio').val(precio);
    $('#btnEdit').attr('disabled', false);
    $('#btnEdit').html('Actualizar');
    $('#modalEditproducto').modal('show');
});

$(document).on('click','.editFacturaRD',function(){
    var analisisID = $(this).attr('data-id');
    var decripcion = $(this).attr('data-descripcion');
    var um = $(this).attr('data-um');
    var cantidad = $(this).attr('data-cantidad');
    var precio=$(this).attr('data-precio');
    $('#editrd_facturaelemento_id').val(analisisID);
    $('#editrd_descripcion').val(decripcion);
    $('#editrd_um').val(um);
    $('#editrd_cantidad').val(cantidad);
    $('#editrd_precio').val(precio);
    $('#btnRDEdit').attr('disabled', false);
    $('#btnRDEdit').html('Actualizar');
    $('#modalEditRD').modal('show');
});
  $(document).ready(function () {
    $('#btnInsert').click(function () {
            $('#btnInsert').attr('disabled', true);
            $('#btnInsert').html('Insertando...');
            $('#addFacturaElemento').submit();
            return true;
    });
    $('#btnRInsert').click(function () {
            $('#btnRInsert').attr('disabled', true);
            $('#btnRInsert').html('Insertando...');
            $('#addFacturaRecargo').submit();
            return true;
    });
    $('#btnDInsert').click(function () {
            $('#btnDInsert').attr('disabled', true);
            $('#btnDInsert').html('Insertando...');
            $('#addFacturaDescuento').submit();
            return true;
    });
    $('#btnEdit').click(function () {
            $('#btnEdit').attr('disabled', true);
            $('#btnEdit').html('Actualizando...');
            $('#editFacturaElemento').submit();
            return true;
    });
    $('#btnRDEdit').click(function () {
            $('#btnRDEdit').attr('disabled', true);
            $('#btnRDEdit').html('Actualizando...');
            $('#editFacturaElementoRD').submit();
            return true;
    });
    $('#addFacturaElemento').validate({
      rules: {
        descripcion: {
          required : true,
        },
        cantidad: {
          required: true,
        },
        precio: {
          required: true,
        },
        um: {
          required: true,
        },
      },
      messages: {
        descripcion: {
          required : "Inserte una descripción de renglón o elija un producto",
        },
        cantidad: {
          required: "Inserte la cantidad",
        },
        precio: {
          required: "Inserte el precio",
        },
        um: {
          required: "Inserte la UM",
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
    $('#editFacturaElemento').validate({
        rules: {
        descripcion: {
          required : true,
        },
        cantidad: {
          required: true,
        },
        precio: {
          required: true,
        },
        um: {
          required: true,
        },
      },
      messages: {
        descripcion: {
          required : "Inserte una descripción de renglón",
        },
        cantidad: {
          required: "Inserte la cantidad",
        },
        precio: {
          required: "Inserte el precio",
        },
        um: {
          required: "Inserte la UM",
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
    $('#editFacturaElementoRD').validate({
        rules: {
        descripcion: {
          required : true,
        },
        precio: {
          required: true,
        },
      },
      messages: {
        descripcion: {
          required : "Inserte el motivo del recargo o escuento",
        },
        precio: {
          required: "Inserte el Importe",
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
    $('#addFacturaRecargo').validate({
        rules: {
        descripcion: {
          required : true,
        },
        precio: {
          required: true,
        },
      },
      messages: {
        descripcion: {
          required : "Inserte el motivo del recargo",
        },
        precio: {
          required: "Inserte el importe",
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
    $('#addFacturaDescuento').validate({
        rules: {
        descripcion: {
          required : true,
        },
        precio: {
          required: true,
        },
      },
      messages: {
        descripcion: {
          required : "Inserte el motivo del descuento",
        },
        precio: {
          required: "Inserte el importe",
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
    $('#formUpdate').validate({
      rules: {
        cliente: {
          required: true
        },
        fechasolicitud:{
            required: true
        },
        descripcion:{
            required: true
        }
      },
      messages: {
        cliente: {
          required: "Inserte un cliente"
        },
        fechasolicitud:{
            required: "Seleccione una fecha"
        },
        descripcion:{
            required: "Debe insertar una descripción"
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
    $('#tablaFacturaElementos').DataTable({
        "responsive": true,
      "autoWidth": false,
    });
  });

</script>
@endsection
