<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/paypal/obj/paypalfunctions.php");

echo "pp<br>";

$paymentAmount = "1.00";
$currencyCodeType = "USD";
$paymentType = "Authorization";

$returnURL = "http://sigefcloud.com/php/paypal/response.php";
$cancelURL = "http://sigefcloud.com/php/paypal/response.php";
CallShortcutExpressCheckout($paymentAmount, $currencyCodeType, $paymentType, $returnURL, $returnURL);

$resArray = CallShortcutExpressCheckout ($paymentAmount, $currencyCodeType, $paymentType, $returnURL, $cancelURL);

$ack = strtoupper($resArray["ACK"]);
if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING")
{
    RedirectToPayPal ( $resArray["TOKEN"] );
}
else
{
    //Display a user friendly Error on the page using any of the following error information returned by PayPal
    $ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
    $ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
    $ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
    $ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);

    echo "SetExpressCheckout API call failed. " . "<br>";
    echo "Detailed Error Message: " . $ErrorLongMsg. "<br>";
    echo "Short Error Message: " . $ErrorShortMsg. "<br>";
    echo "Error Code: " . $ErrorCode. "<br>";
    echo "Error Severity Code: " . $ErrorSeverityCode. "<br>";
}