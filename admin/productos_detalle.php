<?php
session_start();

if (!isset($_SESSION['nombre'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Producto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.0/cosmo/bootstrap.min.css"> 
</head>
<body>
    <?php
        require "funciones/conecta.php";
        $con = conecta();
        $id = $_GET["id"];
        $sql = "SELECT * FROM productos WHERE id = $id";
        $res = $con->query($sql);
        $row = $res->fetch_array();
        $nombre = $row["nombre"];
        $codigo = $row["codigo"];
        $descripcion = $row["descripcion"];
        $costo = $row["costo"];
        $stock = $row["stock"];
        $imagen = $row["archivo"];
    ?>

    <div class="container">
        <h2>Detalles del Producto</h2>
        <?php include_once "funciones/bienvenido-template.php" ?>
    </div>

    <div class="container">
        <div class="img-container">
            <img src="archivos/<?php echo $imagen; ?>" alt="Imagen de <?php echo $nombre; ?>" class="img-thumbnail">
        </div>

        <table class="table">
            <tr>
                <td>Nombre del Producto:</td>
                <td><?php echo $nombre; ?></td>
            </tr>
            <tr>
                <td>Código del Producto:</td>
                <td><?php echo $codigo; ?></td>
            </tr>
            <tr>
                <td>Descripción:</td>
                <td><?php echo $descripcion; ?></td>
            </tr>
            <tr>
                <td>Costo:</td>
                <td><?php echo $costo; ?></td>
            </tr>
            <tr>
                <td>Stock:</td>
                <td><?php echo $stock; ?></td>
            </tr>
        </table>
        <a href="productos_lista.php" class="btn btn-primary">Regresar al Listado</a>
    </div>

</body>
</html>
