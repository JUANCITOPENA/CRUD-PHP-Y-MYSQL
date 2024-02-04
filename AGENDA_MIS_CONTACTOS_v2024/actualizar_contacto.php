<?php
include 'conexion.php';

// Variables para almacenar los detalles del contacto a actualizar
$id_contacto = "";
$nombre = "";
$apellido = "";
$fecha_nacimiento = "";
$genero = "";
$telefono = "";
$email = "";
$direccion = "";
$categoria = "";

// Verificar si se ha enviado un ID de contacto para buscar y actualizar
if (isset($_POST['buscar'])) {
    $id_contacto_buscar = $_POST['id_contacto_buscar'];

    // Consulta para obtener los detalles del contacto correspondiente al ID proporcionado
    $sql_buscar = "SELECT * FROM contactos WHERE id_contacto = '$id_contacto_buscar'";
    $result_buscar = $conn->query($sql_buscar);

    if ($result_buscar->num_rows > 0) {
        // Llenar las variables con los detalles del contacto encontrado
        $row = $result_buscar->fetch_assoc();
        $id_contacto = $row['id_contacto'];
        $nombre = $row['nombre_contacto'];
        $apellido = $row['apellido_contacto'];
        $fecha_nacimiento = $row['fecha_nacimiento'];
        $genero = $row['id_genero'];
        $telefono = $row['telefono'];
        $email = $row['email'];
        $direccion = $row['direccion'];
        $categoria = $row['id_categoria'];
    } else {
        echo "No se encontró ningún contacto con el ID proporcionado";
    }
}

// Verificar si se ha enviado un ID de contacto para actualizar
if (isset($_POST['actualizar'])) {
    // Obtener los detalles actualizados del formulario
    $id_contacto = $_POST['id_contacto'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $genero = $_POST['genero'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];
    $categoria = $_POST['categoria'];

    // Realizar la actualización en la base de datos
    $sql_actualizar = "UPDATE contactos SET nombre_contacto=?, apellido_contacto=?, fecha_nacimiento=?, id_genero=?, telefono=?, email=?, direccion=?, id_categoria=? WHERE id_contacto=?";
    
    $stmt = $conn->prepare($sql_actualizar);
    $stmt->bind_param('sssiisssi', $nombre, $apellido, $fecha_nacimiento, $genero, $telefono, $email, $direccion, $categoria, $id_contacto);
    
    if ($stmt->execute()) {
        echo "Contacto actualizado exitosamente";
    } else {
        echo "Error al actualizar el contacto: " . $stmt->error;
    }
}

// Consulta para obtener los géneros disponibles
$sql_genero = "SELECT id_genero, genero FROM genero";
$result_genero = $conn->query($sql_genero);

// Consulta para obtener las categorías disponibles
$sql_categoria = "SELECT id_categoria, nombre_categoria FROM categoria_contactos";
$result_categoria = $conn->query($sql_categoria);

// Consulta para obtener la lista de contactos
$sql_lista = "SELECT * FROM contactos";
$result_lista = $conn->query($sql_lista);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Contacto</title>
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
                <li class="nav-item">
                    <a class="nav-link" href="crear_contacto.php"><i class="fas fa-user-plus"></i> Crear Contacto</a>
                </li>
                <li class="nav-item active">
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
    <h1 class="text-center mb-4">Actualizar Contacto</h1>

    <!-- Formulario de búsqueda de contacto -->
    <div class="row">
        <div class="col">
            <form action="actualizar_contacto.php" method="post">
                <div class="form-group">
                    <label for="id_contacto_buscar">ID del Contacto a Buscar:</label>
                    <input type="text" class="form-control" id="id_contacto_buscar" name="id_contacto_buscar" required>
                </div>
                <button type="submit" class="btn btn-primary" name="buscar">Buscar</button>
            </form>
        </div>
    </div>

    <!-- Formulario de actualización de contacto -->
    <div class="row">
        <div class="col">
            <form action="actualizar_contacto.php" method="post">
                <div class="form-group">
                    <label for="id_contacto">ID del Contacto:</label>
                    <input type="text" class="form-control" id="id_contacto" name="id_contacto" value="<?php echo $id_contacto; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido:</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $apellido; ?>" required>
                </div>
                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $fecha_nacimiento; ?>" required>
                </div>
                <div class="form-group">
                    <label for="genero">Género:</label>
                    <select class="form-control" id="genero" name="genero" required>
                        <?php
                        // Mostrar opciones de género
                        if ($result_genero->num_rows > 0) {
                            while ($row = $result_genero->fetch_assoc()) {
                                echo "<option value='" . $row['id_genero'] . "'";
                                if ($row['id_genero'] == $genero) {
                                    echo " selected";
                                }
                                echo ">" . $row['genero'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $telefono; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección:</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $direccion; ?>" required>
                </div>
                <div class="form-group">
                    <label for="categoria">Categoría:</label>
                    <select class="form-control" id="categoria" name="categoria" required>
                        <?php
                        // Mostrar opciones de categorías
                        if ($result_categoria->num_rows > 0) {
                            while ($row = $result_categoria->fetch_assoc()) {
                                echo "<option value='" . $row['id_categoria'] . "'";
                                if ($row['id_categoria'] == $categoria) {
                                    echo " selected";
                                }
                                echo ">" . $row['nombre_categoria'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" name="actualizar">Actualizar</button>
            </form>
        </div>
    </div>

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
            // Verificar si $result_lista está definido y no es null
            if (isset($result_lista) && $result_lista !== null) {
                // Verificar si $result_lista tiene filas
                if ($result_lista->num_rows > 0) {
                    while ($row = $result_lista->fetch_assoc()) {
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
            } else {
                echo "<tr><td colspan='9'>No hay contactos</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
