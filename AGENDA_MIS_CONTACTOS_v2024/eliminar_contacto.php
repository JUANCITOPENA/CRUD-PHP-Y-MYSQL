<?php
include 'conexion.php';

// Mensaje de error por defecto
$error_message = '';

// Si se realiza una solicitud POST para eliminar un contacto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se recibió el ID del contacto a eliminar
    if(isset($_POST['id_contacto'])) {
        $id_contacto = $_POST['id_contacto'];

        // Preparar la sentencia SQL para verificar si el contacto existe
        $sql_verificar = "SELECT * FROM CONTACTOS WHERE id_contacto = $id_contacto";
        $result_verificar = $conn->query($sql_verificar);

        if ($result_verificar->num_rows > 0) {
            // El contacto existe, proceder con la eliminación
            // Preparar la sentencia SQL para eliminar el contacto
            $sql = "DELETE FROM CONTACTOS WHERE id_contacto=$id_contacto";

            // Ejecutar la consulta SQL
            if ($conn->query($sql) === TRUE) {
                // Contacto eliminado exitosamente
                header("Location: eliminar_contacto.php");
                exit();
            } else {
                // Error al eliminar el contacto
                $error_message = "Error al eliminar el contacto: " . $conn->error;
            }
        } else {
            // El contacto no existe, mostrar mensaje de error
            $error_message = "Error: El contacto especificado no existe";
        }
    } else {
        // Si no se recibió el ID del contacto, mostrar un mensaje de error
        $error_message = "Error: No se especificó el ID del contacto a eliminar";
    }
}

// Obtener la lista de contactos
$sql_lista = "SELECT * FROM CONTACTOS";
$result_lista = $conn->query($sql_lista);

?>

<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Eliminar Contacto</title>
    <!-- Bootstrap CSS -->
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' rel='stylesheet'>
    <!-- Google Fonts - Roboto -->
    <link href='https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap' rel='stylesheet'>
    <!-- Font Awesome Icons -->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css' rel='stylesheet'>
</head>
<body>

<!-- Barra de navegación -->
<nav class='navbar navbar-expand-lg navbar-dark bg-dark'>
    <div class='container'>
        <a class='navbar-brand' href='#'>CRUD PHP Y MYSQL</a>
        <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span>
        </button>
        <div class='collapse navbar-collapse' id='navbarNav'>
            <ul class='navbar-nav ml-auto'>
                <li class='nav-item active'>
                    <a class='nav-link' href='obtener_contactos.php'><i class='fas fa-address-book'></i> Contactos</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='crear_contacto.php'><i class='fas fa-user-plus'></i> Crear Contacto</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='actualizar_contacto.php'><i class='fas fa-user-edit'></i> Actualizar Contacto</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='eliminar_contacto.php'><i class='fas fa-user-minus'></i> Eliminar Contacto</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class='container mt-5'>
    <h1 class='text-center mb-4'>Eliminar Contacto</h1>

    <!-- Formulario de eliminar contacto -->
    <form action='eliminar_contacto.php' method='post'>
        <div class='form-group'>
            <label for='id_contacto'>ID del Contacto a Eliminar:</label>
            <input type='text' class='form-control' id='id_contacto' name='id_contacto'>
        </div>
        <button type='submit' class='btn btn-danger'>Eliminar</button>
    </form>

    <!-- Mensaje de error -->
    <?php if (!empty($error_message)): ?>
        <div class='alert alert-danger mt-3' role='alert'>
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <!-- Lista de contactos -->
    <h2 class='mt-5'>Lista de Contactos</h2>
    <table class='table'>
        <thead class='thead-dark'>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Fecha de Nacimiento</th>
                <th>Género</th>
                <th>Teléfono</th>
                <th>Correo Electrónico</th>
                <th>Dirección</th>
                <th>Categoría</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_lista->num_rows > 0) {
                while($row = $result_lista->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id_contacto"] . "</td>";
                    echo "<td>" . $row["nombre_contacto"] . "</td>";
                    echo "<td>" . $row["apellido_contacto"] . "</td>";
                    echo "<td>" . $row["fecha_nacimiento"] . "</td>";
                    echo "<td>" . $row["id_genero"] . "</td>";
                    echo "<td>" . $row["telefono"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["direccion"] . "</td>";
                    echo "<td>" . $row["id_categoria"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No hay contactos</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- jQuery y Bootstrap JS -->
<script src='https://code.jquery.com/jquery-3.5.1.slim.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js'></script>
<script src='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'></script>
</body>
</html>
