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
    <title>Actualizar Admnistrador</title>
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

                <h1>Actualizar Usuario</h1>

                <label class="form-label">
                    Usuario (se muestra el actual, actualicelo si asi lo desea):
                    <input type="text" name="admin" value="<?php echo $usuarioActual; ?>" required>
                </label>

                <label class="form-label">
                    Ingrese su contraseña para confirmar cambios:
                    <input type="password" name="contrasena_actual" required>
                </label>
                <button type="submit">Guardar los cambios</button>
                <a href="../../doc/PagPrincipal.php">Regresar</a>

                <?php
                if($_SERVER["REQUEST_METHOD"]==="POST"){
                    //Captura los datos
                    $admin=$_POST["admin"];
                    $contrasenaActual=$_POST["contrasena_actual"];

                    //Invocacion a la clase user para actualizar admin
                    $con=new User("localhost","root","","justificantes");
                    
                    //Cambia el admin
                    $actUser=$con->changeAdmin($usuarioActual,$admin,$contrasenaActual);

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