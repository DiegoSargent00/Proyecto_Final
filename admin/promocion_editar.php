<?php
session_start();

if (!isset($_SESSION['nombre'])) {
    header("Location: index.php");
    exit();
}

require "funciones/conecta.php";
$con = conecta();

$id = $_GET["id"];
$sql = "SELECT * FROM promociones WHERE id = $id";
$res = $con->query($sql);
$row = $res->fetch_array();
$nombre = $row["nombre"];
$imagen = $row["archivo"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    
    // Obtener el nombre de la imagen actual en la base de datos
    $sqlImagenActual = "SELECT archivo FROM promociones WHERE id = ?";
    $stmtImagenActual = $con->prepare($sqlImagenActual);
    $stmtImagenActual->bind_param("i", $id);
    $stmtImagenActual->execute();
    $stmtImagenActual->bind_result($imagenActual);
    $stmtImagenActual->fetch();
    $stmtImagenActual->close();

    // Si se proporciona una nueva imagen, procesarla
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

        // Eliminar la imagen actual si existe
        if (!empty($imagenActual)) {
            unlink($dir . $imagenActual);
        }
    } else {
        // Si no se proporciona una nueva imagen, conservar la imagen actual
        $fileName1 = $imagenActual;
    }

    $sqlUpdate = "UPDATE promociones SET nombre = ?, archivo = ? WHERE id = ?";
    $stmtUpdate = $con->prepare($sqlUpdate);

    if ($stmtUpdate) {
        $stmtUpdate->bind_param("ssi", $nombre, $fileName1, $id);

        if ($stmtUpdate->execute()) {
            // Éxito al actualizar la base de datos
            header("Location: promocion_lista.php");
        } else {
            echo "Error al actualizar la promoción: " . $stmtUpdate->error;
        }

        $stmtUpdate->close();
    } else {
        echo "Error en la consulta SQL para actualizar la promoción.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edición de Promoción</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.0/cosmo/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <div class="container">
        <h2>Edición de Promoción</h2>
        <?php include_once "funciones/bienvenido-template.php" ?>
    </div>

    <div class="container">
        <div style="text-align: left">
            <form id="editPromotionForm" enctype="multipart/form-data" method="post">
                <div class="form-group">
                    <input id="promocionId" type="hidden" value="<?php echo $id; ?>" >
                    <label for="nombre">Nombre de la Promoción:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
                </div>
                <div class="form-group">
                    <label for="foto">Imagen de la Promoción:</label>
                    <input type="file" name="foto" id="foto" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary" id="updateButton">Actualizar</button>
                <a href="promocion_lista.php" class="btn btn-secondary">Regresar</a>
            </form>
            <div id="mensaje" class="alert mt-4" style="display: none;"></div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
        });
    </script>
</body>

</html>
