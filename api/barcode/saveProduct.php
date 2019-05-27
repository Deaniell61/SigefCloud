<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");

$UPC = $_GET["UPC"];
$quantity = $_GET["quantity"];

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
            codprod
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

        $exiQ = "
            SELECT 
                coddtomin
            FROM
                tra_tin_det AS tin
                    INNER JOIN
                tra_tin_enc AS tinenc ON tin.codtominv = tinenc.codtominv
            WHERE
                codprod = '$codprod' and tinenc.ajuste=0;
        ";

        $exiR = mysqli_query(conexion($country), $exiQ);

        if($exiR->num_rows > 0){
            $coddtomin = mysqli_fetch_array($exiR)[0];
            $updateQ = "
                UPDATE
                    tra_tin_det
                SET
                    fisexi = '$quantity',
                    valorf = (ultprecio * $quantity)
                WHERE
                    coddtomin = '$coddtomin'
            ";
//            echo "U:$updateQ<br>";
            $result = mysqli_query(conexion($country), $updateQ);
        }
        else{
            $coddtomin = sys2015();
            $insertQ = "
                insert into tra_tin_det
                (coddtomin, codprod, fisexi)
                values
                ('$coddtomin', '$codprod', '$quantity');
            ";
//            echo "I:$insertQ<br>";
            $result = mysqli_query(conexion($country), $insertQ);
        }

        if($result){
            $response = [
                "status" => "success"
            ];

            echo json_encode($response);
        }

        else{
            $response = [
                "status" => "error"
            ];

            echo json_encode($response);
        }
    }
}