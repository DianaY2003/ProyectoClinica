<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Citas</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Asegúrate de que la ruta sea correcta -->
    <style>
        table {
            width: 100%;
            /* Ancho del contenedor */
            border-collapse: collapse;
            /* Borde y espacio entre las celdas */
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
            /* Fondo de las filas */
        }
    </style>
</head>

<body>
    <header>
        <div class="header_log">
            <img src="img/logo.jpeg" alt="logo" id="logo"> <!-- Asegúrate de que la ruta sea correcta -->
        </div>
        <div>
            <h3>Clinica Odontológica Healthy Smiles S.V</h3>
        </div>
    </header>
    <div class="container">
        <h4 id="titulo_reporte">Reporte de Citas</h4>
        <h5 id="subtitulo_reporte">
            Periodo del: &nbsp; {{ $fecha1 }} &nbsp; al &nbsp; {{ $fecha2 }}
        </h5>
        <table>
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Fecha</th>

                </tr>
            </thead>
            <tbody>
                @if($publicas->isEmpty())
                <tr>
                    <td colspan="4" style="text-align: center;">No hay registros para mostrar.</td>
                </tr>
                @else
                @foreach ($publicas as $publica)
                <tr>
                    <td>{{ $publica->publicas }}</td> <!-- Aquí se muestra el nombre del usuario -->
                    <td>{{ $publica->fecha }}</td>
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