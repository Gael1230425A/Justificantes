<?php
    require_once("../../../config/Database.php");
    require_once("../../../config/Auth.php");
    //conexion a la base de datos
    $cnxDB=new Auth("localhost","root", "","justificantes");
    //verifica si existe una sesión activa
    $verifi=$cnxDB->verifySession("../../error/SinAcceso.html", "");    
    
    // Verifica si se ha solicitado cerrar la sesión
    if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
        $cnxDB->logout(); // Llama a la función logout
        header("Location: ../../auth/index.php"); // Redirige al usuario
        exit(); // Detiene la ejecución del script
    }
?>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width" />
        <link rel="stylesheet" href="../../../assets/styles/Estadisticas.css">
        <title>Mostrar Estadisticas de los Alumnos</title>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
    <body>

        <div class="container">
            <header class="header">
                <img class="header-logo" src="../../../assets/images/CBTIS86logo.png" alt="Encabezado de la Página" />
            </header>
            <nav class="menu">
        <ul class="menu-list">
                <li><a href="../../doc/PagPrincipal.php" class="menu-link">Documentación del Programa</a></li>
                <li><a href="SolicitudJustificante.php" class="menu-link">Nuevo Justificante</a></li>
                <li><a href="Estadisticas.php" class="menu-link">Estadísticas</a></li>
                <li>
                    <a href="#" class="menu-link">Movimientos Administrativos</a>
                    <ul>
                        <li><a href="../orientadores/ActDB.php" >Actualizar Bases de Datos</a></li>
                        <li><a href="../orientadores/NuevoUsuario.php">Crear Nuevo Usuario</a></li>
                        <li><a href="../orientadores/ActualizarAdmin.php">Actualizar Usuario</a></li>
                        <li><a href="../orientadores/ActualizarContrasena.php">Actualizar Contraseña</a></li>
                        <li><a href="?logout=true">Cerrar Sesión</a></li>
                    </ul>
                </li>

        </ul>
        </nav>   
            <!--Ejemplo de Estructura -->
            <form id="form" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                <fieldset class="border  border-black p-5">
                    <legend>
                        Seleccionar Semestre y Grupo:
                        <select name="Semestres">
                            <option value=""></option>
                            <option value="1°">1°</option>
                            <option value="2°">2°</option>
                            <option value="3°">3°</option>
                            <option value="4°">4°</option>
                            <option value="5°">5°</option>
                            <option value="6°">6°</option>
                        </select>

                        <select name="Grupos" id="">
                            <option value=""></option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                            <option value="H">H</option>
                            <option value="I">I</option>
                            <option value="J">J</option>
                            <option value="K">K</option>
                            <option value="L">L</option>
                            <option value="M">M</option>
                            <option value="N">N</option>
                        </select>
                        <input type="submit" value="Mostrar" name="mostrar">
                    </legend>
                    <?php
                    require_once("../../../functions/clases/Justificantes.php");
                    $meses=["1"=> 0,"2"=> 0,"3"=> 0,"4"=> 0,"5"=> 0,"6"=> 0,"7"=> 0,"8"=> 0,"9"=> 0,"10"=> 0,"11"=> 0,"12"=> 0];
                    $justificantes=new Justificantes("localhost","root","","justificantes");

                    if($_SERVER["REQUEST_METHOD"]=="POST"){
                        $semestre=$_POST["Semestres"];
                        $grupo=$_POST["Grupos"];
                        $months=$justificantes->statistics($meses,$semestre,$grupo);
                        $legendText=$justificantes->getError();
                    }
                    ?>
                    <section>
                        <fieldset>
                        <legend id="estadisticas-legend"><?=$legendText[0]?></legend>
                            <canvas id="Grafica" width="400" height="300"></canvas>
                        </fieldset>
                    </section>
                </fieldset>
            </form>
        </div>
    </body>
</html>

<script>
    let Grafic=document.getElementById("Grafica").getContext("2d");
    var Meses=<?php echo json_encode($months); ?>;
    var char = new Chart(Grafic,{
        type:"line",
        data:{
            labels:["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiempre","Octubre","Noviembre","Diciembre"],
            datasets:[
                {
                    label:"Justificantes Solicitados",
                    backgroundColor:"rgb(160, 6, 4)",
                    borderColor:"rgb(160, 6, 4)",
                    data:[Meses["1"],Meses["2"],Meses["3"],Meses["4"],Meses["5"],Meses["6"],Meses["7"],Meses["8"],Meses["9"],Meses["10"],Meses["11"],Meses["12"]]
                }
            ]
        }
    })    
</script>


<style>
#Grafica {
            max-width: 800px; /* Ajusta el ancho máximo */
            max-height: 400px; /* Ajusta la altura máxima */
            margin: 0 auto; /* Centrar el canvas */
        }
</style>