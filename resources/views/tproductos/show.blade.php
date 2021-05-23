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
              <h3 class="card-title">Generales del producto</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                  {{-- <form role="form" id="tproductoData" action="{{ route('tproductos.update',$tproducto->id) }}" method="POST">
                    @csrf
                    @method('PUT')             --}}
                    <div class="col-12">
                      <div class="form-group"> 
                          <strong>Nombre:</strong>  {{ $tproducto->nombre }}
                          {{-- <input type="text" name="nombre" value="{{ $tproducto->nombre }}" id="idNombreProducto" class="form-control" placeholder="Nombre"> --}}
                      </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Precio:</strong> {{ $tproducto->valorbruto }}
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                          <strong>Tipo:</strong> {{ $tproducto->tipotproducto->tipo }}
                        </div>                    
                      </div>
                    <div class="col-12">
                        <div class="form-group">
                            <strong>Descripción:</strong> {{ $tproducto->descripcion }}
                        </div>
                    </div>
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
                {{-- <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button> --}}
              </div>
            </div>
            <div class="card-body">
              <div class="pull-left mb-2">
                {{-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalAddMateriaPrima">Adicionar</button> --}}
              </div>
              <table id="tablaMateriasPrimas" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Mat. prima</th>
                    <th>Cant. necesaria</th>
                    <th>Precio Temp.</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($tproducto->materiaprimas as $mprima)
                  <tr>
                    <td>{{ $mprima->mercancia->nombremercancia }}</td>
                    <td>{{ $mprima->cantidadnecesaria }}</td>
                    <td>{{ $mprima->mercancia->precio }}</td>                    
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>Mat. prima</th>
                    <th>Cant. necesaria</th>
                    <th>Precio Temp.</th>
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
@endsection
@section('scripts')
<script type="text/javascript">

  $(function () {
    $('#tablaMateriasPrimas').DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });

</script>
@endsection