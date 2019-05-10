<?php
session_start();
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/paypalClassic/obj/paypalfunctions.php");
$token = $_GET["token"];
$response = CreateBillingAgreement($token);
$agreementID = $response["BILLINGAGREEMENTID"];
//echo "T:$token<br>";
//echo "R:$agreementID<br>";
//var_dump($response);
//$payerId = $_GET["PayerID"];
$codprov = $_SESSION["codprov"];
$query = "UPDATE cat_prov SET PAYPALID = '$agreementID' WHERE CODPROV = '$codprov';";
//echo $query;
mysqli_query(conexion($_SESSION["pais"]), $query);
echo "<script>window.close();</script>";
//array(6) { ["BILLINGAGREEMENTID"]=> string(19) "B-3N311063VU5367716" ["TIMESTAMP"]=> string(20) "2017-09-26T15:28:07Z" ["CORRELATIONID"]=> string(13) "7ee734692a415" ["ACK"]=> string(7) "Success" ["VERSION"]=> string(3) "204" ["BUILD"]=> string(8) "39073839" }