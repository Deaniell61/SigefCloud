<?php

session_start();
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

$sku = $_POST["sku"];
$status = $_POST["status"];

$q = "update cat_prod set ESTATUS = '$status' where mastersku = '$sku';";

echo $q;

$r = mysqli_query(conexion($_SESSION["pais"]), $q);