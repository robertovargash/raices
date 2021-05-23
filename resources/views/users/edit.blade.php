@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Editando usuario</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('users.index') }}"> Atrás</a>
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
                <h3 class="card-title">Usuario</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
              </div>
              <div class="card-body">
                <form id="editUsuario" action="{{ route('users.update',$user) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group">
                        <strong>Nombre:</strong>
                        <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control" placeholder="Nombre">
                      </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                          <strong>Ocupación:</strong>
                          <input type="text" name="profession" id="profession" value="{{ $user->profession }}" class="form-control" placeholder="Ocupación">
                        </div>
                      </div>
                    <div class="col-12">
                      <div class="form-group">
                        <strong>Correo electrónico:</strong>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ $user->email }}" placeholder="Correo electrónico">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Role:</strong>
                            <div class="select2-red">
                                {!! Form::select('roles[]', $roles,$userRole, array('data-dropdown-css-class' => 'select2-red','style' => 'width: 100%;','class' => 'select2','select2-purple','form-control','multiple')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                      <button type="submit" class="btn btn-primary btn-block">Actualizar</button>
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
  $('#editUsuario').validate({
    rules: {
      name: {
        required: true,
      },
      profession: {
        required: true,
      },
      email: {
        required: true,
        email: true,
      },
      password: {
        required: true,
      },
      password_confirmation: {
        required: true,
      },
    },
    messages: {
        name: {
        required: "Inserte el nombre",
      },
      profession: {
        required: "Inserte ocupación",
      },
      email: {
        required: "Inserte correo electrónico",
        email: "Inserta un correo electrónico válido"
      },
      password: {
        required: "Inserte contraseña",
      },
      password_confirmation: {
        required: "Repita contraseña",
      },
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
