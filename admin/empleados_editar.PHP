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
    <title>Edición de Empleado</title>
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
$sql = "SELECT * FROM empleado WHERE id = $id";
$res = $con->query($sql);
$row = $res->fetch_array();
$nombre = $row["nombre"];
$apellidos = $row["apellido"];
$correo = $row["correo"];
$rol = $row["rol"];
?>

<div class="container">
    <h2 class="title mt-5">Edición de Empleado</h2>

    <div class="menu">
    <div class="menu-items"><a class="btn btn-outline-light" href="bienvenido.php">Inicio</a></div>
            <div class="menu-items"><a class="btn btn-outline-light" href="empleados_lista1.php">Empleados</a></div>
            <div class="menu-items"><a class="btn btn-outline-light" href="productos_lista.php">Productos</a></div>
            <div class="menu-items"><a class="btn btn-outline-light" href="pedidos_lista.php">Pedidos</a></div>
            <div class="menu-items"><a class="btn btn-outline-light" href="cerrar_sesion.php">Salir</a></div>
    </div>

    <form id="editEmployeeForm" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
        </div>
        <div class="form-group">
            <label for="apellidos">Apellidos:</label>
            <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo $apellidos; ?>" required>
        </div>
        <div class="form-group">
            <label for="correo">Correo:</label>
            <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $correo; ?>" required>
            <div class="error-message" id="emailError"></div>
        </div>
        <div class="form-group">
            <label for="rol">Rol:</label>
            <select class="form-control" id="rol" name="rol" required>
                <option value="1" <?php if ($rol == 1) echo "selected"; ?>>Gerente</option>
                <option value="2" <?php if ($rol == 2) echo "selected"; ?>>Ejecutivo</option>
            </select>
        </div>
        <div class="form-group">
            <label for="foto">Foto del Empleado:</label>
            <input type="file" name="foto" id="foto" accept="image/*">
        </div>
        <button type="button" class="btn btn-primary" id="updateButton">Actualizar</button>
        <a href="empleados_lista1.php" class="btn btn-secondary">Regresar</a>
    </form>

    <div id="mensaje" class="alert mt-4" style="display: none;"></div>
</div>

<script>
$(document).ready(function () {
    $('#correo').on('input', function () {
        var correo = $(this).val();
        $.ajax({
            type: 'POST',
            url: "funciones/verificacion correo.php",
            data: { correo: correo },
            success: function (response) {
                if (response == 'existe') {
                    $('#emailError').text('El correo ' + correo + ' ya existe.');
                    setTimeout(function () {
                        $('#emailError').text('');
                    }, 5000);
                } else {
                    $('#emailError').text('');
                }
            }
        });
    });

    $('#updateButton').on('click', function () {
        var nombre = $('#nombre').val();
        var apellidos = $('#apellidos').val();
        var correo = $('#correo').val();
        var rol = $('#rol').val();
        var foto = $('#foto')[0].files[0];

        if (nombre === '' || apellidos === '' || correo === '') {
            $('#mensaje').text('Faltan campos por llenar.').removeClass('alert-success').addClass('alert-danger').show();
            setTimeout(function () {
                $('#mensaje').text('').hide();
            }, 5000);
            return;
        }

        var formData = new FormData();
        formData.append('id', <?php echo $id; ?>);
        formData.append('nombre', nombre);
        formData.append('apellidos', apellidos);
        formData.append('correo', correo);
        formData.append('rol', rol);
        formData.append('foto', foto);

        $.ajax({
            type: 'POST',
            url: 'empleados_actualiza.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                window.location.href = 'empleados_lista1.php';
            }
        });
    });
});
</script>
</body>

</html>
