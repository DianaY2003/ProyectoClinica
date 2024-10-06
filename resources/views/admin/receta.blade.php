<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receta clinica</title>

    <style>
        /****Color 
        #82d7be
        ***/
        
        html {
            box-sizing: border-box;
            padding: 10px 30px;
        }
        
        body {
            font-family: sans-serif;
        }
        
        .input_form {
            width: 90%;
            padding: 8px 12px;
            outline: none;
            border: 1px solid #696969;
            border-radius: 4px;
        }
        
        .description_receta {
            border: 1px solid #020202;
            padding: 20px;
            margin: 40px 0px;
            border-radius: 6px;
            font-size: 8px;
        }
        
        .description_body {
            height: 450px;
        }
        
        .text_footer {
            color: #82d7be;
            font-weight: 700;
        }
        
        .description_footer {
            text-align: center;
        }
        
        .input_title {
            font-weight: 700;
            color: #82d7be;
        }
    </style>

</head>

<body id="print_pdf">

    <table style="width: 100%;">
        <tr>
            <td colspan="100" style="width: 100%;text-align: right;">
                <img src="img/logo_empresa.jpg" width="150" height="80" alt="">
            </td>
        </tr>
        <tr>
            <td colspan="100" style="width: 100%;text-align: right;color: #737373;font-size: 12px;">Clínica Odontológica.</td>
        </tr>
    </table>

    <table style="width: 100%;">
        <tr>
            <td colspan="10" style="width: 10%;text-align: left;"><label class="input_title">Nombre: {{$cita->paciente->nombre}} {{$cita->paciente->apellido}} </label></td>
            
        </tr>
        <tr>
            <td colspan="10" style="width: 10%;text-align: left;"><label class="input_title">DUI: {{$cita->paciente->dui}}  </label></td>
            <td colspan="10" style="width: 10%;text-align: center;"><label class="input_title">Fecha: {{$cita->fecha}} </label></td>
        </tr>
    </table>

    <div class="description_receta">
        <div class="description_body">
        @foreach($cita->recetas as $medicamentos)
        <div class="receta">
        @foreach($medicamentos->medicamentos as $medicamento)
        <div class="receta">
            <h3>Medicamento: {{ $medicamento->nombre }}</h3> <!-- Asumiendo que tienes una relación con el modelo Medicamento -->
            <h3>Cantidad: {{ $medicamento->pivot->cantidad }}</h3>
            <h3>Dosis: {{ $medicamento->pivot->dosis }}</h3>

            <hr>
            <!-- Agrega otros campos que necesites mostrar aquí -->
        </div>
    @endforeach
        </div>
    @endforeach
        </div>
        <div class="description_footer">
            <span class="text_footer">Nadia Gómez.</span> <br> <span style="color: #415158;">Doctora en Cirugia Dental. <br> Tel. 7750-4123</span>
        </div>
    </div>

    <table style="width: 100%;">
        <tr>
            <td colspan="100" style="width: 100%;text-align: right;color: #415158;">Colonia San Francisco, Ave Las Dalias, <br>Calle Los Eucaliptos, Casa 622B, San Salvador.</td>
        </tr>
        <tr>
            <td colspan="100" style="width: 100%;text-align: right;color:#8ddbc4;font-size: 12px;padding-top: 30px;">
                FB. Dra Nadia Gomez Healthy Smiles. | @Dranadiagomezsv
            </td>
        </tr>
    </table>

</body>

</html>