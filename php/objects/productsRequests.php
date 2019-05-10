<?php
    include_once ('products.php');
    $products = new products();

    const GET_PRODUCT = 'getProduct';

    $mMethod = $_POST['method'];

    switch ($mMethod){
        case GET_PRODUCT:
            if(isset($_POST['masterSKU'])){
                $tMasterSKU = $_POST['masterSKU'];
                $tProvider = '-1';
                if(isset($_POST['codprov'])){
                    $tProvider = $_POST['codprov'];
                }
                echo json_encode($products->getProduct($tMasterSKU, $tProvider));
            }
            else{
                echo 'ER - no mastersku';
            }
            break;

        default:
            echo 'ER - unknown method';
            break;
    }