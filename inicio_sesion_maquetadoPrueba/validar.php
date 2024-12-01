<?php
$admin = $_POST["admin"];
$contrasena = $_POST["contrasena"];
session_start();

$_SESSION['admin']= $admin;

$cnx = mysqli_connect("localhost","root","","iniciosesion");
$consulta = "SELECT*FROM admins WHERE admin='$admin' and contraseña = '$contrasena'";
$res = mysqli_query($cnx,$consulta);
$filas = mysqli_num_rows($res);

if($filas) header("Location:admin/pages/principal.php");
else{
    include("inicio_sesion.html");
    ?>
    <h1 class="bad">ERROR DE LA AUTENTICACION</h1>
    <?php
    
}
mysqli_free_result($res);
mysqli_close($cnx);
?>