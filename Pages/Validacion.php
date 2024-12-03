<?php
$admin = $_POST["admin"];
$password = $_POST["password"];
session_start();

$_SESSION['admin'] = $admin;

// Conectar a la base de datos
$cnx = mysqli_connect("localhost", "root", "", "justificantes");

// Buscar el usuario por su nombre
$consulta = "SELECT * FROM orientador WHERE Nombre='$admin'";
$res = mysqli_query($cnx, $consulta);

if ($res && mysqli_num_rows($res) > 0) {
    $usuario = mysqli_fetch_assoc($res);
    $password_hash = $usuario['Contraseña']; // Contraseña cifrada en la base de datos
    
    // Verificar si la contraseña ingresada coincide con el hash
    if (password_verify($password, $password_hash)) {
        header("Location: PagPrincipal.php");
        exit;
    } else {
        include("index.html");
        echo '<h1 class="bad">ERROR: Contraseña incorrecta</h1>';
    }
} else {
    include("index.html");
    echo '<h1 class="bad">ERROR: Usuario no encontrado</h1>';
}

mysqli_free_result($res);
mysqli_close($cnx);
?>
