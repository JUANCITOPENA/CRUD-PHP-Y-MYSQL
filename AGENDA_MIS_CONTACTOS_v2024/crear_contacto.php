<?php
include 'conexion.php';

// Consulta para obtener los géneros disponibles
$sql_genero = "SELECT id_genero, genero FROM genero";
$result_genero = $conn->query($sql_genero);

// Consulta para obtener las categorías disponibles
$sql_categoria = "SELECT id_categoria, nombre_categoria FROM categoria_contactos";
$result_categoria = $conn->query($sql_categoria);

// Mensaje de confirmación por defecto
$confirm_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $genero = $_POST['genero'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];
    $categoria = $_POST['categoria'];

    // Verificar si la categoría existe
    $sql_categoria_exist = "SELECT id_categoria FROM categoria_contactos WHERE id_categoria = '$categoria'";
    $result_categoria_exist = $conn->query($sql_categoria_exist);

    if ($result_categoria_exist->num_rows > 0) {
        // La categoría existe, procede con la inserción del contacto
        $sql = "INSERT INTO contactos (nombre_contacto, apellido_contacto, fecha_nacimiento, id_genero, telefono, email, direccion, id_categoria)
        VALUES ('$nombre', '$apellido', '$fecha_nacimiento', '$genero', '$telefono', '$email', '$direccion', '$categoria')";

        if ($conn->query($sql) === TRUE) {
            $confirm_message = "Nuevo contacto creado exitosamente";
        } else {
            $confirm_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        // La categoría no existe, muestra un mensaje de error
        $confirm_message = "Error: La categoría especificada no existe";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear Contacto</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Google Fonts - Roboto -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <!-- Font Awesome Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body>

<!-- Barra de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
    <a class="navbar-brand" href="#">CRUD PHP Y MYSQL</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="obtener_contactos.php"><i class="fas fa-address-book"></i> Contactos</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="crear_contacto.php"><i class="fas fa-user-plus"></i> Crear Contacto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="actualizar_contacto.php"><i class="fas fa-user-edit"></i> Actualizar Contacto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="eliminar_contacto.php"><i class="fas fa-user-minus"></i> Eliminar Contacto</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h1 class="text-center mb-4">Crear Nuevo Contacto</h1>

    <!-- Formulario de creación de contacto -->
    <form action="crear_contacto.php" method="post">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" class="form-control" id="apellido" name="apellido" required>
        </div>
        <div class="form-group">
            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
        </div>
       
        <div class="form-group">
            <label for="genero">Género:</label>
            <select class="form-control" id="genero" name="genero" required>
                <?php
                // Mostrar opciones de género
                if ($result_genero->num_rows > 0) {
                    while ($row = $result_genero->fetch_assoc()) {
                        echo "<option value='" . $row['id_genero'] . "'>" . $row['genero'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>



        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" class="form-control" id="telefono" name="telefono" required>
        </div>
        <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input type="text" class="form-control" id="direccion" name="direccion" required>
        </div>
       
       
        <div class="form-group">
            <label for="categoria">Categoría:</label>
            <select class="form-control" id="categoria" name="categoria" required>
                <?php
                // Mostrar opciones de categorías
                if ($result_categoria->num_rows > 0) {
                    while ($row = $result_categoria->fetch_assoc()) {
                        echo "<option value='" . $row['id_categoria'] . "'>" . $row['nombre_categoria'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Insertar</button>
    </form>

    <!-- Mensaje de confirmación -->
    <?php if (!empty($confirm_message)): ?>
        <div class="alert alert-success mt-3" role="alert">
            <?php echo $confirm_message; ?>
        </div>
    <?php endif; ?>
</div>

<!-- jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
