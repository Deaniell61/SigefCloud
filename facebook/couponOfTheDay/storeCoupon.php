<?php

include_once $_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php";

if(isset($_POST["sku"])){
    $sku = $_POST["sku"];
    $date = $_POST["date"];

    $newCouponQuery = "
        INSERT INTO
            fb_cotd_config 
        SET
            sku = '$sku',
            date = '$date';
    ";

    mysqli_query(conexion("Demo"), $newCouponQuery);
}