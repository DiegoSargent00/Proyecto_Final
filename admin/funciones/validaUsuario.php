<?php
// validaUsuario.php
require "conecta.php";
$con = conecta();

$correo = $_POST['correo'];
$pass = md5($_POST['pass']);

$sql = "SELECT * FROM empleado WHERE status = 1 AND eliminado = 0 AND correo = '$correo' AND pass = '$pass'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    // Usuario válido
    $usuario = $result->fetch_assoc();
    echo json_encode(['success' => true, 'nombre' => $usuario['nombre']]);
} else {
    // Usuario no válido
    echo json_encode(['success' => false, 'message' => 'Usuario no válido. Verifica tu correo y contraseña.', 'query' => $sql]);
}
?>
