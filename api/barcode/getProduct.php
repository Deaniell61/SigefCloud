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

while ($countriesRow = mysqli_fetch_array($countriesR)) {
    $country = $countriesRow[0];

    $productQ = "
        SELECT 
            codprod, prodname
        FROM
            cat_prod
        WHERE
            upc = '$UPC';
    ";

    $productR = mysqli_query(conexion($country), $productQ);

    if($productR->num_rows > 0){

        $validProduct = true;
        $product = mysqli_fetch_array($productR);
        $codprod = $product["codprod"];
        $descsis = $product["prodname"];

        $exiQ = "
            SELECT 
                coddtomin,
                sisexi,
                fisexi
            FROM
                tra_tin_det AS tin
                    INNER JOIN
                tra_tin_enc AS tinenc ON tin.codtominv = tinenc.codtominv
            WHERE
                codprod = '$codprod' and tinenc.ajuste=0;
        ";

        $exiR = mysqli_query(conexion($country), $exiQ);
        $exiRow = mysqli_fetch_array($exiR);

        $exi = 0;
        $exiF = 0;

        if($exiR->num_rows > 0){
            $exi = $exiRow[1];
            $exiF = $exiRow[2];
        }

        $response = [
            "status" => "success",
            "name" => $descsis,
            "quantity" => $exi,
            "quantityF" => $exiF,
        ];

        echo json_encode($response);

        break;
    }
}

if(!$validProduct){
    $response = [
        "status" => "error",
        "message" => "no product found in any database"
    ];

    echo json_encode($response);
}
