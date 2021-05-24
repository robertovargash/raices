@extends('layouts.main')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="col-lg-12 margin-tb">
            <div class="pull-left">
              <h2>Datos recepción No. {{ $recepcion->numero }}</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('almacens.edit',$recepcion->almacen) }}"> Atrás</a>
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
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Datos recepción No. {{ $recepcion->numero }}</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                  <form role="form" id="recepcionData" action="{{ route('recepcions.update',$recepcion->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <input type="hidden" name="activo" value="0" class="form-control">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                          <div class="form-group">
                            <strong>Fecha: </strong>
                            {{ date('d/m/Y', strtotime($recepcion->fecha)) }}
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="form-group">
                              <strong>Factura ref. *:</strong>
                              <input type="text" name="factura" value="{{ $recepcion->factura }}" class="form-control" placeholder="Factura">
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="form-group">
                              <strong>Proveedor ref. *:</strong>
                              <input type="text" name="proveedor" value="{{ $recepcion->proveedor }}" class="form-control" placeholder="Proveedor">
                          </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <strong>Recibe (*):</strong>
                                <input type="text" name="p_recibe" value="{{ $recepcion->p_recibe }}" id="idp_recibe" class="form-control" placeholder="Recibe">
                            </div>
                          </div>
                          <div class="col-12">
                            <div class="form-group">
                                <strong>Entrega (*):</strong>
                                <input type="text" name="p_entrega" value="{{ $recepcion->p_entrega }}" id="idp_entrega" class="form-control" placeholder="Entrega">
                            </div>
                          </div>
                          <div class="col-12">
                            <div class="form-group">
                                <strong>Autoriza:</strong>
                                <input type="text" readonly name="p_autoriza" value="{{ $recepcion->p_autoriza }}" id="idp_autoriza" class="form-control" placeholder="Autoriza">
                            </div>
                          </div>
                        <div class="col-12">
                            <div class="form-group">
                                <strong>Observaciones:</strong>
                                <textarea class="form-control" style="height:150px" name="observaciones" placeholder="Observaciones">{{ $recepcion->observaciones }}</textarea>
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
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Mercancías recepcionadas</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
                <div class="pull-left mb-2">
                    @can('gestion_recepcion')
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalAddRecepcionproducto">Adicionar</button>
                    @endcan
                </div>
              <table id="tablaRecepcionmercancia" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Código</th>
                    <th>Mercancía</th>
                    <th>UM</th>
                    <th>Cantidad</th>
                    <th>Precio compra</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($recepcion->recepcionmercancias as $recepcionmercancia)
                  <tr>
                    <td>{{ $recepcionmercancia->mercancia->codigo }}</td>
                    <td>{{ $recepcionmercancia->mercancia->nombremercancia }}</td>
                    <td>{{ $recepcionmercancia->mercancia->um }}</td>
                    <td>{{ $recepcionmercancia->cantidad }}</td>
                    <td>{{ $recepcionmercancia->precio}} </td>
                    <td>
                        @can('gestion_recepcion')
                            <a class="btn btn-link editRecepcionProducto text-primary" data-id="{{$recepcionmercancia->id}}" data-cantidad="{{$recepcionmercancia->cantidad}}" data-precio="{{$recepcionmercancia->precio}}">Editar</a>
                            <a class="btn btn-link deleteRecepcionProducto text-danger" data-id="{{$recepcionmercancia->id}}">Eliminar</a>
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
                    <th>Precio compra</th>
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

<div class="modal fade" aria-modal="false" id="deleteRecepcionProductoModal">
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
        <form action="{{route('recepcionmercancias.destroy')}}" method="POST">
          @csrf
          @method('DELETE')
          <input type="hidden", name="id" id="rproducto_id">
          <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>



<div class="modal fade" id="modalAddRecepcionproducto">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Mercancía de recepción</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <form id="recepcionMercanciaData" action="{{ route('recepcionmercancias.store') }}" method="POST">
              @csrf
               <div class="row">
                <div class="col-12">
                  <div class="form-group">
                      <input type="hidden" name="recepcion_id" value="{{ $recepcion->id }}" class="form-control">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <strong for="my-select2">Mercancía:</strong>
                    <select id="idselect2" class="form-control select2bs4" name="mercancia_id" style="width: 100%;">
                        <option value="" selected="selected" hidden="hidden">Selecciona mercancía</option>
                        @foreach ($mercancias as $mercancia)
                            <option value="{{$mercancia->id}}">{{$mercancia->codigo}} | {{$mercancia->nombremercancia}} | {{$mercancia->um}} | {{$mercancia->clasificacion->clasificacion}}</option>
                        @endforeach
                    </select>
                  </div>
                  </div>
                  <div class="col-12">
                      <div class="form-group">
                          <strong>Cantidad *:</strong>
                          <input type="number" name="cantidad" class="form-control" placeholder="Cantidad">
                      </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                        <strong>Precio *:</strong>
                        <input type="number" name="precio" class="form-control" placeholder="Precio">
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                          <button type="submit" class="btn btn-primary">Insertar</button>
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

<div class="modal fade" id="modalEditRecepcionproducto">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Mercancía de recepción</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <form id="recepcionMercanciaData1" action="{{ route('recepcionmercancias.update') }}" method="POST">
                @csrf
                @method('PUT')
                 <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <input type="hidden" name="id" id="id" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                            <div class="form-group">
                                <strong>Cantidad *:</strong>
                                <input type="number" name="cantidad" id="cantidad" step=0.000001 class="form-control" placeholder="Cantidad">
                            </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Precio *:</strong>
                            <input type="number" name="precio" id="precio" step=0.000001 class="form-control" placeholder="Precio">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-success">Actualizar</button>
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
$(document).on('click','.editRecepcionProducto',function(){
    var id=$(this).attr('data-id');
    var cantidad=$(this).attr('data-cantidad');
    var precio=$(this).attr('data-precio');
    $('#id').val(id);
    $('#modalEditRecepcionproducto').modal('show');
    $('#cantidad').val(cantidad);
    $('#precio').val(precio);
});

$(document).on('click','.deleteRecepcionProducto',function(){
    var analisisID=$(this).attr('data-id');
    $('#rproducto_id').val(analisisID);
    $('#deleteRecepcionProductoModal').modal('show');
});

  $(document).ready(function () {
    function elmenor(){
      return 0;
    };
    $('#recepcionData').validate({
      rules: {
        factura: {
          required: true,
          maxlength: 50,
        },
        proveedor: {
          required: true,
          maxlength: 250,
        },
        p_recibe: {
          required: true,
          maxlength: 250,
        },
        p_entrega: {
          required: true,
          maxlength: 250,
        },
        fecha: {
          required: true,
        },
        observaciones: {
          required: true,
        },
      },
      messages: {
        factura: {
          required: "Debe insertar el numero de factura como referencia",
          maxlength: "Máximo 50 caracteres",
        },
        proveedor: {
          required: "Debe insertar el proveedor como referencia",
          maxlength: "Máximo 250 caracteres",
        },
        p_recibe: {
          required: "Debe insertar la persona que recibe",
          maxlength: "Máximo 250 caracteres",
        },
        p_entrega: {
          required: "Debe insertar la persona que entrega",
          maxlength: "Máximo 250 caracteres",
        },
        fecha: {
          required: "Seleccione una fecha",
        },
        observaciones: {
          required: "Escriba un comentario",
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
    $('#recepcionMercanciaData').validate({
      rules: {
        mercancia_id: {
          required: true,
        },
        cantidad: {
          required: true,
          min:elmenor,
        },
        precio: {
          required: true,
          min:elmenor,
        },
      },
      messages: {
        mercancia_id: {
          required: "Escoja una mercancía",
        },
        cantidad: {
          required: "Debe insertar la cantidad de la mercancía",
          min: "El valor debe ser mayor o igual a 0",
        },
        precio: {
          required: "Debe insertar el precio de la mercancía",
          min: "El valor debe ser mayor o igual a 0",
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
    $('#tablaRecepcionmercancia').DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
  </script>
@endsection
