<?php
session_start();
include_once('products.php');
$products = new products();

const GET_PRODUCT = 'getProduct';
const GET_PRICE_BY_DISTRIBUTION = 'getPriceByDistribution';
const SET_PVENTA = 'setPVenta';

if (isset($_POST["method"])) {
    $mMethod = $_POST['method'];

    switch ($mMethod) {
        case GET_PRODUCT:
            if (isset($_POST['masterSKU'])) {
                $tMasterSKU = $_POST['masterSKU'];
                $tProvider = '-1';
                if (isset($_POST['codprov'])) {
                    $tProvider = $_POST['codprov'];
                }else if($_SESSION["codprov"] != ""){
                    $tProvider = $_SESSION["codprov"];
                }

                echo json_encode($products->getProduct($tMasterSKU, $tProvider));
            }
            else {
                echo 'ER - no mastersku';
            }
            break;

        case GET_PRICE_BY_DISTRIBUTION:
            $tMasterSKU = $_POST['masterSKU'];
            $tQuantity = $_POST['quantity'];
            echo json_encode($products->getPriceByDistribution($tMasterSKU, $tQuantity));
            break;

        case SET_PVENTA:
            $tMasterSKU = $_POST['masterSKU'];
            $tPrice = $_POST['price'];
            echo json_encode($products->setPVenta($tMasterSKU, $tPrice));
            break;

        default:
            echo 'ER - unknown method';
            break;
    }
}

if (isset($_GET["method"])) {
    $method = $_GET["method"];
    switch ($method) {
        case "searchProduct":
            $term = $_GET["term"];
            echo json_encode($products->searchProduct($term));
            break;
    }
}