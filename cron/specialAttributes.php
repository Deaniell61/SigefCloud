<?php
session_start();
$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

$productsQuery = "
    SELECT 
        CODPROD
    FROM
        cat_prod;
";

$productsResult = mysqli_query(conexion($_SESSION["pais"]), $productsQuery);

while ($productsRow = mysqli_fetch_array($productsResult)){
    getProductSpecialAttributes($productsRow["CODPROD"]);ssx
}

function getProductSpecialAttributes($codProd){
    $productAtributesQuery = "
        SELECT 
            atr.NOMBRE, atr.VALOR
        FROM
            tra_esp_atr_pro AS prod
                INNER JOIN
            cat_esp_atr AS atr ON prod.CODESPATR = atr.CODESPATR
        WHERE prod.CODPROD = '$codProd';
    ";

    $productAtributesResult = mysqli_query(conexion($_SESSION["pais"]), $productAtributesQuery);

    while ($productAtributesRow = mysqli_fetch_array($productAtributesResult)){
        echo $productAtributesRow["NOMBRE"] . ":" . $productAtributesRow["VALOR"] . "<br>";
    }
}