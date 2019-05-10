<?php
error_reporting(E_ERROR);
ini_set('display_errors', 'On');

include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/productos/syncQueue.php");
addProductToQueue("502300999", "Guatemala");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/cron/processSyncProductQueue.php");


/*
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/channels/sellercloud/sellercloud.php");

$sellercloud = new \channels\sellercloud(false);
$test = $sellercloud->updateProductFull("502300999", "Guatemala");

var_dump($test);
*/