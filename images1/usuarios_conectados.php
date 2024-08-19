<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "captive_portal";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error);
}

// Eliminar registro si se ha enviado una solicitud de eliminación
if (isset($_POST['eliminar_id'])) {
    $idEliminar = $_POST['eliminar_id'];
    $sqlEliminar = "DELETE FROM invitados WHERE id = $idEliminar";
    if ($conn->query($sqlEliminar) === TRUE) {
        echo "<div class='alert alert-success'>Registro eliminado correctamente.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error al eliminar el registro: " . $conn->error . "</div>";
    }
}

// Consulta para obtener los registros de la tabla `invitados`
$sql = "SELECT id, correo, matricula, password FROM invitados";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Conectados</title>
    <!-- Incluir Bootstrap y Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Usuarios Conectados</h2>
        
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Correo</th>
                        <th>Matrícula</th>
                        <th>Password</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rowCount = 0;
                    while ($row = $result->fetch_assoc()): 
                        $rowColor = $rowCount % 2 == 0 ? '#f1620f' : '#0a9d00'; // Alterna entre naranja y verde
                    ?>
                        <tr style='background-color: <?php echo $rowColor; ?>; color: white;'>
                            <td><?php echo htmlspecialchars($row["id"]); ?></td>
                            <td><?php echo htmlspecialchars($row["correo"]); ?></td>
                            <td><?php echo htmlspecialchars($row["matricula"]); ?></td>
                            <td><?php echo htmlspecialchars($row["password"]); ?></td>
                            <td>
                                <button class='btn btn-danger btn-sm' onclick='confirmarEliminacion(<?php echo $row["id"]; ?>)'>
                                    <i class='bi bi-trash'></i> Eliminar
                                </button>
                            </td>
                        </tr>
                    <?php
                        $rowCount++;
                    endwhile;
                    ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay usuarios conectados.</p>
        <?php endif; ?>

        <?php $conn->close(); ?>
    </div>

    <!-- Scripts necesarios para Bootstrap y SweetAlert2 -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
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
        })
    }
    </script>
</body>
</html>
