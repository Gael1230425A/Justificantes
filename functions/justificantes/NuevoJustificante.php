<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    require_once("../../config/Auth.php");
    //conexion a la base de datos
    $cnxDB=new Auth("localhost","root", "","justificantes");
    //verifica si existe una sesión activa
    $verifi=$cnxDB->verifySession("../../views/error/SinAcceso.html", "");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Nuevo Justificante</title>
    <link rel="stylesheet" href="../../assets/styles/Justificantes.css">
</head>
<body>
<div class="container">
    <header class="header">
        <img class="header-logo" src="../../assets/images/CBTIS86logo.png" alt="Encabezado de la Página" />
     </header>
    <?php 
    //Incluye a la clase que se encarga de los justificantes
     require_once('../clases/Justificantes.php'); 

    //Recupera el id del formulario
     $Nocont=$_GET["Nocont"];
     
     //Se crea un nuevo objeto de la clase
     $estudiante=new Justificantes("localhost","root","","justificantes");

     //Busca el estudiante en la base de datos
     $busqueda= $estudiante->prepareQuery("SELECT * FROM estudiantes INNER JOIN tutor ON estudiantes.numTutor=tutor.numTutor WHERE estudiantes.NoControl=?", "i", [$Nocont]);

     $rows= $busqueda->fetch_assoc();
    ?>
    <form name="Form_just" id="Form_just" method="POST">
    <table border="1" name="Tab_jus">
        <thead><tr><th colspan="5">Justificantes</th></tr></thead>
        <tbody>
            <tr>
                <th>Alumno: <?php echo $rows["Nombre"]?></th> 
                <th>Semestre y Grupo: <?php echo $rows["Semestre"].$rows["Grupo"]?></th> 
                <th>Tutor: <?php echo $rows["nombreTutor"] ?></th> 
                <th>Fecha: <?php echo $fech_ho=date("Y-m-d "); ?></th>
                <th>No.Control: <?php echo $rows["NoControl"]?></th>
            </tr>
            <tr>
                <th colspan="5">Situacion:</th>
            </tr>
            <tr>
                <th colspan="1" style="text-align:center;"><input required type="radio" name="sit" id="eme" value="Emergencia Familiar"></th>
                <th colspan="4" name="emerg">Emergencia Familiar</th>
            </tr>
            <tr>
                <th colspan="1" style="text-align:center;"><input required type="radio" name="sit" id="con" value="Consulta Medica"></th>
                <th colspan="4" name="soli">Consulta Médica</th>
            </tr>
            <tr>
                <th colspan="1" style="text-align:center;"><input required type="radio" name="sit" id="sol" value="Solicitud del Tutor"></th>
                <th colspan="4" name="soli">Solicitud del Tutor</th>
            </tr>
            <tr>
                <th colspan="1" style="text-align:center;"><input required type="radio" name="sit" id="enf" value="Enfermedad"></th>
                <th colspan="4" name="enf">Enfermedad</th>
            </tr>
            <tr>
                <th colspan="1" style="text-align:center;"><input required type="radio" name="sit" id="otro" value="Otro"><br><input required type="text" name="sit" id="expli" disabled></th>
                <th colspan="4" name="otro">Otro</th>
            </tr>
            <tr>
                <th colspan="3">Fecha de la falta</th>
                <th colspan="2"><input type="date" name="De" id="de" required> a <input type="date" name="a" id="a" required></th>
            </tr>
            <?php
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                //Datos recibidos del formulario
                $Situacion=$_POST["sit"];
                $Fechasoli=date("Y-m-d");
                $Fechade=$_POST["De"];
                $Fechaa=$_POST["a"];
                $orientador=$_SESSION["user_id"];
                $estudiante->insertStudent($Nocont,$Fechasoli,$Situacion,$Fechade,$Fechaa,$orientador);
                
            }
            ?>
        </tbody>
    </table> 
    <input type="submit">
    <button type="button"><a href=<?="TramiteJusti.php?Nocont=$Nocont"?>>Regresar</a></button>
    </form>

    <h1 id="error" style="color: green;"><?php $error=$estudiante->getError(); if(count($error)>2){echo $error[2];} else if(count($error)===1) {echo $error[0];}?></h1>
   </div>
</body>
<script>
    const expli = document.getElementById('expli');

    // evento para el input radio del "si"
    function actInp(id){
        document.getElementById(id).addEventListener('click', function(e) {
            console.log('Vamos a habilitar el input text');
            expli.disabled = false;
        });
    }
    function desInput(id){
        document.getElementById(id).addEventListener('click', function(e) {
            expli.disabled = true;
            expli.value="";
        });
    }
    actInp('otro');
    desInput('eme');
    desInput('con');
    desInput('enf');
    desInput('sol');


    document.getElementById('Form_just').addEventListener('submit', function(event)
    {
        event.preventDefault();

        const Fechde= new Date(document.getElementById('de').value);
        const Fecha= new Date(document.getElementById('a').value);
        const error= document.getElementById('error');

        if(Fechde< Fecha)
    {
        this.submit();
    }
    else if(Fechde>Fecha)
    {
        error.textContent ="Las fechas estan mal colocadas";
    }
    else
    {
        this.submit();
    }
    })
</script>
</html>