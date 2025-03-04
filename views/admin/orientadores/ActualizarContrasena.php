<?php
    require_once("../../../config/Auth.php");
    require_once("../../../config/User.php");
    //conexion a la base de datos
    $cnxDB=new Auth("localhost","root", "","justificantes");
    //verifica si existe una sesión activa
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
    <title>Actualizar Contraseña</title>
    <link rel="stylesheet" href="../../../assets/styles/index.css">
</head>

<body>
    <div class="container">
        <header class="header">
            <img class="header-logo" src="../../../assets/images/CBTIS86logo.png" alt="Encabezado de la Página" />
        </header>
        <header>
            <h1 class="welcome-text">
                Ingresa los nuevos datos
            </h1>
        </header>

        <form id="updateForm" method="post">
            <fieldset class="login-form">

                <h1>Actualizar Contraseña</h1>

                <h3>¡Bienvenid@ <?php echo $usuarioActual?>! ¿deseas actualizar la contraseña de este administrador?</h3>

                <label class="form-label">
                    Ingrese su contraseña actual:
                    <input type="password" name="contrasena_actual" required>
                </label>
                
                <label class="form-label">
                    Ingrese su nueva contraseña:

                    <input type="password" name="nueva_contrasena1" required>
                </label>

                <label class="form-label">
                    Ingrese de nuevo su nueva contraseña:
                    <input type="password" name="nueva_contrasena2" required>
                </label>

                <button type="submit">Guardar los cambios</button>
                <a href="../../doc/PagPrincipal.php">Regresar</a>

                <?php
                if($_SERVER["REQUEST_METHOD"]==="POST"){
                    //Captura los datos actuales
                    $contrasenaActual=$_POST["contrasena_actual"];

                    //Captura los nuevos datos
                    $nuevaContrasena1=$_POST["nueva_contrasena1"];
                    $nuevaContrasena2=$_POST["nueva_contrasena2"];

                    //Invocacion a la clase user para actualizar contraseña
                    $con=new User("localhost","root","","justificantes");

                    //Cambia la contraseña
                    $actPass=$con->changePassword($usuarioActual,$contrasenaActual,$nuevaContrasena1,$nuevaContrasena2);

                    //obtiene el error
                    $errors=$con->getError();

                    //busca en el arreglo de errores y lo imprime en formato html
                    foreach ($errors as $error) {
                        echo("<h3 class='error'>$error</h3>");
                    }
                }
                ?>
            </fieldset>

        </form>
    </div>
</body>
<script>

</script>
</html>