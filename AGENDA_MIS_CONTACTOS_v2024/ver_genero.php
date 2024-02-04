<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Consulta para obtener los géneros disponibles
$sql_genero = "SELECT id_genero, genero FROM genero";
$result_genero = $conn->query($sql_genero);

// Verificar si hay resultados en la consulta
if ($result_genero === false) {
    echo "Error en la consulta de géneros: " . $conn->error;
} else {
    // Comprobar si hay filas devueltas
    if ($result_genero->num_rows > 0) {
        echo "<h2>Géneros</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Género</th></tr>";
        // Iterar sobre los resultados y mostrar cada género en una fila de la tabla
        while ($row = $result_genero->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id_genero'] . "</td>";
            echo "<td>" . $row['genero'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron géneros";
    }
}

// Cerrar la conexión
$conn->close();
?>
