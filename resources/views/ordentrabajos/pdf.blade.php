<html>
    <head>
        <style>
            /**
                Establezca los márgenes de la página en 0, por lo que el pie de página y el encabezado
                puede ser de altura y anchura completas.
             **/
             @page { margin: 170px 50px; }
            #header { position: fixed; left: 0px; top: -120px; right: 0px; height: 110px;text-align: center; }
            #footer { position: fixed; left: 0px; bottom: -60px; right: 0px; height: 60px; }
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
        text-align: left;
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
        text-align: left;
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
                    <strong>Órden de trabajo   </strong>
                </div>
                <div class="Column">
                    <strong>Numero: </strong> {{ $ot->numero }}
                </div>
                <div class="Column">
                    <strong>Entidad: </strong> {{ $proveedor->nombre }}
                </div>
                <div class="Column">
                    <strong>Emisión: </strong> {{ date('d-m-Y', strtotime($ot->fecha)) }}
                </div>
            </div>
          </div>
          <div id="footer">            
            <div class="Row">
                <div class="Column">
                    <strong>Operario: </strong> {{ $ot->operario }}
                    <br>
                    <strong>Firma _____________________________</strong>
                </div>
                <div class="Column">
                    <strong>Técnico: </strong> {{ $ot->tecnico }}
                    <br>
                    <strong>Firma _____________________________</strong>
                </div>
            </div>
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
            <table class="table table-bordered" >
                <thead>
                    <tr>
                      <th>Solicitud</th>
                      <th>Cliente</th>
                      <th>Fecha</th>
                      <th>Cant. productos</th>
                      <th>Terminados</th>
                      <th>Importe</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach ($ot->otsolicitudes as $otsolicitud)
                      <tr>
                        @foreach ($otsolicitud->solicitude->solicitudproductos as $solicitudproducto)
                          @if ( $solicitudproducto->tproducto->id == $ot->tproducto_id)
                          <td>{{ $otsolicitud->solicitude->id }}  </td>
                          <td>{{ $otsolicitud->solicitude->cliente }}</td>
                          <td>{{ date('d/m/Y', strtotime($otsolicitud->solicitude->fechasolicitud)) }}</td>
                          <td>{{ $solicitudproducto->cantidad }} {{  $solicitudproducto->tproducto->nombre }}</td>
                          <td>
                              @if ($otsolicitud->terminado == 1)
                                  Si
                              @else
                                  No
                              @endif
                          </td>
                          @endif
                        @endforeach
                        <td>{{ $solicitudproducto->cantidad * $solicitudproducto->tproducto->valorbruto }}</td>
                      </tr>
                      @endforeach
                  </tbody>
            </table>
            <hr>
            <h5>Materias Primas</h5>
            <table class="table table-bordered" >
                <thead>
                    <tr>
                      <th>Mat. prima</th>
                      <th>Cant. necesaria</th>
                      <th>Precio</th>
                      <th>Importe</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($ot->tproducto->materiaprimas as $mprima)
                    <tr>
                        <td>{{ $mprima->mercancia->nombremercancia  }}</td>
                        <td>{{ $mprima->cantidadnecesaria * $ot->cantidad }} {{$mprima->mercancia->um}}</td>
                        <td>{{ $mprima->mercancia->precio}}</td>
                        <td>{{ $mprima->cantidadnecesaria * $ot->cantidad * $mprima->mercancia->precio}}</td>
                    </tr>
                    @endforeach
                  </tbody>
            </table>
            <hr>
            <div>
                <strong>Observaciones: </strong><p>{{ $ot->observaciones }}</p>
            </div>
        </div>
    </body>
</html>
