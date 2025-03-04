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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../../assets/styles/ActDB.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <img class="header-logo" src="../../../assets/images/CBTIS86logo.png" alt="Encabezado de la Página" />
        </div>
        <nav class="menu">
        <ul class="menu-list">
                <li><a href="../../doc/PagPrincipal.php" class="menu-link">Documentación del Programa</a></li>
                <li><a href="../justificantes/SolicitudJustificante.php" class="menu-link">Nuevo Justificante</a></li>
                <li><a href="../justificantes/Estadisticas.php" class="menu-link">Estadísticas</a></li>
                <li>
                    <a href="#" class="menu-link">Movimientos Administrativos</a>
                    <ul>
                        <li><a href="ActDB.php" >Actualizar Bases de Datos</a></li>
                        <li><a href="NuevoUsuario.php">Crear Nuevo Usuario</a></li>
                        <li><a href="ActualizarAdmin.php">Actualizar Usuario</a></li>
                        <li><a href="ActualizarContrasena.php">Actualizar Contraseña</a></li>
                        <li><a href="?logout=true">Cerrar Sesión</a></li>
                    </ul>
                </li>
        </ul>
        </nav>   

        <section id="seccion-actualizacion">
            <form id="excelForm" method="POST">
                <fieldset>
                    <legend>Actualizar la Base de Datos de los Alumnos</legend>
                    <h4>Subir archivo Excel</h4>
                    <input type="file" name="subirArc" id="subirArc" accept=".xls, .xlsx, .csv">
                    <button type="submit" id="envInserts">Subir a la Base de datos</button>
                    <input type="hidden" value="" name="alu" id="alu">
                    <input type="hidden" value="" name="tuto" id="tuto">
                    <?php
                    require_once("../../../functions/clases/ClasePadre.php");
                    require_once("../../../functions/clases/Orientador.php");
                    $orientador= new Orientador("localhost","root","","justificantes");
                    if($_SERVER["REQUEST_METHOD"]==="POST"){
                        $insertTutor=$_POST['tuto'];
                        $insertAlumno=$_POST['alu'];  
                        $orientador->insertStudentsandParents($insertAlumno,$insertTutor);
                        $error=$orientador->getError();
                    }

                    ?>
                    <h4 class="error"><?= $error[0]?></h4>
                </fieldset>
            </form>


            <form class="form-eliminacion" id="form-eliminacion1" name="form-eliminacion" method="post" action="../php/EditarBasedeDatos.php">
                <fieldset id="f1">
                    <legend>Edición de la Base de Datos</legend>
                    <table border="1">
                        <thead>
                            <th></th>
                            <th>Tabla</th>
                            <th colspan="3">Acción</th>
                            <th>Filas</th>
                        </thead>
                        <tbody>
                            <td><input type="checkbox" name="" id=""></td>
                            <td>Tabla 1</td>
                            <td><a href="">Buscar</a></td>
                            <td><a href="">Insertar</a></td>
                            <td><a href="">Vaciar</a></td>
                            <td>Nfilas</td>
                        </tbody>
                        <tbody>
                            <td><input type="checkbox" name="" id=""></td>
                            <td>Tabla 2</td>
                            <td><a href="">Buscar</a></td>
                            <td><a href="">Insertar</a></td>
                            <td><a href="">Vaciar</a></td>
                            <td>nFilas</td>
                        </tbody>
                        <tbody>
                            <td><input type="checkbox" name="" id=""></td>
                            <td>Tabla 3</td>
                            <td><a href="">Buscar</a></td>
                            <td><a href="">Insertar</a></td>
                            <td><a href="">Vaciar</a></td>
                            <td>nFilas</td>
                        </tbody>
                    </table>
                </fieldset>
            </form>
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
    <script src="../../../assets/js/ExcelToJson.js"></script>
</body>
</html>
