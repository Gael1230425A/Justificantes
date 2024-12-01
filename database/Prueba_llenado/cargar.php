<?php
// Configuración de la base de datos
$host = "localhost";
$username = "root";
$password = "";
$dbname = "pruebas";

// Conexión a la base de datos
$conn = new mysqli($host, $username, $password, $dbname);

// Verifica si la conexión es exitosa
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Carga el archivo JSON (colócalo en la misma carpeta que este script)
$json_data = file_get_contents('alumnos.json');

// Decodifica el JSON a un arreglo asociativo
$alumnos = json_decode($json_data, true);

if ($alumnos === null) {
    die("Error al decodificar el JSON.");
}

// Inicia una transacción para insertar múltiples registros
$conn->begin_transaction();

try {
    foreach ($alumnos as $alumno) {
        // Captura los datos del alumno
        $numero_control = $alumno['numero_control'];
        $nombre = $alumno['nombre'];
        $semestre = $alumno['semestre'];
        $turno = $alumno['turno'];
        $numero_telefono_tutor = $alumno['numero_telefono_tutor'];

        // Verifica si el tutor existe
        $tutor_query = "SELECT * FROM tutor WHERE numero_telefono_tutor = '$numero_telefono_tutor'";
        $tutor_result = $conn->query($tutor_query);

        if ($tutor_result->num_rows === 0) {
            // Si el tutor no existe, insértalo primero
            $insert_tutor = "INSERT INTO tutor (numero_telefono_tutor, nombre) 
                             VALUES ('$numero_telefono_tutor', 'Tutor Desconocido')";
            $conn->query($insert_tutor);
        }

        // Inserta el alumno en la tabla alumnos
        $insert_alumno = "INSERT INTO alumnos (numero_control, nombre, semestre, turno, numero_telefono_tutor) 
                          VALUES ($numero_control, '$nombre', $semestre, '$turno', '$numero_telefono_tutor')";

        $conn->query($insert_alumno);
    }

    // Confirma los cambios si no hubo errores
    $conn->commit();
    echo "Todos los alumnos se insertaron correctamente.";
} catch (Exception $e) {
    // Revierte los cambios en caso de error
    $conn->rollback();
    echo "Error al insertar los datos: " . $e->getMessage();
}

// Cierra la conexión
$conn->close();
?>
