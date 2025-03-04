<?php
include '../../Pages/php/Seguridad.php';

include '../../database/cnx.php'; 
$opcion=$_POST['opcion'];
$semestre=$_POST['semestre'];
if($opcion== 'Confirmar Edicion'){
$conn->multi_query('UPDATE maestros SET Semestre="'.($semestre+1).'°" WHERE Semestre="'.$semestre.'°";
UPDATE estudiantes SET Semestre="'.($semestre+1).'°" WHERE Semestre="'.$semestre.'°";');
header('Location: ../html/ActDB.php');
}
else if($opcion== '¿Deseas Borrar la Base de Datos?'){
    $conn->multi_query('DELETE FROM maestros;
DELETE FROM justificante;
DELETE FROM estudiantes;
DELETE FROM tutor;');
header('Location: ../html/ActDB.php');
}
?>