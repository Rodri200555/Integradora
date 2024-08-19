<?php
session_start();
session_unset();
session_destroy();
header("Location: admin_teacher_login.html");
exit();
?>
