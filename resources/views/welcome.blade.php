@extends('layouts.main')
@section('content')
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Inicio</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <h5 class="col-12">Ofertas</h5>
            <div class="col-lg-3 col-md-6 col-sm-12 col-xl-3">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>{{ $count_tproductos }}</h3>
                  <p>Productos en ofertas</p>
                </div>
                <div class="icon">
                  <i class="fas fa fa-boxes"></i>
                </div>
                <a href="{{ route('tproductos.index')}}" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
        </div>
        <div class="row">
            <h5 class="col-12">Solicitudes</h5>
            <!-- ./col -->
            <div class="col-lg-3 col-md-6 col-sm-12 col-xl-3">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3>{{ $count_sol_proceso }}</h3>
                  <p>Solicitudes en proceso</p>
                </div>
                <div class="icon">
                  <i class="fas fa-phone"></i>
                </div>
                <a href="{{ route('solicitudes.index')}}" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-md-6 col-sm-12 col-xl-3">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>{{ $count_sol_terminadas }}</h3>
                  <p>Solicitudes terminadas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-phone"></i>
                </div>
                <a href="{{ route('solicitudes.index')}}" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
        </div>
        <div class="row">
            <h5 class="col-12">Órdenes de trabajo</h5>
            <!-- ./col -->
            <div class="col-lg-3 col-md-6 col-sm-12 col-xl-3">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3>{{ $count_OT_proceso }}</h3>
                  <p>OT en elaboración</p>
                </div>
                <div class="icon">
                  <i class="fas fa-book"></i>
                </div>
                <a href="{{ route('ordentrabajos.index')}}" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
