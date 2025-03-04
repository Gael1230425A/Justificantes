<?php
include '../../Pages/php/Seguridad.php';

include '../../database/cnx.php';
$folio=$_POST["folio"];
$sqlcmd= "DELETE FROM `justificante` WHERE `Folio`=$folio";
$conn->query($sqlcmd);
header("Location: ../html/MovAdministrativos.php");
?>