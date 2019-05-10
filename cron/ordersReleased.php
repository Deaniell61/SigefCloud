<?php

$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));

include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/walmart/walmart.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/walmart/orderReleasedNotificationTemplate.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/lib/PHPMailer-master/PHPMailerAutoload.php");

$walmart = new walmart(false);
$ordersReleased = $walmart->ordersReleased();

$ordersReleased = json_decode($ordersReleased);

$orders = $ordersReleased->elements->order;
if(count($ordersReleased->elements->order) == 1){
    $orders = [$ordersReleased->elements->order];
}
echo count($ordersReleased->elements->order) . "<br>";

foreach ($orders as $order){
    echo "OID:" . $order->purchaseOrderId . "<br>";
    if(checkIfNotified($order->purchaseOrderId)){

        $lines = null;

        $orderLines = $order->orderLines->orderLine;
        if(count($order->orderLines->orderLine) == 1){
            $orderLines = [$order->orderLines->orderLine];
        }

        foreach ($orderLines as $orderLine){

            $sku = $orderLine->item->sku;
            $existsQ = "
                SELECT 
                    *
                FROM
                    quintoso_sigef01.tra_bun_det
                WHERE
                    mastersku = '$sku'
                        OR amazonsku = '$sku' 
                UNION SELECT 
                    *
                FROM
                    quintoso_sigef02.tra_bun_det
                WHERE
                    mastersku = '$sku'
                        OR amazonsku = '$sku';
            ";

            $existsR = mysqli_query(conexion($gcountry), $existsQ);
            $exists = $existsR->num_rows;
            echo "$sky - $exists<br>";
            if($exists > 0){
                if(array_key_exists($orderLine->item->sku, $lines)){
                    $lines[$orderLine->item->sku] = [
                        "productName" => $orderLine->item->productName,
                        "sku" => $orderLine->item->sku,
                        "amount" =>  intval($lines[$orderLine->item->sku]["amount"]) + intval($orderLine->orderLineQuantity->amount),
                        "originalCarrierMethod" => getCarrier($orderLine->originalCarrierMethod),
                    ];
                }
                else{
                    $lines[$orderLine->item->sku] = [
                        "productName" => $orderLine->item->productName,
                        "sku" => $orderLine->item->sku,
                        "amount" => $orderLine->orderLineQuantity->amount,
                        "originalCarrierMethod" => getCarrier($orderLine->originalCarrierMethod),
                    ];
                }
                echo ">>sku:" . $orderLine->item->sku . "<br>";
            }
            else{
                echo "this items doesnt belong to us<br>";
            }

        }

        $orderData = [
            "orderId" => $order->purchaseOrderId,
            "name" => $order->shippingInfo->postalAddress->name,
            "estimatedShipDate" => explode("T", $order->shippingInfo->estimatedShipDate)[0],
            "purchaseOrderId" => $order->purchaseOrderId,
            "orderDate" => explode("T", $order->orderDate)[0],
            "orderLines" => $lines
        ];

        getRecipeints($orderData);
        markNotified($order->purchaseOrderId);
    }
}

function sendEmail($recipient, $orderData){
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "ssl";
    $mail->Host = "srv70.hosting24.com";
    $mail->Port = 465;
    $mail->Username = "support@sigefcloud.com";
    $mail->Password = "5upp0rt51g3fCl0ud";
    $mail->setFrom("sigefcloud@sigefcloud.com", "SigefCloud Seller Support");
    $mail->addAddress($recipient, $recipient);
    $mail->Subject = "Walmart Seller Notification";
    $mail->Body = buildNotification($orderData);
    if(!$mail->send()){
        echo "error " .  $mail->ErrorInfo;;
    }else{
        echo "sent!<br>";
    }
}

function getCarrier($id){
    $carriers = [
        "501" => "UPS Ground",
        "22" => "FedEx 2Day",
        "9" => "UPS Second day Air",
        "67" => "FedEx Home Delivery",
        "31" => "USPS Priority Mail",
    ];

    return $carriers[$id];
}

function getRecipeints($orderData){
    $recipients = [
//        "echang@galileo.edu",
        "andres.chang@sigefcloud.com",
        "mauricio.aldana@guatedirect.com",
        "customerservice@guatedirect.com",
        "paulo.armas@worldirect.com",
        "fabiola.obregon@worldirect.com"
    ];

    foreach ($recipients as $recipient){
        sendEmail($recipient, $orderData);
    }
}

function checkIfNotified($orderId){
    $query = "SELECT * FROM tmp_wm_ordersReleasedNotifications WHERE orderId = '$orderId'";
    $result = mysqli_query(conexion("Guatemala"), $query);
    $rows = $result->num_rows;
    return ($rows == 0) ? true : false;
}

function markNotified($orderId){
    $query = "INSERT INTO tmp_wm_ordersReleasedNotifications(orderId) VALUES ('$orderId')";
    mysqli_query(conexion("Guatemala"), $query);
}