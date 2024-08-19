<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root"; // Reemplaza con tu usuario de la base de datos
$password = ""; // Reemplaza con tu contraseña de la base de datos
$dbname = "user_management";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error);
}

// Eliminar registro si se ha enviado una solicitud de eliminación
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar_id'])) {
    $eliminar_id = $_POST['eliminar_id'];
    $sql = "DELETE FROM teachers WHERE id = $eliminar_id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Registro eliminado con éxito',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    window.location.href = 'maestrosregistrados.php';
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Error al eliminar el registro: " . $conn->error . "',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
              </script>";
    }
}

// Consulta para obtener los registros de la tabla `teachers`
$sql = "SELECT id, email,  password FROM teachers";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maestros Registrados</title>
    <!-- Incluir Bootstrap y Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Maestros Registrados</h2>
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-bordered table-striped table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Contraseña</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["id"]); ?></td>
                            <td><?php echo htmlspecialchars($row["email"]); ?></td>
                            <td><?php echo htmlspecialchars($row["password"]); ?></td>
                            <td>
                                <a href="editar_maestro.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                                <button class="btn btn-danger btn-sm ml-2" onclick="confirmarEliminacion(<?php echo $row['id']; ?>)">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay maestros registrados.</p>
        <?php endif; ?>

        <?php $conn->close(); ?>
    </div>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Script para confirmar la eliminación -->
    <script>
    function confirmarEliminacion(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esto",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Enviar el formulario para eliminar
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '';
                
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'eliminar_id';
                input.value = id;
                form.appendChild(input);

                document.body.appendChild(form);
                form.submit();
            }
        });
    }
    </script>
</body>
</html>
