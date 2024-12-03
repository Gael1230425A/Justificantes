<?php
#Seguridad
session_start();
$sesion = $_SESSION['admin'];
if ($sesion == null || $sesion == "") {
    header("location:SinAcceso.html");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proceso de Solicitud de Justificante</title>
    <link rel="stylesheet" href="../styles/styles.css">
</head>

<body>
    <div class="container">
        <header class="header">
            <img class="header-logo" src="../images/CBTIS86logo.png" alt="Encabezado de la Página" />
        </header>
        <header>
            <h1 class="welcome-text">
                Ingresa los nuevos datos
            </h1>
        </header>

        <form id="updateForm" method="post" action="ProcesoCambio.php">
            <fieldset class="login-form">

                <h1>Actualizar Usuario y Contraseña</h1>

                <label>
                    Usuario actual:
                    <input type="text" name="usuario_actual" required>
                </label>

                <label>
                    Contraseña actual:
                    <input type="password" name="contraseña_actual" required>
                </label>

                <label>
                    Nuevo usuario:
                    <input type="text" name="nuevo_usuario" required>
                </label>

                <label>
                    Nueva contraseña:
                    <input type="password" name="nueva_contraseña" required>
                </label>

                <button type="submit">Actualizar</button>
            </fieldset>

        </form>
    </div>
</body>

</html>