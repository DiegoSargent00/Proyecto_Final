<?php
// verificacion correo.php
require "conecta.php";
$con = conecta();

$correo = $_POST['correo']; // Obtén el correo del POST

$sql = "SELECT * FROM Empleado WHERE correo = ? AND eliminado = 0";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$stmt->store_result();
$count = $stmt->num_rows;

if ($count > 0) {
    echo "existe"; // El correo ya existe
} else {
    echo "noexiste"; // El correo no existe
}
?>
