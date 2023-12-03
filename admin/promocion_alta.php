<?php
session_start();

if (!isset($_SESSION['nombre'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require "funciones/conecta.php";
    $con = conecta();

    if ($con->connect_error) {
        die("Conexión fallida: " . $con->connect_error);
    }

    $nombre = $_POST['nombre'];


    if (empty($nombre) ) {
        echo "Faltan campos por llenar.";
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
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Promoción</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.0/cosmo/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container">
        <h2>Registro de Promoción</h2>
        <?php include_once "funciones/bienvenido-template.php" ?>
    </div>

    <div class="container">
        <div style="text-align: left;">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre de la Promoción:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="imagen" class="form-label">Imagen de la Promoción:</label>
                    <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary">Guardar Promoción</button>
                <a href="promocion_lista.php" class="btn btn-secondary">Regresar a la Lista de Promociones</a>
            </form>
            <div id="mensaje" class="alert mt-4" style="display: none;"></div>
        </div>

        <script>
        </script>

    </div>
</body>

</html>
