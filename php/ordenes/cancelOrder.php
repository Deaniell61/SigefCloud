<?php

session_start();
include_once $_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php";

$tOrderId = $_POST["tOrderId"];
$query = "
    UPDATE tra_ord_enc SET tranum = 'Cancelled', estatus = 'Cancelled' WHERE orderid = '$tOrderId';
";
//echo "$query";


include_once $_SERVER["DOCUMENT_ROOT"] . "/php/walmart/walmart.php";
$walmart = new walmart();
if($walmart->cancelOrder($tOrderId, $_SESSION["pais"])){
    mysqli_query(conexion($_SESSION["pais"]), $query);
}