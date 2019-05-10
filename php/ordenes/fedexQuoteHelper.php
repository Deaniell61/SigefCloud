<?php

include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/shipping/fedex/RateService/Rate/RateWebServiceClient.php5");

if(isset($_POST["method"])){
    $method = $_POST["method"];
    switch ($method){
        case "quote":
            $id = $_POST["id"];
            $plan = getPlan($_POST["plan"]);
            $dropoffType = ($_POST["dropoffType"] == "") ? "REGULAR_PICKUP" :  $_POST["dropoffType"];
            $shipDate = $_POST["shipDate"];
            $lblWUnit = $_POST["lblWUnit"];
            $lblW = $_POST["lblW"];
            $lblDUnit = $_POST["lblDUnit"];
            $lblDLength = $_POST["lblDLength"];
            $lblDHeight = $_POST["lblDHeight"];
            $lblDWidth = $_POST["lblDWidth"];
            $data = getData($id, $plan, $dropoffType, $shipDate, $lblWUnit, $lblW, $lblDUnit, $lblDLength, $lblDWidth, $lblDHeight);
//            echo json_encode($data);
            echo quoteShipping($data);
            break;
    }
}

function getPlan($planId){
    switch ($planId){
        case "plan1":
            return "FEDEX_2_DAY";
        case "plan2":
            return "FEDEX_EXPRESS_SAVER";
        case "plan3":
            return "FEDEX_GROUND";
        case "plan4":
            return "GROUND_HOME_DELIVERY";
    }
}

function getData($id, $plan, $dropoffType, $shipDate, $lblWUnit, $lblW, $lblDUnit, $lblDLength, $lblDWidth, $lblDHeight){
    $data = [
        "id" => $id,
        "dropoffType" => $dropoffType,
        "shipDate" => date("c", strtotime($shipDate)),
        "serviceType" => $plan,
        "lblWUnit" => $lblWUnit,
        "lblW" => $lblW,
        "lblDUnit" => $lblDUnit,
        "lblDLength" => $lblDLength,
        "lblDHeight" => $lblDHeight,
        "lblDWidth" => $lblDWidth,
    ];

    return $data;
}

/*
$testData = [
    "id" => "3785623917427",
    "dropoffType" => "REGULAR_PICKUP",
    "shipDate" => date("c"),
    "serviceType" => "GROUND_HOME_DELIVERY",
    "lblWUnit" => "LB",
    "lblW" => "1",
    "lblDUnit" => "IN",
    "lblDLength" => "1",
    "lblDHeight" => "1",
    "lblDWidth" => "1",
];

echo quoteShipping($testData);
*/