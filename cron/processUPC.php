<?php

$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));

include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/cron/product.php");

$product = new product();

$query = "SELECT dir.nomPais FROM cat_empresas AS emp INNER JOIN direct AS dir ON emp.pais = dir.codPais WHERE emp.companyid != '0';";
$result = mysqli_query(conexion(""), $query);

while ($row = mysqli_fetch_array($result)) {
    $country = $row[0];
    $productsQuery = "
        SELECT 
            codbundle, AMAZONSKU
        FROM
            tra_bun_det
        WHERE
            UPC = ''
        ORDER BY amazonsku;    
    ";
    $productsResult = mysqli_query(conexion($country), $productsQuery);
    $counter = 0;
    while ($productsRow = mysqli_fetch_array($productsResult)) {
        $tId = $productsRow["codbundle"];
        $tAmazonSKU = $productsRow["AMAZONSKU"];
        $tUPC = $product->UPC($tId, $tAmazonSKU, $country);

        if ($tUPC != "") {
            echo "$tAmazonSKU - $tUPC<br>";
            $counter += 1;
        }
    }
    echo "$country: $counter<br>";
}