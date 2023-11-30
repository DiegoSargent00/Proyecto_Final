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
    $id = $_POST['id'];

    $sql = "SELECT COUNT(*) as count FROM productos WHERE codigo = ?";
    $sql2 = "SELECT codigo as codigo FROM productos WHERE id = ?";
    
    $stmt = $con->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $codigo); 
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $count=$row['count'];

            $stmt = $con->prepare($sql2);
            if ($stmt) {
                $stmt->bind_param("s", $id); 
                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $codigo_og=$row['codigo'];        
                    if ($codigo_og!=$codigo and $count > 0) {
                        echo "existe";//Para ver si en la funcion de edicion se envia el mismo codigo que ya tenia 
                    } else {
                        echo "noexiste";
                    }
                } else {
                    echo "Error en la ejecución de la consulta SQL.";
                }
            } else {
                echo "Error en la preparación de la consulta SQL.";
            }
        }else {
            echo "Error en la ejecución de la consulta SQL.";
        }
    } else {
        echo "Error en la preparación de la consulta SQL.";
    }

} else {
    echo "Código no válido o no proporcionado.";
}

?>
