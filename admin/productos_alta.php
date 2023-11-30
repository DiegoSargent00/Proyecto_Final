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
</head>

<body>
    <div class="container">
        <h2>Registro de Producto</h2>
        <?php include_once "funciones/bienvenido-template.php" ?>
    </div>

    <div class="container">
        <div style="text-align: left;">
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
        </div>

        <script>
            function verificarCodigo(codigo) {
                $.ajax({
                    type: "POST",
                    url: "funciones/verificacion_codigo.php",
                    data: { codigo: codigo, id: "nuevo" },
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
