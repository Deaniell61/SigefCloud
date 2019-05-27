<?php
error_reporting(E_ERROR);
ini_set('display_errors', 'On');
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

$validProduct = false;
$type = $_GET["type"];

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
$result;

while ($countriesRow = mysqli_fetch_array($countriesR)) {
    $country = $countriesRow[0];

    if($type == "sisexi"){
        $productQ = "
            SELECT 
                prod.mastersku, prod.upc, tin.nomprod, tin.sisexi
            FROM
                tra_tin_det AS tin
                    INNER JOIN
                cat_prod AS prod ON tin.codprod = prod.codprod
            WHERE
                sisexi > 0 and tinenc.ajuste=0
            ORDER BY nomprod LIMIT 15;
        ";
    }
    else{
        $productQ = "
            SELECT 
                prod.mastersku, prod.upc, tin.nomprod, tin.sisexi, tin.fisexi
            FROM
                tra_tin_det AS tin
                    INNER JOIN
                tra_tin_enc AS tinenc ON tin.codtominv = tinenc.codtominv
                    INNER JOIN
                cat_prod AS prod ON tin.codprod = prod.codprod
            WHERE
                fisexi = 0 AND sisexi and tinenc.ajuste=0
            ORDER BY nomprod LIMIT 15;
        ";
    }


    $productR = mysqli_query(conexion($country), $productQ);

    if($productR->num_rows > 0){

        while($productRow = mysqli_fetch_array($productR)){

            $tMastersku = $productRow["mastersku"];
            $tUPC = $productRow["upc"];
            $tNomprod = $productRow["nomprod"];
            $tSisexi = $productRow["sisexi"];

            if($type == "sisexi"){
                $response[] = [
                    "mastersku" => $tMastersku,
                    "upc" => $tUPC,
                    "nomprod" => $tNomprod,
                    "sisexi" => $tSisexi
                ];
            }
            else{
                $tFisexi = $productRow["fisexi"];

                $response[] = [
                    "mastersku" => $tMastersku,
                    "upc" => $tUPC,
                    "nomprod" => $tNomprod,
                    "fisexi" => $tFisexi,
                    "sisexi" => $tSisexi
                ];
            }
        }
    }
}
echo json_encode($response);
