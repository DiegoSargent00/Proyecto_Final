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
    <title>Listado de Empleados</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.0/cosmo/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Listado de Empleados</h2>
        <?php include_once "funciones/bienvenido-template.php" ?>
    </div>
    <div class="container">     
        <div style="text-align: left;">
            <a class="btn btn-primary mb-3" href="empleados_alta.php">Crear nuevo registro</a>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre completo</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Rol</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require "funciones/conecta.php";
                $con = conecta();
                $sql = "SELECT * FROM empleado WHERE status = 1 AND eliminado = 0";
                $res = $con->query($sql);
                while($row = $res->fetch_array()) {
                    $id = $row["id"];
                    $nombre = $row["nombre"];
                    $apellidos = $row["apellido"];
                    $correo = $row["correo"];
                    $rol = $row["rol"];
                    echo "<tr id='fila$id'>";
                    echo "<th scope='row'>$id</th>";
                    echo "<td>$nombre $apellidos</td>";
                    echo "<td>$correo</td>";
                    $rolText = ($rol == 1) ? "Gerente" : "Ejecutivo";
                    echo "<td>$rolText</td>";
                    echo "<td>";
                    echo "<a class='btn btn-outline-danger eliminar' data-id='$id'>Eliminar</a> | ";
                    echo "<a class='btn btn-outline-primary editar' data-id='$id'>Editar</a> | ";
                    echo "<a class='btn btn-outline-success detalle' data-id='$id'>Detalle</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".eliminar").click(function () {
                var id = $(this).data('id');
                if (confirm("¿Estás seguro de que deseas eliminar este empleado?")) {
                    $.ajax({
                        type: "POST",
                        url: "empleados_elimina.php",
                        data: { id: id },
                        success: function (response) {
                            $("#fila" + response).remove();
                        }
                    });
                }
            });

            $(".editar").click(function () {
                var id = $(this).data('id');
                window.location.href = "empleados_editar.php?id=" + id;
            });

            $(".detalle").click(function () {
                var id = $(this).data('id');
                window.location.href = "empleados_detalle.php?id=" + id;
            });
        });
    </script>
</body>
</html>
