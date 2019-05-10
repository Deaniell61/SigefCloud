<?php
session_start();
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

function addProductToQueue($sku, $country){

    $productsQ = "
        SELECT 
            AMAZONSKU
        FROM
            tra_bun_det
        WHERE
            mastersku = '$sku';
    ";
    echo "$productsQ<br>";
    $productsR = mysqli_query(conexion($country), $productsQ);
    $skus = null;
    while ($productsRow = mysqli_fetch_array($productsR)){
        $tSku = $productsRow["AMAZONSKU"];
        $skus[] = $tSku;
    }

    $syncProducts = $skus;
    $syncProducts[] = $sku;
    $syncKits = $skus;

    insertIntoQueue("syncProduct", $syncProducts, $country);
    insertIntoQueue("syncKit", $syncKits, $country);
    insertIntoQueue("syncImages", $syncProducts, $country);
}

function insertIntoQueue($type, $queue, $country){
    $values = "";
    foreach ($queue as $item){
        $date = date("Y-m-d h:i:s");
        $user = $_SESSION["user"];
        $values .= "('$type', '$item', '$date', '$user', '$date', '$user'),";
    }
    $values = substr($values, 0, -1);
    $insert = "
        INSERT INTO
            tra_job_queue
        (`type`, `job_id`, `created`, `created_by`, `modificated`, `modificated_by`)
            VALUES
        $values;
    ";

//    echo "<span>$insert</span>";
    mysqli_query(conexion($country), $insert);
}
