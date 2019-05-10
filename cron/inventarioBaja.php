<?php

$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));

include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");

$tCountry = "Guatemala";
process($tCountry);

$tCountry = "Costa Rica";
process($tCountry);

function process($gCountry)
{
    echo "country:$gCountry<br>";
//productos con estatus B
    $productsQuery = "
    SELECT 
        inv.codprod,
        prod.codprod as codprod1,
        prod.mastersku,
        inv.productid,
        inv.wharehouse,
        inv.PHYSICALIN,
        inv.InventoryD
    FROM
        cat_prod AS prod
            INNER JOIN
        sageinventario AS inv ON prod.mastersku = inv.productid
    WHERE
        prod.estatus = 'B';
";
    echo "$productsQuery<br><br>";
    $productsResult = mysqli_query(conexion($gCountry), $productsQuery);

    $index = 0;

    while ($productsRow = mysqli_fetch_array($productsResult)) {

        $tCodProd = $productsRow["codprod1"];
        $tMasterSKU = $productsRow["mastersku"];
    echo "$tCodProd - $tMasterSKU<br>";

        //revisamos si tienen registro en tra_exi_pro
        $checkInventoryQuery = "
        SELECT 
            *
        FROM
            tra_exi_pro
        WHERE
            codprod = '$tCodProd';
    ";

        $checkInventoryResult = mysqli_query(conexion($gCountry), $checkInventoryQuery);
        $checkInventory = $checkInventoryResult->num_rows;

//    echo "$checkInventory<br>";

        //no tienen se inserta
        if ($checkInventory == 0) {
            $CODEPROD = sys2015();
            $CODPROD = $tCodProd;
            $CODBODEGA = $codBod;
            $EXISTENCIA = "0";
            $inventoryQuery = "
            INSERT INTO tra_exi_pro
                (CODEPROD, CODPROD, EXISTENCIA)
            VALUES
                ('$CODEPROD', $CODPROD, '$EXISTENCIA');
        ";
        } //si tienen se actualiza a existencia 0
        else {
            $inventoryQuery = "
            UPDATE tra_exi_pro 
            SET 
                existencia = 0
            WHERE
                codprod = '$tCodProd';
        ";
        }

//    echo "$inventoryQuery<br>";
        mysqli_multi_query(conexion($gCountry), $updateInventoryQuery);

        //cambiamos sageinventario para que se actualice en el siguiente cron
        $updateActualizaQuery = "
        UPDATE sageinventario 
        SET 
            physicalin = 0,
            actualiza = 1
        WHERE
            productid = '$tMasterSKU';
    ";

//    echo "$updateActualizaQuery<br>";
        mysqli_multi_query(conexion($gCountry), $updateActualizaQuery);

        //actualizamos el producto para que no tenga estatus B
        $updateProdQuery = "
        UPDATE cat_prod 
        SET 
            estatus = 'A'
        WHERE
            codprod = '$tCodProd';
    ";

//    echo "$updateProdQuery<br>";
//    mysqli_multi_query(conexion($gCountry),$updateProdQuery);

        //revisamos la existencia en tra_exi_pro
        $q1 = "
        SELECT 
            existencia
        FROM
            tra_exi_pro
        WHERE
            codprod = '$tCodProd';
    ";

        $r1 = mysqli_query(conexion($gCountry), $q1);
        $e1 = mysqli_fetch_array($r1)[0];

//    echo "E:$e1<br>";

        //revisamos la existencia en sageinventario
        $q2 = "
        select physicalin from sageinventario where productid = '$tMasterSKU';
    ";

        $r2 = mysqli_query(conexion($gCountry), $q2);
        $e2 = mysqli_fetch_array($r2)[0];

//    echo "E2:$e2<br>";

    }
    echo "<br>";
}
