<?php

require_once('../coneccion.php');

require_once('../fecha.php');

$idioma = idioma();

include('../idiomas/' . $idioma . '.php');

session_start();

$tSKU = $_POST["SKU"];

$tAmazonSKU = "";

$tUPC = "";

$tCodUPC = "";

$getUPCQuery = "SELECT CODUPC, UPC FROM cat_upc WHERE CANTIDAD = 0 AND MASTERSKU = '' AND AMAZONSKU = '' AND CODPAIS = '' ORDER BY UPC DESC LIMIT 1;";

$getUPCResult = mysqli_query(conexion(""), $getUPCQuery);

if($getUPCResult){

    if($getUPCResult->num_rows > 0){

        $getUPCRow = mysqli_fetch_array($getUPCResult);

        $tCodUPC = $getUPCRow[0];

        $tUPC = $getUPCRow[1];

        $getAmazonSKUQuery = "SELECT AMAZONSKU FROM tra_bun_det WHERE MASTERSKU = '$tSKU' AND UNITBUNDLE = '1';";

        $getAmazonSKUResult = mysqli_query(conexion($_SESSION["pais"]), $getAmazonSKUQuery);

        if($getAmazonSKUResult){

            if($getAmazonSKUResult->num_rows > 0){

                $tAmazonSKU = mysqli_fetch_array($getAmazonSKUResult)[0];

            }

        }

        $updateUPCQuery = "UPDATE cat_upc SET MASTERSKU = '$tSKU', AMAZONSKU = '$tAmazonSKU', CANTIDAD = '1', CODPAIS = '" . $_SESSION["codEmpresa"] . "' WHERE CODUPC = '$tCodUPC';";

        $updateBundleQuery = "UPDATE tra_bun_det SET UPC = '$tUPC' WHERE MASTERSKU = '$tSKU' AND UNITBUNDLE = '1';";

        $updateProductQuery = "UPDATE cat_prod SET UPC = '$tUPC' WHERE MASTERSKU = '$tSKU';";

        echo $getUPCQuery . ' +++++ ' . $updateUPCQuery . ' +++++ ' . $updateBundleQuery . ' +++++ ' . $updateProductQuery;

        mysqli_query(conexion(""), $updateUPCQuery);

        mysqli_query(conexion($_SESSION["pais"]), $updateBundleQuery);

        mysqli_query(conexion($_SESSION["pais"]), $updateProductQuery);

    }

}