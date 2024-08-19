<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "user_management";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encriptar la contraseña

    if ($role == 'teacher') {
        $sql = "INSERT INTO teachers (email, password) VALUES (?, ?)";
    } elseif ($role == 'admin') {
        $sql = "INSERT INTO admins (email, password) VALUES (?, ?)";
    } else {
        die("Rol no válido.");
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);

    if ($stmt->execute()) {
        $success = true;
    }

    $stmt->close();
}

$conn->close();

if ($success) {
    echo '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registro Exitoso</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
            Swal.fire({
                title: "Registro Exitoso",
                text: "Tu registro ha sido completado exitosamente.",
                icon: "success",
                confirmButtonText: "Aceptar"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "register.html";
                }
            });
        </script>
    </body>
    </html>';
} else {
    echo '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
            Swal.fire({
                title: "Error",
                text: "Ocurrió un error al registrar. Por favor, inténtalo de nuevo.",
                icon: "error",
                confirmButtonText: "Aceptar"
            });
        </script>
    </body>
    </html>';
}
?>
