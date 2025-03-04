<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trámite de Nuevo Justificante</title>
    <link rel="stylesheet" href="../../assets/styles/Solicitud.css">
</head>
<body>
    <div class="container">
    <header class="header">
       <img class="header-logo" src="../../assets/images/CBTIS86logo.png" alt="Encabezado de la Página" />
    </header>
    
<?php
    require_once('../clases/Justificantes.php'); 
    //Obtiene el número de control del formulario
    $noCont=$_GET["Nocont"];

    //Clase Justificantes la cual se encarga de todo lo relacionado a ellos
    $justificantes=new Justificantes("localhost","root","","justificantes");
    
    //Search student, busca al estudiante en la DB y conforme al resultado de la consulta va estableciendo errores
    $justificantes->searchStudent($noCont);

    //se obtienen los errores establecidos
    $errors=$justificantes->getError();

    //se obtienen los datos del estudiante
    $estudiantes=$justificantes->getStudents();

    //se obtienen los datos de los justificantes tramitados
    $justis=$justificantes->getJusti();

    //está relacionado al número de justificantes actuales
    $buttons=$justificantes->getButtons();

    //cuando ese número de justificantes es superado el valor de buttons cambia
    function impBoton($buttons, int $noCont){
        if($buttons[0]=="Nuevo Justificante"){
            echo "<button><a href='NuevoJustificante.php?Nocont=$noCont' name='soli_justi'>$buttons[0]</a></button>";
        }
        else if($buttons[0]=="No puedes tramitar más justificantes"){
            echo "<h2 style='color: red; padding: 10px'>$buttons[0]</h2>";
        }
    }

    //si el estudiante existe y tiene en existencia algún justificante tramitado, imprime los datos necesarios
    if(!empty($estudiantes)&&!empty($justis)){
        //Tabla con datos del estudiante
        echo "<table border=0 name='Tab_inf'>";
        echo "<tr>";
        $arrayDatos=["NoControl", "Nombre", "Semestre y Grupo", "Turno", "Tutor"];
        foreach($arrayDatos as $datos){
            echo "<th> $datos";
            foreach($estudiantes as $estudiante){
                echo ": $estudiante[$datos] <br></th>";
            }
        }
        echo "</tr>";
        echo "</table>";

        //tamaño del array para hacer un ciclo for
        $indiceJustificantes=0;
        $indiceDatos=0;
        echo "<table border='1' name='Tab_justi'>";
        echo "<tr><th>Folio</th><th>Situacion</th><th>Fech.Solicitud</th><th>Fech.Falta</th></tr>";
        $arrayDJusti=["Folio","Situacion", "Fecha Solicitud","Fecha Falta"];
        foreach($justis as $justi){
            echo"<tr>";
            foreach($arrayDJusti as $Datos){
                echo"<th>$justi[$Datos]";
                if($Datos==="Fecha Falta"){
                    echo "<button><a href='imprimir.php?Folio=$justi[Folio]' target='_blank'>Imprimir</a></button>";
                }
                echo"</th>";
            }
            echo"</tr>";
        }
        echo "</table>";
        impBoton($buttons,$noCont);
    }
    //en dado caso de que el estudiante no exista en la base de datos, se lanza un error
    else if($estudiantes==null){
        echo("<h2 style='color: red; padding: 10px'>$errors[0]</h2>");
    }
    //si no tiene ningún justificante tramitado, imprime los datos del justificante y se lanza un error
    else if($justis==null){
        echo "<table border=0 name='Tab_inf'>";
        echo "<tr>";
        $arrayDatos=["NoControl", "Nombre", "Semestre y Grupo", "Turno", "Tutor"];
        foreach($arrayDatos as $datos){
            echo "<th> $datos";
            foreach($estudiantes as $estudiante){
                echo ": $estudiante[$datos] <br></th>";
            }
        }
        echo "</tr>";
        echo "</table>";
        echo("<h2 style='color: red; padding: 10px'>$errors[0]</h2>");
        impBoton($buttons,$noCont);
    }
?>

    <a href="../../views/admin/justificantes/SolicitudJustificante.php">Regresar</a>
    </div>
   
</body>
</html>