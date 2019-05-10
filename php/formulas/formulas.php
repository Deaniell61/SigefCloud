<?php

class formulas{

    public function __construct() {
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
    }

    //01 units per case
    public function unitsPerCase($mMasterSKU, $mCountry){
        $unitsPerCase = $this->getUnitsPerCase($mMasterSKU, $mCountry);

        return $unitsPerCase;
    }

    //02 bundle units
    public function bundleUnits($mMasterSKU, $mCountry){
        $bundleUnits = $this->getBundleUnits($mMasterSKU, $mCountry);
        $tUniventa = $bundleUnits[0];
        $tUBundle = $bundleUnits[1];
        $response = [1];
        for($i = 1; $i < $tUBundle; $i++){
            if($i%$tUniventa == 0){
                $response[] = $i;
            }
        }
        $response[] = intval($tUBundle);

        return $response;
    }

    //03 cospri
    public function cospri($mMasterSKU, $mBundleUnits, $mCountry){
        $cost = $this->getCost($mMasterSKU, $mCountry);
        $cospri = $cost * $mBundleUnits;
        $cospri = round($cospri, 2);

        return $cospri;
    }

    //04 fbaordhanf
    public function fbaordhanf($mChannel, $mCountry){
        $fbaordhanf = $this->getFacVal($mChannel, "FBAORDHANF", $mCountry);

        return $fbaordhanf;
    }

    //05 fbapicpacf
    public function fbapicpacf($mChannel, $mCountry){
        $fbapicpacf = $this->getFacVal($mChannel, "FBAPICPACF", $mCountry);

        return $fbapicpacf;
    }

    //06 fbaweihanf
    public function fbaweihanf($mMasterSKU, $mUnits, $mChannel, $mCountry){
        $productWeigth = $this->getProductWeigth($mMasterSKU, $mCountry);
        $tWeigth = ($productWeigth * $mUnits);

        $channelFee = $this->getChannelFee($mChannel, $tWeigth, $mCountry);
        $channelFeeFactor = $channelFee[0];
        $fbaweihanf = $tWeigth * $channelFeeFactor;

        $tFormula = $channelFee[1];

        if($tFormula == "MULTI"){
            $tSubstraction = $channelFee[2];
            $fbaweihanf *= ($tWeigth - $tSubstraction);
        }

        $fbaweihanf = round($fbaweihanf, 2);
        return $fbaweihanf;
    }

    //07 fbainbshi
    public function fbainbshi($mMasterSKU, $mUnits, $mCountry){
        $inboundShipping = $this->getInboundShipping($mMasterSKU, $mCountry);
        $tUniventa = $inboundShipping[0];
        $tWeigth = $inboundShipping[1];

        if($tUniventa > 1){
            $fbainbshi = (1 / $tUniventa) * $mUnits;
        }
        else{
            if($tUniventa == 1 && $tWeigth < 15){
                $fbainbshi = (1 / $tUniventa);
            }
            else{
                $fbainbshi = 1;
            }
        }

        $fbainbshi = round($fbainbshi, 2);

        return $fbainbshi;
    }

    //08 pacmat
    public function pacMat($mChannel, $mCountry){
        $pacMat = $this->getFacVal($mChannel, "PACMAT", $mCountry);

        return $pacMat;
    }

    public function shipping($mMasterSKU, $mCountry, $mUnits = 1){

        $start = microtime(true);

        $productQuery = $this->getProductQuery($mMasterSKU);
        $productResult = mysqli_query(conexion($mCountry), $productQuery);

        if($productResult->num_rows == 1){

            $productRow = mysqli_fetch_array($productResult);

            $mWeight = $productRow["PESO_OZ"];
            $mLength = $productRow["PROFUN"];
            $mWidth = $productRow["ANCHO"];
            $mHeight = $productRow["ALTO"];

            //get price by weight
            $tWeight = round($mUnits * $mWeight, 5) + 3;

            if($tWeight <= 13){
                $tPriority = "1";
                $tShippingWeight = $tWeight;
            }

            else{
                $tPriority = "4";
                $tShippingWeight = $tWeight / 16;

                //get cubic price
                $tXCube = (($mLength * $mWidth) * $mHeight) / 1728;
                $tCubicWeight = round($mUnits * $tXCube, 5);

                if($tCubicWeight <= 0.4){
                    $tPriority = "2";
                    $tShippingWeight = ceil($tCubicWeight * 100) / 100;
                }
            }

            $response = $this->getPriceByPriority($tPriority, $tShippingWeight, $mCountry);

            //offset
            $offset = $this->getOffset($mUnits);
            $response += ($response * $offset);

            //shipping fee
            $shippingFee = $this->getShippingFee($mMasterSKU, $mUnits, $mCountry);

            if($shippingFee != "" &&
                $shippingFee <= ($response * 1.30)){
                $response = $shippingFee;
            }

            $response = round($response, 2);

            $end = round((microtime(true) - $start), 3);

            echo "TIME: $end MS<br>";
        }

        else{
            $response = "PRODUCT DOESN'T EXISTS";
        }

        return "$response";
    }

    public function minPrice($mMasterSKU, $mCountry){
        $tMMIN = $this->getMMIN($mMasterSKU, $mCountry);
        $tMMAX = $this->getMMAX($mMasterSKU, $mCountry);

        echo "MMIN:$tMMIN<br>MMAX:$tMMAX<br>";
    }

    //auxs
    //01
    private function getUnitsPerCase($mMasterSKU, $mCountry){
        $unitsPerCaseQuery = $this->getUnitsPerCaseQuery($mMasterSKU);
        $unitsPerCaseResult = mysqli_query(conexion($mCountry), $unitsPerCaseQuery);
        $unitsPerCase = mysqli_fetch_array($unitsPerCaseResult)[0];

        return $unitsPerCase;
    }

    //02
    private function getBundleUnits($mMasterSKU, $mCountry){
        $bundleUnitsQuery = $this->getBundleUnitsQuery($mMasterSKU);
        $bundleUnitsResult = mysqli_query(conexion($mCountry), $bundleUnitsQuery);
        $bundleUnits = mysqli_fetch_array($bundleUnitsResult);

        return $bundleUnits;
    }

    //03
    private function getCost($mMasterSKU, $mCountry){
        $costQuery = $this->getCostQuery($mMasterSKU);
        $costResult = mysqli_query(conexion($mCountry), $costQuery);
        $cost = mysqli_fetch_array($costResult)[0];

        return $cost;
    }

    //06
    private function getProductWeigth($mMasterSKU, $mCountry){
        $productWeigthQuery = $this->getProductQuery($mMasterSKU);
        $productWeightResult = mysqli_query(conexion($mCountry), $productWeigthQuery);
        $productWeight = mysqli_fetch_array($productWeightResult)[0];

        return $productWeight;
    }

    private function getChannelFee($mChannel, $mWeigth, $mCountry){
        $channelFeeQuery = $this->getChannelFeeQuery($mChannel, $mWeigth);
        $channelFeeResult = mysqli_query(conexion($mCountry), $channelFeeQuery);
        $channelFee = mysqli_fetch_array($channelFeeResult);

        return $channelFee;
    }

    //07
    private function getInboundShipping($mMasterSKU, $mCountry){
        $inboundShippingQuery = $this->getInboundShippingQuery($mMasterSKU);
        $inboundShippingResult = mysqli_query(conexion($mCountry), $inboundShippingQuery);
        $inboundShipping = mysqli_fetch_array($inboundShippingResult);

        return $inboundShipping;
    }

    private function getFacVal($mChannel, $mParameter, $mCountry){
        $facVal = "0.00000";
        $facValQuery = $this->getFacValQuery($mChannel, $mParameter);
//        echo "$facValQuery<br>";
        $facValResult = mysqli_query(conexion($mCountry), $facValQuery);
        if($facValResult->num_rows == 1){
            $facVal = mysqli_fetch_array($facValResult)[0];
        }

        return $facVal;
    }

    private function getPriceByPriority($mPriority, $mWeight, $mCountry){
        $priceQuery = $this->getPriceByPriorityQuery($mPriority, $mWeight);
        $priceResult = mysqli_query(conexion($mCountry), $priceQuery);
        $price = mysqli_fetch_array($priceResult)[0];

        return $price;
    }

    private function getOffset($mUnits, $mCountry){
        $offsetQuery = $this->getOffsetQuery($mUnits);
        $offsetResult = mysqli_query(conexion($mCountry), $offsetQuery);
        $offset = mysqli_fetch_array($offsetResult)[0];
        $offset /= 100;

        return $offset;
    }

    private function getShippingFee($mMasterSKU, $mUnits, $mCountry){
        $shippingFeeQuery = $this->getShippingFeeQuery($mMasterSKU, $mUnits);
        $shippingFeeResult = mysqli_query(conexion($mCountry), $shippingFeeQuery);
        $shippingFee = mysqli_fetch_array($shippingFeeResult)[0];

        return $shippingFee;
    }

    private function getMMIN($mMasterSKU, $mCountry){
        $mminQuery = $this->getMMINQuery($mMasterSKU);
        $mminResult = mysqli_query(conexion($mCountry), $mminQuery);
        $mmin = mysqli_fetch_array($mminResult)[0];

        return $mmin;
    }

    private function getMMAX($mMasterSKU, $mCountry){
        $mmaxQuery = $this->getMMAXQuery($mMasterSKU);
        $mmaxResult = mysqli_query(conexion($mCountry), $mmaxQuery);
        $mmax = mysqli_fetch_array($mmaxResult)[0];

        return $mmax;
    }

    //queries
    private function getUnitsPerCaseQuery($mMasterSKU){
        $response = "
            SELECT 
                UNIVENTA
            FROM
                cat_prod
            WHERE
                MASTERSKU = '$mMasterSKU';
        ";

        return $response;
    }

    private function getBundleUnitsQuery($mMasterSKU){
        $response = "
            SELECT 
                UBUNDLE, UNIVENTA
            FROM
                cat_prod
            WHERE
                MASTERSKU = '$mMasterSKU';
        ";

        return $response;
    }

    private function getCostQuery($mMasterSKU){
        $response = "
            SELECT 
                PCOSTO
            FROM
                cat_prod
            WHERE
                MASTERSKU = '$mMasterSKU';
        ";

        return $response;
    }

    private function getFacValQuery($mChannel, $mParameter){
        $response = "
            SELECT 
                tpc.FAC_VAL
            FROM
                tra_par_cha AS tpc inner join cat_par_pri as cpp on tpc.CODPARAM = cpp.CODPARPRI
            WHERE
                codcanal = '$mChannel'
                    AND cpp.COLUMNA = '$mParameter';
        ";

        return $response;
    }

    private function getPriceByPriorityQuery($mPriority, $mWeight){
        $response = "
            SELECT 
                PRECIO
            FROM
                det_shi_par
            WHERE
                PRIORIDAD = '$mPriority'
                    AND '$mWeight' BETWEEN MINI AND MAXI;
        ";

        return $response;
    }

    private function getProductQuery($mMasterSKU){
        $response = "
            SELECT 
                PESO, (PESO_LB * 16) + PESO_OZ as PESO_OZ, PROFUN, ANCHO, ALTO
            FROM
                cat_prod
            WHERE
                MASTERSKU = '$mMasterSKU';
        ";

        return $response;
    }

    private function getOffsetQuery($mUnits){
        $response = "
            SELECT 
                VALOR
            FROM
                cat_ext_shi
            WHERE
                CANTIDAD >= '$mUnits' 
            UNION SELECT 
                VALOR
            FROM
                cat_ext_shi
            WHERE
                CANTIDAD = (SELECT 
                        MAX(cantidad)
                    FROM
                        cat_ext_shi)
            LIMIT 1;
        ";

        return $response;
    }

    private function getShippingFeeQuery($mMasterSKU, $mUnits){
        $response = "
            SELECT 
                *
            FROM
                (SELECT 
                    enc.shifee
                FROM
                    tra_ord_det AS det
                INNER JOIN tra_ord_enc AS enc ON det.codorden = enc.codorden
                WHERE
                    det.productid = (
                    SELECT 
                IF((SELECT 
                            COUNT(*)
                        FROM
                            tra_bun_det
                        WHERE
                            MASTERSKU = '$mMasterSKU' AND UNITBUNDLE = $mUnits) > 1,
                    (SELECT 
                            AMAZONSKU
                        FROM
                            tra_bun_det
                        WHERE
                            MASTERSKU = '$mMasterSKU' AND UNITBUNDLE = $mUnits
                                AND PUBLICAR = 1
                        ORDER BY CODBUNDLE
                        LIMIT 1),
                    (SELECT 
                            AMAZONSKU
                        FROM
                            tra_bun_det
                        WHERE
                            MASTERSKU = '$mMasterSKU' AND UNITBUNDLE = $mUnits)))
                    ) AS dataset 
            UNION SELECT 
                *
            FROM
                (SELECT 
                    enc.shifee
                FROM
                    tra_ord_det AS det
                INNER JOIN tra_ord_enc AS enc ON det.codorden = enc.codorden
                WHERE
                    det.productid = '$mMasterSKU' AND det.QTY = $mUnits
                        AND enc.timoford BETWEEN (NOW() - INTERVAL 60 DAY) AND NOW()
                ORDER BY enc.timoford DESC
                LIMIT 1) AS dataset
            LIMIT 1;
        ";

        return $response;
    }

    private function getMMINQuery($mMasterSKU){
        $response = "
            SELECT 
                MARMIN
            FROM
                cat_prod AS prod
                    INNER JOIN
                cat_prov AS prov ON prod.codprov = prov.codprov
            WHERE
                MASTERSKU = '$mMasterSKU'
                    AND MARMIN != '0.00000' 
            UNION SELECT 
                emp.MMIN
            FROM
                cat_prod AS prod
                    INNER JOIN
                cat_prov AS prov ON prod.codprov = prov.codprov
                    INNER JOIN
                quintoso_sigef.cat_empresas AS emp ON prov.codempresa = emp.codempresa
            WHERE
                prod.mastersku = '$mMasterSKU';
        ";

        return $response;
    }

    private function getMMAXQuery($mMasterSKU){
        $response = "
            SELECT 
                MARMAX
            FROM
                cat_prod AS prod
                    INNER JOIN
                cat_prov AS prov ON prod.codprov = prov.codprov
            WHERE
                MASTERSKU = '$mMasterSKU'
                    AND MARMIN != '0.00000' 
            UNION SELECT 
                emp.MMAX
            FROM
                cat_prod AS prod
                    INNER JOIN
                cat_prov AS prov ON prod.codprov = prov.codprov
                    INNER JOIN
                quintoso_sigef.cat_empresas AS emp ON prov.codempresa = emp.codempresa
            WHERE
                prod.mastersku = '$mMasterSKU';
        ";

        return $response;
    }

    private function getChannelFeeQuery($mChannelFee, $mWeight){
        $response = "
            SELECT 
                (VALORBASE + VALOR) as valor, formula, resta
            FROM
                cat_chan_fee
            WHERE
                codcanal = '$mChannelFee'
                    AND '$mWeight' BETWEEN RANGO_DE AND RANGO_A;
        ";

        return $response;
    }

    private function getInboundShippingQuery($mMasterSKU){
        $response = "
            SELECT 
                UNIVENTA, PESO
            FROM
                cat_prod
            WHERE
                MASTERSKU = '$mMasterSKU';
        ";

        return $response;
    }
}
