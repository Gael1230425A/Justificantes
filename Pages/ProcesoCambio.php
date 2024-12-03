<?php
session_start();
error_reporting(0);

// Obtener los datos del formulario
$usuario_actual = $_POST['usuario_actual'];
$contraseña_actual = $_POST['contraseña_actual'];
$nuevo_usuario = $_POST['nuevo_usuario'];
$nueva_contraseña = $_POST['nueva_contraseña'];

// Conexión a la base de datos
$cnx = mysqli_connect("localhost", "root", "", "justificantes");

// Validar si el usuario y la contraseña actuales son correctos
$consulta = "SELECT * FROM orientador WHERE Nombre='$usuario_actual'";
$res = mysqli_query($cnx, $consulta);
$usuario = mysqli_fetch_assoc($res);

if ($usuario && password_verify($contraseña_actual, $usuario['Contraseña'])) {
    // Si la contraseña actual es correcta, actualizamos el usuario y la contraseña
    $nueva_contraseña_hash = password_hash($nueva_contraseña, PASSWORD_DEFAULT);
    $actualizar = "UPDATE orientador SET Nombre='$nuevo_usuario', Contraseña='$nueva_contraseña_hash' WHERE Nombre='$usuario_actual'";
    $resultado = mysqli_query($cnx, $actualizar);

    if ($resultado) {
        echo "<h1>Usuario y contraseña actualizados correctamente</h1>";
        header("Location: index.html"); // Redirigir al inicio de sesión
    } else {
        include "Cambio.php";
        echo "<h1 class='bad'>Error al actualizar los datos</h1>";
    }
} else {
    include "Cambio.php";

    echo "<h1 class='bad'>Usuario o contraseña actual incorrectos</h1>";
}

mysqli_close($cnx);
?>
