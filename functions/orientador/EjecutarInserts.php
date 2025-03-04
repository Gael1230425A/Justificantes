
<?php
$insertTutor=$_POST['tuto']??null;
$insertAlumno=$_POST['alu']??null;  
$conn->multi_query($insertTutor.$insertAlumno);
header('Location: ../html/ActDB.php');
?>