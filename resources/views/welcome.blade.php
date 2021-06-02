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
                <a href="{{ route('ofertas.index')}}" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
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
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Ventas</h3>
                  <a href="javascript:void(0);">Ver reporte</a>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">$18,230.00</span>
                    <span>Ventas en la semana</span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fas fa-arrow-up"></i> 33.1%
                    </span>
                    <span class="text-muted">Ventas en el mes</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="sales-chart" height="200"></canvas>
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@section('scripts')
@section('scripts')
<script type="text/javascript">
var ctx = document.getElementById('sales-chart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'bar',
// The data for our dataset
        data: {
            labels:  {!!json_encode($chart->labels)!!} ,
            datasets: [
                {
                    label: 'Ingresos $',
                    backgroundColor: {!! json_encode($chart->colours)!!} ,
                    data:  {!! json_encode($chart->dataset)!!} ,
                },
            ]
        },
// Configuration options go here
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function(value) {if (value % 1 === 0) {return value;}}
                    },
                    scaleLabel: {
                        display: false
                    }
                }]
            },
            legend: {
                labels: {
                    // This more specific font property overrides the global property
                    fontColor: '#122C4B',
                    fontFamily: "'Muli', sans-serif",
                    padding: 25,
                    boxWidth: 25,
                    fontSize: 14,
                }
            },
            layout: {
                padding: {
                    left: 10,
                    right: 10,
                    top: 0,
                    bottom: 10
                }
            }
        }
    });
</script>
@endsection
@endsection
