<?php
$admin = $_POST["admin"];
$password = $_POST["password"];
session_start();

$_SESSION['admin']= $admin;

$cnx = mysqli_connect("localhost","root","","justificantes");
$consulta = "SELECT*FROM orientador WHERE Nombre='$admin' and Contraseña= '$password'";
$res = mysqli_query($cnx,$consulta);
$filas = mysqli_num_rows($res);

if($filas) header("Location:PagPrincipal.php");
else{
    include("index.html");
    ?>
    <h1 class="bad">ERROR DE LA AUTENTICACION</h1>
    <?php
    
}
mysqli_free_result($res);
mysqli_close($cnx);
?>