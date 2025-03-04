<?php
    require_once("../../../config/Auth.php");
    require_once("../../../config/User.php");

    $cnxDB=new Auth("localhost","root","","justificantes");
    $verifi=$cnxDB->verifySession("../../error/SinAcceso.html", "");

    //inicia una sesión para buscar el administrador
    session_start();
    $usuarioActual=$_SESSION["admin"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proceso de Solicitud de Justificante</title>
    <link rel="stylesheet" href="../../../assets/styles/index.css">
</head>

<body>
    <div class="container">
        <header class="header">
        <img class="header-logo" src="../../../assets/images/CBTIS86logo.png" alt="Encabezado de la Página" />
        </header>
        <header>

        </header>

        <form id="updateForm" method="post">

            <fieldset class="login-form">
                <h3 class="welcome-text">
                    ¡Bienvenid@ <?php echo $usuarioActual;?>!
                </h3>

                <label class="form-label">
                    Contraseña:
                    <input type="password" name="contrasena-actual" required>
                </label>

                <h2>Nuevo Usuario</h2>

                <label class="form-label">
                    Nombre:
                    <input type="text" name="usuario" required>
                </label>

                <label class="form-label">
                    Contraseña:
                    <input type="password" name="contrasena" required>
                </label>

                <button type="submit">Guardar</button>
                <a href="../../doc/PagPrincipal.php">Regresar</a>
                <?php
                 if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    // Capturar datos del formulario
                    $contrasenaActual=$_POST["contrasena-actual"];
                    $admin = $_POST['usuario'];
                    $password = $_POST['contrasena'];

                    $user=new User("localhost","root","","justificantes");

                    $nuevoUsuario=$user->createAdmin($usuarioActual,$contrasenaActual,$admin,$password);

                    $errors=$user->getError();
                    foreach($errors as $error){
                        echo"<h3 class='error'>$error</h3>";
                    }
                  }
                ?>
            </fieldset>
        </form>
    </div>
</body>

</html>