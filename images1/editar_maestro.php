<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_management";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

// Obtener el ID del maestro a editar
$id = $_GET['id'];

// Consulta para obtener los datos del maestro
$sql = "SELECT * FROM teachers WHERE id = $id";
$result = $conn->query($sql);
$teacher = $result->fetch_assoc();

// Actualizar el registro si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Encriptar la contraseña antes de guardarla
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Actualizar los datos del maestro con la contraseña encriptada
    $sql = "UPDATE teachers SET email='$email', password='$hashed_password' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header('Location: maestrosregistrados.php'); // Redirigir a la página original
        exit(); // Asegurarse de que no se continúe ejecutando después de la redirección
    } else {
        echo "Error al actualizar el registro: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Maestro</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .container {
            max-width: 600px; /* Limitar el ancho máximo del contenedor */
        }
        .btn-secondary {
            margin-left: 10px; /* Espacio entre botones */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Editar Maestro</h2>
        <form id="edit-form" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($teacher['email']); ?>">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" id="password" name="password" class="form-control" value="" >
            </div>

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="javascript:history.back()" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('edit-form');

        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevenir el envío del formulario

            Swal.fire({
                title: '¿Estás seguro?',
                text: '¿Quieres guardar los cambios?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Cancelar'
            }).then(result => {
                if (result.isConfirmed) {
                    form.submit(); // Enviar el formulario si se confirma
                }
            });
        });
    });
    </script>
</body>
</html>
