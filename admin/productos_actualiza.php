<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require "funciones/conecta.php";
    $con = conecta();
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $codigo = $_POST["codigo"];
    $descripcion = $_POST["descripcion"];
    $costo = $_POST["costo"];
    $stock = $_POST["stock"];

    if (!empty($_FILES['foto']['name'])) {
        $file_name = $_FILES['foto']['name'];
        $file_tmp = $_FILES['foto']['tmp_name'];
        $arreglo = explode(".", $file_name);
        $len = count($arreglo);
        $pos = $len - 1;
        $ext = $arreglo[$pos];
        $dir = "archivos/";
        $file_enc = md5_file($file_tmp);
        $fileName1 = "$file_enc.$ext";
        move_uploaded_file($file_tmp, $dir . $fileName1);

        $sql = "UPDATE productos SET nombre = ?, codigo = ?, descripcion = ?, costo = ?, stock = ?, foto = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssdsi", $nombre, $codigo, $descripcion, $costo, $stock, $fileName1, $id);
    } else {
        $sql = "UPDATE productos SET nombre = ?, codigo = ?, descripcion = ?, costo = ?, stock = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssdi", $nombre, $codigo, $descripcion, $costo, $stock, $id);
    }

    $stmt->execute();
    $stmt->close();
    header("Location: productos_lista.php");
}
