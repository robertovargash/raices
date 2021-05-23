@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>Ver Clasificación de mercancías</h2>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('clasificacions.index') }}"> Atrás</a>
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
            </div>           
          </div><!-- /.row -->         
        </div><!-- /.container-fluid -->
      <div class="content">
        <div class="container-fluid">
            <div class="card text-left">
              <img class="card-img-top">
              <div class="card-body">
                <h4 class="card-title"></h4>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Nombre clasificación:</strong>
                            {{ $clasificacion->clasificacion }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Detalles de la clasificación:</strong>
                            {{ $clasificacion->detalle }}
                        </div>
                    </div>      
                </div><!-- /.row -->
                <div class="row">
                    @if ($clasificacion->mercancias->count() > 0)
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Mercancía</th>
                                <th>UM</th>
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clasificacion->mercancias->all() as $mercancia)
                            <tr>
                                <td>{{ $mercancia->nombremercancia }}</td>
                                <td>{{ $mercancia->um }}</td>
                                <td>{{ $mercancia->precio }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>        
                    @endif  
                </div>
              </div>
            </div>
        </div><!-- /.container-fluid -->
      </div>
</div>
@endsection
