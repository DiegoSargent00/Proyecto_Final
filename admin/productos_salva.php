<?php
require "funciones/conecta.php";
$con = conecta();

if ($con->connect_error) {
    die("Conexión fallida: " . $con->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $descripcion = $_POST['descripcion'];
    $costo = $_POST['costo'];
    $stock = $_POST['stock'];

    if (empty($nombre) || empty($codigo) || empty($descripcion) || empty($costo) || empty($stock)) {
        echo "Faltan campos por llenar.";
    } else {
        $sqlCheck = "SELECT * FROM productos WHERE codigo = ?";
        $stmtCheck = $con->prepare($sqlCheck);
        $stmtCheck->bind_param("s", $codigo);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();

        if ($resultCheck->num_rows > 0) {
            echo "El código ya existe. Introduce uno nuevo.";
        } else {
            $file_name = $_FILES['imagen']['name'];
            $file_tmp = $_FILES['imagen']['tmp_name'];
            $arreglo = explode(".", $file_name);
            $len = count($arreglo);
            $pos = $len - 1;
            $ext = $arreglo[$pos];
            $dir = "archivos/"; 
            $file_enc = md5_file($file_tmp);

            if ($file_name != '') {
                $fileName1 = "$file_enc.$ext";
                move_uploaded_file($file_tmp, $dir . $fileName1);
            } else {
                $fileName1 = ''; 
            }
            $sqlInsert = "INSERT INTO productos (nombre, codigo, descripcion, costo, stock, archivo) VALUES (?, ?, ?, ?, ?, ?)";
            $stmtInsert = $con->prepare($sqlInsert);

            if ($stmtInsert) {
                $stmtInsert->bind_param("ssssds", $nombre, $codigo, $descripcion, $costo, $stock, $fileName1);

                if ($stmtInsert->execute()) {
                    header("Location: productos_lista.php");
                } else {
                    echo "Error al guardar el producto: " . $stmtInsert->error;
                }

                $stmtInsert->close();
            } else {
                echo "Error en la consulta SQL.";
            }
        }

        $stmtCheck->close();
    }
}
?>
