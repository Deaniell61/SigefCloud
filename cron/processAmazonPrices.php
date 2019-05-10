<?php

$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));

include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/cron/product.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/lib/amazonMWS/src/MarketplaceWebServiceProducts/amazonMWS.php");
$product = new product();
$amazonMWS = new amazonMWS();
$query = "SELECT dir.nomPais FROM cat_empresas AS emp INNER JOIN direct AS dir ON emp.pais = dir.codPais WHERE emp.companyid != '0';";
$result = mysqli_query(conexion(""), $query);

$file = fopen($_SERVER["DOCUMENT_ROOT"] . "/csv/amazonPrices.txt", "w");
fwrite($file, "ProductID\tSitePrice\tBuyItNowPrice\tStartPrice\tAmazonPrice\tBuyDotComPrice\tMAPPrice\tNewEggDotComPrice\tJETPrice\tOverStockPrice\tSearsPrice\tWalmartAPIPrice\tPriceFallPrice\tMyPriceOnAmazon\tListPrice\r\n");
fclose($file);
while ($row = mysqli_fetch_array($result)) {
    $couter = 0;
    $country = $row[0];
    $skuQuery = "
        SELECT 
            AMAZONSKU
        FROM
            tra_bun_det;
    ";
    $skuResult = mysqli_query(conexion($country), $skuQuery);
    $tArray = null;
    for ($index = 0; $index < $skuResult->num_rows; $index++) {
        $skuRow = mysqli_fetch_array($skuResult);
        $tAmazonSKU = $skuRow["AMAZONSKU"];
        $tArray[] = $tAmazonSKU;
        if (($index + 1) % 20 == 0) {
            $counter += 1;
            processAmazonPrices($tArray, $country);
            $tArray = null;
        }
    }

    if ($tArray != null) {
        $counter += 1;
        processAmazonPrices($tArray, $country);
    }

    echo "$country:$counter<br>";
}

function processAmazonPrices($skus, $country){
    global $amazonMWS;
    $result = $amazonMWS->getPriceForSKU($skus);
    $file = fopen($_SERVER["DOCUMENT_ROOT"] . "/csv/amazonPrices.txt", "a");
    foreach ($result as $key => $value){
        $oldPriceQuery = "
            SELECT 
                codbundle, SUGSALPRIC
            FROM
                tra_bun_det
            WHERE
                AMAZONSKU = '$key';
        ";

        $oldPriceResult = mysqli_query(conexion($country), $oldPriceQuery);

        if($oldPriceResult->num_rows == 1){
            $oldPriceRow = mysqli_fetch_array($oldPriceResult);
            $PRECIO = $oldPriceRow["SUGSALPRIC"];
            $NUEVPRECIO = $value;

            if($PRECIO != $NUEVPRECIO){

                fwrite($file, "$key\t$value\t$value\t$value\t$value\t$value\t$value\t$value\t$value\t$value\t$value\t$value\t$value\t$value\t$value\r\n");
                fclose($file);

                $CODBUNBIT = sys2015();
                $CODBUNDLE = $oldPriceRow["codbundle"];
                $FECHA = date("Y-m-d H:i:s");

                $updateQuery = "
                    UPDATE tra_bun_det
                    SET 
                        SUGSALPRIC = '$value'
                    WHERE
                        AMAZONSKU = '$key';
                ";
                mysqli_query(conexion($country), $updateQuery);

                $priceBitQuery = "
                    INSERT INTO tra_bun_bit (CODBUNBIT, CODBUNDLE, FECHA, PRECIO, NUEVPRECIO) VALUES ('$CODBUNBIT', '$CODBUNDLE', '$FECHA', '$PRECIO', '$NUEVPRECIO');
                ";
                mysqli_query(conexion($country), $priceBitQuery);

                echo "$key - $value<br>";
            }
        }
    }
    uploadToFTP("AppEagle/amazonPrices.txt", $_SERVER["DOCUMENT_ROOT"] . "/csv/amazonPrices.txt");
}

function uploadToFTP($file, $path){
    $server = "ftp.quintosol.com.gt";
    $user = "sigefcloud@sigefcloud.com";
    $pass = "ftpSC2016";
    $connection = ftp_connect($server) or die("Could not connect to $server");
    $login = ftp_login($connection, $user, $pass);
    ftp_put($connection, $file, $path, FTP_ASCII);
    ftp_close($connection);
}