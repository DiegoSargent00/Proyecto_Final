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
    <title>Edición de Producto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.0/cosmo/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        .error-message {
            color: red;
        }

        .title {
            text-align: center;
            margin-bottom: 20px;
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
?>

<div class="container">
    <h2 class="title mt-5">Edición de Producto</h2>

    <div class="menu">
    <div class="menu-items"><a class="btn btn-outline-light" href="bienvenido.php">Inicio</a></div>
            <div class="menu-items"><a class="btn btn-outline-light" href="empleados_lista1.php">Empleados</a></div>
            <div class="menu-items"><a class="btn btn-outline-light" href="productos_lista.php">Productos</a></div>
            <div class="menu-items"><a class="btn btn-outline-light" href="pedidos_lista.php">Pedidos</a></div>
            <div class="menu-items"><a class="btn btn-outline-light" href="cerrar_sesion.php">Salir</a></div>
    </div>

    <form id="editProductForm" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nombre">Nombre del Producto:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
        </div>
        <div class="form-group">
            <label for="codigo">Código del Producto:</label>
            <input type="text" class="form-control" id="codigo" name="codigo" value="<?php echo $codigo; ?>" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea class="form-control" id="descripcion" name="descripcion" required><?php echo $descripcion; ?></textarea>
        </div>
        <div class="form-group">
            <label for="costo">Costo:</label>
            <input type="number" class="form-control" id="costo" name="costo" value="<?php echo $costo; ?>" required>
        </div>
        <div class="form-group">
            <label for="stock">Stock:</label>
            <input type="number" class="form-control" id="stock" name="stock" value="<?php echo $stock; ?>" required>
        </div>
        <div class="form-group">
            <label for="foto">Imagen del Producto:</label>
            <input type="file" name="foto" id="foto" accept="image/*">
        </div>
        <button type="button" class="btn btn-primary" id="updateButton">Actualizar</button>
        <a href="productos_lista.php" class="btn btn-secondary">Regresar</a>
    </form>

    <div id="mensaje" class="alert mt-4" style="display: none;"></div>
</div>

<script>
$(document).ready(function () {
    $('#updateButton').on('click', function () {
        var nombre = $('#nombre').val();
        var codigo = $('#codigo').val();
        var descripcion = $('#descripcion').val();
        var costo = $('#costo').val();
        var stock = $('#stock').val();
        var foto = $('#foto')[0].files[0];

        if (nombre === '' || codigo === '' || descripcion === '' || costo === '' || stock === '') {
            $('#mensaje').text('Faltan campos por llenar.').removeClass('alert-success').addClass('alert-danger').show();
            setTimeout(function () {
                $('#mensaje').text('').hide();
            }, 5000);
            return;
        }

        var formData = new FormData();
        formData.append('id', <?php echo $id; ?>);
        formData.append('nombre', nombre);
        formData.append('codigo', codigo);
        formData.append('descripcion', descripcion);
        formData.append('costo', costo);
        formData.append('stock', stock);
        formData.append('foto', foto);

        $.ajax({
            type: 'POST',
            url: 'productos_actualiza.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                window.location.href = 'productos_lista.php';
            }
        });
    });
});
</script>
</body>

</html>
