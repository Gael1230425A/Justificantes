<?php
    require_once("../../config/Database.php");
    require_once("../../config/Auth.php");
    //conexion a la base de datos
    $cnxDB=new Auth("localhost","root", "","justificantes");
    //verifica si existe una sesión activa
    $verifi=$cnxDB->verifySession("../error/SinAcceso.html", "");
    
    // Verifica si se ha solicitado cerrar la sesión
    if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
        $cnxDB->logout(); // Llama a la función logout
        header("Location: ../auth/index.php"); // Redirige al usuario
        exit(); // Detiene la ejecución del script
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentación del Programa</title>
    <link rel="stylesheet" href="../../assets/styles/PagPrincipal.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <img class="header-logo" src="../../assets/images/CBTIS86logo.png" alt="Encabezado de la Página" />
        </header>
        <nav class="menu">
        <ul class="menu-list">
                <li><a href="PagPrincipal.php" class="menu-link">Documentación del Programa</a></li>
                <li><a href="../admin/justificantes/SolicitudJustificante.php" class="menu-link">Nuevo Justificante</a></li>
                <li><a href="../admin/justificantes/Estadisticas.php" class="menu-link">Estadísticas</a></li>
                <li>
                    <a href="#" class="menu-link">Movimientos Administrativos</a>
                    <ul>
                        <li><a href="../admin/orientadores/ActDB.php" >Actualizar Bases de Datos</a></li>
                        <li><a href="../admin/orientadores/NuevoUsuario.php">Crear Nuevo Usuario</a></li>
                        <li><a href="../admin/orientadores/ActualizarAdmin.php">Actualizar Usuario</a></li>
                        <li><a href="../admin/orientadores/ActualizarContrasena.php">Actualizar Contraseña</a></li>
                        <li><a href="?logout=true">Cerrar Sesión</a></li>
                    </ul>
                </li>
               
        </ul>
        </nav>   
 
        <section>
            <article>
                <header class="border  border-black p-5">
                    <h2>Documentación del Programa.</h2>
                </header>

                <nav class=" nav-doc p-5  border  border-black" aria-label="Navegación de Documentación">
                    <ul>
                        <li><a href="#NuevoJusti">Nuevo Justificante</a></li>
                        <li><a href="#Historial">Historial de Justificantes</a></li>
                        <li><a href="#Estadisticas">Estadisticas</a></li>
                        <li><a href="#MovAdmin">Movimientos Administrativos</a></li>
                        <li><a href="#ActDB">Actualizar Bases de Datos</a></li>
                    </ul>
                </nav>
                
            </article>
        </section>

        <section class="border  border-black p-5" id="NuevoJusti">
            <aside>
                <h3>Nuevo Justificante</h3>
                <p>Para crear un nuevo jsutificante usted se dirige a la pestaña de "nuevo jsutificante", se le muestra una pantalla
                    donde debe ingresar el <b>número de control</b> del alumno que esta solicitando el justificante. Se va imprimir
                    todos los datos del alumno así como los justificantes que ya ha solicitado anteriormente.
                    <br>
                    Para crear uno nuevo dirijase al botón de <b>Nuevo jsutificante</b>, se le muestra nuevamente los datos del alumno,
                    debe llenar los datos necesarios, situacion y el periodo en que el alumno falto. Con los datos llenados
                    presione en enviar para confirmar el justificante. Enviado se le regresa a la ventada anterior.
                </p>
            </aside>
        </section>

        <section class="border  border-black p-5" id="Historial">
            <aside>
                <h3>Historial de Justificantes</h3>
            </aside>
        </section>
        
        <section class="border  border-black p-5" id="Estadisticas">
            <aside>
                <h3>Estadisticas</h3>
            </aside>
        </section>
        
        <section class="border  border-black p-5" id="MovAdmin">
            <aside>
                <h3>Movimientos Administrativos</h3>
            </aside>
        </section>

        <section class="border  border-black p-5" id="ActDB">
            <aside>
                <h3>Actualizar Bases de Datos</h3>
            </aside>
        </section>
    </div>  
</body>
</html>