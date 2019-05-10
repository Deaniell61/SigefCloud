<?php
$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));
class product{
    public function ASIN($id, $amazonSKU, $country){
        include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/sellercloud/sellercloud.php");
        $sellercloud = new sellercloud();
        $tProduct = $sellercloud->getProduct($amazonSKU);
        $tASIN = $tProduct->GetProductResult->ASIN;

        if($tASIN != ""){
            $ASINQuery = "
                UPDATE tra_bun_det
                SET
                    ASIN = '$tASIN'
                WHERE
                    codbundle = '$id';
            ";
            mysqli_query(conexion($country), $ASINQuery);
            return $tASIN;
        }
    }
    public function UPC($id, $amazonSKU, $country){
        include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/sellercloud/sellercloud.php");
        $sellercloud = new sellercloud();
        $tProduct = $sellercloud->getProduct($amazonSKU);
        $tUPC = $tProduct->GetProductResult->UPC;

        if($tUPC != ""){
            $ASINQuery = "
                UPDATE tra_bun_det
                SET
                    UPC = '$tUPC'
                WHERE
                    codbundle = '$id';
            ";
            mysqli_query(conexion($country), $ASINQuery);
            return $tUPC;
        }
    }
}