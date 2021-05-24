@extends('layouts.main')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="col-lg-12 margin-tb">
            <div class="pull-left">
              <h2>Datos almacén</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('almacens.index') }}"> Atrás</a>
                <a class="btn btn-link text-info" href="#cardRecepciones">Ir a Recepciones</a>
                <a class="btn btn-link text-info" href="#cardVales">Ir a Vales</a>
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
              <h3 class="card-title">Datos almacén</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                  <form role="form" id="almacenData" action="{{ route('almacens.update',$almacen->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-12">
                      <div class="form-group">
                          <strong>Almacén (*):</strong>
                          <input type="text" name="almacen" value="{{ $almacen->almacen }}" id="idNombreAlmacen" class="form-control" placeholder="Almacén">
                      </div>
                  </div>
                  <div class="col-12">
                      <div class="form-group">
                          <strong>Descripción:</strong>
                          <textarea class="form-control" style="height:150px" name="descripcion" placeholder="Descripción">{{ $almacen->descripcion }}</textarea>
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
          <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Mercancía en almacén</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <table id="tablaExistencia" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Código</th>
                    <th>Mercancía</th>
                    <th>UM</th>
                    <th>Existencia</th>
                    <th>Precio Prom.</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($almacen->almacenmercancias as $mercancia)
                  <tr>
                    <td>{{ $mercancia->mercancia->codigo }}</td>
                    <td>{{ $mercancia->mercancia->nombremercancia }}</td>
                    <td>{{ $mercancia->mercancia->um }}</td>
                    <td>{{ $mercancia->cantidad }}</td>
                    <td>{{ $mercancia->mercancia->precio}} </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>Código</th>
                    <th>Mercancía</th>
                    <th>UM</th>
                    <th>Existencia</th>
                    <th>Precio Prom.</th>
                  </tr>
                </tfoot>
            </table>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Recepciones del almacén</h3>
              <div class="card-tools">
                <button id="cardRecepciones" type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="pull-left mb-2">
                {{-- <a class="btn btn-success" href="{{ route('recepciones.create') }}"> Adicionar</a> --}}
                @can('gestion_recepcion')
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalAddRecepcion">Adicionar</button>
                @endcan
              </div>
              <table id="tablaRecepciones" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Estado</th>
                    <th>Recibido</th>
                    <th>Entregado</th>
                    <th>Fecha</th>
                    <th>Observaciones</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($almacen->recepciones as $recepcion)
                  <tr>
                    <td>{{ $recepcion->numero }}</td>
                    <td>
                        @switch($recepcion->activo)
                            @case(0)
                                <b>Proceso</b>
                                @break
                            @case(1)
                                <b class="text-success">Fimada</b>
                                @break
                            @default
                                <b class="text-danger">Cancelada</b>
                        @endswitch
                    </td>
                    <td>{{ $recepcion->p_recibe }}</td>
                    <td>{{ $recepcion->p_entrega}} </td>
                    <td>{{ date('d/m/Y', strtotime($recepcion->fecha)) }}</td>
                    <td>{{ $recepcion->observaciones }}</td>
                    <td>
                        <div class="d-inline">
                            <a href="{{ route('recepcions.show',$recepcion) }}" class="btn btn-link text-info">Detalles</a>
                            @can('gestion_recepcion')
                                <a href="{{ route('recepcions.edit',$recepcion) }}" class="btn btn-link text-primary" {{ $recepcion->activo != 0 ? 'hidden' : 'enabled'}}>{{-- <span class="fas fa-pencil-alt"> --}}Editar</a>
                                <a class="btn btn-link deleteRecepcion text-danger" {{ $recepcion->activo != 0 ? 'hidden' : 'enabled'}} data-recepcion_id="{{$recepcion->id}}">Cancelar</a>
                            @endcan
                            @can('firma_recepcion')
                                <a class="btn btn-link firmarRecepcion text-success" {{ $recepcion->activo != 0 ? 'hidden' : ''}} data-recepcion_id="{{$recepcion->id}}">Firmar</a>
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
                    <th>Recibido</th>
                    <th>Entregado</th>
                    <th>Fecha</th>
                    <th>Observaciones</th>
                    <th></th>
                  </tr>
                </tfoot>
            </table>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card card-warning">
            <div class="card-header">
              <h3 class="card-title">Vales de salida del almacén</h3>
              <div class="card-tools">
                <button type="button" id="cardVales" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="pull-left mb-2">
                  @can('gestion_vale')
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalAddvale">Adicionar</button>
                  @endcan
              </div>
              <table id="tablaVales" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Estado</th>
                    <th>Solicita</th>
                    <th>Entrega</th>
                    <th>Fecha</th>
                    <th>Observaciones</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($almacen->vales as $vale)
                  <tr>
                    <td>{{ $vale->numero }}</td>
                    <td>
                        @switch($vale->activo)
                            @case(0)
                                <b>Proceso</b>
                                @break
                            @case(1)
                                <b class="text-success">Firmado</b>
                                @break
                            @default
                                <b class="text-danger">Cancelado</b>
                        @endswitch
                    </td>
                    <td>{{ $vale->p_solicita }}</td>
                    <td>{{ $vale->p_entrega}} </td>
                    <td>{{ date('d/m/Y', strtotime($vale->fecha)) }}</td>
                    <td>{{ $vale->observaciones }}</td>
                    <td>
                        <a href="{{ route('vales.show',$vale) }}" class="btn btn-link text-info ">Detalles</a>
                        <a href="{{ route('vales.imprimir',$vale) }}" class="btn btn-link text-info ">Imprimir</a>
                        @can('gestion_vale')
                            <a href="{{ route('vales.edit',$vale) }}" class="btn btn-link text-primary " {{ $vale->activo != 0 ? 'hidden' : ''}}>Editar</a>
                            <a class="btn btn-link deleteVale text-danger " {{ $vale->activo != 0 ? 'hidden' : ''}} data-vale_id="{{$vale->id}}">Cancelar</a>
                        @endcan
                        @can('firma_vale')
                            <a class="btn btn-link firmarVale text-success " {{ $vale->activo != 0 ? 'hidden' : ''}} data-vale_id="{{$vale->id}}">Firmar</a>
                        @endcan
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Estado</th>
                    <th>Solicita</th>
                    <th>Entrega</th>
                    <th>Fecha</th>
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
  </div>
</div>
<div class="modal fade" aria-modal="false" id="deleteRecepcionModal">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirmación</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="modal-deleterecepcion-body"></p>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <form action="{{route('recepcions.cancelar')}}" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden", name="id" id="recepcion_id">
          <button type="submit" class="btn btn-danger">Si, cancelar</button>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" aria-modal="false" id="deleteValeModal">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modal-delete-title">Confirmación</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="modal-deletevale-body"></p>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        <form action="{{route('vales.cancelar')}}" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden", name="id" id="vale_id">
          <button type="submit" class="btn btn-danger btn-md">Si, cancelar</button>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" aria-modal="false" id="firmarRecepcionModal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirmación</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <p id="modal-firmarrecepcion-body"></p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <form action="{{route('recepcions.firmar')}}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden", name="id" id="recepcionn_id">
            <button type="submit" class="btn btn-success">Si, firmar</button>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal fade" aria-modal="false" id="firmarValeModal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirmación</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <p id="modal-firmarvale-body"></p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
          <form action="{{route('vales.firmar')}}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden", name="id" id="valee_id">
            <button type="submit" class="btn btn-success btn-md">Si, firmar</button>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>



<div class="modal fade" id="modalAddRecepcion">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Recepción de mercancía</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <form action="{{ route('recepcions.store') }}" id="recepcionData" method="POST">
              @csrf
               <div class="row">
                <div class="col-12">
                  <div class="form-group">
                      <input type="hidden" name="almacen_id" value="{{ $almacen->id }}" class="form-control">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                      <input type="hidden" name="numero" value="0" class="form-control" placeholder="Número">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                      <strong>Factura ref. *:</strong>
                      <input type="text" name="factura" class="form-control" placeholder="Factura">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                      <strong>Proveedor ref. *:</strong>
                      <input type="text" name="proveedor" class="form-control" placeholder="Proveedor">
                  </div>
                </div>
                  <div class="col-12">
                      <div class="form-group">
                          <strong>Entrega *:</strong>
                          <input type="text" name="p_entrega" class="form-control" placeholder="Entrega">
                      </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                        <strong>Recibe *:</strong>
                        <input type="text" readonly name="p_recibe" value="{{ Auth::user()->name }}" class="form-control" placeholder="Recibe">
                    </div>
                  </div>
                  <div class="col-12">
                      <div class="form-group">
                          <strong>Observaciones:</strong>
                          <textarea class="form-control" style="height:150px" name="observaciones" placeholder="Observaciones"></textarea>
                      </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-success btn-block">Insertar</button>
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
<div class="modal fade" id="modalAddvale">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Vale de salida</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <form action="{{ route('vales.store') }}" id="valeData" method="POST">
              @csrf
               <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <input type="hidden" name="almacen_id" value="{{ $almacen->id }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong for="select2tipovale">Tipo vale</strong>
                            <select id="select2tipovale" class="form-control" name="tipovale">
                              <option value="1" selected>Vale para Órden de Trabajo</option>
                              <option value="0" >Vale para Gastos</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12" id="div_ordentrabajo">
                        <div class="form-group">
                            <strong for="select2ordentrabajo_id">Órden de trabajo</strong>
                            <select id="select2ordentrabajo_id" class="form-control select2bs4" name="ordentrabajo_id" id="ordentrabajo_id" style="width: 100%;">
                                <option value="0" selected="selected" disabled hidden="hidden">Selecciona una Órden de trabajo</option>
                                @for ($i = 0; $i < $ordentrabajos->count(); $i++)
                                    @if ($i == 0)
                                        <option value="{{ $ordentrabajos[$i]->id }}" selected>OT : {{ $ordentrabajos[$i]->id }} de {{ $ordentrabajos[$i]->tproducto->nombre }}</option>
                                    @else
                                        <option value="{{ $ordentrabajos[$i]->id }}">OT : {{ $ordentrabajos[$i]->id }} de {{ $ordentrabajos[$i]->tproducto->nombre }}</option>
                                    @endif
                                @endfor
                            </select>
                          </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Entrega *:</strong>
                            <input type="text" name="p_entrega" class="form-control" placeholder="Entrega">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Solicita *:</strong>
                            <input type="text" readonly name="p_solicita" value="{{ Auth::user()->name }}" class="form-control" placeholder="Solicita">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Observaciones:</strong>
                            <textarea class="form-control" style="height:150px" name="observaciones" id="valeObservaciones" placeholder="Observaciones">Vale de Orden de Trabajo</textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-success btn-block">Insertar</button>
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
  $(document).ready(function () {
    $('#almacenData').validate({
      rules: {
        almacen: {
          required: true,
          minlength: 5,
        }
      },
      messages: {
        almacen: {
          required: "Inserta un nombre para el almacén",
          minlength: "Inserta un almacén de al menos 5 caracteres"
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
     $('#valeData').validate({
       rules: {
         numero: {
           required: true,
         },
         p_entrega: {
           required: true,
         },
         p_solicita: {
           required: true,
         },
         fecha: {
           required: true,
         },
         observaciones: {
           required: true,
         }
       },
       messages: {
         numero: {
           required: "Inserta un número para el vale",
         },
         p_entrega: {
           required: "Debe insertar la persona que entrega",
         },
         p_solicita: {
           required: "Debe insertar la persona que solicita",
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
  });

$('#select2tipovale').on('change', function () { // your select change handler
    let valuee = $('#select2tipovale option:selected').val();
    if (valuee == 1) {
        $('#select2ordentrabajo_id').prop('disabled', false);
        $('#div_ordentrabajo').prop('hidden', false);
        $('#valeObservaciones').val("Vale de Orden de Trabajo")
        $('#select2ordentrabajo_id').rules("add", { required: true });
    } else {
        $('#select2ordentrabajo_id').prop('disabled', true);
        $('#div_ordentrabajo').prop('hidden', true);
        $('#valeObservaciones').val("Vale para Gastos")
        $('#select2ordentrabajo_id' ).rules( "remove" );
    }
});

$(document).on('click','.deleteRecepcion',function(){
    var analisisID=$(this).attr('data-recepcion_id');
    $('#recepcion_id').val(analisisID);
    $('#modal-deleterecepcion-body').text('¿Desea cancelar la recepción '+ $(this).attr('data-recepcion_id') + '?');
    $('#deleteRecepcionModal').modal('show');
});
$(document).on('click','.deleteVale',function(){
    var analisisID=$(this).attr('data-vale_id');
    $('#vale_id').val(analisisID);
    $('#modal-deletevale-body').text('¿Desea cancelar el vale '+ $(this).attr('data-vale_id') + '?');
    $('#deleteValeModal').modal('show');
});

$(document).on('click','.firmarRecepcion',function(){
    var analisisID=$(this).attr('data-recepcion_id');
    $('#recepcionn_id').val(analisisID);
    $('#modal-firmarrecepcion-body').text('¿Desea firmar la recepción '+ $(this).attr('data-recepcion_id') + '?');
    $('#firmarRecepcionModal').modal('show');
});
$(document).on('click','.firmarVale',function(){
    var analisisID=$(this).attr('data-vale_id');
    $('#modal-firmarvale-body').text('¿Desea firmar el vale '+ $(this).attr('data-vale_id') + '?');
    $('#valee_id').val(analisisID);
    $('#firmarValeModal').modal('show');
});

  $(function () {
    $('#tablaRecepciones').DataTable({
        "order": [[0, "desc"]],
      "responsive": true,
      "autoWidth": false
    });
  });

  $(function () {
    $('#tablaVales').DataTable({
        "order": [[0, "desc"]],
      "responsive": true,
      "autoWidth": false
    });
  });
  $(function () {
    $('#tablaExistencia').DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
  </script>
@endsection
