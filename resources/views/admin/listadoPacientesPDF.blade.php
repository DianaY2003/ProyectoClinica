<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Pacientes</title>
    <link rel="stylesheet" href="css\styles.css">
</head>
<body>
      <header>
        <div class="header_log">
             <img src="img/logo.jpeg" alt="logo" id="logo">
        </div>
        <div><h3>Clinica odontológica Healthy Smiles S.V</h3></div>
      </header>
      <div class="container">
        <h4 id="titulo_reporte">Listado de Pacientes </h4>
        <table id="inv">
                   <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Dui</th>
                        <th>Telefono</th>
                        <th>Fecha Nacimiento</th>
                        <th>Sexo</th>
                        <th>Estado Civil</th>
                        <th>Distrito</th>
                    </tr>
                    <?php $i =0; ?>
                   </thead>
                   <tbody>
                      @foreach($pacientes as $Paciente)
                         <tr>
                            
                            <td>{{$Paciente->nombre}}</td>
                            <td>{{$Paciente->apellido}}</td>
                            <td>{{$Paciente->dui}}</td>
                            <td>{{$Paciente->telefono}}</td>
                            <td>{{$Paciente->fecha_nacimiento}}</td>
                            <td>{{$Paciente->sexo}}</td>
                            <td>{{$Paciente->estado_civil}}</td>
                            <td>{{$Paciente->distrito_nombre}}</td>
                         </tr>
                         <?php $i++; ?>
                      @endforeach
                      <tr>
                        <td colspan="8"> Total de Pacientes &nbsp;&nbsp; {{$i}}</td>
                      </tr>
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