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
    <title>Listado de Productos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.0/cosmo/bootstrap.min.css">
    <style>
        .container {
            margin-top: 50px;
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

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .btn-crear {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    
<h2>Listado de Productos</h2>

<div class="container">
    <div class="menu">
        <div class="menu-items"><a class="btn btn-outline-light" href="bienvenido.php">Inicio</a></div>
        <div class="menu-items"><a class="btn btn-outline-light" href="empleados_lista1.php">Empleados</a></div>
        <div class="menu-items"><a class="btn btn-outline-light" href="productos_lista.php">Productos</a></div>
        <div class="menu-items"><a class="btn btn-outline-light" href="pedidos_lista.php">Pedidos</a></div>
        <div class="menu-items"><a class="btn btn-outline-light" href="cerrar_sesion.php">Salir</a></div>
    </div>

    <a class="btn btn-primary mb-3" href="productos_alta.php">Crear nuevo producto</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Código</th>
                <th scope="col">Descripción</th>
                <th scope="col">Costo</th>
                <th scope="col">Stock</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require "funciones/conecta.php";
            $con = conecta();
            $sql = "SELECT * FROM productos WHERE eliminado = 0";
            $res = $con->query($sql);
            while($row = $res->fetch_array()) {
                $id = $row["id"];
                $nombre = $row["nombre"];
                $codigo = $row["codigo"];
                $descripcion = $row["descripcion"];
                $costo = $row["costo"];
                $stock = $row["stock"];
                echo "<tr id='fila$id'>";
                echo "<th scope='row'>$id</th>";
                echo "<td>$nombre</td>";
                echo "<td>$codigo</td>";
                echo "<td>$descripcion</td>";
                echo "<td>$costo</td>";
                echo "<td>$stock</td>";
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
            if (confirm("¿Estás seguro de que deseas eliminar este producto?")) {
                $.ajax({
                    type: "POST",
                    url: "productos_elimina.php",
                    data: { id: id },
                    success: function (response) {
                        $("#fila" + response).remove();
                    }
                });
            }
        });

        $(".editar").click(function () {
            var id = $(this).data('id');
            window.location.href = "productos_editar.php?id=" + id;
        });

        $(".detalle").click(function () {
            var id = $(this).data('id');
            window.location.href = "productos_detalle.php?id=" + id;
        });
    });
</script>

</body>
</html>
