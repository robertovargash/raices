@extends('layouts.main')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="col-lg-12 margin-tb">
            <div class="pull-left">
              <h2>Datos del producto</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('tproductos.index') }}"> Atrás</a>
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
              <h3 class="card-title">Generales del producto</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                  <form role="form" id="tproductoData" action="{{ route('tproductos.update',$tproducto->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-12">
                        <div class="form-group">
                          <strong>En oferta:</strong>
                          <select id="disponible" class="form-control" name="disponible">
                              <option value="1" {{ $tproducto->disponible == 1 ? ' selected ' : '' }}>Disponible</option>
                              <option value="0" {{ $tproducto->disponible == 0 ? ' selected ' : '' }}>No disponible</option>
                          </select>
                        </div>
                    </div>
                    <div class="col-12">
                      <div class="form-group">
                          <strong>Nombre (*):</strong>
                          <input type="text" name="nombre" value="{{ $tproducto->nombre }}" id="idNombreProducto" class="form-control" placeholder="Nombre">
                      </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Valor bruto:</strong>
                            <input type="number" value="{{ $tproducto->valorbruto }}" name="valorbruto" class="form-control" placeholder="Valor bruto">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Valor referencia:</strong>
                            <input readonly type="number" value="{{ $valor }}" class="form-control" placeholder="Valor referencia">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Valor mano obra:</strong>
                            <input type="number" value="{{ $tproducto->preciomanoobra }}" name="preciomanoobra" class="form-control" placeholder="Valor m. obra">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                          <strong>Tipo:</strong>
                          <select id="tipo" class="form-control select2bs4" name="tipotproducto_id" style="width: 100%;">
                              <option value="" selected="selected" hidden="hidden">Selecciona tipo de producto</option>
                              @foreach ($tipotproductos as $tipo)
                                  <option value="{{$tipo->id}}" {{ $tproducto->tipotproducto_id == $tipo->id ? ' selected ' : '' }}>{{$tipo->tipo}}</option>
                              @endforeach
                          </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Descripción:</strong>
                            <textarea class="form-control" style="height:150px" name="descripcion" placeholder="Descripción">{{ $tproducto->descripcion }}</textarea>
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
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Materias primas del producto</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="pull-left mb-2">
                  @can('gestion_productos')
                    <button type="button" class="btn btn-info addProducto">Adicionar</button>
                  @endcan
              </div>
              <table id="tablaMateriasPrimas" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Mat. prima</th>
                    <th>Cant. necesaria</th>
                    <th>Precio Temp.</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($tproducto->materiaprimas as $mprima)
                  <tr>
                    <td>{{ $mprima->mercancia->nombremercancia }}</td>
                    <td>{{ $mprima->cantidadnecesaria }}</td>
                    <td>{{ $mprima->mercancia->precio }}</td>
                    <td>
                        @can('gestion_productos')
                            <a class="btn btn-link text-primary editMateriaPrima" data-id="{{$mprima->id}}"
                                data-cantidad="{{ $mprima->cantidadnecesaria }}"
                                data-mercancia="{{ $mprima->mercancia->nombremercancia }}"
                                data-prod_id="{{ $mprima->mercancia->id }}"><b>Editar</b></a>
                            <a class="btn btn-link text-danger deleteMateriaPrima" data-id="{{$mprima->id}}"><b>Eliminar</b></a>
                        @endcan
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>Mat. prima</th>
                    <th>Cant. necesaria</th>
                    <th>Precio Temp.</th>
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
          <form action="{{route('materiaprimas.destroy')}}" method="POST">
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
<div class="modal fade" id="modalAddMateriaPrima">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Materia prima del producto</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <form action="{{ route('materiaprimas.store') }}" id="materiaprimaData" method="POST">
                @csrf
                 <div class="row">
                    <input type="hidden" name="tproducto_id" value="{{ $tproducto->id }}" class="form-control"/>
                    <div class="col-12">
                     <div class="form-group">
                        <strong for="my-select2">Materia prima (mercancía):</strong>
                        <select id="idselectProducto" class="form-control select2bs4" name="mercancia_id" onchange="colocar_precio()" style="width: 100%;">
                            <option value="" selected="selected" hidden="hidden">Selecciona mercancía</option>
                            @foreach ($mercancias as $mercancia)
                                <option value="{{$mercancia->mercancia->id}}" precio="{{$mercancia->precio}}">{{$mercancia->mercancia->codigo}} | {{$mercancia->mercancia->nombremercancia}} | {{$mercancia->mercancia->um}} | {{$mercancia->mercancia->clasificacion->clasificacion}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Cantidad necesaria *:</strong>
                            <input type="number" name="cantidadnecesaria" id="cantidadnecesaria" class="form-control" placeholder="Cantidad necesaria">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Cantidad en UM mínima:</strong>
                            <input type="number" id="cantidadgramos" class="form-control" placeholder="Cantidad convertida" onkeyup="dividir_por_mil()" onblur="dividir_por_mil()">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Convertidor a dividir:</strong>
                            <input type="number" id="convertidor" class="form-control" placeholder="Convertidor" value="1000" onkeyup="dividir_por_mil()" onblur="dividir_por_mil()">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" id="bntInsertar" class="btn btn-success btn-block">Insertar</button>
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

<div class="modal fade" id="modalEditMateriaPrima">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Materia prima del producto</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <form action="{{ route('materiaprimas.editar') }}" id="materiaprimaEditData" method="POST">
                @csrf
                @method('PUT')
                 <div class="row">
                    <input type="hidden" name="id" id="edit_mprima_id" class="form-control"/>
                    <input type="hidden" name="tproducto_id" value="{{ $tproducto->id }}" class="form-control"/>
                    <input type="hidden" name="mercancia_id" id="edit_mercancia_id" class="form-control"/>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Materia prima (Mercancía):</strong>
                            <input type="text" readonly id="edit_materiaprima" class="form-control" placeholder="Materia prima">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Cantidad necesaria *:</strong>
                            <input type="number" name="cantidadnecesaria" id="edit_cantidadnecesaria" step=".000001" class="form-control" placeholder="Cantidad necesaria">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Cantidad en UM mínima:</strong>
                            <input type="number" id="edit_cantidadgramos" class="form-control" step=".000001" placeholder="Cantidad convertida" onkeyup="edit_dividir_por_mil()" onblur="edit_dividir_por_mil()">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Convertidor a dividir:</strong>
                            <input type="number" id="edit_convertidor" class="form-control" placeholder="Convertidor" value="1000" onkeyup="edit_dividir_por_mil()" onblur="edit_dividir_por_mil()">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" id="btnEditar" class="btn btn-success btn-block">Editar</button>
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

function dividir_por_mil(){
  let gramos =$("#cantidadgramos").val();
  let convertir = $("#convertidor").val();
  $("#cantidadnecesaria").val(parseFloat(gramos/convertir).toFixed(6));
  console.log(gramos/convertir)
}

function edit_dividir_por_mil(){
  let gramos =$("#edit_cantidadgramos").val();
  let convertir = $("#edit_convertidor").val();
  $("#edit_cantidadnecesaria").val(parseFloat(gramos/convertir).toFixed(6));
  console.log(gramos/convertir)
}

function colocar_precio(){
  let precio =$("#idselectProducto option:selected").attr("precio");
  $("#preciotemp").val(precio);
  $("#cantidadgramos").val(0);
  $("#convertidor").val(1000);
  $("#cantidadnecesaria").val(0);
}

$(document).on('click','.addProducto',function(){
    $('#bntInsertar').attr('disabled', false);
    $('#bntInsertar').html('Insertar');
    $('#modalAddMateriaPrima').modal('show');
});

$(document).on('click','.editMateriaPrima',function(){
    var id = $(this).attr('data-id');
    var mercancia_id = $(this).attr('data-prod_id');
    var mercancia = $(this).attr('data-mercancia');
    var cantidad = $(this).attr('data-cantidad');
    $('#edit_mprima_id').val(id);
    $('#edit_mercancia_id').val(mercancia_id);
    $('#edit_materiaprima').val(mercancia);
    $('#edit_cantidadnecesaria').val(parseFloat(cantidad).toFixed(6));
    $('#edit_cantidadgramos').val(parseFloat(cantidad * 1000).toFixed(6));
    $('#edit_convertidor').val(1000);
    $('#modalEditMateriaPrima').modal('show');
});

$(document).on('click','.deleteMateriaPrima',function(){
    var analisisID=$(this).attr('data-id');
    $('#materiaprima_id').val(analisisID);
    $('#deleteMateriaPrimaModal').modal('show');
});

  $(document).ready(function () {
    $('#bntInsertar').click(function () {
            $('#bntInsertar').attr('disabled', true);
            $('#bntInsertar').html('Insertando...');
            $('#materiaprimaData').submit();
            return true;
    });
    $('#tproductoData').validate({
      rules: {
        nombre: {
          required: true
        },
        valorbruto:{
            required: true
        },
        tipotproducto_id:{
            required: true
        },
        descripcion:{
            required: true
        }
      },
      messages: {
        nombre: {
          required: "Inserta un nombre para el producto"
        },
        valorbruto:{
            required: "Debe tener un valor, al menos 0"
        },
        tipotproducto_id:{
            required: "Selecciona el tipo de producto al que pertenece"
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
    $('#materiaprimaData').validate({
      rules: {
        producto_id: {
          required: true,
        },
        cantidadnecesaria: {
          required: true,
        },
        preciotemp: {
          required: true
        }
      },
      messages: {
        producto_id: {
          required: "Seleccione materia prima o mercancía",
        },
        cantidadnecesaria: {
          required: "Inserte la cantidad necesaria",
        },
        preciotemp: {
          required: "Incluya el precio del material"
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
    $('#tablaMateriasPrimas').DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });

</script>
@endsection
