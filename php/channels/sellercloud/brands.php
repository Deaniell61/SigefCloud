<?php

include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/channels/sellercloud/sellercloud.php");

$sellercloud = new \channels\sellercloud();

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

while ($countriesRow = mysqli_fetch_array($countriesR)){
    $country = $countriesRow["nomPais"];
    echo "COUNTRY:$country<br>";
    $brandsQ = "
        SELECT 
            *
        FROM
            cat_marcas
        WHERE
            CODIGO = '';
    ";

    $brandsR = mysqli_query(conexion($country), $brandsQ);

    while ($brandsRow = mysqli_fetch_array($brandsR)){
        $codmarca = $brandsRow["CODMARCA"];
        $nombre = $brandsRow["NOMBRE"];
        echo "CODMARCA:$codmarca - NOMBRE:$nombre<br>";

        $response = $sellercloud->getBrandByName($nombre);

        if($response["status"] == "success"){

            $result = $response["result"];

            $tCODIGO = $result->Brands_GetByNameResult->ID;

            $updateQ = "
                UPDATE cat_marcas SET CODIGO = '$tCODIGO' WHERE CODMARCA = '$codmarca';
            ";

            echo "1: $updateQ<br>";
            mysqli_query(conexion($country), $updateQ);
        }
        else{
//            echo $result->message . "<br>";

            $response = $sellercloud->createBrand($nombre);
            if($response["status"] == "success"){
                $result = $response["result"];
                $tCODIGO = $result->Brands_CreateNewResult;

                $updateQ = "
                    UPDATE cat_marcas SET CODIGO = '$tCODIGO' WHERE CODMARCA = '$codmarca';
                ";

                echo  "2: $updateQ<br>";
                mysqli_query(conexion($country), $updateQ);
            }
            else{
                echo "E:" . $response["message"] . "<br>";
            }
        }
    }
}