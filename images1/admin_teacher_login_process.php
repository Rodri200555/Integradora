<?php
session_start();
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verificar si el usuario es un admin
    $sql_admin = "SELECT * FROM admins WHERE email = ?";
    $stmt_admin = $conn->prepare($sql_admin);
    $stmt_admin->bind_param("s", $email);
    $stmt_admin->execute();
    $result_admin = $stmt_admin->get_result();

    if ($result_admin->num_rows > 0) {
        $row_admin = $result_admin->fetch_assoc();
        if (password_verify($password, $row_admin['password'])) {
            $_SESSION['user_role'] = 'admin';
            $_SESSION['user_email'] = $email;
            header("Location: index admin.html");
            exit();
        }
    }

    // Verificar si el usuario es un maestro
    $sql_teacher = "SELECT * FROM teachers WHERE email = ?";
    $stmt_teacher = $conn->prepare($sql_teacher);
    $stmt_teacher->bind_param("s", $email);
    $stmt_teacher->execute();
    $result_teacher = $stmt_teacher->get_result();

    if ($result_teacher->num_rows > 0) {
        $row_teacher = $result_teacher->fetch_assoc();
        if (password_verify($password, $row_teacher['password'])) {
            $_SESSION['user_role'] = 'teacher';
            $_SESSION['user_email'] = $email;
            header("Location: index teacher.html");
            exit();
        }
    }

    // Si las credenciales no coinciden
    echo "Correo electrónico o contraseña incorrectos.";
}

$conn->close();
?>
