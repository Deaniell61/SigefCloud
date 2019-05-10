<?php
/**
 * This class is in charge of downloading the orders from seller cloud and writing them to sigefcloud's database
 */
set_time_limit(0);

$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));

include_once($_SERVER["DOCUMENT_ROOT"] . "/php/sellercloud/sellercloud.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/cron/orders.php");

$sellercloud = new sellercloud();
$orders = new orders();

$startDate = date("Y-m-d 00:00:00", strtotime("-5 days"));
$endDate = date("Y-m-d 23:59:59");

//$startDate = str_replace("EST", "T", $startDate);
//$endDate = str_replace("EST", "T", $endDate);

$startDate = (isset($_GET["initialDate"])) ? $_GET["initialDate"] . "-01 00:00:00" : str_replace(" ", "T", $startDate);
$endDate = (isset($_GET["finalDate"])) ? $_GET["finalDate"] . "-31 23:59:59" : str_replace(" ", "T", $endDate);

echo "$startDate - $endDate<br>";

$resultsCount = 1;
$pageNumber = 1;

echo "ORDERS GT - Start:$startDate - End:$endDate<br>";

while ($resultsCount > 0) {
    $getOrders = $sellercloud->getOrders("163", $startDate, $endDate, $pageNumber);
//    echo "<br>";
//    print_r(json_encode($getOrders));
//    echo "<br>";
    $resultsCount = (isset($getOrders->ListOrdersResult->OrderSearchResponse)) ? count($getOrders->ListOrdersResult->OrderSearchResponse) : 0;
    echo "RC:$resultsCount<br>";
    if ($resultsCount > 0) {
        if($resultsCount == 1){
            echo $orders->write([$getOrders->ListOrdersResult->OrderSearchResponse]);
        }
        else{
            echo $orders->write($getOrders->ListOrdersResult->OrderSearchResponse);
        }
        $pageNumber += 1;
    }
}


$resultsCount = 1;
$pageNumber = 1;

echo "ORDERS CR - Start:$startDate - End:$endDate<br>";

while ($resultsCount > 0) {
    $getOrders = $sellercloud->getOrders("202", $startDate, $endDate, $pageNumber);
//    echo "<br>";
//    print_r(json_encode($getOrders));
//    echo "<br>";
    $resultsCount = (isset($getOrders->ListOrdersResult->OrderSearchResponse)) ? count($getOrders->ListOrdersResult->OrderSearchResponse) : 0;
    echo "RC:$resultsCount<br>";
    if ($resultsCount > 0) {
        if($resultsCount == 1){
            echo $orders->write([$getOrders->ListOrdersResult->OrderSearchResponse]);
        }
        else{
            echo $orders->write($getOrders->ListOrdersResult->OrderSearchResponse);
        }

        $pageNumber += 1;
    }
}
/*
//
$resultsCount = 1;
$pageNumber = 1;

echo "UPDATE SHIPPING DIMENSIONS GT - Start:$startDate - End:$endDate<br>";

while ($resultsCount > 0) {
    $getOrders = $sellercloud->getOrders("163", $startDate, $endDate, $pageNumber);
//    echo "<br>";
//    print_r(json_encode($getOrders));
//    echo "<br>";
    $resultsCount = (isset($getOrders->ListOrdersResult->OrderSearchResponse)) ? count($getOrders->ListOrdersResult->OrderSearchResponse) : 0;
    echo "RC:$resultsCount<br>";
    if ($resultsCount > 0) {
        if($resultsCount == 1){
            echo $orders->updateShippingDimensions([$getOrders->ListOrdersResult->OrderSearchResponse], "Guatemala");
        }
        else{
            echo $orders->updateShippingDimensions($getOrders->ListOrdersResult->OrderSearchResponse, "Guatemala");
        }
        $pageNumber += 1;
    }
}

//
$resultsCount = 1;
$pageNumber = 1;

echo "UPDATE SHIPPING DIMENSIONS CR - Start:$startDate - End:$endDate<br>";

while ($resultsCount > 0) {
    $getOrders = $sellercloud->getOrders("202", $startDate, $endDate, $pageNumber);
//    echo "<br>";
//    print_r(json_encode($getOrders));
//    echo "<br>";
    $resultsCount = (isset($getOrders->ListOrdersResult->OrderSearchResponse)) ? count($getOrders->ListOrdersResult->OrderSearchResponse) : 0;
    echo "RC:$resultsCount<br>";
    if ($resultsCount > 0) {
        if($resultsCount == 1){
            echo $orders->updateShippingDimensions([$getOrders->ListOrdersResult->OrderSearchResponse], "Costa Rica");
        }
        else{
            echo $orders->updateShippingDimensions($getOrders->ListOrdersResult->OrderSearchResponse, "Costa Rica");
        }
        $pageNumber += 1;
    }
}
*/