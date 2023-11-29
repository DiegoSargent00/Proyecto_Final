<?php
session_start();
if (isset($_SESSION['nombre'])) {
    header("Location: bienvenido.php");
    exit();
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 100px;
            max-width: 400px;
        }

        #mensaje {
            color: #F00;
            font-size: 16px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        $(document).ready(function () {

            verificarSesion();

            $("#btnEnviar").click(function () {
                validar();
            });
        });

        function verificarSesion() {

            $.ajax({
                url: "funciones/verificarSesion.php",
                type: 'post',
                dataType: 'json',
                success: function (data) {
                    if (data.success) {
                        window.location.href = 'bienvenido.php';
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log('Error en la solicitud AJAX:', textStatus, errorThrown);
                }
            });
        }

        function validar() {
            var correo = $("#correo").val();
            var pass = $("#pass").val();

            if (correo === "" || pass === "") {
                mostrarMensaje('Faltan campos por llenar');
            } else {
                $.ajax({
                    url: "funciones/validaUsuario.php",
                    type: 'post',
                    data: { correo: correo, pass: pass },
                    dataType: 'json',
                    success: function (data) {
                        if (data.success) {
                            $.ajax({
                                url: "funciones/iniciarSesion.php",
                                type: 'post',
                                data: { nombre: data.nombre },
                                dataType: 'json',
                                success: function (response) {
                                    if (response.success) {
                                        window.location.href = 'bienvenido.php';
                                    } else {
                                        mostrarMensaje('Usuario no válido. Verifica tu correo y contraseña.');
                                    }
                                }
                            });
                        } else {
                            mostrarMensaje('Usuario no válido. Verifica tu correo y contraseña.');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        mostrarMensaje('Error en la solicitud AJAX. Consulta la consola del navegador para más detalles.');
                    }
                });
            }
        }

        function mostrarMensaje(mensaje) {
            $('#mensaje').html(mensaje);
            setTimeout(function () {
                $('#mensaje').html('');
            }, 5000);
        }
    </script>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Login</h1>
        <form id="Forma01">
            <div class="form-group">
                <input type="text" class="form-control" name="correo" id="correo" placeholder="Escribe tu correo" />
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="pass" id="pass" placeholder="Escribe tu contraseña" />
            </div>
            <button type="button" class="btn btn-primary btn-block" id="btnEnviar">Enviar</button>
            <div id="mensaje" class="mt-2 text-center"></div>
        </form>
    </div>
</body>

</html>
