<?php
#Seguridad
session_start();
$sesion = $_SESSION['admin'];
if($sesion == null || $sesion==""){
    header("location:/Pages/SinAcceso.html");
    die();
}
