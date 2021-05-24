@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              {{-- <h1 class="m-0">Lista de productos</h1> --}}
              <div class="pull-right">
                  @can('gestion_mercancia')
                    <button type="button" class="btn btn-success mb-2 " data-toggle="modal" data-target="#modalAddProducto">Nueva</button>
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
                  <h3 class="card-title">Mercancías</h3>
                </div>
                <div class="card-body">
                  <table id="tablaProductos" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Código</th>
                          <th>Nombre</th>
                          <th>Detalles</th>
                          <th>U/M</th>
                          <th></th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($listamercancias as $mercancia)
                        <tr>
                            <td>{{ $mercancia->codigo }}</td>
                            <td>{{ $mercancia->nombremercancia }}</td>
                            <td>{{ $mercancia->descripcion.'|'.$mercancia->clasificacion->clasificacion }} </td>
                            <td>{{ $mercancia->um }}</td>
                             <td>
                               <div>
                                  <a href="{{ route('mercancias.show',$mercancia) }}" class="btn btn-link text-info">Detalles</a>
                                    @can('gestion_mercancia')
                                        <a href="{{ route('mercancias.edit',$mercancia) }}" class="btn btn-link text-primary">Editar</a>
                                        <a class="btn btn-link text-danger deleteProducto" data-id="{{$mercancia->id}}">Eliminar</a>
                                    @endcan
                               </div>
                            </td>
                        </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>Código</th>
                          <th>Nombre</th>
                          <th>Detalles</th>
                          <th>U/M</th>
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
        <form action="{{route('mercancias.destroy')}}" method="POST">
          @csrf
          @method('DELETE')
          <input type="hidden", name="id" id="producto_id">
          <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalAddProducto">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Adicionar mercancía</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addproducto" action="{{ route('mercancias.store') }}" method="POST">
          @csrf
           <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <strong for="cuenta">Cuenta:</strong>
                  <select id="cuenta" class="form-control select2bs4" name="ficuenta_id" style="width: 100%;">
                      <option value="" selected="selected" hidden="hidden">Selecciona cuenta</option>
                      @foreach ($cuentas as $cuenta)
                          <option value="{{$cuenta->id}}">{{$cuenta->numero}} ({{ $cuenta->descripcion }})</option>
                      @endforeach
                  </select>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <strong for="subcuenta">Subcuenta:</strong>
                  <select id="subcuenta" class="form-control select2bs4" name="fisubcuenta_id" disabled="true" style="width: 100%;">
                      <option value="" selected="selected" hidden="hidden">Selecciona cuenta primero</option>
                  </select>
                </div>
              </div>

              <div class="col-12">
                <div class="form-group">
                  <strong for="analisis">Análisis:</strong>
                  <select id="analisis" class="form-control select2bs4" name="fiinfracuenta_id" disabled="true" style="width: 100%;">
                      <option value="" selected="selected" hidden="hidden">Selecciona subcuenta primero</option>
                  </select>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <strong for="my-select2">Clasificación:</strong>
                  <select id="id" class="form-control select2bs4" name="clasificacion_id" style="width: 100%;">
                      <option value="" selected="selected" hidden="hidden">Selecciona clasificación</option>
                      @foreach ($clasificaciones as $clasificacion)
                          <option value="{{$clasificacion->id}}">{{$clasificacion->clasificacion}}</option>
                      @endforeach
                  </select>
                </div>
              </div>
              <div class="col-12">
                  <div class="form-group">
                      <strong>Código:</strong>
                      <input type="text" name="codigo" class="form-control" placeholder="Código">
                  </div>
              </div>
              <div class="col-12">
                  <div class="form-group">
                      <strong>Nombre:</strong>
                      <input type="text" name="nombremercancia" class="form-control" placeholder="Nombre">
                  </div>
              </div>
              <div class="col-12">
                  <div class="form-group">
                      <strong>U/M:</strong>
                      <input type="text" name="um" class="form-control" placeholder="U/M">
                  </div>
              </div>
              <div class="col-12">
                  <div class="form-group">
                      <strong>Descripción:</strong>
                      <textarea class="form-control" style="height:150px" name="descripcion" placeholder="Descripción">Sin detalles</textarea>
                  </div>
              </div>
              <input type="hidden" value="0" name="precio" class="form-control" placeholder="U/M">
              <div class="col-12 text-center">
                <button type="submit" class="btn btn-success btn-block">Insertar</button>
              </div>
          </div>
        </form>
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

 $("#cuenta").change(function(e) {
    $("#subcuenta").empty();
    let model = e.target.value;
    let selectsubcuenta = document.querySelector('#subcuenta');
    if (model != "") {
     $.getJSON("fisubcuentas/get_by_cuenta/" + model, function(data) {
      let option = document.createElement('option');
       option.value = "";
       option.text = "Seleccione Subcuenta";
       selectsubcuenta.add(option);
       $.each(data, function (index, field) {
        let option = document.createElement('option');
          option.value = field.id;
          option.text = "Subcuenta: " + field.numero + " (" + field.descripcion + ")";
          selectsubcuenta.add(option);
        });
        selectsubcuenta.disabled = false;
    });
    }else{
      let option = document.createElement('option');
      option.text = "Selecciona cuenta primero";
      selectsubcuenta.add(option);
      selectsubcuenta.disabled = true;
    }
   });

   $("#subcuenta").change(function(e) {
    $("#analisis").empty();
    let model = e.target.value;
    let selectanalisis = document.querySelector('#analisis');
    if (model != "") {
          $.getJSON("fiinfracuentas/get_by_subcuenta/" + model, function(data) {
      let option = document.createElement('option');
       option.value = "";
       option.text = "Seleccione análisis";
       selectanalisis.add(option);
       $.each(data, function (index, field) {
        let option = document.createElement('option');
          option.value = field.id;
          option.text = "Análisis: " + field.numero + " (" + field.descripcion + ")";
          selectanalisis.add(option);
        });
        selectanalisis.disabled = false;
    });
    }else{
      let option = document.createElement('option');
      option.text = "Selecciona subcuenta primero";
      selectanalisis.add(option);
      selectanalisis.disabled = true;
    }
   });

  $(function () {
    $('#tablaProductos').DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });

$(document).on('click','.deleteProducto',function(){
  var productoID=$(this).attr('data-id');
  $('#producto_id').val(productoID);
  $('#deleteProductoModal').modal('show');
});

  $(document).ready(function () {
    $('#addproducto').validate({
      rules: {
        clasificacion_id: {
          required: true,
        },
        codigo: {
          required: true,
        },
        nombremercancia: {
          required: true,
        },
        um: {
          required: true,
        },
      },
      messages: {
        clasificacion_id: {
          required: "Escoja una clasificación",
        },
        codigo: {
          required: "Debe insertar un código",
        },
        nombremercancia: {
          required: "Debe insertar nombre del producto o mercancía",
        },
        um: {
          required: "Seleccione una Unidad de medida",
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
</script>
@endsection
