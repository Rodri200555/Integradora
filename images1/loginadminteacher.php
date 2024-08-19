<!-- maestro_home.php -->
<?php
session_start();
if ($_SESSION['user_role'] !== 'maestro') {
    header("Location: index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido Maestro</title>
</head>
<body>
    <h1>Bienvenido, Maestro</h1>
    <p>Has iniciado sesión como maestro y tienes acceso a la red y puedes ver el número de usuarios conectados.</p>
    <!-- maestro_home.php -->
<?php
session_start();
if ($_SESSION['user_role'] !== 'maestro') {
    header("Location: index.html");
    exit();
}
header("Location: success.html");
?>

</body>
</html>
