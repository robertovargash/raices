@extends('layouts.app')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <b>Raíces</b>
      </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Autentíquese para iniciar sesión</p>              
            <form method="POST" action="{{ route('login') }}">
                @csrf
              <div class="input-group mb-3">
                <input placeholder="Correo electrónico" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus/>               
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                  </div>
                </div>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                 @enderror
              </div>
              <div class="input-group mb-3">
                <input placeholder="Contraseña" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"/>                
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="row">
                <div class="col-8">
                  <div class="icheck-primary">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">
                      Recuérdame
                    </label>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" class="btn btn-primary btn-block">{{ __('Entrar') }}</button>
                </div>
                <!-- /.col -->
              </div>                  
            </form>
            @if (Route::has('password.request'))
            <p class="mb-1">
                <a href="{{ route('password.request') }}" class="btn btn-link">{{ __('Olvidé mi contraseña') }}</a>
            </p>
            @endif
        </div>
        {{-- <div class="card-header">{{ __('Autenticar') }}</div> --}}

        {{-- <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                
            </form>
        </div> --}}
    </div>
</div> 
@endsection
