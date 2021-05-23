@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              {{-- <h1 class="m-0">Lista de productos</h1> --}}
                <div class="pull-right">
                  @can('gestion_clasificadores')
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAddClasificacion">Nueva clasificación</button>
                  @endcan
                </div>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <section class="content">
        <div class="content-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Clasificaciones</h3>
                </div>
                <div class="card-body">
                  <table id="tablaClasificaciones" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Clasificación</th>
                          <th>Detalles</th>
                          <th></th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($clasificaciones as $clasif)
                        <tr>
                            <td>{{ $clasif->clasificacion }}</td>
                            <td>{{ $clasif->detalle }}</td>
                             <td>
                               <div>
                                  <a href="{{ route('clasificacions.show',$clasif) }}" class="btn btn-link text-info">Detalles</a>
                                    @can('gestion_clasificadores')
                                        <a href="{{ route('clasificacions.edit',$clasif) }}" class="btn btn-link text-primary">Editar</a>
                                        <a class="btn btn-link text-danger deleteClasificacion" data-id="{{$clasif->id}}">Eliminar</a>
                                    @endcan
                               </div>
                            </td>
                        </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>Clasificación</th>
                          <th>Detalles</th>
                          <th></th>
                        </tr>
                      </tfoot>
                  </table>
                </div>
              </div>
              </div>
            </div>
          </div>
      </section>
</div>

<div class="modal fade" aria-modal="false" id="deleteClasificacionModal">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirmación</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>¿Desea eliminar la clasificación?</p>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <form action="{{route('clasificacions.destroy')}}" method="POST">
          @csrf
          @method('DELETE')
          <input type="hidden", name="id" id="clasificacion_id">
          <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalAddClasificacion">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Adicionar clasificación</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <form id="addclasificacion" action="{{ route('clasificacions.store') }}" method="POST">
              @csrf
               <div class="row">
                  <div class="col-12">
                      <div class="form-group">
                          <strong>Clasificación:</strong>
                          <input type="text" name="clasificacion" class="form-control" placeholder="Clasificación">
                      </div>
                  </div>
                  <div class="col-12">
                      <div class="form-group">
                          <strong>Detalles:</strong>
                          <textarea class="form-control" style="height:150px" name="detalles" placeholder="Detalles"></textarea>
                      </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                          <button type="submit" class="btn btn-primary">Insertar</button>
                  </div>
              </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- /.modal -->
@endsection
@section('scripts')
<script>
  $(function () {
    $('#tablaClasificaciones').DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });

  $(document).on('click','.deleteClasificacion',function(){
    var analisisID=$(this).attr('data-id');
    $('#clasificacion_id').val(analisisID);
    $('#deleteClasificacionModal').modal('show');
});

  $(document).ready(function () {
    $('#addclasificacion').validate({
      rules: {
        clasificacion: {
          required: true,
        },
      },
      messages: {
        clasificacion: {
          required: "Inserte el nombre de clasificación",
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

  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })


    //Date range picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });
  })
</script>
@endsection
