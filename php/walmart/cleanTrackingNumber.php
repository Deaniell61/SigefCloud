<?php

session_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/walmart/walmart.php");

$walmart = new walmart();

$carrier = $_POST["trackingCarrier"];
$formOderIds = explode(",", $_POST["formOderIds"]);
$name = $_FILES['csv']['tmp_name'];
$data = array_map('str_getcsv', file($name));

$cont = ($carrier == "fedex") ? $cont = 1 : $cont = 0;

//var_dump($formOderIds);
//echo "<br>";
//echo "<br>";

//var_dump($data);

$tYear = date("Y");

$orderIdsQ = "
    SELECT 
        orderid
    FROM
        tra_ord_enc
    WHERE
        tranum = '' AND timoford > '$tYear-01-01';
";

//echo "$orderIdsQ<br>";

$orderIdsResult = mysqli_query(conexion($_SESSION["pais"]), $orderIdsQ);

while ($row = mysqli_fetch_array($orderIdsResult)){
    $emptyOrders[] = $row["orderid"];
}

//var_dump($emptyOrders);
//echo "<br>";
//echo "<br>";

foreach ($data as $row) {

    if ($cont > 0) {
        if ($carrier == "ups") {
            $tReference1 = $row[37];
            $tReference2 = $row[38];
            $tOrderId = ($tReference2 != '') ? $tReference2 : $tReference1;
            $tTrackingNumber = $row[4];
            $tShipDate = date("Y-m-d h:m:s", strtotime($row[0]));
            $tShiMetSel = $row[1];
        } else if ($carrier == "fedex") {
            $refIndex = 32;
            $refIndex1 = 18;
            $rowCount = count($row);
            // $rowOffset = $rowCount - 40;
            // $rowOffset1 = $rowCount - 40;
            // $refIndex += $rowOffset;
            // $refIndex1 += $rowOffset1;
            $tReference1 = $row[$refIndex];
            $tReference2 = $row[$refIndex + 1];
            $tReference3 = $row[$refIndex + 2];
            if($tReference1 != "" && $tReference1 != "null"){
                $tOrderId = $tReference1;
            } else
             if($tReference2 != "" && $tReference2 != "null"){
                $tOrderId = $tReference2;
            } else
             if($tReference3 != "" && $tReference3 != "null"){
                $tOrderId = $tReference3;
            }
            $tTrackingNumber = $row[0];
            $tShipDate = date("Y-m-d h:m:s", strtotime($row[1]));
            $tShiMetSel = (+$row[$refIndex1]*1)?$row[$refIndex1+1]:$row[$refIndex1];
            echo "<script>console.log('".$tTrackingNumber." - ".$tShiMetSel." - ".$tOrderId."')</script>";
//            echo "$refIndex - $tOrderId - $tShiMetSel<br>";
        }else if ($carrier == "usps") {
            $tOrderId = $row[38];
            $tTrackingNumber = $row[70];
            $tShipDate = date("Y-m-d h:m:s", strtotime($row[25]));
            $tShiMetSel = $row[41];

//            echo "OID:$tOrderId - TN:$tTrackingNumber - SD:$tShipDate - SMT:$tShiMetSel";
        }

        $tTrackingURL = $walmart->getTrackingURL($carrier, $tTrackingNumber);
        $tTrackingMethod = $walmart->getCarrierMethod($carrier, $tShiMetSel);

        if ($tOrderId != "" && $tTrackingNumber != '') {
            echo "OID:$tOrderId<br>";
            if (in_array($tOrderId, $formOderIds)) {
//                echo "$tOrderId<br>";
                $tShiCar = getShiCar($carrier);
                $tPayDat = date('Y-m-d', strtotime('saturday this week', strtotime($tShipDate)));
                $tPayRefNum = "WMBAL" . str_replace("-", "", date('Y-m-d', strtotime('saturday this week', strtotime($tShipDate))) . " 23:59:00");
                $checkQuery = "
                    SELECT tranum from tra_ord_enc WHERE orderid = '$tOrderId';
                ";

                $checkResult = mysqli_query(conexion($_SESSION["pais"]), $checkQuery);

//                echo "$checkQuery - $checkResult->num_rows<br>";

                if ($checkResult->num_rows == 1) {
                    $check = mysqli_fetch_array($checkResult)[0];
                    $query = "
                        UPDATE tra_ord_enc SET tranum = '$tTrackingNumber', shipdate = '$tShipDate', shimetsel = '$tShiMetSel', shicar = '$tShiCar', paydat = '$tPayDat', payrefnum = '$tPayRefNum', estatus = 'Completed', shista = 'WShipped', paymet = 'WALMART', paysta = 'Charged' WHERE orderid = '$tOrderId';
                    ";

//                    echo "Q $cont:$query<br> - $check" . $_SESSION["pais"] . "<br>";

                    $cleanCodOrdShi = "
                        UPDATE tra_ord_shi 
                        SET 
                            statusdate = '$tShipDate',
                            `status` = 'Shipped',
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

//                    echo "tra_ord_shi<br>$cleanCodOrdShi";

                    if ($check == "") {
                        mysqli_query(conexion($_SESSION["pais"]), $query);
                        mysqli_query(conexion($_SESSION["pais"]), $cleanCodOrdShi);
                    }
                }
            }
            else{
//                echo "E: in array";
            }
        }
        else{
            echo "E: $tOrderId - $tTrackingNumber<br>";
        }
    }
    $cont += 1;
}

function getShiCar($carrier)
{
    switch ($carrier) {
        case "ups":
            return "UPS";
        case "fedex":
            return "FedEx";
        case "usps":
            return "USPS";
    }
}