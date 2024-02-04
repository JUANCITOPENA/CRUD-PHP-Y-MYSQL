<?php
$servername = "localhost"; // o "127.0.0.1"
$username = "root"; // Nombre de usuario de MySQL
$password = ""; // Contraseña de MySQL (en este caso está vacía)
$database = "AGENDA_MIS_CONTACTOS_v2024"; // Nombre de la base de datos MySQL

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

/*
// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} else {
    echo "¡Conexión exitosa a la base de datos!";
}
*/
?>
