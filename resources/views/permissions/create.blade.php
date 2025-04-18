@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Creando nuevo permiso</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('permissions.index') }}"> Atrás</a>
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
                <h3 class="card-title">Permiso</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
              </div>
              <div class="card-body">
                  <div class="row">
                      <div class="col-12">
                        {!! Form::open(array('route' => 'permissions.store','method'=>'POST')) !!}
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <strong>Permiso:</strong>
                                    {!! Form::text('name', null, array('placeholder' => 'Permiso','class' => 'form-control')) !!}
                                    @if ($errors->any())
                                    <span role="alert">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li><strong class="text-danger">{{ $error }}</strong></li>
                                            @endforeach
                                        </ul>
                                    </span>
                                    @endif
                                    {{-- @error('name')
                                        <span role="alert">
                                            <strong class="text-danger">{{ $error }}</strong>
                                        </span>
                                    @enderror --}}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-success btn-block">Insertar</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                      </div>
                  </div>
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
</script>
@endsection
