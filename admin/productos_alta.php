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
    <title>Registro de Producto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.0/cosmo/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        .error-message {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            padding: 8px;
            margin-top: 5px;
            display: none;
        }
    </style>
</head>

<body>

    <h2>Registro de Producto</h2>

    <div class="container">
        <div class="menu">
            <div class="menu-items"><a class="btn btn-outline-light" href="bienvenido.php">Inicio</a></div>
            <div class="menu-items"><a class="btn btn-outline-light" href="empleados_lista1.php">Empleados</a></div>
            <div class="menu-items"><a class="btn btn-outline-light" href="productos_lista.php">Productos</a></div>
            <div class="menu-items"><a class="btn btn-outline-light" href="pedidos_lista.php">Pedidos</a></div>
            <div class="menu-items"><a class="btn btn-outline-light" href="cerrar_sesion.php">Salir</a></div>
        </div>

        <form action="productos_salva.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Producto:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="codigo" class="form-label">Código del Producto:</label>
                <input type="text" class="form-control" id="codigo" name="codigo" required>
                <div id="codigo-message" class="error-message"></div>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
            </div>
            <div class="mb-3">
                <label for="costo" class="form-label">Costo:</label>
                <input type="number" class="form-control" id="costo" name="costo" required>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Stock:</label>
                <input type="number" class="form-control" id="stock" name="stock" required>
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen del Producto:</label>
                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
            </div>
            <button id="guardar" type="submit" class="btn btn-primary">Guardar Producto</button>
            <a href="productos_lista.php" class="btn btn-secondary">Regresar a la Lista de Productos</a>
        </form>
        <div id="mensaje" class="alert mt-4" style="display: none;"></div>

        <script>
            function verificarCodigo(codigo) {
                $.ajax({
                    type: "POST",
                    url: "funciones/verificacion_codigo.php",
                    data: { codigo: codigo },
                    success: function (response) {
                        if (response === "existe") {
                            $("#codigo-message").text("El código " + codigo + " ya existe.").removeClass("alert-success").addClass("alert-danger").show();
                            $("#guardar").prop('disabled', true);
                            setTimeout(function () {
                            $("#correo-message").text("").hide();
                        }, 5000);
                        } else {
                            $("#codigo-message").text("").hide();
                            $("#guardar").prop('disabled', false);
                        }
                    }
                });
            }

            $(document).ready(function () {
                $("#codigo").on("input", function () {
                    var codigo = $(this).val();
                    verificarCodigo(codigo);
                });
            });
        </script>

    </div>
</body>

</html>
