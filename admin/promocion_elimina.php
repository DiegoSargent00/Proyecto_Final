<?php
require "funciones/conecta.php";

if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
    $con = conecta();
    $id = $_REQUEST['id'];
    
    // Verificar si la promoción está asociada a algún pedido antes de eliminarla
    $sqlCheck = "SELECT COUNT(*) FROM pedidos WHERE id_promocion = ?";
    $stmtCheck = $con->prepare($sqlCheck);
    $stmtCheck->bind_param("i", $id);
    $stmtCheck->execute();
    $stmtCheck->bind_result($count);
    $stmtCheck->fetch();
    $stmtCheck->close();

    if ($count > 0) {
        echo "No se puede eliminar la promoción porque está asociada a uno o más pedidos.";
    } else {
        $sql = "UPDATE promociones SET eliminado = 1 WHERE id = ?";
        $stmt = $con->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                echo $id;
            } else {
                echo "Error al eliminar la promoción.";
            }
        } else {
            echo "Error en la consulta SQL.";
        }
    }
} else {
    echo "ID no válido o no proporcionado.";
}
?>
