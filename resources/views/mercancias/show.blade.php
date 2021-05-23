@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Detalles de mercancía</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('mercancias.index') }}"> Atrás</a>
                </div>
            </div>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="content">
      <div class="container-fluid">
          <div class="card text-left">
            <img class="card-img-top">
            <div class="card-body">
              <h4 class="card-title"></h4>
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Código:</strong>
                        {{ $mercancia->codigo }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Nombre:</strong>
                        {{ $mercancia->nombremercancia }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Descripción:</strong>
                        {{ $mercancia->descripcion }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Unidad de medida:</strong>
                        {{ $mercancia->um }}
                    </div>
                </div>                
              </div><!-- /.row -->
            </div>
          </div>

      </div><!-- /.container-fluid -->
    </div>   
  </div>
@endsection
