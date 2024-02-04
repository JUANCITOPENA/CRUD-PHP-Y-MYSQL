<?php
include 'conexion.php';

// Consulta para obtener el total de contactos
$sql_count = "SELECT COUNT(*) AS total_contactos FROM contactos";
$result_count = $conn->query($sql_count);
$total_contactos = $result_count->fetch_assoc()['total_contactos'];

$sql = "SELECT c.nombre_contacto, c.apellido_contacto, c.fecha_nacimiento, g.genero, c.telefono, c.email, c.direccion, cc.nombre_categoria 
        FROM contactos c 
        INNER JOIN genero g ON c.id_genero = g.id_genero 
        INNER JOIN categoria_contactos cc ON c.id_categoria = cc.id_categoria";
$result = $conn->query($sql);

echo "<!DOCTYPE html>";
echo "<html lang='es'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>Lista de Contactos</title>";
echo "<!-- Bootstrap CSS -->";
echo "<link href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' rel='stylesheet'>";
echo "<!-- Google Fonts - Roboto -->";
echo "<link href='https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap' rel='stylesheet'>";
echo "<!-- Font Awesome Icons -->";
echo "<link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css' rel='stylesheet'>";
echo "</head>";
echo "<body>";

// Barra de navegación
echo "<nav class='navbar navbar-expand-lg navbar-dark bg-dark'>";
echo "<div class='container'>";
echo "<a class='navbar-brand' href='#'>CRUD PHP Y MYSQL</a>";
echo "<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>";
echo "<span class='navbar-toggler-icon'></span>";
echo "</button>";
echo "<div class='collapse navbar-collapse' id='navbarNav'>";
echo "<ul class='navbar-nav ml-auto'>";
echo "<li class='nav-item active'>";
echo "<a class='nav-link' href='obtener_contactos.php'><i class='fas fa-address-book'></i> Lista de Contactos</a>";
echo "</li>";
echo "<li class='nav-item'>";
echo "<a class='nav-link' href='crear_contacto.php'><i class='fas fa-user-plus'></i> Crear Contacto</a>";
echo "</li>";
echo "<li class='nav-item'>";
echo "<a class='nav-link' href='actualizar_contacto.php'><i class='fas fa-user-edit'></i> Actualizar Contacto</a>";
echo "</li>";
echo "<li class='nav-item'>";
echo "<a class='nav-link' href='eliminar_contacto.php'><i class='fas fa-user-minus'></i> Eliminar Contacto</a>";
echo "</li>";
echo "</ul>";
echo "</div>";
echo "</div>";
echo "</nav>";

// Contenido principal
echo "<div class='container mt-5'>";
echo "<h1 class='text-center mb-2'>Total de Contactos: $total_contactos</h1>";

echo "<div class='row'>";
echo "<div class='col'>";
echo "<div class='table-responsive'>";
echo "<table class='table table-striped'>";
echo "<thead class='thead-dark'>";
echo "<tr>";
echo "<th scope='col'>Nombre</th>";
echo "<th scope='col'>Apellido</th>";
echo "<th scope='col'>Fecha de Nacimiento</th>";
echo "<th scope='col'>Género</th>";
echo "<th scope='col'>Teléfono</th>";
echo "<th scope='col'>Correo Electrónico</th>";
echo "<th scope='col'>Dirección</th>";
echo "<th scope='col'>Categoría</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["nombre_contacto"] . "</td>";
        echo "<td>" . $row["apellido_contacto"] . "</td>";
        echo "<td>" . $row["fecha_nacimiento"] . "</td>";
        echo "<td>" . $row["genero"] . "</td>";
        echo "<td>" . $row["telefono"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["direccion"] . "</td>";
        echo "<td>" . $row["nombre_categoria"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>0 resultados</td></tr>";
}

echo "</tbody>";
echo "</table>";
echo "</div>"; // Cierre de div.table-responsive
echo "</div>"; // Cierre de div.col
echo "</div>"; // Cierre de div.row
echo "</div>"; // Cierre de div.container

$conn->close();

echo "</body>";
echo "</html>";
?>
