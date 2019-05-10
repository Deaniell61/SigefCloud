<?php
session_start();
$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/productos/specialAttributes.php");
$specialAttributes = new specialAttributes();
$productsQuery = "
    SELECT 
        CODPROD, NOMBRE
    FROM
        cat_prod;
";

$countriesQuery = "
    SELECT 
        dir.nomPais
    FROM
        cat_empresas AS emp
            INNER JOIN
        direct AS dir ON emp.pais = dir.codPais
    WHERE
        emp.companyid != '0';
";
$countriesResult = mysqli_query(conexion(""), $countriesQuery);
while ($countriesRow = mysqli_fetch_array($countriesResult)) {
    $country = $countriesRow["nomPais"];
    $productsResult = mysqli_query(conexion($country), $productsQuery);
    while ($productsRow = mysqli_fetch_array($productsResult)) {
//        $specialAttributes->processSpecialAttributes($productsRow["CODPROD"], $productsRow["NOMBRE"], $country);
    }
    echo "$country<br><br>";
    $specialAttributes->uploadToSellercloud($country);
}