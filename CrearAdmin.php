<?php
// Obtener datos del formulario
$nombre = "AveFenix";
$contraseña = "1234";

// Validar que no estén vacíos
if (empty($nombre) || empty($contraseña)) {
    echo '<h1 class="bad">Error: Todos los campos son obligatorios.</h1>';
    exit;
}

// Conectar a la base de datos
$cnx = mysqli_connect("localhost", "root", "", "justificantes");

if (!$cnx) {
    die('<h1 class="bad">Error al conectar con la base de datos.</h1>');
}

// Verificar si el usuario ya existe
$consulta_existente = "SELECT * FROM orientador WHERE Nombre='$nombre'";
$res_existente = mysqli_query($cnx, $consulta_existente);

if (mysqli_num_rows($res_existente) > 0) {
    echo '<h1 class="bad">Error: El usuario ya existe.</h1>';
    mysqli_close($cnx);
    exit;
}

// Cifrar la contraseña
$contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

// Insertar el nuevo orientador
$consulta = "INSERT INTO orientador (Nombre, Contraseña) VALUES ('$nombre', '$contraseña_hash')";
$resultado = mysqli_query($cnx, $consulta);

if ($resultado) {
    echo '<h1>Orientador registrado exitosamente.</h1>';
    echo '<a href="index.html">Volver al inicio</a>';
} else {
    echo '<h1 class="bad">Error al registrar el orientador.</h1>';
}

// Cerrar la conexión
mysqli_close($cnx);
?>
