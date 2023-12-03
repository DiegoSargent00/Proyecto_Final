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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Promoción</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.0/cosmo/bootstrap.min.css"> 
</head>
<body>
    <div class="container">
        <h2>Detalles de la Promoción</h2>
        <?php include_once "funciones/bienvenido-template.php" ?>
    </div>

    <div class="container">
        <div class="img-container">
            <img src="archivos/<?php echo $imagen; ?>" alt="Imagen de <?php echo $nombre; ?>" class="img-thumbnail">
        </div>

        <table class="table">
            <tr>
                <td>Nombre de la Promoción:</td>
                <td><?php echo $nombre; ?></td>
            </tr>
        </table>
        <a href="promocion_lista.php" class="btn btn-primary">Regresar al Listado de Promociones</a>
    </div>

</body>
</html>
