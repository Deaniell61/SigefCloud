<?php

class specialAttributes {

    const EXPIRATION_DATE = "Expiration Date";

    const EXPIRATION_MONTH = "Expiration Month";

    const EXPIRATION_YEAR = "Expiration Year";

    public function processSpecialAttributes($codProd, $nomProd, $country) {

        $productAtributesQuery = "
            SELECT 
                prod_atr.CODESPPRO, atr.NOMBRE
            FROM
                tra_esp_atr_pro AS prod_atr
                    INNER JOIN
                cat_esp_atr AS atr ON prod_atr.CODESPATR = atr.CODESPATR
            WHERE prod_atr.CODPROD = '$codProd';
        ";
        $productAtributesResult = mysqli_query(conexion($country), $productAtributesQuery);
//        echo "$nomProd - $codProd<br>";
        while ($productAtributesRow = mysqli_fetch_array($productAtributesResult)) {
            $method = $productAtributesRow["NOMBRE"];
            switch ($method) {
                case self::EXPIRATION_DATE:
                    $this->expirationDate($codProd, $country);
                    break;
                case self::EXPIRATION_MONTH:
                    $this->expirationMonth($codProd, $country);
                    break;
                case self::EXPIRATION_YEAR:
                    $this->expirationYear($codProd, $country);
                    break;
            }
        }
    }

    public function expirationDate($codProd, $country) {

        $date = $this->getExpirationDate($codProd, $country);
        $this->updateAttribute(self::EXPIRATION_DATE, $codProd, $date, $country);
        return $date;
    }

    public function expirationMonth($codProd, $country) {

        $date = $this->getExpirationDate($codProd, $country);
        $date = date("m", strtotime($date));
        $this->updateAttribute(self::EXPIRATION_MONTH, $codProd, $date, $country);
        return $date;
    }

    public function expirationYear($codProd, $country) {

        $date = $this->getExpirationDate($codProd, $country);
        $date = date("Y", strtotime($date));
        $this->updateAttribute(self::EXPIRATION_YEAR, $codProd, $date, $country);
        return $date;
    }

    function getExpirationDate($codProd, $country) {

        $itemCodeQuery = "
            SELECT 
                ITEMCODE 
            FROM 
                cat_prod 
            WHERE 
                CODPROD = '$codProd';       
        ";

        $itemCode = getSingleValue($itemCodeQuery, $country);

        $dateQuery = "
            SELECT 
                exp.fechaexp
            FROM
                cat_prod_ven AS ven
                    INNER JOIN
                tra_lot_exp AS exp ON ven.CODPROD = exp.codprod
            WHERE
                ven.CODIGO = '$itemCode'
            ORDER BY exp.fechaexp ASC; 
        ";

        $dateResult = mysqli_query(conexionProveedorLocal($country), $dateQuery);

        if ($dateResult->num_rows == 0) {
            $date = date('Y-m-d', strtotime("+180 days"));
        }

        else {
            $targetDate = date('Y-m-d', strtotime("+30 days"));
            while ($dateRow = mysqli_fetch_array($dateResult)) {
                $tDate = explode(" ", $dateRow[0])[0];
                if ($tDate >= $targetDate) {
                    $date = $tDate;
                    break;
                }
            }
        }

        return $date;
    }

    function updateAttribute($key, $codProd, $value, $country) {

        $updateQuery = "
        UPDATE tra_esp_atr_pro AS prod_atr
                INNER JOIN
            cat_esp_atr AS atr ON prod_atr.CODESPATR = atr.CODESPATR 
        SET 
            prod_atr.VALOR = '$value',
            prod_atr.ACTUALIZA = '1'
        WHERE
            CODPROD = '$codProd'
                AND atr.NOMBRE = '$key';
    ";
        mysqli_query(conexion($country), $updateQuery);
    }

    public function uploadToSellercloud($country){
        include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/sellercloud/sellercloud.php");
        $sellercloud = new sellercloud();
        $specialAtributesQuery = "
            SELECT 
                prod_atr.CODESPPRO,
                prod.MASTERSKU,
                atr.NOMBRE,
                prod_atr.VALOR
            FROM
                tra_esp_atr_pro AS prod_atr
                    INNER JOIN
                cat_prod AS prod ON prod_atr.codprod = prod.codprod
                    INNER JOIN
                cat_esp_atr AS atr ON prod_atr.CODESPATR = atr.CODESPATR
            WHERE
                ACTUALIZA = 1
            ORDER BY prod.MASTERSKU;
        ";
        $specialAtributesResult = mysqli_query(conexion($country), $specialAtributesQuery);
        $file = fopen($_SERVER["DOCUMENT_ROOT"] . "/csv/specialAttributes$country.txt", "w");
        fputcsv($file, ["ProductID", "SpecificName", "SpecificValue"], chr(9));
        while ($specialAtributesRow = mysqli_fetch_array($specialAtributesResult)){
            echo $specialAtributesRow["NOMBRE"]."<br>";
            fputcsv($file, [$specialAtributesRow["MASTERSKU"], $specialAtributesRow["NOMBRE"], $specialAtributesRow["VALOR"]], chr(9));
        }
        fclose($file);
        $file = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/csv/specialAttributes$country.txt");
        echo $sellercloud->bulkUpdate($file);
    }
}
