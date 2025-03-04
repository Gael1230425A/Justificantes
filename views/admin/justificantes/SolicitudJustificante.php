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
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Solicitud de Justificante</title>
        <link rel="stylesheet" href="../../../assets/styles/NuevoJustificante.css">
    </head>
    <body class="bg-amber-100">
        <!--Contenedor Principal encargado del layout-->
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
            <header class="soli-justi">
                <h2 class="titulo">Solicitud de Justificantes</h2>
            </header>

            <!--Buscador -->
            <main>
                <form action="../../../functions/justificantes/TramiteJusti.php" method="GET" name="Formcont" class="Formcont"> 
                    <fieldset class="fieldset-nocontrol">
                        <legend class="legend-nocontrol">
                            <header>
                                <h3><strong>Número de Control del alumno:</strong></h3>
                            </header>
                        </legend>
                        
                        <label class="label-nocontrol">
                            <input type="number" placeholder="No.control" name="Nocont" class="Nocont">
                            <input type="submit" value="Buscar Alumno" name="Buscador" class="Buscador">
                        </label>    
                       
                    </fieldset>
                </form>
            </main>
        </div>

    </body>
</html>