<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

$validProduct = false;
$UPC = $_GET["UPC"];

$countriesQ = "
        SELECT 
            dir.nomPais
        FROM
            cat_empresas AS emp
                INNER JOIN
            direct AS dir ON emp.pais = dir.codPais
        WHERE
            emp.companyid != '0';
    ";

$countriesR = mysqli_query(conexion(""), $countriesQ);

$sis = 0;
$fis = 0;

while ($countriesRow = mysqli_fetch_array($countriesR)) {
    $country = $countriesRow[0];

    $exiQ = "
        SELECT
            (SELECT 
                    COUNT(*)
                FROM
                    tra_tin_det
                WHERE
                    sisexi > 0) AS sis,
            (SELECT 
                    COUNT(*)
                FROM
                    tra_tin_det
                WHERE
                    fisexi > 0) AS fis
        FROM
            tra_tin_det;
    ";

    $exiR = mysqli_query(conexion($country), $exiQ);

    if($exiR->num_rows > 0){
        $exiRow = mysqli_fetch_array($exiR);
        $sis += intval($exiRow[0]);
        $fis += intval($exiRow[1]);
    }

}

$response = [
    "sis" => $sis,
    "fis" => $fis,
];

echo json_encode($response);
