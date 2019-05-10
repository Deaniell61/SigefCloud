<?php

error_reporting(E_ERROR);
ini_set('display_errors', 'On');

include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/sigefcloud/product.php");

$method = $_POST["method"];
switch ($method){
    case "loadProduct":
        $sku = $_POST["sku"];
        $country = $_POST["country"];
        echo loadProduct($sku, $country);
        break;
    case "syncName":
        $sku = $_POST["sku"];
        $name = $_POST["name"];
        $country = $_POST["country"];
        echo syncName($sku, $name, $country);
        break;
    case "syncWeight":
        $sku = $_POST["sku"];
        $lb = $_POST["lb"];
        $oz = $_POST["oz"];
        $peso = $_POST["peso"];
        $country = $_POST["country"];
        echo syncWeight($sku, $lb, $oz, $peso, $country);
        break;
}

function loadProduct($sku, $country){
    $productQ = "
        SELECT
            prodname, peso_lb, peso_oz, peso
        FROM
            cat_prod
        WHERE
            mastersku = '$sku';
    ";

    $productR = mysqli_query(conexion($country), $productQ);

    $productRow = mysqli_fetch_array($productR);

    $response = [
        "name" => $productRow["prodname"],
        "lb" => $productRow["peso_lb"],
        "oz" => $productRow["peso_oz"],
        "peso" => $productRow["peso"],
    ];

    return json_encode($response);
}

function syncName($sku, $name, $country){
    $productQ = "
        UPDATE
            cat_prod
        SET
            prodname = '$name'
        WHERE
            mastersku = '$sku';
    ";

    $productR = mysqli_query(conexion($country), $productQ);
    $product = new sigefcloud\product($sku, $country);
    echo $product->sync(sigefcloud\product::OP_UPDATE_NAME, [sigefcloud\product::CH_SELLERCLOUD]);
}

function syncWeight($sku, $lb, $oz, $peso, $country){
    $productQ = "
        UPDATE
            cat_prod
        SET
            PESO_LB = '$lb',
            PESO_OZ = '$oz',
            PESO = '$peso'
        WHERE
            mastersku = '$sku';
    ";

    $productR = mysqli_query(conexion($country), $productQ);

    $product = new sigefcloud\product($sku, $country);
    echo $product->sync(sigefcloud\product::OP_UPDATE_WEIGHT, [sigefcloud\product::CH_SELLERCLOUD]);
}