<?php
require "funciones/conecta.php";
$con = conecta();

if ($con->connect_error) {
    die("Conexión fallida: " . $con->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];

    // Verificar si el nombre de la promoción ya existe
    $sqlCheck = "SELECT * FROM promociones WHERE nombre = ?";
    $stmtCheck = $con->prepare($sqlCheck);
    $stmtCheck->bind_param("s", $nombre);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        echo "La promoción ya existe. Introduce un nombre nuevo.";
    } else {
        // Procesar la imagen si se proporciona
        if (!empty($_FILES['imagen']['name'])) {
            $file_name = $_FILES['imagen']['name'];
            $file_tmp = $_FILES['imagen']['tmp_name'];
            $arreglo = explode(".", $file_name);
            $len = count($arreglo);
            $pos = $len - 1;
            $ext = $arreglo[$pos];
            $dir = "archivos/"; 
            $file_enc = md5_file($file_tmp);

            $fileName1 = "$file_enc.$ext";
            move_uploaded_file($file_tmp, $dir . $fileName1);
        } else {
            $fileName1 = ''; // Si no se proporciona una imagen
        }

        // Insertar la nueva promoción
        $sqlInsert = "INSERT INTO promociones (nombre, archivo) VALUES (?, ?)";
        $stmtInsert = $con->prepare($sqlInsert);

        if ($stmtInsert) {
            $stmtInsert->bind_param("ss", $nombre, $fileName1);

            if ($stmtInsert->execute()) {
                header("Location: promocion_lista.php");
            } else {
                echo "Error al guardar la promoción: " . $stmtInsert->error;
            }

            $stmtInsert->close();
        } else {
            echo "Error en la consulta SQL.";
        }
    }

    $stmtCheck->close();
}
?>
