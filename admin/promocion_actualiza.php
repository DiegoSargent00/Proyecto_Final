<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require "funciones/conecta.php";
    $con = conecta();
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];

    // Verificar si la promoción ya existe
    $sqlCheck = "SELECT * FROM promociones WHERE nombre = ? AND id != ?";
    $stmtCheck = $con->prepare($sqlCheck);
    $stmtCheck->bind_param("si", $nombre, $id);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        echo "La promoción ya existe. Introduce un nombre nuevo.";
    } else {
        $descripcion = $_POST["descripcion"];
        $file_name = $_FILES['foto']['name'];

        // Verificar si se proporciona una nueva imagen
        if (!empty($file_name)) {
            $file_tmp = $_FILES['foto']['tmp_name'];
            $arreglo = explode(".", $file_name);
            $len = count($arreglo);
            $pos = $len - 1;
            $ext = $arreglo[$pos];
            $dir = "archivos/";
            $file_enc = md5_file($file_tmp);
            $fileName1 = "$file_enc.$ext";
            move_uploaded_file($file_tmp, $dir . $fileName1);

            $sql = "UPDATE promociones SET nombre = ?, descripcion = ?, archivo = ? WHERE id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("sssi", $nombre, $descripcion, $fileName1, $id);
        } else {
            // Si no se proporciona una nueva imagen, conservar la imagen actual
            $sql = "UPDATE promociones SET nombre = ?, descripcion = ? WHERE id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ssi", $nombre, $descripcion, $id);
        }

        $stmt->execute();
        $stmt->close();
        header("Location: promocion_lista.php");
    }

    $stmtCheck->close();
}
?>
