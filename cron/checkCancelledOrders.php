<?php
/**
 * This class is in charge of downloading the orders from seller cloud and writing them to sigefcloud's database
 */
set_time_limit(0);

$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));

include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/sellercloud/sellercloud.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/cron/orders.php");

$sellercloud = new sellercloud();
$orders = new orders();

$datesQ = "
    SELECT fecha1, fecha2 FROM prueba WHERE CODPRUEBA = 'checkCance';
";

$datesR = mysqli_query(conexion(""), $datesQ);

$datesR = mysqli_fetch_array($datesR);

$endDate = $datesR["fecha1"];
$startDate = date("Y-m-d", strtotime("-1 day", strtotime($endDate)));
$startDate .= "T00:00:00";
$endDate .= "T23:59:59";
$lastDate = $datesR["fecha2"] . "T00:00:00";

if($endDate > $lastDate){
    $resultsCount = 1;
    $pageNumber = 1;
    $country = "Guatemala";

    echo "ORDERS GT<br>Start:$startDate<br>End:$endDate<br>";

    while ($resultsCount > 0) {
        $getOrders = $sellercloud->getOrders("163", $startDate, $endDate, $pageNumber);
        $resultsCount = (isset($getOrders->ListOrdersResult->OrderSearchResponse)) ? count($getOrders->ListOrdersResult->OrderSearchResponse) : 0;
        echo "RC:$resultsCount<br>";
        if ($resultsCount > 0) {
            $ordersResult = $getOrders->ListOrdersResult->OrderSearchResponse;
            if($resultsCount == 1){
                $ordersResult = [$getOrders->ListOrdersResult->OrderSearchResponse];
            }
            foreach ($ordersResult as $order) {
//                echo "<br>***NEW ORDER***<br>";
//                var_dump($order);
//                echo "<br><br>";
                $fullOrder = $sellercloud->getOrderFull($order->OrderID);
                $fullOrder = $fullOrder->GetOrderFullResult;
                $orderId = getOrderId($order->OrderID, "Guatemala");
                if($orderId == ""){
                    $orderId = getOrderId($order->OrderID, "Costa Rica");
                }
//                var_dump($fullOrder->Notes);
//                echo "<br>";
                $orders->processNotes($orderId,$fullOrder->Notes->OrderNote, $country);
            }
            $pageNumber += 1;
        }
    }
}

$dateQ = "UPDATE prueba SET fecha1 = '$startDate' WHERE CODPRUEBA = 'checkCance';";
//echo "$dateQ";
mysqli_query(conexion(""), $dateQ);

function getOrderId($id, $country){
    $getCodOrdenQuery = "SELECT CODORDEN FROM tra_ord_enc WHERE ORDERID = '" . $id . "';";
    $getCodOrdenResult = mysqli_query(conexion($country), $getCodOrdenQuery);
    $orderId = mysqli_fetch_array($getCodOrdenResult)[0];
    return $orderId;
}
