<?php

$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));

include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

function getCountries()
{
    $query = "
        SELECT 
            dir.nomPais
        FROM
            cat_empresas AS emp
                INNER JOIN
            direct AS dir ON emp.pais = dir.codPais
        WHERE
            emp.companyid != '0';
    ";

    $result = mysqli_query(conexion(""), $query);
    while ($row = mysqli_fetch_array($result)) {
        $array[] = $row[0];
    }
    $response = json_encode($array);
    return $response;
}

function clean_TraOrdEnc_CompanyId($country){
    $missingRowsQ = "
        SELECT 
            productid, codorden
        FROM
            tra_ord_det
        WHERE
            codorden IN (SELECT 
                    codorden
                FROM
                    tra_ord_enc
                WHERE
                    companyid = '');
    ";

    $missingRowsR = mysqli_query(conexion($country), $missingRowsQ);

    $cont = 0;

    while ($missingRow = mysqli_fetch_array($missingRowsR)){
        $productId = $missingRow[0];
        $codOrden = $missingRow[1];

        $companyIdQ = "
            SELECT 
                emp.companyid
            FROM
                tra_bun_det AS bun
                    INNER JOIN
                cat_prod AS prod ON bun.mastersku = prod.mastersku
                    INNER JOIN
                quintoso_sigef.cat_empresas AS emp ON prod.codempresa = emp.codempresa
            WHERE
                bun.amazonsku = '$productId'
                    OR prod.mastersku = '$productId' AND bun.unitbundle = 1;
        ";

        $companyIdR = mysqli_query(conexion($country),$companyIdQ);

        if($companyIdR->num_rows == 1){
            $companyId = mysqli_fetch_array($companyIdR)[0];
            $updateQ = "
                UPDATE
                    tra_ord_enc
                SET
                    companyid = '$companyId'
                WHERE
                    codorden = '$codOrden';
            ";

            $updateR = mysqli_query(conexion($country), $updateQ);

            if($updateR){
                $cont += 1;
            }
        }
    }

    echo "tra_ord_enc - companyid: $cont rows cleaned<br>";
}

function clean_TraOrdEnc_CodProv($country){
    $missingRowsQ = "
        SELECT 
            productid, codorden
        FROM
            tra_ord_det
        WHERE
            codorden IN (SELECT 
                    codorden
                FROM
                    tra_ord_enc
                WHERE
                    codprov = '') LIMIT 250;
    ";

    $missingRowsR = mysqli_query(conexion($country), $missingRowsQ);

    $cont = 0;

    while ($missingRow = mysqli_fetch_array($missingRowsR)){
        $productId = $missingRow[0];
        $codOrden = $missingRow[1];

        $codProvQ = "
            SELECT 
                prod.codprov
            FROM
                tra_bun_det AS bun
                    INNER JOIN
                cat_prod AS prod ON bun.mastersku = prod.mastersku
            WHERE
                bun.amazonsku = '$productId'
                    OR prod.mastersku = '$productId' AND bun.unitbundle = 1 LIMIT 1;
        ";

        $codProvR = mysqli_query(conexion($country),$codProvQ);

        echo "$codProvQ<br>";

        if($codProvR->num_rows == 1){
            $codProv = mysqli_fetch_array($codProvR)[0];
            $updateQ = "
                UPDATE
                    tra_ord_enc
                SET
                    codprov = '$codProv'
                WHERE
                    codorden = '$codOrden';
            ";

            echo "$updateQ<br>";

            $updateR = mysqli_query(conexion($country), $updateQ);

            if($updateR){
                $cont += 1;
            }
        }
    }

    echo "tra_ord_enc - codprov: $cont rows cleaned<br>";
}