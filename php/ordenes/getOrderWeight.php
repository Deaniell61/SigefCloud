<?php

session_start();

if (isset($_POST["method"])) {
    $orderId = $_POST["orderId"];
    echo getOrderWeight($orderId);
}

//echo getOrderWeight("3583158899858");

function getOrderWeight($orderId){

    include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

    $query = "
        SELECT 
            SUM(prod.peso)
        FROM
            tra_bun_det AS bun
                INNER JOIN
            cat_prod AS prod ON bun.mastersku = prod.mastersku
        WHERE
            bun.amazonsku IN (SELECT 
                    det.productid
                FROM
                    tra_ord_enc AS enc
                        INNER JOIN
                    tra_ord_det AS det ON enc.codorden = det.codorden
                WHERE
                    enc.orderid = '$orderId');
    ";

    $result = mysqli_query(conexion($_SESSION["pais"]), $query);

    $response = mysqli_fetch_array($result)[0];

    return $response;
}