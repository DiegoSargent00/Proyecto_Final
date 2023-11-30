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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.0/cosmo/bootstrap.min.css">
</head>

<body>
<div class="container">
    <h2>Bienvenido <?= $nombre; ?> al sistema</h2>
    <?php include_once "funciones/bienvenido-template.php" ?>
</div>
</body>

</html>
