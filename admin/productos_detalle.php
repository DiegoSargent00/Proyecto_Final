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
    <style>
        .container {
            text-align: center;
        }

        .img-container {
            max-width: 300px;
            margin: 0 auto;
        }

        .img-thumbnail {
            max-width: 100%;
            height: auto;
        }

        .table {
            width: 50%;
            margin: 20px auto;
        }

        .menu {
            display: flex;
            justify-content: center;
            background-color: #007bff;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .menu-items {
            margin: 0 10px;
        }

        .menu-items a {
            text-decoration: none;
            color: #ffffff;
            font-weight: bold;
        }
    </style>
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
    <h2 class="mt-5">Detalles del Producto</h2>

    <div class="menu">
    <div class="menu-items"><a class="btn btn-outline-light" href="bienvenido.php">Inicio</a></div>
            <div class="menu-items"><a class="btn btn-outline-light" href="empleados_lista1.php">Empleados</a></div>
            <div class="menu-items"><a class="btn btn-outline-light" href="productos_lista.php">Productos</a></div>
            <div class="menu-items"><a class="btn btn-outline-light" href="pedidos_lista.php">Pedidos</a></div>
            <div class="menu-items"><a class="btn btn-outline-light" href="cerrar_sesion.php">Salir</a></div>
    </div>

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
