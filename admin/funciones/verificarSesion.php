<?php
// Verificar si no hay una sesión activa antes de iniciarla
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si la sesión no está abierta
if (!isset($_SESSION['nombre'])) {
    header("Location: index.php");
    exit();
}
?>
