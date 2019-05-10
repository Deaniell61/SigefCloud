<?php
session_start();
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/shipping/fedex/RateService/Rate/RateWebServiceClient.php5");

if(isset($_POST["method"])){
    $method = $_POST["method"];
    switch ($method){
        case "quote":
            $address1 = $_POST["address1"];
            $address2 = $_POST["address2"];
            $state = $_POST["state"];
            $city = $_POST["city"];
            $zip = $_POST["zip"];
            $shippingMethod = $_POST["shippingMethod"];
            $shipDate = $_POST["shipDate"];
            $weightUnit = $_POST["weightUnit"];
            $weight = $_POST["weight"];
            $dimensionUnit = $_POST["dimensionUnit"];
            $length = $_POST["length"];
            $height = $_POST["height"];
            $width = $_POST["width"];
            $orderType = $_POST["orderType"];
            $carrier = $_POST["carrier"];
            $data = getData($address1, $address2, $state, $city, $zip, $weightUnit, $weight, $dimensionUnit, $length, $width, $height, $shipDate, $shippingMethod, $orderType);
            $tQuote = genericQuote($data);

            if (strpos($tQuote, "ERROR") !== false) {
                echo $tQuote;
            }else{
                echo quoteWithMargin($tQuote, $carrier);
            }
            break;
    }
}

//975 NW 1401st. road Odessa, MO, 64076
function getData($address1, $address2, $state, $city, $zip, $weightUnit, $weight, $dimensionUnit, $length, $width, $height, $shipDate, $shippingMethod, $orderType){
    $data = [
        "address1" => $address1,
        "address2" => $address2,
        "state" => $state,
        "city" => $city,
        "zip" => $zip,
        "dropoffType" => "REGULAR_PICKUP",
        "shipDate" => date("c", strtotime($shipDate)),
        "shippingMethod" => $shippingMethod,
        "weightUnit" => $weightUnit,
        "weight" => $weight,
        "dimensionUnit" => $dimensionUnit,
        "length" => $length,
        "height" => $height,
        "width" => $width,
        "orderType" => $orderType,
    ];

    return $data;
}

function quoteWithMargin($quote, $carrier){
    $marginQuery = "
        SELECT 
            shipmar
        FROM
            cat_carriers
        WHERE
            nombre = '$carrier';
    ";

    $marginResult = mysqli_query(conexion($_SESSION["pais"]), $marginQuery);
    $margin = mysqli_fetch_array($marginResult)[0];

    $result = round($quote + ($quote * $margin), 2);

    return $result;
}