<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Proceso de Solicitud de Justificante</title>
  <link rel="stylesheet" href="../../assets/styles/index.css">
</head>
<body>
  <div class="container">
    <header class="header">
      <img class="header-logo" src="../../assets/images/CBTIS86logo.png" alt="Encabezado de la Página" />
    </header>
    <header>
        <h1 class="welcome-text">
          ¡Bienvenido al Proceso de Solicitud de Justificante del CBTIS 86!
        </h1>
    </header>

    <form id="loginForm" method="post">
        <fieldset class="login-form">
            <legend class="form-title">Ingresa tu Nombre de Usuario y Contraseña</legend>
            
            <label class="form-label">
                Nombre de Usuario:
                <input type="text" id="admin" name="admin" />
            </label>
            
            <label class="form-label">
                Contraseña:
                <input type="password" id="password" name="password"/>
            </label>
            <input type="hidden" name="servicio" value="INICIO">
            <button type="submit">Iniciar Sesion</button>

            <?php
            require_once("../../config/Database.php");
            require_once("../../config/Auth.php");
            //conexion a la base de datos
            $cnxDB=new Auth("localhost","root", "","justificantes");

            //verifica si existe una sesión activa
            $verifi=$cnxDB->verifySession("", "../doc/PagPrincipal.php");
            
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

              // Capturar datos del formulario
              $admin = $_POST['admin'];
              $password = $_POST['password'];

             //validación de los datos
             $vali=$cnxDB->validateLogin($admin,$password);
             $errors=$cnxDB->getError();
            foreach ($errors as $error) {
              echo("<h3 class='error' style='padding:10px'>$error</h3>");
            }
  
          } 
            ?>
        </fieldset>
    </form>
  </div>
</body>
</html>
