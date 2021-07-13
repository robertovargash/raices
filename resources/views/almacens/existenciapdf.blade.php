<html>
    <head>
        <style>
            /**
                Establezca los márgenes de la página en 0, por lo que el pie de página y el encabezado
                puede ser de altura y anchura completas.
             **/
             @page { margin: 80px 50px; }
            #header { position: fixed; left: 0px; top: -50px; right: 0px; height: 10px;text-align: center; }
            #footer { position: fixed; left: 0px; bottom: -10px; right: 0px; height: 10px; }
            #footer .page:after { content: counter(page); }

            .Row {
            display: table;
            width: 100%; /*Optional*/
            table-layout: fixed; /*Optional*/
            border-spacing: 10px; /*Optional*/
        }
        .Column {
            display: table-cell;
        }
        .table {
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
        background-color: transparent;
        text-align: right;
        }

        .table th,
        .table td {
        /* padding: 0.75rem; */
        vertical-align: top;
        border-top: 1px solid #dee2e6;
        }

        .table thead th {
        vertical-align: bottom;
        border-bottom: 1px solid #dee2e6;
        text-align: right;
        }

        .table tfoot th  {
        vertical-align: bottom;
        border-bottom: 1px solid #dee2e6;
        text-align: right;
        }

        .table tbody + tbody {
        border-top: 1px solid #dee2e6;
        }
        .table-bordered {
        border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
        border: 1px solid #dee2e6;
        }

        .table-bordered thead th,
        .table-bordered thead td {
        border-bottom-width: 1px;
        }
        </style>
        <title>{{ $title }}</title>
    </head>
    <body>
        <div id="header">
            <div class="Row">
                <div class="Column">
                    <strong>Existencia en almacenes  </strong>
                </div>
                <div class="Column">
                    <strong>NIT: </strong> {{ $proveedor->nit }}
                </div>
                <div class="Column">
                    <strong>Entidad: </strong> {{ $proveedor->nombre }}
                </div>
            </div>
          </div>
          <div id="footer">
            <div class="Row">
                <div class="Column">
                    <p class="page">Página </p>
                </div>
                <div class="Column">
                    <p style="text-align: center;">Impreso el {{ date('d-m-Y', strtotime(now())) }}</p>
                </div>
            </div>
          </div>
          <div id="content">
              <h3>Existencia por almacenes</h3>

            @foreach ($almacenes as $almacen)
            <h5>{{ $almacen->almacen }}</h5>
              <table class="table table-bordered" >
                <thead>
                    <tr>
                      <th>Almacén</th>
                      <th>Mercancia</th>
                      <th>UM</th>
                      <th>Existencia</th>
                      <th>Precio</th>
                      <th>Importe</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($almacen->almacenmercancias as $mercancia)
                        <tr>
                          <td>{{ $mercancia->almacen->almacen }}</td>
                          <td>{{ $mercancia->mercancia->nombremercancia }}</td>
                          <td>{{ $mercancia->mercancia->um }}</td>
                          <td>{{ $mercancia->cantidad }}</td>
                          <td>{{ $mercancia->mercancia->precio}} </td>
                          <td>{{ $mercancia->mercancia->precio * $mercancia->cantidad}} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr>
            @endforeach

        </div>
    </body>
</html>

