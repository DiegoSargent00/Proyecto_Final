<?php
require "funciones/conecta.php";

if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
    try {
        $con = conecta();
        $id = $_REQUEST['id'];

        $sql = "UPDATE promociones SET eliminado = 1 WHERE id = ?";
        $stmt = $con->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                echo json_encode(["success" => true, "id" => $id]);
            } else {
                throw new Exception("Error al eliminar la promoción.");
            }
        } else {
            throw new Exception("Error en la consulta SQL.");
        }
    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "ID no válido o no proporcionado."]);
}
?>
