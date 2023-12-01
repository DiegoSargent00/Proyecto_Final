<?php
session_start();

if (!isset($_SESSION['nombre'])) {
    header("Location: index.php");
    exit();
}

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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $descripcion = $_POST['descripcion'];
    $costo = $_POST['costo'];
    $stock = $_POST['stock'];
    
    // Obtener el nombre de la imagen actual en la base de datos
    $sqlImagenActual = "SELECT archivo FROM productos WHERE id = ?";
    $stmtImagenActual = $con->prepare($sqlImagenActual);
    $stmtImagenActual->bind_param("i", $id);
    $stmtImagenActual->execute();
    $stmtImagenActual->bind_result($imagenActual);
    $stmtImagenActual->fetch();
    $stmtImagenActual->close();

    // Si se proporciona una nueva imagen, procesarla
    if (!empty($_FILES['foto']['name'])) {
        $file_name = $_FILES['foto']['name'];
        $file_tmp = $_FILES['foto']['tmp_name'];
        $arreglo = explode(".", $file_name);
        $len = count($arreglo);
        $pos = $len - 1;
        $ext = $arreglo[$pos];
        $dir = "archivos/"; 
        $file_enc = md5_file($file_tmp);

        $fileName1 = "$file_enc.$ext";
        move_uploaded_file($file_tmp, $dir . $fileName1);

        // Eliminar la imagen actual si existe
        if (!empty($imagenActual)) {
            unlink($dir . $imagenActual);
        }
    } else {
        // Si no se proporciona una nueva imagen, conservar la imagen actual
        $fileName1 = $imagenActual;
    }

    $sqlUpdate = "UPDATE productos SET nombre = ?, codigo = ?, descripcion = ?, costo = ?, stock = ?, archivo = ? WHERE id = ?";
    $stmtUpdate = $con->prepare($sqlUpdate);

    if ($stmtUpdate) {
        $stmtUpdate->bind_param("ssssdsi", $nombre, $codigo, $descripcion, $costo, $stock, $fileName1, $id);

        if ($stmtUpdate->execute()) {
            // Éxito al actualizar la base de datos
            header("Location: productos_lista.php");
        } else {
            echo "Error al actualizar el producto: " . $stmtUpdate->error;
        }

        $stmtUpdate->close();
    } else {
        echo "Error en la consulta SQL para actualizar producto.";
    }
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
</head>

<body>

    <div class="container">
        <h2>Edición de Producto</h2>
        <?php include_once "funciones/bienvenido-template.php" ?>
    </div>

    <div class="container">
        <div style="text-align: left">
            <form id="editProductForm" enctype="multipart/form-data" method="post">
                <div class="form-group">
                    <input id="productoId" type="hidden" value="<?php echo $id; ?>" >
                    <label for="nombre">Nombre del Producto:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
                </div>
                <div class="form-group">
                    <label for="codigo">Código del Producto:</label>
                    <input type="text" class="form-control" id="codigo" name="codigo" value="<?php echo $codigo; ?>" required>
                    <!-- Nuevo campo para mostrar mensajes de validación del código -->
                    <div id="codigo-message" class="error-message"></div>
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
                <button type="submit" class="btn btn-primary" id="updateButton">Actualizar</button>
                <a href="productos_lista.php" class="btn btn-secondary">Regresar</a>
            </form>
            <div id="mensaje" class="alert mt-4" style="display: none;"></div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Función para verificar el código en tiempo real
            function verificarCodigo(codigo) {
                var id=$('#productoId').val();
                console.log(id);
                $.ajax({
                    type: "POST",
                    url: "funciones/verificacion_codigo.php",
                    data: { codigo: codigo, id: id },
                    success: function (response) {
                        if (response === "existe") {
                            $("#codigo-message").text("El código " + codigo + " ya existe.").removeClass("alert-success").addClass("alert-danger").show();
                            $("#updateButton").prop('disabled', true);
                        } else {
                            $("#codigo-message").text("").hide();
                            $("#updateButton").prop('disabled', false);
                        }
                    }
                });
            }

            // Evento que se dispara al ingresar el código
            $("#codigo").on("input", function () {
                var codigo = $(this).val();
                verificarCodigo(codigo);
            });
        });
    </script>
</body>

</html>
