<?php

session_start();
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

$sku = $_POST["sku"];
$status = $_POST["status"];
$num = $status=='A'?1:0;
$q = "update cat_prod set ESTATUS = '$status' where mastersku = '$sku';";
$q1 = "update sageinventario set ESTATUS = '$status',actualiza=$num where productid = '$sku';";

echo "<script>console.log(\"".$q."\");console.log(\"".$q1."\");</script>";

if($r = mysqli_query(conexion($_SESSION["pais"]), $q)){
    $a = mysqli_query(conexion($_SESSION["pais"]), $q1);
}