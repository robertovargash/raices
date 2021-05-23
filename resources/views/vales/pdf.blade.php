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
                    <strong>Vale de despacho   </strong>
                </div>
                <div class="Column">
                    <strong>NIT: </strong> {{ $proveedor->nit }}
                </div>
                <div class="Column">
                    <strong>Entidad: </strong> {{ $proveedor->nombre }}
                </div>
            </div>
            <div class="Row">
                <div class="Column">
                    <strong>Cod. Alm.: </strong> {{ $vale->almacen_id }}
                </div>
                <div class="Column">
                    <strong>Almacén: </strong> {{ $vale->almacen_id }}
                </div>
                <div class="Column">
                    <strong>Vale No.: </strong> {{ $vale->id }}
                </div>
                <div class="Column">
                    <strong>Emisión: </strong> {{ date('d-m-Y', strtotime($vale->fecha)) }}
                </div>
            </div>
            <div>
                @if ($vale->tipovale == 1)
                <div style="text-align: left">
                    <strong>OT: </strong> {{ $vale->ordentrabajo->id }}
                    <strong> Producto: </strong> {{ $vale->ordentrabajo->tproducto->nombre }}
                </div>
                @else
                    <div>
                        <strong>Vale para gastos</strong>
                    </div>
                @endif
            </div>
          </div>
          <div id="footer">
            <div class="Row">
                <div class="Column">
                    <strong>Cantidad de renglones: </strong> {{ $vale->valeitems->count() }}
                </div>
                <div class="Column">
                    <strong>Importe total: </strong> {{ $importetotal }}
                </div>
            </div>
            <div class="Row">
                <div class="Column">
                    <strong>Solicita: </strong> {{ $vale->p_solicita }}
                    <br>
                    <strong>Firma _____________________________</strong>
                </div>
                <div class="Column">
                    <strong>Despachado: </strong> {{ $vale->p_entrega }}
                    <br>
                    <strong>Firma _____________________________</strong>
                </div>
                <div class="Column">
                    <strong>Autoriza: </strong> {{ $vale->p_autoriza }}
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
                    <p style="text-align: right;">SC-2-08</p>
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
                  @foreach ($vale->valeitems as $vitem)
                  <tr>
                    <td>{{ $vitem->mercancia->codigo }}</td>
                    <td>{{ $vitem->mercancia->nombremercancia }}</td>
                    <td>{{ $vitem->mercancia->um }}</td>
                    <td>{{ $vitem->cantidad }}</td>
                    <td>{{ $vitem->precio}} </td>
                    <td>{{ $vitem->importe }} </td>
                    <td>{{ $vitem->existencia }}</td>
                  </tr>
                  @endforeach
                </tbody>
            </table>
            <hr>
            <div>
                <strong>Observaciones: </strong><p>{{ $vale->observaciones }}</p>
            </div>
        </div>
    </body>
</html>
