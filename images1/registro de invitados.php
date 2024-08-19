<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricula = $_POST['matricula'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    // Insertar los datos en la tabla invitados
    $stmt = $conn->prepare("INSERT INTO invitados (correo, matricula, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $correo, $matricula, $hashed_password);

    
    if ($stmt->execute()) {
        // Redirigir a la página de éxito
        header("Location: success.html");
        exit();
    } else {
        echo "Error al registrar los datos.";
    }

    $stmt->close();
    $conn->close();
}
?>

