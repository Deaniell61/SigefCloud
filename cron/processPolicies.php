<?php
/**
 * This class is in charge of processing the policies of the orders
 */

$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));

include_once ($_SERVER["DOCUMENT_ROOT"]."/php/coneccion.php");
include_once ($_SERVER["DOCUMENT_ROOT"]."/cron/orders.php");

$orders = new orders();

$initialDate = (isset($_GET["initialDate"])) ? $_GET["initialDate"] : "";
$finalDate = (isset($_GET["finalDate"])) ? $_GET["finalDate"] : "";

$query = "SELECT dir.nomPais FROM cat_empresas AS emp INNER JOIN direct AS dir ON emp.pais = dir.codPais WHERE emp.companyid != '0';";
$result = mysqli_query(conexion(""), $query);

while ($row = mysqli_fetch_array($result)){
    $country = $row[0];
    $processedOrders = $orders->processPolicies($country, $initialDate, $finalDate);
    echo "$country: $processedOrders<br>";
}