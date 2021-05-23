@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <div class="col-lg-12 margin-tb">
                  <div class="pull-left">
                      <h2>Cambiando contraseña</h2>
                  </div>
                  <div class="pull-right">
                      <a class="btn btn-primary" href="{{ route('home') }}"> Inicio</a>
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
                  <h3 class="card-title">Cambiando contraseña</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  </div>
                </div>
                <div class="card-body">
                  <form id="cambiate" method="POST" action="{{ route('change.password') }}">
                    @csrf 
                     @foreach ($errors->all() as $error)
                        <p class="text-danger">{{ $error }}</p>
                     @endforeach 

                    <div class="form-group row">
                        {{-- <label for="password" class="col-md-4 col-form-label text-md-right">Contraseña actual</label> --}}
                        <strong>Contraseña actual:</strong>
                        <div class="col-12">
                            <input id="password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" autocomplete="current-password">
                            @error('current_password')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        {{-- <label for="password" class="col-md-4 col-form-label text-md-right">Nueva contraseña</label> --}}
                        <strong>Nueva contraseña:</strong>
                        <div class="col-12">
                            <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" autocomplete="current-password">
                            @error('new_password')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <strong>Confirmación de nueva contraseña:</strong>
                        {{-- <label for="password" class="col-md-4 col-form-label text-md-right">Confirmació de nueva contraseña</label> --}}

                        <div class="col-12">
                            <input id="new_confirm_password" type="password" class="form-control @error('new_confirm_password') is-invalid @enderror" name="new_confirm_password" autocomplete="current-password">
                            @error('new_confirm_password')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">
                                Actualizar contraseña
                            </button>
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

$(document).ready(function () {
  $('#cambiate').validate({
    rules: {
      current_password: {
        required: true,
      },
      new_password: {
        required: true,
      },
      new_confirm_password: {
        required: true,
      }
    },
    messages: {
        current_password: {
        required: "Inserte la contraseña",
      },
      new_password: {
        required: "Inserte la nueva contraseña",
      },
      new_confirm_password: {
        required: "Inserte la confirmación de contraseña",
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