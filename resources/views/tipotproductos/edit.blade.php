@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                  <h2>Editando tipo producto</h2>
              </div>
              <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('tipotproductos.index') }}"> Atrás</a>
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
              <form id="editclasificador" action="{{ route('tipotproductos.update',$tipotproducto->id) }}" method="POST">
                @csrf
                @method('PUT')        
                 <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Tipo:</strong>
                            <input type="text" name="tipo" value="{{ $tipotproducto->tipo }}" class="form-control" placeholder="Tipo producto">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                      <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </div>
            </form>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </div>
</div>    
@endsection
@section('scripts')
<script>
  $(document).ready(function () {
    $('#editclasificador').validate({
      rules: {
        tipo: {
          required: true,
        },
      },
      messages: {
        tipo: {
          required: "Inserte el tipo de producto",
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
