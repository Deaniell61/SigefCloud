<?php

class formulas{
    public function __construct() {
    }

    public function shipping($mUnits, $mWeight, $mLenght, $mWidth, $mHeight, $mCountry){

        include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

        $tWeight = round($mUnits * $mWeight, 4) + 3;

        if($tWeight <= 13){
            $tPriority = "1";
            $tShippingWeight = $tWeight / 16;
        }

        else{
            $tXCube = (($mLenght * $mWidth) * $mHeight) / 1728;
            $tCubicWeight = round($mUnits * $tXCube, 4);

            if($tCubicWeight <= 0.4){
                $tPriority = "2";
                $tShippingWeight = ceil($tCubicWeight * 100) / 100;
            }
            else{
                $tPriority = "4";
                $tShippingWeight = $tWeight / 16;
            }
        }

        $priceQuery = "
            SELECT 
                PRECIO
            FROM
                det_shi_par
            WHERE
                PRIORIDAD = '$tPriority'
                    AND '$tShippingWeight' BETWEEN MINI AND MAXI;
        ";

        $priceResult = mysqli_query(conexion($mCountry), $priceQuery);
        $price = mysqli_fetch_array($priceResult)[0];
    }
}
