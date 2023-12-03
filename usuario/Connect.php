<?php

    $serverName = 'MEGACHOCO-117\SQLEXPRESS'
    $connection = array("Database"=> "BookCRUD", "UID" => "acceso", "PWD" => "123")

    $conn = sqlsrv_connect($serverName, $connection);

    if (!$conn) {
        echo 'Fallo en la conexion'
        die(print_r(sqlsrv_errors(), true));
    }

?>