<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de pagos</title>
    <link rel="stylesheet" href="css\styles.css">
    <style>
       
        table {
            width: 100%; /*ancho del contenedor */
            border-collapse: collapse; /*borde y espacio entre las celdas */
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9; /* fondo de las filas */
        }
       
        
       
    </style>
</head>

<body>
    <header>
        <div class="header_log">
            <img src="img/logo.jpeg" alt="logo" id="logo">
        </div>
        <div>
            <h3>Clinica odontológica Healthy Smiles S.V</h3>
        </div>
    </header>
    <div class="container">
        <h4 id="titulo_reporte">Reporte de Pagos</h4>
        <h5 id="subtitulo_reporte">
            Periodo del: &nbsp; {{ $fecha1 }} &nbsp; al &nbsp; {{ $fecha2 }}
        </h5>
        <table>
            <thead>
                <tr>
                   
                    <th>Paciente</th>
                    <th>Fecha de Pago</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                @if($pagos->isEmpty())
                    <tr>
                        <td colspan="4" style="text-align: center;">No hay registros para mostrar.</td>
                    </tr>
                @else
                    @foreach ($pagos as $pago)
                        <tr>
                          
                            <td>{{ $pago->paciente }}</td>
                            <td>{{ $pago->fecha_pago }}</td>
                            <td>${{ number_format($pago->precio, 2) }}</td>

                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(270, 800, "Página $PAGE_NUM de $PAGE_COUNT", $font, 10);
            ');
        }
	</script>
</body>

</html>