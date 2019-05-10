<?php

function buildNotification($data){

    $purchaseOrderId = $data["purchaseOrderId"];
    $name = $data["name"];
    $orderDate = $data["orderDate"];
    $estimatedShipDate = $data["estimatedShipDate"];
    $orderLines = $data["orderLines"];

    $productsMessage = "";

    foreach ($orderLines as $orderLine){
//        echo "<br><br>ORDERLINE";
//        var_dump($orderLine);
//        echo "ORDERLINE<br><br>";
        $productName = $orderLine["productName"];
        $sku = $orderLine["sku"];
        $amount = $orderLine["amount"];
        $originalCarrierMethod = $orderLine["originalCarrierMethod"];

        $productsMessage .= "
    Please ship this order using $originalCarrierMethod
    -Item: $productName
    -SKU: $sku
    -Quantity: $amount
    
        ";
    }

    if(count($orderLines) > 1){
//        echo "MESSAGE:$productsMessage MESSAGE<br><br>";
    }

    $message = "
Dear sales@guatedirect.com,
Congratulations! You just sold items on Walmart.com!

Please note you agreed to ship this order no later than $estimatedShipDate. Keep in mind you are responsible for the item until it reaches the buyer at the address provided in your seller account. We recommend purchasing insurance for high value shipments.

Order ID: $purchaseOrderId
Name: $name
Ship by: $estimatedShipDate
Order date: $orderDate

$productsMessage

Powered by SigefCloud.
    ";

    return $message;
}