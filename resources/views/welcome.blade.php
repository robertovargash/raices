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
        @can('gestion_almacen')
        <div class="row">
            <h5 class="col-12">Almacenes</h5>
            <div class="col-lg-3 col-md-6 col-sm-12 col-xl-3">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>{{ $count_mercancias  }}</h3>
                  <p>Mercancías en almacén</p>
                </div>
                <div class="icon">
                  <i class="fas fa fa-warehouse"></i>
                </div>
                <a href="{{ route('existenciapdf')}}" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
        </div>
        @endcan
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
          <div class="col-12 col-md-6 col-lg-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-bar mr-1"></i>
                  Última semana
                </h3>
                <div class="card-tools">
                  <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                      <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Barra</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#sales-chart" data-toggle="tab">Línea</a>
                    </li>
                  </ul>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <div class="chart tab-pane active" id="revenue-chart"
                       style="position: relative; height: 300px;">
                      <canvas id="ventas-semanales-chart-barra" height="300" style="height: 300px;"></canvas>
                   </div>
                  <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                    <canvas id="ventas-semanales-linea" height="300" style="height: 300px;"></canvas>
                  </div>
                </div>
              </div><!-- /.card-body -->
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-bar mr-1"></i>
                  Mensuales
                </h3>
                <div class="card-tools">
                  <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                      <a class="nav-link active" href="#ventas-mensuales-barra" data-toggle="tab">Barra</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#ventas-mensuales-linea" data-toggle="tab">Línea</a>
                    </li>
                  </ul>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <div class="chart tab-pane active" id="ventas-mensuales-barra" style="position: relative; height: 300px;">
                      <canvas id="ventas-mensuales-chart-barra" height="300" style="height: 300px;"></canvas>
                   </div>
                  <div class="chart tab-pane" id="ventas-mensuales-linea" style="position: relative; height: 300px;">
                    <canvas id="sales-chart-month" height="300" style="height: 300px;"></canvas>
                  </div>
                </div>
              </div><!-- /.card-body -->
            </div>
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
$(function () {
  'use strict'

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode      = 'index'
  var intersect = true

  var $visitorsChart = $('#ventas-semanales-linea')
  var visitorsChart  = new Chart($visitorsChart, {
    data   : {
      labels  :  {!!json_encode($chartsemana->labels)!!} ,
      datasets: [{
        type                : 'line',
        data                : {!! json_encode($chartsemana->dataset)!!} ,
        backgroundColor     : 'transparent',
        borderColor         : '#007bff',
        pointBorderColor    : '#007bff',
        pointBackgroundColor: '#007bff',
        fill                : false
        // pointHoverBackgroundColor: '#007bff',
        // pointHoverBorderColor    : '#007bff'
      }]
    },
    options: {
      maintainAspectRatio: false,
      tooltips           : {
        mode     : mode,
        intersect: intersect
      },
      hover              : {
        mode     : mode,
        intersect: intersect
      },
      legend             : {
        display: false
      },
      scales             : {
        yAxes: [{
          // display: false,
          gridLines: {
            display      : true,
            lineWidth    : '4px',
            color        : 'rgba(0, 0, 0, .2)'
          },
          ticks    : $.extend({
            beginAtZero : true,
            // Include a dollar sign in the ticks
            callback: function (value, index, values) {
              if (value >= 1000) {
                value /= 1000
                value += 'M'
              }
              return '$' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display  : true,
          gridLines: {
            display: false
          },
          ticks    : ticksStyle
        }]
      }
    }
  })

  var $salesChart = $('#ventas-semanales-chart-barra')
  var salesChart  = new Chart($salesChart, {
    type   : 'bar',
    data   : {
      labels  : {!!json_encode($chartsemana->labels)!!} ,
      datasets: [
        {
          backgroundColor: '#007bff',
          borderColor    : '#007bff',
          pointBorderColor    : '#007bff',
          pointBackgroundColor: '#007bff',
          data           : {!! json_encode($chartsemana->dataset)!!} ,
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips           : {
        mode     : mode,
        intersect: intersect
      },
      hover              : {
        mode     : mode,
        intersect: intersect
      },
      legend             : {
        display: false
      },
      scales             : {
        yAxes: [{
          // display: false,
          gridLines: {
            display      : true,
            lineWidth    : '4px',
            color        : 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks    : $.extend({
            beginAtZero: true,
            // Include a dollar sign in the ticks
            callback: function (value, index, values) {
              if (value >= 1000) {
                value /= 1000
                value += 'M'
              }
              return '$' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display  : true,
          gridLines: {
            display: false
          },
          ticks    : ticksStyle
        }]
      }
    }
  })
});
$(function () {
  'use strict'

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode      = 'index'
  var intersect = true

  var $visitorsChart = $('#sales-chart-month')
  var visitorsChart  = new Chart($visitorsChart, {
    data   : {
      labels  :  {!!json_encode($chartmes->labels)!!} ,
      datasets: [{
        type                : 'line',
        data                : {!! json_encode($chartmes->dataset)!!} ,
        backgroundColor     : 'transparent',
        borderColor         : '#007bff',
        pointBorderColor    : '#007bff',
        pointBackgroundColor: '#007bff',
        fill                : false
        // pointHoverBackgroundColor: '#007bff',
        // pointHoverBorderColor    : '#007bff'
      }]
    },
    options: {
      maintainAspectRatio: false,
      tooltips           : {
        mode     : mode,
        intersect: intersect
      },
      hover              : {
        mode     : mode,
        intersect: intersect
      },
      legend             : {
        display: false
      },
      scales             : {
        yAxes: [{
          // display: false,
          gridLines: {
            display      : true,
            lineWidth    : '4px',
            color        : 'rgba(0, 0, 0, .2)'
          },
          ticks    : $.extend({
            beginAtZero : true,
            // Include a dollar sign in the ticks
            callback: function (value, index, values) {
              if (value >= 1000) {
                value /= 1000
                value += 'M'
              }
              return '$' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display  : true,
          gridLines: {
            display: false
          },
          ticks    : ticksStyle
        }]
      }
    }
  })

  var $salesChart = $('#ventas-mensuales-chart-barra')
  var salesChart  = new Chart($salesChart, {
    type   : 'bar',
    data   : {
      labels  : {!!json_encode($chartmes->labels)!!} ,
      datasets: [
        {
          backgroundColor: '#007bff',
          borderColor    : '#007bff',
          pointBorderColor    : '#007bff',
          pointBackgroundColor: '#007bff',
          data           : {!! json_encode($chartmes->dataset)!!} ,
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips           : {
        mode     : mode,
        intersect: intersect
      },
      hover              : {
        mode     : mode,
        intersect: intersect
      },
      legend             : {
        display: false
      },
      scales             : {
        yAxes: [{
          // display: false,
          gridLines: {
            display      : true,
            lineWidth    : '4px',
            color        : 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks    : $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value, index, values) {
              if (value >= 1000) {
                value /= 1000
                value += 'M'
              }
              return '$' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display  : true,
          gridLines: {
            display: false
          },
          ticks    : ticksStyle
        }]
      }
    }
  })
});
$(function () {
  'use strict'
  // Sales graph chart
  var salesGraphChartCanvas = $('#line-chart-semana').get(0).getContext('2d');
  //$('#revenue-chart').get(0).getContext('2d');

  var salesGraphChartData = {
    labels  : {!!json_encode($chartsemana->labels)!!} ,
    datasets: [
      {
        label               : 'Ventas',
        fill                : false,
        borderWidth         : 2,
        lineTension         : 0,
        spanGaps : true,
        borderColor         : '#efefef',
        pointRadius         : 3,
        pointHoverRadius    : 7,
        pointColor          : '#efefef',
        pointBackgroundColor: '#efefef',
        data                : {!! json_encode($chartsemana->dataset)!!} ,
      }
    ]
  }

  var salesGraphChartOptions = {
    maintainAspectRatio : false,
    responsive : true,
    legend: {
      display: false,
    },
    scales: {
      xAxes: [{
        ticks : {
          fontColor: '#efefef',
        },
        gridLines : {
          display : false,
          color: '#efefef',
          drawBorder: false,
        }
      }],
      yAxes: [{
        ticks : {
          // stepSize: 200,
          fontColor: '#efefef',
        },
        gridLines : {
          display : true,
          color: '#efefef',
          drawBorder: false,
        }
      }]
    }
  }

  // This will get the first returned node in the jQuery collection.
  var salesGraphChart = new Chart(salesGraphChartCanvas, {
      type: 'line',
      data: salesGraphChartData,
      options: salesGraphChartOptions
    }
  )

})
$(function () {
  'use strict'
  // Sales graph chart
  var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d');
  //$('#revenue-chart').get(0).getContext('2d');

  var salesGraphChartData = {
    labels  : ['1/21','2/21','3/21','4/21','5/21','6/21','7/21','8/21','9/21','10/21','11/21','12/21'] ,
    datasets: [
      {
        label               : 'Ventas',
        fill                : false,
        borderWidth         : 2,
        lineTension         : 0,
        spanGaps : true,
        borderColor         : '#efefef',
        pointRadius         : 3,
        pointHoverRadius    : 7,
        pointColor          : '#efefef',
        pointBackgroundColor: '#efefef',
        data                : ['1000','4234','5435','6565','1234','5545','8887','9898','9898','5554','3456','4567'] ,
      }
    ]
  }

  var salesGraphChartOptions = {
    maintainAspectRatio : false,
    responsive : true,
    legend: {
      display: false,
    },
    scales: {
      xAxes: [{
        ticks : {
          fontColor: '#efefef',
        },
        gridLines : {
          display : false,
          color: '#efefef',
          drawBorder: false,
        }
      }],
      yAxes: [{
        ticks : {
          stepSize: 200,
          fontColor: '#efefef',
        },
        gridLines : {
          display : true,
          color: '#efefef',
          drawBorder: false,
        }
      }]
    }
  }

  // This will get the first returned node in the jQuery collection.
  var salesGraphChart = new Chart(salesGraphChartCanvas, {
      type: 'line',
      data: salesGraphChartData,
      options: salesGraphChartOptions
    }
  )

})


</script>
@endsection
@endsection
