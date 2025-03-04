<?php
    require_once("../../config/Auth.php");
    //conexion a la base de datos
    $cnxDB=new Auth("localhost","root", "","justificantes");
    //verifica si existe una sesión activa
    $verifi=$cnxDB->verifySession("../../error/SinAcceso.html", "");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Justificante de Ausencia Escolar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 90%;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 200px;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
        .footer div {
            margin-bottom: 10px;
        } 
    </style>
</head>
<body>
    <?php
     require_once("../clases/Justificantes.php"); 
     $folio=$_GET["Folio"];
     
     //Clase justificantes
     $justificantes=new Justificantes("localhost","root","","justificantes");
     $justificantes->printJusti($folio);
     $datosJusti=$justificantes->getJusti();
     $datosEstudiante=$justificantes->getStudents();

     $estudiante=[];
     $justificante=[];
     for($i=0; $i<=(count($datosEstudiante)+1); $i++){
        foreach($datosEstudiante as $dato){
            $estudiante[]=$dato[$i];
        }
     }
     for($i=0; $i<=(count($datosJusti)+3); $i++){
        foreach($datosJusti as $dato){
            $justificante[]=$dato[$i];
        }
     }
    ?>
    <table border="1" style="font-family: Algerian;" width="100%"><tr><td><img src="../../assets/images/640px-SEP_Logo_2019.jpg" width="140px" style="float:left;"><h1 style="text-align: center;">JUSTIFICANTE</h1> <h3 style="text-align: right;">Folio:<?php echo $folio ?></h3></td></tr></table>
    <br>
    <div class="container">
        <table class="table">
            <tr>
                <th width="10px"><input type="checkbox" id="Emergencia Familiar"></th>
                <th>Emergencia Familiar</th>
                <th>Nombre: <?=$estudiante[0]?> Grado y Grupo: <?=$estudiante[2].$estudiante[1]?></th>
            </tr>
            <tr>
                <th width="10px"><input type="checkbox" id="Solicitud del Tutor"></th>
                <th>Solicitud del Tutor</th>
                <td></td>
            </tr>
            <tr>
                <th width="10px"><input type="checkbox" id="Consulta Medica"></th>
                <th>Consulta Médica</th>
                <th rowspan="2">Por <?=$justificante[4]?> día(s)  de <?="$justificante[2] al $justificante[3] "?></th>
            </tr>
            <tr>
                <th width="10px"><input type="checkbox" id="Enfermedad"></th>
                <th>Enfermedad</th>
            </tr>
            <tr>
                <th width="10px"><input type="checkbox" id="Otro"></th>
                <th>Otro (especificar)</th>
                <td><?php if($justificante[0] === "Otro")echo $justificante[0]; else echo ""; ?></td>
            </tr>
            <tr>
                <th width="10px"><input type="checkbox"></th>
                <th colspan="2" style="font-family: Brush Script MT; font-size: 20px;">Así mismo en caso de que durante esos días se haya realizado algún examen o trabajo académico, favor de dar oportunidad al alumno de presentarlo</th>
            </tr>
            <tr>
                <th colspan="3">
                    <p style="text-align: center;"><strong>Huauchinango Pue. a <?=$justificante[1]?></strong></p>
                    <br><br><br><br>
                    <div style="float: left;">
                    <p style="text-align: center; font-size: 14px;"><strong style="font-family: Algerian;">LIC. SONIA ESCAMILLA OLMEDO</strong><br>
                    Jefe de la Ofna. de Orientación Educativa<br>
                    Turno Matutino</p>
                </div>
                <div style="float: right;">
                    <p style="text-align: center; font-size: 14px;"><strong style="font-family: Algerian;">C.P. EZEQUIEL BARRIOS NEGRETE</strong><br>
                    Jefe de la Ofna. de Orientación Educativa<br>
                    Turno Vespertino</p>
                </div>
                </th>
            </tr>
        </table>
    <input type="button" value="Imprimir" class="printbutton" id="boton">
    
    <script>
        document.getElementById(<?php echo json_encode($justificante[0]); ?>).checked=true;
        document.querySelectorAll('.printbutton').forEach(function(element) {
    element.addEventListener('click', function() {
        document.getElementById("boton").style.display = "none";
         window.print();
        
    });
});
    </script>
</body>
</html>
