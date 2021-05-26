<html>
    <head>
        <style>
            /**
                Establezca los márgenes de la página en 0, por lo que el pie de página y el encabezado
                puede ser de altura y anchura completas.
             **/
             @page { margin: 250px 30px; }
            #header { position: fixed; left: 0px; top: -230px; right: 0px; height: 30px;text-align: left; }
            #footer { position: fixed; left: 0px; bottom: -150px; right: 0px; height: 60px; }
            #footer .page:after { content: counter(page); }

            .Row {
            display: table;
            width: 100%; /*Optional*/
            table-layout: fixed; /*Optional*/
            border-spacing: 3px; /*Optional*/
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
                    <strong>Informe de recepción </strong>
                </div>
                <div class="Column">
                    <strong>Entidad: </strong> {{ $proveedor->nombre }}
                </div>
                <div class="Column">
                    <strong>NIT: </strong> {{ $proveedor->nit }}
                </div>
                
                <div class="Column">
                    <strong>Emisión: </strong> {{ date('d-m-Y', strtotime($recepcion->fecha)) }}
                </div>
                <div class="Column">
                    <strong>Número: </strong> {{ $recepcion->numero }}
                </div>
            </div>
            <div class="Row">
                <div class="Column">
                    <strong>Unidad: </strong> -
                </div>
                <div class="Column">
                    <strong>Código unidad: </strong> -
                </div>
                <div class="Column">
                    <strong>Almacén: </strong> {{ $recepcion->almacen->almacen }}
                </div>
                <div class="Column">
                    <strong>Cod. Almacén: </strong> {{ $recepcion->almacen_id }}
                </div>
            </div>
            <div class="Row">
                <div class="Column">
                    <strong>Proveedor: </strong>{{ $recepcion->proveedor }}
                </div>
                <div class="Column">
                    <strong>Codigo: </strong> -
                </div>
                <div class="Column">
                    <strong>Contrato: </strong> {{ $recepcion->contrato }}
                </div>
                <div class="Column">
                    <strong>Factura: </strong> {{ $recepcion->factura }}
                </div>
                <div class="Column">
                    <strong>Conduce: </strong> {{ $recepcion->conduce }}
                </div>
            </div>
            <div class="Row">
                <div class="Column">
                    <strong>Solic. de Compra: </strong>{{ $recepcion->scompra }}
                </div>
                <div class="Column">
                    <strong>Manifiesto: </strong> {{ $recepcion->manifiesto }}
                </div>
                <div class="Column">
                    <strong>Conc. Embarque: </strong> {{ $recepcion->conocimiento }}
                </div>
                <div class="Column">
                    <strong>Casilla Ferr.: </strong> {{ $recepcion->casilla }}
                </div>
            </div>
            <div class="Row">
                <div class="Column">
                    <strong>Partida No.: </strong>{{ $recepcion->partida }}
                </div>
                <div class="Column">
                    <strong>Cant. Bultos: </strong> {{ $recepcion->bultos }}
                </div>
                <div class="Column">
                    <strong>Tipo bultos: </strong> {{ $recepcion->tbultos }}
                </div>
                <div class="Column">
                    <strong>Orden Expedición: </strong> {{ $recepcion->expedicion }}
                </div>
            </div>
            <div class="Row">
                <div class="Column">
                    <strong>Transportista: </strong>{{ $recepcion->transportista }}
                </div>
                <div class="Column">
                    <strong>CI: </strong> {{ $recepcion->tci }}
                </div>
                <div class="Column">
                    <strong>Chapa: </strong> {{ $recepcion->tchapa }}
                </div>
                <div class="Column">
                    <strong>Firma: </strong> _______________
                </div>
            </div>
            
          </div>
          <div id="footer">
            <div class="Row">
                <div class="Column">
                    <strong>Cantidad de renglones: </strong> {{ $recepcion->recepcionmercancias->count() }}
                </div>
                <div class="Column">
                    <strong>Importe total: </strong> {{ $importetotal }}
                </div>
            </div>
            <div class="Row">
                <div class="Column">
                    <strong>Recepciona: </strong> {{ $recepcion->p_recibe }}
                    <br>
                    <strong>Firma _____________________________</strong>
                </div>
                <div class="Column">
                    <strong>Despachado: </strong> {{ $recepcion->p_entrega }}
                    <br>
                    <strong>Firma _____________________________</strong>
                </div>
                <div class="Column">
                    <strong>J' Almacén: </strong> {{ $recepcion->p_autoriza }}
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
                <div class="Column">
                    <p style="text-align: right;">SC-2-04</p>
                </div>
            </div>

          </div>
          <div id="content">
            <table class="table table-bordered" >
                <thead>
                  <tr>
                    <th>Código</th>
                    <th>Mercancía</th>
                    <th>UM</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Importe</th>
                    <th>Existencia</th>
                  </tr>
                </thead>
                <tbody>                    
                  @foreach ($recepcion->recepcionmercancias as $ritem)
                  <tr>
                    <td>{{ $ritem->mercancia->codigo }}</td>
                    <td>{{ $ritem->mercancia->nombremercancia }}</td>
                    <td>{{ $ritem->mercancia->um }}</td>
                    <td>{{ $ritem->cantidad }}</td>
                    <td>{{ $ritem->precio}} </td>
                    <td>{{ $ritem->importe }} </td>
                    <td>{{ $ritem->existencia }}</td>
                  </tr>
                  @endforeach
                </tbody>
            </table>
            <hr>
            <div>
                <strong>Observaciones: </strong><p>{{ $recepcion->observaciones }}</p>
            </div>
        </div>
    </body>
</html>
