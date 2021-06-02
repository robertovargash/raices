
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
                    <strong>SOLICITUD</strong>
                </div>
                <div class="Column">
                    <strong>Número: </strong> {{ $solicitude->numero }}
                </div>
                <div class="Column">
                    @if ($solicitude->pagada === 1)
                    <strong>Solicitud pagada</strong>
                    @else
                    <strong>Solicitud sin pagar</strong>
                    @endif
                </div>
            </div>
            <div class="Row">                
                <div class="Column">
                    <strong>Importe total: </strong>${{ $acobrar }}
                </div>
                <div class="Column">
                    <strong>Entidad: </strong> {{ $proveedor->nombre }}
                </div>
                <div class="Column">
                    <strong>Emisión: </strong> {{ date('d/m/Y', strtotime($solicitude->fechasolicitud)) }}
                </div>
                <div class="Column">
                    <strong>Entrega: </strong> {{ date('d/m/Y', strtotime($solicitude->fechaentrega)) }}
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
            <table class="table table-bordered" >
                <thead>
                    <tr>
                      <th>Producto</th>
                      <th>Cantidad</th>
                      <th>Precio</th>
                      <th>Importe</th>
                      <th>Terminado</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($solicitude->solicitudproductos as $sproducto)
                    <tr>
                        <td>{{ $sproducto->tproducto->nombre }}</td>
                        <td>{{ $sproducto->cantidad }}</td>
                        <td>{{ $sproducto->tproducto->valorbruto }}</td>
                        <td>{{ $sproducto->tproducto->valorbruto * $sproducto->cantidad  }}</td>
                        <td>
                            @if ($sproducto->terminado == 1)
                                Si
                            @else
                                No
                            @endif
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
            </table>
            <hr>
            <div>
                <strong>Descripción: </strong><p>{{ $solicitude->descripcion }}</p>
            </div>
            
            <div class="Row">   
                <div class="Column">
                    <strong>QR comprobante: </strong>
                    <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(200)->generate(".$qr.")) }}">   
                </div>             
                <div class="Column">
                    <strong>QR de Cobro: </strong>
                    <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(200)->generate(".$qrcobro.")) }}">   
                </div>
                
            </div>
        </div>
    </body>
</html>
