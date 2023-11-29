<?php
require "funciones/conecta.php";

if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
    $con = conecta();
    $id = $_REQUEST['id'];
    
    $sql = "UPDATE empleado SET eliminado = 1 WHERE id = ?";
    
    $stmt = $con->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("i", $id); 
        if ($stmt->execute()) {

            echo $id;
        } else {

            echo "Error al eliminar el empleado.";
        }
    } else {

        echo "Error en la consulta SQL.";
    }
} else {

    echo "ID no válido o no proporcionado.";
}
?>

