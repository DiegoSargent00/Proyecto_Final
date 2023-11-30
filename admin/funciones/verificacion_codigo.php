<?php
session_start();

if (!isset($_SESSION['nombre'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['codigo']) && !empty($_POST['codigo'])) {
    require "conecta.php";

    $con = conecta();
    $codigo = $_POST['codigo'];

    $sql = "SELECT COUNT(*) as count FROM productos WHERE codigo = ?";
    
    $stmt = $con->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("s", $codigo); 
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($row['count'] > 0) {
                echo "existe";
            } else {
                echo "noexiste";
            }
        } else {
            echo "Error en la ejecución de la consulta SQL.";
        }
    } else {
        echo "Error en la preparación de la consulta SQL.";
    }
} else {
    echo "Código no válido o no proporcionado.";
}
?>
