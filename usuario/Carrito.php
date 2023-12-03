<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Carrito</title>
        <link href="./Assets/CSS/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>

        <?php include('./Header.php') ?>

        <div class="container mt-3 mb-3">
            <h2>Pedidos</h2>
            <div>
                <ol class="list-group list-group-numbered">
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                        <div class="fw-bold">Producto 1</div>
                        Content for list item
                        </div>
                        <span class="badge bg-primary rounded-pill">14</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                        <div class="fw-bold">Producto 2</div>
                        Content for list item
                        </div>
                        <span class="badge bg-primary rounded-pill">14</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                        <div class="fw-bold">Producto 3</div>
                        Content for list item
                        </div>
                        <span class="badge bg-primary rounded-pill">14</span>
                    </li>
                </ol>
            </div>
        </div>

        <?php include('./Footer.php') ?>

        <script src="./Assets/JS/bootstrap.bundle.min.js"></script>
        <script src="./Assets/JS/jquery.min.js"></script>
    </body>
</html>