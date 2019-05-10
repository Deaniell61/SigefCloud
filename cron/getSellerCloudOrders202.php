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

$startDate = date("Y-m-d 00:00:00", strtotime("-7 days"));
$endDate = date("Y-m-d 23:59:59");

//$startDate = str_replace("EST", "T", $startDate);
//$endDate = str_replace("EST", "T", $endDate);

$startDate = (isset($_GET["initialDate"])) ? $_GET["initialDate"] . "-01 00:00:00" : str_replace(" ", "T", $startDate);
$endDate = (isset($_GET["finalDate"])) ? $_GET["finalDate"] . "-31 23:59:59" : str_replace(" ", "T", $endDate);

$resultsCount = 1;
$pageNumber = 1;

echo "Start:$startDate - End:$endDate<br>";

while ($resultsCount > 0) {
    $getOrders = $sellercloud->getOrders("163", $startDate, $endDate, $pageNumber);
    $resultsCount = (isset($getOrders->ListOrdersResult->OrderSearchResponse)) ? count($getOrders->ListOrdersResult->OrderSearchResponse) : 0;
    var_dump($getOrders);
    
    if ($resultsCount > 0) {
        echo $orders->write($getOrders->ListOrdersResult->OrderSearchResponse);
        $pageNumber += 1;
    }
    
}