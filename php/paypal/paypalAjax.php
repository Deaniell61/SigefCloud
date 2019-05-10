<?php

include_once ("paypalOperations.php");
$paypalOperations = new paypalOperations();

if(isset($_POST["method"])){
    $method = $_POST["method"];

    switch ($method){
        case "generateInvoice":
            $id = $_POST["id"];
            $wd = $_POST["wd"];
            $separator = $_POST["separator"];
            echo $paypalOperations->generateOrderInvoice($id, $wd, $separator);
            break;
        case "remindInvoice":
            $id = $_POST["id"];
            $wd = $_POST["wd"];
            echo $paypalOperations->remindInvoice($id, $wd);
            break;
        case "cleanInvoice":
            $id = $_POST["id"];
            $wd = $_POST["wd"];
            echo $paypalOperations->cleanInvoice($id, $wd);
            break;
        case "detailInvoice":
            $id = $_POST["id"];
            $wd = $_POST["wd"];
            echo $paypalOperations->detailInvoice($id, $wd);
            break;
        case "statusInvoice":
            $id = $_POST["id"];
            $wd = $_POST["wd"];
            echo $paypalOperations->statusInvoice($id, $wd);
            break;
        case "payInvoice":
            $id = $_POST["id"];
            $amount = $_POST["amount"];
            echo $paypalOperations->payInvoice($id, $amount);
            break;
        case "refundInvoice":
            $id = $_POST["id"];
            $amount = $_POST["amount"];
            echo $paypalOperations->refundInvoice($id, $amount);
            break;
        case "cancelInvoice":
            $id = $_POST["id"];
            $subject = $_POST["subject"];
            $note = $_POST["note"];
            $notifyMerchant = $_POST["notifyMerchant"];
            $notifyPayer = $_POST["notifyPayer"];
            echo $paypalOperations->cancelInvoice($id, $subject, $note, $notifyMerchant, $notifyPayer);
            break;
        case "deleteInvoice":
            $id = $_POST["id"];
            echo $paypalOperations->deleteInvoice($id);
            break;
        default:
            echo "E: method not recognized";
            break;
    }
}
else{
    echo "E: no method";
}