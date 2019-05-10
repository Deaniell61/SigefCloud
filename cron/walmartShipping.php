<?php

$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));

include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/walmart/walmart.php");

$gcountry = $_GET["country"];

if($gcountry == ""){
    echo "SET COUNTRY, DEFAULTED TO Guatemala<br>";
    $gcountry = "Guatemala";
}

processOrders();

function processOrders(){

    global $gcountry;
    $walmart = new walmart(true);

    $ordersQuery = "
        SELECT 
            orderid
        FROM
            tra_ord_enc
        WHERE
            shista = 'wshipped' AND tranum != '';
    ";

    $ordersResult = mysqli_query(conexion($gcountry), $ordersQuery);

    while ($ordersRow = mysqli_fetch_array($ordersResult)){
        $tOrderId = $ordersRow[0];
        echo "<br>OID:$tOrderId<br>";
        $response = $walmart->order($tOrderId);


        $tJson = json_decode($response);
//        echo "<pre>";
//        echo count($tJson->orderLines->orderLine);
//        echo "</pre>";

        if(count($tJson->orderLines->orderLine) > 1){
//            echo "<pre>";
//            echo print_r($tJson->orderLines->orderLine[0]->orderLineStatuses->orderLineStatus->trackingInfo);
//            echo "</pre>";
//            echo "<br>" . count($tJson->orderLines->orderLine[0]->orderLineStatuses->orderLineStatus->trackingInfo);
            $tTrackingInfo = count($tJson->orderLines->orderLine[0]->orderLineStatuses->orderLineStatus->trackingInfo);
        }else{
//            echo "<pre>";
//            echo print_r($tJson->orderLines->orderLine->orderLineStatuses->orderLineStatus->trackingInfo);
//            echo "</pre>";
//            echo "<br>" . count($tJson->orderLines->orderLine->orderLineStatuses->orderLineStatus->trackingInfo);
            $tTrackingInfo = count($tJson->orderLines->orderLine->orderLineStatuses->orderLineStatus->trackingInfo);
        }
        if($tTrackingInfo == 0){
            $response = $walmart->shipping($tOrderId, $gcountry);
//      $flag = false;
            if (strpos($response, "ERROR") !== false) {
                $flag = true;
            }
            if(!$flag){
                $updateTraOrdEnc = "
                    UPDATE tra_ord_enc SET shista = 'Shipped' WHERE orderid = '$tOrderId';
                ";

                mysqli_query(conexion($gcountry), $updateTraOrdEnc);
            }
        }else{

            $check = "SELECT shista FROM tra_ord_enc WHERE orderid = '$tOrderId'";
            $checkR = mysqli_query(conexion($gcountry), $check);
            if(mysqli_fetch_array($checkR)[0] == "WShipped"){
                $updateTraOrdEnc = "
                    UPDATE tra_ord_enc SET shista = 'Shipped' WHERE orderid = '$tOrderId';
                ";

                mysqli_query(conexion($gcountry), $updateTraOrdEnc);
            }
        }
    }
}
