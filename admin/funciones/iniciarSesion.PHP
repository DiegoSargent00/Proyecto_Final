<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nombre'])) {
        $_SESSION['nombre'] = $_POST['nombre'];
        echo json_encode(['success' => true, 'message' => 'Sesión iniciada correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al iniciar la sesión: Nombre no proporcionado']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Acceso no autorizado']);
}
?>
