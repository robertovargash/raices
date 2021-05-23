@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Editando mercancía</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('mercancias.index') }}"> Atrás</a>
                </div>
            </div>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="col-12">
          <div class="row">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">Mercancía</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
              </div>
              <div class="card-body">
                <form id="editProducto" action="{{ route('mercancias.update',$mercancia) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group">
                        <strong>Cuenta:</strong>
                        <select id="cuenta" class="form-control select2bs4" name="ficuenta_id" style="width: 100%;">
                            <option value="" selected="selected" hidden="hidden">Selecciona cuenta</option>
                            @foreach ($cuentas as $cuenta)
                                <option value="{{$cuenta->id}}" {{$mercancia->ficuenta_id == $cuenta->id ? ' selected ' : '' }}>{{$cuenta->numero}} ({{ $cuenta->descripcion }})</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-group">
                        <strong>Subcuenta:</strong>
                        <select id="subcuenta" class="form-control select2bs4" name="fisubcuenta_id" style="width: 100%;" {{$mercancia->ficuenta_id == null ? ' disabled ' : '' }}>
                            <option value="" selected="selected" hidden="hidden">{{$mercancia->ficuenta_id == null ? 'Seleccione cuenta primero' : 'Seleccione subcuenta' }}</option>
                            @if ($mercancia->ficuenta)
                              @foreach ($mercancia->ficuenta->fisubcuentas as $subcuenta)
                                <option value="{{$subcuenta->id}}" {{$mercancia->fisubcuenta_id == $subcuenta->id ? ' selected ' : '' }}>{{$subcuenta->numero}} ({{ $subcuenta->descripcion }})</option>
                              @endforeach
                            @endif
                        </select>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-group">
                        <strong>Análisis:</strong>
                        <select id="analisis" class="form-control select2bs4" name="fiinfracuenta_id" style="width: 100%;" {{$mercancia->fisubcuenta_id == null ? ' disabled ' : '' }}>
                            <option value="" selected="selected" hidden="hidden">{{$mercancia->fisubcuenta_id == null ? 'Seleccione subcuenta primero' : 'Seleccione análisis' }}</option>
                            @if ($mercancia->fisubcuenta)
                              @foreach ($mercancia->fisubcuenta->fiinfracuentas as $analisis)
                                <option value="{{$analisis->id}}" {{$mercancia->fiinfracuenta_id == $analisis->id ? ' selected ' : '' }}>{{$analisis->numero}} ({{ $analisis->descripcion }})</option>
                              @endforeach
                            @endif
                        </select>
                      </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Código:</strong>
                            <input type="text" name="codigo" value="{{ $mercancia->codigo }}" class="form-control" placeholder="Código">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Nombre:</strong>
                            <input type="text" name="nombremercancia" value="{{ $mercancia->nombremercancia }}" class="form-control" placeholder="Nombre">
                        </div>
                    </div>
                    <div class="col-12">
                      <div class="form-group">
                        <strong for="my-select2">Clasificación:</strong>
                        <select id="my-select2" class="form-control" name="clasificacion_id">
                            @foreach ($clasificaciones as $clasificacion)
                              <option value="{{ $clasificacion->id }}" {{$mercancia->clasificacion_id == $clasificacion->id ? ' selected ' : '' }}>{{ $clasificacion->clasificacion }}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>U/M:</strong>
                            <input type="text" name="um" value="{{ $mercancia->um }}" class="form-control" placeholder="U/M">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Descripción:</strong>
                            <textarea class="form-control" style="height:150px" name="descripcion" placeholder="Descripción">{{ $mercancia->descripcion }}</textarea>
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
      </div><!-- /.container-fluid -->
    </section>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
$("#cuenta").change(function(e) {
    $("#subcuenta").empty();
    let model = e.target.value;
    let selectsubcuenta = document.querySelector('#subcuenta');
    if (model != "") {
     var url = "{{ route('fisubcuentas.get_by_cuenta', ":id") }}";
      url = url.replace(':id', model);
     $.getJSON(url, function(data) {
      let option = document.createElement('option');
       option.value = "";
       option.text = "Seleccione subcuenta";
       selectsubcuenta.add(option);
       $.each(data, function (index, field) {
        let option = document.createElement('option');
          option.value = field.id;
          option.text = "Subcuenta: " + field.numero + " (" + field.descripcion + ")";
          selectsubcuenta.add(option);
          selectsubcuenta.disabled = false;
        });
    });
    }else{
      let option = document.createElement('option');
          option.text = "Seleccione cuenta primero";
          selectsubcuenta.add(option);
          selectsubcuenta.disabled = true;
    }
});
$("#subcuenta").change(function(e) {
  $("#analisis").empty();
  let model = e.target.value;
  let selectanalisis = document.querySelector('#analisis');
  if (model != "") {
    var url = "{{ route('fiinfracuentas.get_by_subcuenta', ":id") }}";
    url = url.replace(':id', model);
    $.getJSON(url, function(data) {
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
$(document).ready(function () {
  $('#editProducto').validate({
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
