<?php
session_start();

if (!isset($_SESSION['nombre'])) {
    header("Location: index.php");
    exit();
}

$nombre = $_SESSION['nombre'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido <?= $nombre; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .menu {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            background-color: #007bff; 
            padding: 10px; 
            border-radius: 5px; 
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
    <div class="container text-center">
        <h1 class="mb-4">Bienvenido <?= $nombre; ?> al sistema</h1>
        <div class="menu">
        <div class="menu-items"><a class="btn btn-outline-light" href="bienvenido.php">Inicio</a></div>
            <div class="menu-items"><a class="btn btn-outline-light" href="empleados_lista1.php">Empleados</a></div>
            <div class="menu-items"><a class="btn btn-outline-light" href="../productos_lista.php">Productos</a></div>
            <div class="menu-items"><a class="btn btn-outline-light" href="../pedidos_lista.php">Pedidos</a></div>
            <div class="menu-items"><a class="btn btn-outline-light" href="cerrar_sesion.php">Salir</a></div>
        </div>
    </div>
</body>

</html>
