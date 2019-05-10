<?php

session_start();
include_once $_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php";
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/walmart/walmart.php");

$walmart = new walmart();

$tOrderId = $_POST["tOrderId"];
$tTrackingNumber = $_POST["tTrackingNumber"];
$tShipDate = $_POST["tShipDate"];
$tShiCar = $_POST["tShipCarrier"];
$tShiMetSel = $_POST["tShipMethod"];
$tPayDat = $_POST["tPayDate"];
$tPayRefNum = $_POST["tPayRefNum"];

$tTrackingURL = $walmart->getTrackingURL($carrier, $tTrackingNumber);
$tTrackingMethod = $walmart->getCarrierMethod($carrier, $tShiMetSel);

$query = "
    UPDATE tra_ord_enc SET tranum = '$tTrackingNumber', shipdate = '$tShipDate', shimetsel = '$tShiMetSel', shicar = '$tShiCar', paydat = '$tPayDat', payrefnum = '$tPayRefNum', estatus = 'Completed', shista = 'WShipped', paymet = 'WALMART', paysta = 'Charged' WHERE orderid = '$tOrderId';
";

$cleanCodOrdShi = "
    UPDATE tra_ord_shi 
    SET 
        statusdate = '$tShipDate',
        status = 'Shipped',
        shidattim = '$tShipDate',
        methodcode = '$tTrackingMethod',
        tranum = '$tTrackingNumber',
        traurl = '$tTrackingURL'
    WHERE
        codordshi IN (SELECT 
                shi.codordshi
            FROM
                tra_ord_enc AS enc
                    INNER JOIN
                (SELECT 
                    *
                FROM
                    tra_ord_det
                GROUP BY codorden) AS det ON enc.codorden = det.codorden
                    INNER JOIN
                (SELECT 
                    *
                FROM
                    tra_ord_shi
                GROUP BY codorddet) AS shi ON det.coddetord = shi.codorddet
            WHERE
                enc.orderid = '$tOrderId');
";

//echo "$query";
//echo "";
//echo "$cleanCodOrdShi";

mysqli_query(conexion($_SESSION["pais"]), $query);
mysqli_query(conexion($_SESSION["pais"]), $cleanCodOrdShi);

$walmart->shipping($tOrderId, $_SESSION["pais"]);