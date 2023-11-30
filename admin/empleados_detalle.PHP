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
    <title>Detalles del Empleado</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.0/cosmo/bootstrap.min.css"> 
</head>
<body>
    <?php
        require "funciones/conecta.php";
        $con = conecta();
        $id = $_GET["id"];
        $sql = "SELECT * FROM empleado WHERE id = $id";
        $res = $con->query($sql);
        $row = $res->fetch_array();
        $nombre = $row["nombre"];
        $apellidos = $row["apellido"];
        $correo = $row["correo"];
        $rol = ($row["rol"] == 1) ? "Gerente" : "Ejecutivo";
        $status = ($row["status"] == 1) ? "Activo" : "Inactivo";
        $imagen = $row["archivo"];
    ?>
    <div class="container">
        <h2>Detalles del Empleado</h2>
        <?php include_once "funciones/bienvenido-template.php" ?>
    </div>
    <div class="container">
        <div class="img-container">
            <img src="archivos/<?php echo $imagen; ?>" alt="Foto de <?php echo $nombre; ?>" class="img-thumbnail">
        </div>

        <table class="table">
            <tr>
                <td>Nombre completo:</td>
                <td><?php echo "$nombre $apellidos"; ?></td>
            </tr>
            <tr>
                <td>Correo:</td>
                <td><?php echo $correo; ?></td>
            </tr>
            <tr>
                <td>Rol:</td>
                <td><?php echo $rol; ?></td>
            </tr>
            <tr>
                <td>Status:</td>
                <td><?php echo $status; ?></td>
            </tr>
        </table>
        <a href="empleados_lista1.php" class="btn btn-primary">Regresar al Listado</a>
    </div>
</body>
</html>
