<?php

session_start();
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/sellercloud/sellercloud.php");

$sellercloud = new sellercloud();

$OrderID = $_POST["tOrderId"];
$TrackingNumber = $_POST["tTrackingNumber"];
$ShipDate = $_POST["tShipDate"];
$ShippingCarrier = $_POST["tShipCarrier"];
$ShippingService = $_POST["tShipMethod"];
$ShippingCost = $_POST["tShipCost"];
$IsLocal = $_POST["tIsLocal"];

if($IsLocal){
    $q = "
    UPDATE tra_ord_enc 
    SET 
        tranum = '$TrackingNumber',
        shipdate = '$ShipDate',
        shicar = '$ShippingCarrier',
        shimetsel = '$ShippingService',
        shifee = '$ShippingCost',
        shista = 'FullyShipped'
    WHERE
        orderid = '$OrderID';
";
    mysqli_query(conexion($_SESSION["pais"]), $q);
}

$list = str_replace(' ', '', $TrackingNumber);
$list = explode(",", $list);

foreach ($list as $item){
    $data = [
        "OrderID" => $OrderID,
        "ShipDate" => $ShipDate,
        "ShippingCarrier" => $ShippingCarrier,
        "ShippingService" => $ShippingService,
        "ShippingCost" => $ShippingCost,
        "TrackingNumber" => $item
    ];
    var_dump($data);
    $r = $sellercloud->markShipped($data);
    var_dump(json_encode($r));
    $r1 = $sellercloud->markCompleted($data);
    var_dump(json_encode($r1));
//    echo $sellercloud->getUser("mauricio.aldana@guatedirect.com");
//    echo $sellercloud->getIP();
}
