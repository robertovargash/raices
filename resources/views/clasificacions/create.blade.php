@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                  <h2>Inserte nueva clasificación</h2>
              </div>
              <div class="pull-right">
                  <a class="btn btn-primary" href="{{ route('clasificacions.index') }}"> Atrás</a>
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
      </div>
      <div class="content">
        <div class="container-fluid">
          <div class="card text-left">
            <img class="card-img-top">
            <div class="card-body">
              <h4 class="card-title"></h4>
              <div class="row">
                <form action="{{ route('clasificacions.store') }}" method="POST">
                    @csrf            
                     <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Nombre Clasificación:</strong>
                                <input type="text" name="clasificacion" class="form-control" placeholder="Nombre">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Detalle de la clasificación:</strong>
                                <textarea class="form-control" style="height:150px" name="detalle" placeholder="Detalle"></textarea>
                            </div>
                        </div>
                        <div class="dropdown">
                
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">Adicionar</button>
                        </div>
                    </div>
                
                </form>
              </div>
            </div>
          </div>

          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div> 
</div>
@endsection
