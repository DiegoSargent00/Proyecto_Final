<?php
require "funciones/conecta.php";
$con = conecta();

if ($con->connect_error) {
    die("Conexión fallida: " . $con->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $pass = $_POST['pass'];
    $rol = $_POST['rol'];

    $file_name = $_FILES['foto']['name'];
    $file_tmp = $_FILES['foto']['tmp_name'];
    $arreglo = explode(".", $file_name);
    $len = count($arreglo);
    $pos = $len - 1;
    $ext = $arreglo[$pos];
    $dir = "archivos/";
    $file_enc = md5_file($file_tmp);

    if ($file_name != '') {
        $fileName1 = "$file_enc.$ext";
        move_uploaded_file($file_tmp, $dir . $fileName1);
    }

    if (empty($nombre) || empty($apellidos) || empty($correo) || empty($pass) || $rol === '0') {
        echo "Faltan campos por llenar.";
    } else {
        $passEnc = md5($pass);

        $sql = "INSERT INTO empleado (nombre, apellido, correo, pass, rol, archivo_h, archivo)
                VALUES (?, ?, ?, ?, ?, '', ?)";

        $stmt = $con->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssssis", $nombre, $apellidos, $correo, $passEnc, $rol, $fileName1);

            if ($stmt->execute()) {
                header("Location: empleados_lista1.php");
            } else {
                echo "Error al guardar el empleado: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error en la consulta SQL.";
        }
    }
}
?>
