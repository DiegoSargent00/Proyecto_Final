<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Contacto</title>
        <link href="./Assets/CSS/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>

        <?php include('./Header.php') ?>

        <div class="container mt-3">
            <form>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Nombre(s)</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Telefono</label>
                    <input type="tel" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Correo Electronico</label>
                    <input type="email" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Asunto</label>
                    <input type="text" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Descripcion</label>
                    <textarea class="form-control" id="exampleInputPassword1" rows="5"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

        <?php include('./Footer.php') ?>

        <script src="./Assets/JS/bootstrap.bundle.min.js"></script>
        <script src="./Assets/JS/jquery.min.js"></script>

        <script>

            function consulta() {
                var parametros = {
                    "" : ""
                }

                $.ajax({
                    data: parametros,
                    url: '',
                    type: 'POST',

                    beforesend: function() {

                    },

                    success: function() {

                    }

                });
            }

        </script>

    </body>
</html>