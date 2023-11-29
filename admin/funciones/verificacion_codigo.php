<?php
session_start();

// Verificar si la sesión no está abierta
if (!isset($_SESSION['nombre'])) {
    header("Location: index.php");
    exit();
}

// Verificar si el código está definido y no está vacío
if (isset($_POST['codigo']) && !empty($_POST['codigo'])) {
    require "funciones/conecta.php";

    $con = conecta();
    $codigo = $_POST['codigo'];

    // Utiliza una consulta preparada para prevenir inyección SQL.
    $sql = "SELECT COUNT(*) as count FROM productos WHERE codigo = ?";
    
    $stmt = $con->prepare($sql);
    
    if ($stmt) {
        // Vincula el parámetro 'codigo' y ejecuta la consulta.
        $stmt->bind_param("s", $codigo); // "s" indica que se espera una cadena.
        if ($stmt->execute()) {
            // Obtiene el resultado de la consulta
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            // Comprueba si ya existe un producto con el mismo código
            if ($row['count'] > 0) {
                // Respuesta si el código ya existe
                echo "existe";
            } else {
                // Respuesta si el código no existe
                echo "no_existe";
            }
        } else {
            // Ocurrió un error al ejecutar la consulta.
            echo "Error en la ejecución de la consulta SQL.";
        }
    } else {
        // Ocurrió un error al preparar la consulta.
        echo "Error en la preparación de la consulta SQL.";
    }
} else {
    // Si 'codigo' no está definido o está vacío, muestra un mensaje de error.
    echo "Código no válido o no proporcionado.";
}
?>
