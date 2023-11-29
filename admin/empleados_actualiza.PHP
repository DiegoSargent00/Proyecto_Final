<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require "funciones/conecta.php";
    $con = conecta();
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $correo = $_POST["correo"];
    $rol = $_POST["rol"];

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

        $sql = "UPDATE empleado SET nombre = '$nombre', apellido = '$apellidos', correo = '$correo', rol = $rol, archivo = '$fileName1' WHERE id = $id";
    } else {
        $sql = "UPDATE empleado SET nombre = '$nombre', apellido = '$apellidos', correo = '$correo', rol = $rol WHERE id = $id";
    }

    $con->query($sql);

    header("Location: empleados_lista1.php");
}

