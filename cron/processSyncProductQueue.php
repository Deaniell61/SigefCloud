<?php

error_reporting(E_ERROR);
ini_set('display_errors', 'On');
$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));
require_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/channels/sellercloud/sellercloud.php");
$sellercloud = new \channels\sellercloud(false);


$countries = ["Guatemala", "Costa Rica"];

foreach ($countries as $country) {
    echo "COUNTRY:$country<br>";
    syncProducts($country);
    syncKits($country);
    syncImages($country);
}

function syncProducts($country, $debug = false)
{

    global $sellercloud;

    $productsQ = "
        SELECT 
            id, job_id
        FROM
            tra_job_queue
        WHERE
            `type` = 'syncProduct'
                AND status = 'PENDING'
        ORDER BY created DESC;
    ";

    $productsR = mysqli_query(conexion($country), $productsQ);

    while ($productsRow = mysqli_fetch_array($productsR)) {
        $tId = $productsRow["id"];
        $tSKU = $productsRow["job_id"];
        if ($debug) {
            echo "<h2>SYNC PROD SKU:$tSKU</h2>";
        }
        $response = $sellercloud->updateProductFull($tSKU, $country);
        $response = json_decode($response);
        if ($debug) {
            echo "<pre>";
            print_r($response);
            echo "</pre>";
        }
        if ($response->status == "SUCCESS") {
            $updateStatusQ = "
                UPDATE tra_job_queue 
                SET 
                    `status` = 'SUCCESS'
                WHERE
                    id = '$tId';
            ";
        } else if ($response->status == "ERROR") {
            $updateStatusQ = "
                UPDATE tra_job_queue 
                SET 
                    `status` = 'ERROR',
                    `notes` = '$response->message'
                WHERE
                    id = '$tId';
            ";
        }
        mysqli_query(conexion($country), $updateStatusQ);
    }
}

function syncKits($country, $debug = false)
{

    global $sellercloud;

    $productsQ = "
        SELECT 
            id, job_id
        FROM
            tra_job_queue
        WHERE
            `type` = 'syncKit'
                AND status = 'PENDING'
        ORDER BY created DESC;
    ";

    $productsR = mysqli_query(conexion($country), $productsQ);

    while ($productsRow = mysqli_fetch_array($productsR)) {
        $tId = $productsRow["id"];
        $tSKU = $productsRow["job_id"];
        if ($debug) {
            echo "<h2>SYNC KIT SKU:$tSKU</h2>";
        }
        $response = $sellercloud->addKitItem($tSKU, $country);
        $response = json_decode($response);
        if ($debug) {
            echo "<pre>";
            print_r($response);
            echo "</pre>";
        }
        if ($response->status == "SUCCESS") {
            $updateStatusQ = "
                UPDATE tra_job_queue 
                SET 
                    `status` = 'SUCCESS'
                WHERE
                    id = '$tId';
            ";
        } else if ($response->status == "ERROR") {
            $updateStatusQ = "
                UPDATE tra_job_queue 
                SET 
                    `status` = 'ERROR',
                    `notes` = '$response->message'
                WHERE
                    id = '$tId';
            ";
        }
        mysqli_query(conexion($country), $updateStatusQ);
    }
}

function syncImages($country, $debug = false)
{

    global $sellercloud;

    $productsQ = "
        SELECT 
            id, job_id
        FROM
            tra_job_queue
        WHERE
            `type` = 'syncImages'
                AND status = 'PENDING'
        ORDER BY created DESC;
    ";

    $productsR = mysqli_query(conexion($country), $productsQ);

    while ($productsRow = mysqli_fetch_array($productsR)) {
        $tId = $productsRow["id"];
        $tSKU = $productsRow["job_id"];
        if ($debug) {
            echo "<h2>SYNC IMAGES SKU:$tSKU</h2>";
        }
        $tCodProd = getSingleValue("
            SELECT 
                prod.CODPROD
            FROM
                cat_prod AS prod
                    INNER JOIN
                tra_bun_det AS bun ON prod.mastersku = bun.mastersku
            WHERE
                (prod.mastersku = '$tSKU'
                    || bun.amazonsku = '$tSKU')
            ORDER BY bun.unitbundle
            LIMIT 1;
        ", $country);

        $imagesQ = "
            SELECT 
                CODIMAGE, SCCOD
            FROM
                cat_prod_img
            WHERE
                codprod = '$tCodProd';
        ";

        $imagesR = mysqli_query(conexion($country), $imagesQ);

        while($imageRow = mysqli_fetch_array($imagesR)){
            $tCod = $imageRow["CODIMAGE"];
            $tSCCod = json_decode($imageRow["SCCOD"], true);

            if(!isset($tSCCod[$tSKU])){
//                echo "NO $tSKU<br>";
                $response = $sellercloud->addImage($tSKU, $tCod, $country);
            }else{
//                echo "SI $tSKU ".$tSCCod[$tSKU]."<br>";
                $response = $sellercloud->updateImage($tCod, $tSCCod[$tSKU], $country);
                //edit
            }

            $response = json_decode($response);

            if ($response->status == "SUCCESS") {
                $updateStatusQ = "
                UPDATE tra_job_queue 
                SET 
                    `status` = 'SUCCESS',
                    `notes` = '$response->message'
                WHERE
                    id = '$tId';
            ";
            } else if ($response->status == "ERROR") {
                $updateStatusQ = "
                UPDATE tra_job_queue 
                SET 
                    `status` = 'ERROR',
                    `notes` = '$response->message'
                WHERE
                    id = '$tId';
            ";
            }

//            echo "UQ:$updateStatusQ<br>";
            mysqli_query(conexion($country), $updateStatusQ);
        }

        //clean unused images
//        echo "<h2>CLEAN IMAGES $tSKU</h2>";
        $images = $sellercloud->listProductImages($tSKU);
        $images = json_decode($images);
        $images = $images->result->ProductImage;
        foreach($images as $image){
            $tSCImage = $image->ID;
            $checkQ = "select * from cat_prod_img where codprod = '_5EE0NEURD' and sccod like '%$tSCImage%';";
            $checkR = mysqli_query(conexion($country), $checkQ);
            if($checkR->num_rows == 0){
//                echo "DELETE: $tSCImage<br>";
                $sellercloud->deleteImage($tSCImage);
            }else{
//                echo "HAS $tSCImage<br>";
            }
        }
    }
}
