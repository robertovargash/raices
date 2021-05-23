@extends('layouts.main')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="col-lg-12 margin-tb">
            <div class="pull-left">
              <h2>Datos del vale No. {{ $vale->numero }}</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-warning" href="{{ route('almacens.edit',$vale->almacen) }}"> Atrás</a>
            </div>
          </div>
        </div>
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
      </div>
    </div><!-- /.container-fluid -->
  </div>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card card-warning">
            <div class="card-header">
              <h3 class="card-title">Datos del vale No. {{ $vale->numero }}</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                  <form role="form" id="valeData" action="{{ route('vales.update',$vale->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <strong for="my-select2-2">Tipo de vale:</strong>
                                @if ($vale->tipovale == 0)
                                    Vale para Gastos
                                @else
                                    Vale de Órden de Trabajo
                                @endif
                              </div>
                        </div>
                        @if ($vale->tipovale == 1)
                        <div class="col-12">
                            <div class="form-group">
                              <strong>Órden de trabajo:</strong> {{ $vale->ordentrabajo_id }} ({{ $vale->ordentrabajo->cantidad }} {{ $vale->ordentrabajo->tproducto->nombre }})
                            </div>
                        </div>
                        @endif
                        <input type="hidden" name="activo" value="0" class="form-control">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <strong>Fecha:</strong>
                                {{ date('d/m/Y', strtotime($vale->fecha)) }}
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <strong>Entrega (*):</strong>
                                <input type="text" name="p_entrega" value="{{ $vale->p_entrega }}" id="idp_entrega" class="form-control" placeholder="Entrega">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <strong>Solicita (*):</strong>
                                <input type="text" name="p_solicita" value="{{ $vale->p_solicita }}" id="idp_solicita" class="form-control" placeholder="Solicita">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <strong>Autoriza:</strong>
                                <input type="text" readonly name="p_autoriza" value="{{ $vale->p_autoriza }}" id="idp_autoriza" class="form-control" placeholder="Autoriza">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <strong>Observaciones:</strong>
                                <textarea class="form-control" style="height:150px" name="observaciones" placeholder="Observaciones">{{ $vale->observaciones }}</textarea>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-success btn-block">Actualizar</button>
                        </div>
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
          <div class="card card-warning">
            <div class="card-header">
              <h3 class="card-title">Mercancías del vale</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
                <div class="pull-left mb-2">
                    @can('gestion_vale')
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalAddValeMercancia">Adicionar</button>
                    @endcan
                </div>
              <table id="tablavalemercancia" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Código</th>
                    <th>Mercancía</th>
                    <th>UM</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($vale->valeitems as $valeitem)
                  <tr>
                    <td>{{ $valeitem->mercancia->codigo }}</td>
                    <td>{{ $valeitem->mercancia->nombremercancia }}</td>
                    <td>{{ $valeitem->mercancia->um }}</td>
                    <td>{{ $valeitem->cantidad }}</td>
                    <td>{{ $valeitem->mercancia->precio}} </td>
                    <td>
                        @can('gestion_vale')
                            <a class="btn btn-link editValeitem text-primary"
                            data-id="{{$valeitem->id}}"
                            item-nombre="{{$valeitem->mercancia->nombremercancia}}"
                            item-cantidad="{{$valeitem->cantidad}}"
                            item-mercid="{{$valeitem->mercancia_id}}"
                            item-mercprecio="{{$valeitem->mercancia->precio}}"
                            @foreach ($mercancias as $mercancia)
                                @if ($mercancia->id == $valeitem->mercancia_id)
                                    item-cantidadmax="{{$mercancia->cantidad + $valeitem->cantidad}}"
                                @endif
                            @endforeach
                            ><b>Editar</b></a>
                            <a class="btn btn-link deleteValeitem text-danger" data-id="{{$valeitem->id}}"><b>Eliminar</b></a>
                        @endcan
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>Código</th>
                    <th>Mercancía</th>
                    <th>UM</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
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

<div class="modal fade" aria-modal="false" id="deleteValeitemModal">
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
        <form action="{{route('valeitems.destroy')}}" method="POST">
          @csrf
          @method('DELETE')
          <input type="hidden", name="id" id="valeitem_id">
          <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalAddValeMercancia">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Mercancía del vale</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <form id="valeMercanciaData" action="{{ route('valeitems.store') }}" method="POST">
              @csrf
               <div class="row">
                <div class="col-12">
                  <div class="form-group">
                      <input type="hidden" name="vale_id" value="{{ $vale->id }}" class="form-control">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <strong for="my-select2">Mercancía:</strong>
                    <select id="idselectmercancia" class="form-control select2bs4" name="mercancia_id" onchange="colocar_precio()">
                        <option value="" selected="selected" hidden="hidden">Selecciona mercancía</option>
                        @foreach ($mercancias as $mercancia)
                            @if ($mercancia->existe == 0)
                            <option precio="{{ $mercancia->mercancia->precio }}" cantidad="{{ $mercancia->cantidad }}" value="{{$mercancia->mercancia->id}}">{{$mercancia->mercancia->codigo}} | {{$mercancia->mercancia->nombremercancia}} | {{$mercancia->mercancia->um}} | {{$mercancia->mercancia->clasificacion->clasificacion}}</option>
                            @endif
                        @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-12">
                      <div class="form-group">
                          <strong>Cantidad *:</strong>
                          <input type="number" id="cantidad" name="cantidad" class="form-control" placeholder="Cantidad">
                      </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Cantidad en almacén:</strong>
                        <input type="number" id="cantidadmax" readonly class="form-control" placeholder="Cantidad">
                    </div>
              </div>
                <div class="col-12">
                    <div class="form-group">
                        <strong>Precio *:</strong>
                        <input type="number" name="precio" id="precio" class="form-control" placeholder="Precio" readonly>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" id="btnInsert" class="btn btn-success btn-block">Insertar</button>
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

<div class="modal fade" id="modalEditValeMercancia">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Mercancía del vale</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <form id="valeEditMercanciaData" action="{{ route('valeitems.editar') }}" method="POST">
                @csrf
                @method('PUT')
                 <div class="row">
                    <input type="hidden" name="id" id="edit_valeitem_id" class="form-control">
                    <input type="hidden" name="vale_id" value="{{ $vale->id }}" class="form-control">
                    <input type="hidden" name="mercancia_id" id="edit_mercancia_id" class="form-control">
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Mercancía *:</strong>
                            <input type="text" id="edit_mercancia" readonly class="form-control" placeholder="Mercancía">
                        </div>
                  </div>
                  <div class="col-12">
                        <div class="form-group">
                            <strong>Cantidad *:</strong>
                            <input type="number" id="edit_cantidad" name="cantidad" class="form-control" placeholder="Cantidad">
                        </div>
                  </div>
                  <div class="col-12">
                      <div class="form-group">
                          <strong>Cantidad en almacén:</strong>
                          <input type="number" id="edit_cantidadmax" readonly class="form-control" placeholder="Cantidad">
                      </div>
                </div>
                  <div class="col-12">
                      <div class="form-group">
                          <strong>Precio *:</strong>
                          <input type="number" name="precio" id="edit_precio" class="form-control" placeholder="Precio" readonly>
                      </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                      <button type="submit" class="btn btn-success btn-block">Editar</button>
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
function colocar_precio(){
  let precio =$("#idselectmercancia option:selected").attr("precio");
  let cantidad =$("#idselectmercancia option:selected").attr("cantidad");
  $("#precio").val(precio);
  $("#cantidad").val(cantidad);
  $("#cantidadmax").val(cantidad);
}

$(document).on('click','.deleteValeitem',function(){
    var analisisID=$(this).attr('data-id');
    $('#valeitem_id').val(analisisID);
    $('#deleteValeitemModal').modal('show');
});

$(document).on('click','.editValeitem',function(){
    var valeitem_id=$(this).attr('data-id');
    var valei_mercanciaid=$(this).attr('item-mercid');
    var valei_mercancia=$(this).attr('item-nombre');
    var valei_cantidad=$(this).attr('item-cantidad');
    var valei_cantmax=$(this).attr('item-cantidadmax');
    var valei_precio=$(this).attr('item-mercprecio');
    $('#edit_valeitem_id').val(valeitem_id);
    $('#edit_mercancia_id').val(valei_mercanciaid);
    $('#edit_mercancia').val(valei_mercancia);
    $('#edit_cantidad').val(valei_cantidad);
    $('#edit_cantidadmax').val(valei_cantmax);
    $('#edit_precio').val(valei_precio);
    $('#modalEditValeMercancia').modal('show');
});

  $(document).ready(function () {
    $('#btnInsert').click(function () {
            $('#btnInsert').attr('disabled', true);
            $('#btnInsert').html('Insertando...');
            $('#valeMercanciaData').submit();
            return true;
        });
    $('#valeData').validate({
      rules: {
        p_solicita: {
          required: true,
        },
        p_entrega: {
          required: true,
        },
        fecha: {
          required: true,
        },
      },
      messages: {
        p_solicita: {
          required: "Debe insertar la persona que solicita",
        },
        p_entrega: {
          required: "Debe insertar la persona que entrega",
        },
        fecha: {
          required: "Seleccione una fecha",
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
    $('#valeMercanciaData').validate({
      rules: {
        producto_id: {
          required: true,
        },
        cantidad: {
          required: true,
          max: function() {
                return parseFloat($("#cantidadmax").val());
            },
          min:function() {
            return 0;
            },
        },
        precio: {
          required: true,
        },
      },
      messages: {
        producto_id: {
          required: "Escoja una mercancía",
        },
         cantidad: {
           required: "Debe insertar la cantidad de la mercancía",
           max: "la cantidad a insertar debe ser menor a la existente (existente:{0})",
           min: "la cantidad debe ser mayor o igual a 0",
         },
        precio: {
          required: "Debe insertar el precio de la mercancía",
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
    $('#valeEditMercanciaData').validate({
      rules: {
        cantidad: {
          required: true,
          max: function() {
                return parseFloat($("#edit_cantidadmax").val());
            },
          min:function() {
            return 0;
            },
        },
        precio: {
          required: true,
        },
      },
      messages: {
        producto_id: {
          required: "Escoja una mercancía",
        },
         cantidad: {
           required: "Debe insertar la cantidad de la mercancía",
           max: "la cantidad a insertar debe ser menor a la existente (existente:{0})",
           min: "la cantidad debe ser mayor o igual a 0",
         },
        precio: {
          required: "Debe insertar el precio de la mercancía",
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
    $('#tablavalemercancia').DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
  </script>
@endsection
