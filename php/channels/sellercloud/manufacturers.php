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
    $manufacturersQ = "
        SELECT 
            *
        FROM
            cat_manufacturadores
        WHERE
            CODIGO = '';
    ";

    $manufacturersR = mysqli_query(conexion($country), $manufacturersQ);

    while ($manufacturersRow = mysqli_fetch_array($manufacturersR)){
        $codmanufac = $manufacturersRow["CODMANUFAC"];
        $nombre = $brandsRow["NOMBRE"];
        echo "<CODMANUFAC:0>0codmanufac</CODMANUFAC:0>$codmanufac - NOMBRE:$nombre<br>";

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