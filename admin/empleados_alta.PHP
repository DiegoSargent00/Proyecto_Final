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
    <title>Agregar Empleado</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.0/cosmo/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
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
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
    <script>
        function verificarCorreo(correo) {
            var test;
            $.ajax({
                type: "POST",
                url: "funciones/verificacion correo.php", 
                data: { correo: correo },
                success: function (response) {
                    if (response === "existe") {
                        $("#correo-message").text("El correo " + correo + " ya existe.").removeClass("alert-success").addClass("alert-danger").show();
                        $("#guardar").prop('disabled', true);
                        setTimeout(function () {
                            $("#correo-message").text("").hide();
                        }, 5000);
                    } else {
                        $("#correo-message").text("").hide();
                        $("#guardar").prop('disabled', false);
                    }
                }
            });
        }

        function validar() {           
            var nombre = $("#nombre").val();
            var apellidos = $("#apellidos").val();
            var correo = $("#correo").val();
            var pass = $("#pass").val();
            var rol = $("#rol").val();
            var foto = $("#foto")[0].files[0];
            var mensaje = $("#mensaje");
            if (nombre !== "" && apellidos !== "" && correo !== "" && pass !== "" && rol > 0 && foto) {
                var formData = new FormData();
                formData.append('nombre', nombre);
                formData.append('apellidos', apellidos);
                formData.append('correo', correo);
                formData.append('pass', pass);
                formData.append('rol', rol);
                formData.append('foto', foto);

                $.ajax({
                    type: "POST",
                    url: "empleados_salva.php",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        mensaje.text("Empleado registrado exitosamente").removeClass("alert-danger").addClass("alert-success").show();
                        setTimeout(function () {
                            location.href = "empleados_lista1.php";
                        }, 3000);
                    }
                });
            } else {
                mensaje.text("Error: Faltan campos por llenar").removeClass("alert-success").addClass("alert-danger").show();
                setTimeout(function () {
                    mensaje.text("").hide();
                }, 5000);
            }
        }
    </script>
</head>

<body class="bg-light">
    <div class="container">
        <h1 class="mt-5">Agregar Empleado</h1>

        <div class="menu">
        <div class="menu-items"><a class="btn btn-outline-light" href="bienvenido.php">Inicio</a></div>
            <div class="menu-items"><a class="btn btn-outline-light" href="empleados_lista1.php">Empleados</a></div>
            <div class="menu-items"><a class="btn btn-outline-light" href="productos_lista.php">Productos</a></div>
            <div class="menu-items"><a class="btn btn-outline-light" href="pedidos_lista.php">Pedidos</a></div>
            <div class="menu-items"><a class="btn btn-outline-light" href="cerrar_sesion.php">Salir</a></div>
        </div>

        <form name="Form01" id="Form01" method="post" class="mt-4" enctype="multipart/form-data">
            <div class="form-group">
                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" required>
            </div>
            <div class="form-group">
                <input type="text" name="apellidos" id="apellidos" class="form-control" placeholder="Apellidos" required>
            </div>
            <div class="form-group">
                <input type="text" name="correo" id="correo" class="form-control" placeholder="Correo" required onblur="verificarCorreo(this.value)">
                <div id="correo-message" class="error-message mt-2"></div>
            </div>
            <div class="form-group">
                <input type="password" name="pass" id="pass" class="form-control" placeholder="Contraseña" required>
            </div>
            <div class="form-group">
                <select form="Form01" name="rol" id="rol" class="form-control" required>
                    <option value="0">Selecciona</option>
                    <option value="1">Gerente</option>
                    <option value="2">Ejecutivo</option>
                </select>
            </div>
            <div class="form-group">
                <label for="foto">Foto del Empleado:</label>
                <input type="file" name="foto" id="foto" accept="image/*" required>
            </div>
            <button id="guardar" type="button" class="btn btn-primary" onclick="validar();">Guardar</button>
        </form>

        <div id="mensaje" class="alert mt-4" style="display: none;"></div>

        <a href="empleados_lista1.php" class="btn btn-secondary mt-3">Regresar al Listado</a>
    </div>
</body>
</html>
