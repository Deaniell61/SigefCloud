<?php

$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));

echo $_SERVER["DOCUMENT_ROOT"] . "/php/walmart/walmart.php" . "!";
echo file_exists($_SERVER["DOCUMENT_ROOT"] . "/php/walmart/walmart.php") . "!";
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/walmart/walmart.php");


//$walmart = new walmart(true);

//$orders = $walmart->ordersReleased();

//var_dump($orders);