<?php
header('Content-Type: text/html; charset=utf-8');
$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/walmart/walmart.php");
$gcountry = $_GET["country"];
if ($gcountry == "") {
    echo "SET COUNTRY<br>";
    $gcountry = "Guatemala";
}
processOrders();
function processOrders($mNextCursor) {
    global $gcountry;
    $walmart = new walmart(true);
    if ($mNextCursor == "") {
        $orders = $walmart->orders();
    } else {
        $orders = $walmart->orders($mNextCursor);
    }
    $orders = json_decode($orders);
    $tNextCursor = $orders->meta->nextCursor;
    echo "<br>NC:$tNextCursor<br>";
    $orders = $orders->elements->order;
    echo count($orders) . "<br>";
    if (count($ordersReleased->elements->order) == 1) {
        $orders = [$ordersReleased->elements->order];
    }
    foreach ($orders as $order) {
        echo "<h3>NEW ORDER</h3>";
        $tOrderId = $order->purchaseOrderId;
        $qoe = "SELECT count(*) FROM tra_ord_enc WHERE orderid = '$tOrderId';";
        $roe = mysqli_query(conexion($gcountry), $qoe);
        $aoe = mysqli_fetch_array($roe);
        $tOE = ($aoe[0] == 0) ? false : true;
        if (!$tOE) {
            echo "ORDEN NO EXISTE EN BD<br>";
            $codOrden = sys2015();
            $encQuery = getTraOrdEncQuery($codOrden);
            $purchaseOrderId = $order->purchaseOrderId;
            $customerOrderId = $order->customerOrderId;
            $customerEmailId = $order->customerEmailId;
            $orderDate = $order->orderDate;
            $shippingInfo = $order->shippingInfo; //A
            $phone = $shippingInfo->phone;
            $estimatedDeliveryDate = $shippingInfo->estimatedDeliveryDate;
            $estimatedShipDate = $shippingInfo->estimatedShipDate;
            $methodCode = $shippingInfo->methodCode;
            $postalAddress = $shippingInfo->postalAddress; //A
            $name = $shippingInfo->postalAddress->name;
            $address1 = $shippingInfo->postalAddress->address1;
            $address1 = mysqli_real_escape_string(conexion($gcountry), $address1);
            $address2 = $shippingInfo->postalAddress->address2;
            $address2 = mysqli_real_escape_string(conexion($gcountry), $address2);
            $city = $shippingInfo->postalAddress->city;
            $state = $shippingInfo->postalAddress->state;
            $postalCode = $shippingInfo->postalAddress->postalCode;
            $country = $shippingInfo->postalAddress->country;
            $addressType = $shippingInfo->postalAddress->addressType;
            $tFName = trim(explode(' ', $name, 2)[0]);
            $tLName = trim(explode(' ', $name, 2)[1]);
            $tFName = mysqli_real_escape_string(conexion($gcountry), $tFName);
            $tLName = mysqli_real_escape_string(conexion($gcountry), $tLName);
//        echo "<br>NAMES: $tFName - $tLName<br>";
            echo "OD: $orderDate<br>";
            $encQuery = getTraOrdEncQuery($codOrden, $purchaseOrderId, $customerEmailId, $orderDate, $estimatedShipDate, $tFName, $tLName, $phone, $address1, $address2, $city, $state, $postalCode, "US", "Charged", "", "", $country, "Walmart", $customerOrderId, "system", $tFName, $tLName, $addressType);
            echo "tra_ord_enc:<br>$encQuery<br>";
            $qoe = "SELECT count(*) FROM tra_ord_enc WHERE orderid = '$tOrderId';";
            $roe = mysqli_query(conexion($gcountry), $qoe);
            $aoe = mysqli_fetch_array($roe);
            $tOE = ($aoe[0] == 0) ? false : true;
            if (!$tOE) {
                mysqli_query(conexion($gcountry), $encQuery);
            }
            $orderLines = $order->orderLines;
            $subtotal = "";
            $shitot = "";
            $orddistot = "";
            $grandtotal = "";
            $estatus = "";
            $payrefnum = "";
            $shista = "";
            $shifee = "";
            $shimetsel = "";
            $shicar = "";
            $taxtotal = "";
            $shiweitoto = "";
            $tranum = "";
            $orderunits = "";
            $orderArray = [];
            foreach ($orderLines as $orderLine) {
                if (count($orderLine) == 1) {
                    $orderLine = [$orderLine];
                }
                foreach ($orderLine as $orderItem) {
                    echo "<br>-NEW ORDER LINE<br>";
//                $codOrdenDet = sys2015();
                    $lineNumber = $orderItem->lineNumber;
                    $item = $orderItem->item; //A
                    $productName = $item->productName;
                    $sku = $item->sku;

                    $existsQ = "
                        SELECT 
                            *
                        FROM
                            quintoso_sigef01.tra_bun_det
                        WHERE
                            mastersku = '$sku'
                                OR amazonsku = '$sku' 
                        UNION SELECT 
                            *
                        FROM
                            quintoso_sigef02.tra_bun_det
                        WHERE
                            mastersku = '$sku'
                                OR amazonsku = '$sku';
                    ";

                    $existsR = mysqli_query(conexion($gcountry), $existsQ);
                    $exists = $existsR->num_rows;
//                    echo "$sku - $exists<br>";

                    if($exists > 0){

                        $charges = $orderItem->charges; //A
                        $chargeType = $charges->charge->chargeType;
                        $chargeName = $charges->charge->chargeName;
//            $chargeAmount = $charges->charge->chargeAmount; //A
                        $currency = $charges->charge->chargeAmount->currency; //A
                        $amount1 = $charges->charge->chargeAmount->amount; //A
                        $taxName = $charges->charge->tax->taxName;
                        $taxAmountCurrency = $charges->charge->tax->taxAmount->currency;
                        $taxAmount = $charges->charge->tax->taxAmount->amount;
                        if ($charges->charge->chargeName == "ItemPrice") {
                            $tosChargeName = $charges->charge->chargeName;
                        }
                        $orderLineQuantity = $orderItem->orderLineQuantity; //A
                        $unitOfMeasurement1 = $orderLineQuantity->unitOfMeasurement;
                        $amount2 = $orderLineQuantity->amount;
                        $statusDate = explode("T", $orderItem->statusDate)[0];
                        $orderLineStatuses = $orderItem->orderLineStatuses; //A
                        $status = $orderLineStatuses->orderLineStatus->status;
                        $statusQuantity = $orderLineStatuses->orderLineStatus->statusQuantity;//A
                        $unitOfMeasurement2 = $orderLineStatuses->orderLineStatus->statusQuantity->unitOfMeasurement;
                        $amount3 = $orderLineStatuses->orderLineStatus->statusQuantity->amount;
                        $trackingShipDate = explode("T", $orderLineStatuses->orderLineStatus->trackingInfo->shipDateTime)[0];
                        $trackingCarrierName = $orderLineStatuses->orderLineStatus->trackingInfo->carrierName->carrier;
                        $trackingMethodCode = $orderLineStatuses->orderLineStatus->trackingInfo->methodCode;
                        $trackingNumber = $orderLineStatuses->orderLineStatus->trackingInfo->trackingNumber;
                        $trackingURL = $orderLineStatuses->orderLineStatus->trackingInfo->trackingURL;
                        $originalCarrierMethod = $orderItem->originalCarrierMethod;
                        $fulfillment = $orderItem->fulfillment;//A
                        $fulfillmentOption = $fulfillment->fulfillmentOption;
                        $shipMethod = $fulfillment->shipMethod;
                        $orditeid = getORDITEID();
                        $upc = getUPC($sku);
                        //usleep(25000);
//            $detQuery = getTraOrdDetQuery($codOrden, $codOrdenDet, $sku, $productName, $amount2, $amount1, $amount1, $amount1, $orditeid, $sku, $upc);
                        $TC = count($charges->charge);
                        echo "<br>CHARGES:$TC<br>";
                        $cht1 = "";
                        $chn1 = "";
                        $chc1 = "";
                        $cha1 = "";
                        $cht2 = "";
                        $chn2 = "";
                        $chc2 = "";
                        $cha2 = "";
                        if ($TC > 1) {
                            foreach ($charges->charge as $tcharge) {
                                $chargeName = $tcharge->chargeName;
                                $chargeType = $tcharge->chargeType;
                                $amount1 = $tcharge->chargeAmount->amount;
                                $currency = $tcharge->chargeAmount->currency;
                                $taxAmount = $tcharge->tax->taxAmount->amount;
                                $taxName = $tcharge->tax->taxName;
                                $taxAmountCurrency = $tcharge->tax->taxAmount->currency;
//                    if($tcharge->chargeName == "ItemPrice"){
//                        $tosChargeName = $tcharge->chargeName;
//                    }
                                $cod1 = sys2015();
//                    $auxDetQuery = getInsertTraOrdShiQuery($cod1, $codOrdenDet, $lineNumber, $productName, $sku, $chargeType, $chargeName, $currency, $amount1, $taxName, $taxAmountCurrency, $taxAmount, $unitOfMeasurement1, $amount2, $statusDate, $status, $unitOfMeasurement2, $amount3, $trackingShipDate, $trackingCarrierName, $trackingMethodCode, $trackingNumber, $trackingURL, $originalCarrierMethod, $fulfillmentOption, $shipMethod);
                                if ($chargeName == "ItemPrice") {
                                    $subtotal += $amount1;
                                    $ipAmount = $amount1;
                                } else if ($chargeName == "Shipping") {
                                    $shitot += $amount1;
                                    $shifee += $amount1;
                                }
                                echo "<br>TAB:!!$chargeName - $amount1!!<br>";
                                $orddistot += $taxAmount;
                                if ($chargeName == "Shipping") {
                                    $orddistot += $amount1;
                                }
                                $estatus = $status;
                                $payrefnum = $sunday;
                                $shista = $status;
                                $shimetsel = $shipMethod;
                                $shicar = $trackingCarrierName;
                                $taxtotal += $taxAmount;
                                $shiweitoto;
                                $tranum = $trackingNumber;
                                $orderunits += $amount2;
                                echo "<br>CHARGE:$amount1 - CHARGENAME:$chargeName<br>TAX:$taxAmount - TAXNAME:$taxName<br>";
                                if ($chargeName == "Shipping") {
                                    $cht2 = $chargeType;
                                    $chn2 = $chargeName;
                                    $chc2 = $currency;
                                    $cha2 = $amount1;
                                } else {
                                    $cht1 = $chargeType;
                                    $chn1 = $chargeName;
                                    $chc1 = $currency;
                                    $cha1 = $amount1;
                                }
                            }
                        } else {
                            $cod1 = sys2015();
//                $auxDetQuery = getInsertTraOrdShiQuery($cod1, $codOrdenDet, $lineNumber, $productName, $sku, $chargeType, $chargeName, $currency, $amount1, $taxName, $taxAmountCurrency, $taxAmount, $unitOfMeasurement1, $amount2, $statusDate, $status, $unitOfMeasurement2, $amount3, $trackingShipDate, $trackingCarrierName, $trackingMethodCode, $trackingNumber, $trackingURL, $originalCarrierMethod, $fulfillmentOption, $shipMethod);
                            if ($chargeName == "ItemPrice") {
                                $subtotal += $amount1;
                            } else if ($chargeName == "Shipping") {
                                $shitot += $amount1;
                                $shifee += $amount1;
                            }
                            $orddistot += $taxAmount;
                            if ($chargeName == "Shipping") {
                                $orddistot += $amount1;
                            }
                            $estatus = $status;
                            $payrefnum = $sunday;
                            $shista = $status;
                            $shimetsel = $shipMethod;
                            $shicar = $trackingCarrierName;
                            $taxtotal += $taxAmount;
                            $shiweitoto;
                            $tranum = $trackingNumber;
                            $orderunits += $amount2;
//                $grandtotal += $subtotal + $shitot + $taxtotal - $orddistot;
                            echo "<br>CHARGE:$amount1 - CHARGENAME:$chargeName<br>TAX:$taxAmount - TAXNAME:$taxName<br>";
                            if ($chargeName == "Shipping") {
                                $cht2 = $chargeType;
                                $chn2 = $chargeName;
                                $chc2 = $currency;
                                $cha2 = $amount1;
                            } else {
                                $cht1 = $chargeType;
                                $chn1 = $chargeName;
                                $chc1 = $currency;
                                $cha1 = $amount1;
                            }
                        }
                        if (!array_key_exists($sku, $orderArray)) {
                            $codOrdenDet = sys2015();
                            if ($chargeName == "ItemPrice") {
                                $tAmount = $amount1;
                            }
                            if ($TC > 1) {
                                $tAmount = $ipAmount;
                            }
                            $orderArray[$sku] = [
                                "coddetord" => $codOrdenDet,
                                "codorden" => $codOrden,
                                "productid" => $sku,
                                "disnam" => $productName,
                                "qty" => $amount2,
                                "linetotal" => $tAmount,
                                "oriunipri" => $tAmount,
                                "adjunipri" => $tAmount,
                                "orditeid" => $orditeid,
                                "bundlesku" => $sku,
                                "upc" => $upc,
                                "walpactyp" => $shipMethod
                            ];
                        } else {
                            if ($chargeName == "ItemPrice") {
                                $tAmount = $amount1;
                            }
                            echo "<br>TAM:!!$tAmount!!<br>";
                            $codOrdenDetT = $orderArray[$sku]["coddetord"];
                            $codOrdenT = $orderArray[$sku]["codorden"];
                            $skuT = $orderArray[$sku]["productid"];
                            $productNameT = $orderArray[$sku]["disnam"];
                            $amount2T = $orderArray[$sku]["qty"];
                            $amount1T = $orderArray[$sku]["linetotal"];
                            $amount1T = $orderArray[$sku]["oriunipri"];
                            $amount1T = $orderArray[$sku]["adjunipri"];
                            $orditeidT = $orderArray[$sku]["orditeid"];
                            $skuT = $orderArray[$sku]["sku"];
                            $upcT = $orderArray[$sku]["upc"];
                            $walpactypT = $orderArray[$sku]["walpactyp"];
                            $amount1T += $amount1;
                            $amount2T += $amount2;
                            $orderArray[$sku] = [
                                "coddetord" => $codOrdenDet,
                                "codorden" => $codOrden,
                                "productid" => $sku,
                                "disnam" => $productName,
                                "qty" => $amount2T,
                                "linetotal" => ($amount2T * $tAmount),
                                "oriunipri" => $tAmount,
                                "adjunipri" => $tAmount,
                                "orditeid" => $orditeid,
                                "bundlesku" => $sku,
                                "upc" => $upc,
                                "walpactyp" => $shipMethod
                            ];
                        }
                        $auxDetQuery = getInsertTraOrdShiQuery($cod1, $codOrdenDet, $lineNumber, $productName, $sku, $cht1, $chn1, $chc1, $cha1, $taxName, $taxAmountCurrency, $taxtotal, $unitOfMeasurement1, $amount2, $statusDate, $status, $unitOfMeasurement2, $amount3, $trackingShipDate, $trackingCarrierName, $trackingMethodCode, $trackingNumber, $trackingURL, $originalCarrierMethod, $fulfillmentOption, $shipMethod, $cht2, $chn2, $chc2, $cha2);
                        echo "<br>tra_ord_shi:<br>$auxDetQuery<br>";
                        if (!$tOE) {
                            mysqli_query(conexion($gcountry), $auxDetQuery);
                        }
                        $grandtotal = floatval($subtotal) + floatval($shitot) + floatval($taxtotal) - floatval($orddistot);
                    }
                }
                $tday = explode("T", $orderDate)[0];
//            $sunday = "WMBA" . str_replace("-", "", date('Y-m-d', strtotime('saturday this week', strtotime($tday))));
                $sunday = "";
            }
            echo "<br>-CONSOLIDADO<br>";
            foreach ($orderArray as $to) {
                $detQuery = getTraOrdDetQuery($to["coddetord"], $to["codorden"], $to["productid"], $to["disnam"], $to["qty"], $to["linetotal"], $to["oriunipri"], $to["adjunipri"], $to["orditeid"], $to["sku"], $to["upc"], $to["walpactyp"]);
                echo "<br>tra_ord_det<br>$detQuery<br>";
                if (!$tOE) {
                    mysqli_query(conexion($gcountry), $detQuery);
                }
            }
            $tEmpresaQ = "
                    (SELECT 
                        emp.companyid
                    FROM
                        tra_bun_det AS bun
                            INNER JOIN
                        cat_prod AS prod ON bun.mastersku = prod.mastersku
                            INNER JOIN
                        quintoso_sigef.cat_empresas AS emp ON prod.codempresa = emp.codempresa
                    WHERE
                        bun.amazonsku = '$sku'
                            OR prod.mastersku = '$sku')
                ";
            $tEmpresaQ = "
                    '163'
                ";
//        $tEmpresaR = mysqli_query(conexion($gcountry), $tEmpresaQ);
//        $tEmpresa = mysqli_fetch_array($tEmpresaR)[0];
            $q = "UPDATE tra_ord_enc SET SUBTOTAL = '$subtotal', SHITOT = '$shitot', ORDDISTOT = '$orddistot', GRANDTOTAL = '$grandtotal', ESTATUS = '$status', PAYREFNUM = '$payrefnum', SHISTA = '$shista', SHIFEE = '$shifee', SHIMETSEL = '$shimetsel', SHICAR = '$shicar', TAXTOTAL = '$taxtotal', TRANUM ='$tranum', ORDERUNITS = '$orderunits' WHERE CODORDEN = '$codOrden';";
            echo "<br>-UPDATE tra_ord_enc<br><br>$q<br>";
            if (!$tOE) {
                mysqli_query(conexion($gcountry), $q);
            }
        }
        else{
            $name = $order->shippingInfo->postalAddress->name;
//            $name = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $name);
//            $name = mysqli_real_escape_string(conexion($gcountry), $name);
//            $name = utf8_decode($name);
//            $name = mb_convert_encoding($name, "UTF-8");
//            echo mb_internal_encoding() . "<br>";
//            echo mb_detect_encoding($name) . "<br>";
//            $name = htmlspecialchars($name);
//            $name = mb_convert_encoding($name, "ASCII");
            echo "ORDEN YA EXISTE EN BD $tOrderId - $name<br>";

            /*
            $orderLines = $order->orderLines;
            foreach ($orderLines as $orderLine) {
                if (count($orderLine) == 1) {
                    $orderLine = [$orderLine];
                }
                foreach ($orderLine as $orderItem) {
                    $sku = $orderItem->item->sku;
//                    echo "$sku<br>";
                    $existsQ = "
                        SELECT 
                            *
                        FROM
                            quintoso_sigef01.tra_bun_det
                        WHERE
                            mastersku = '$sku'
                                OR amazonsku = '$sku' 
                        UNION SELECT 
                            *
                        FROM
                            quintoso_sigef02.tra_bun_det
                        WHERE
                            mastersku = '$sku'
                                OR amazonsku = '$sku';
                            ";

                    $existsR = mysqli_query(conexion($gcountry), $existsQ);
                    $exists = $existsR->num_rows;
                    if($exists < 1){
                        echo "NO EXISTE: $sku - $exists<br>";
                    }
                }
            }
            */
        }
    }
    if ($tNextCursor != "") {
        echo "<br>has<br>";
        processOrders($tNextCursor);
    } else {
        echo "<br>end<br>";
    }
}

function getTraOrdEncQuery($codOrden, $orderid, $username, $timoford, $shipdate, $firstname, $lastname, $shiphonum, $shiadd1, $shiadd2, $shicity, $shistate, $shizipcod, $sitecode, $paysta, $paydat, $paymet, $shicou, $ordsou, $ordsourdi, $creator, $shifirnam, $shilasnam, $addressType) {
    return "
        INSERT INTO tra_ord_enc (CODORDEN, ORDERID, USERNAME, TIMOFORD, SHIPDATE, FIRSTNAME, LASTNAME, SHIPHONUM, SHIADD1, SHIADD2, SHIPCITY, SHIPSTATE, SHIZIPCOD, SITECODE, PAYSTA, PAYDAT, PAYMET, SHICOU, ORDSOU, ORDSOUORDI, CREATOR, SHIFIRNAM, SHILASNAM, CODTORDEN, WALRESIND)
        VALUES
        ('$codOrden', '$orderid', '$username', '$timoford', '$shipdate', '$firstname', '$lastname', '$shiphonum', '$shiadd1', '$shiadd2', '$shicity', '$shistate', '$shizipcod', '$sitecode', '$paysta', '$paydat', '$paymet', '$shicou', '$ordsou', '$ordsourdi', '$creator', '$shifirnam', '$shilasnam', 'ONL', '$addressType');
";
}

function getTraOrdDetQuery($coddetord, $codorden, $productid, $disnam, $qty, $linetotal, $oriunipri, $adjunipri, $orditeid, $bundlesku, $upc, $walpactyp) {
    return "
INSERT INTO tra_ord_det (CODDETORD, CODORDEN, PRODUCTID, DISNAM, QTY, LINETOTAL, ORIUNIPRI, ADJUNIPRI, ORDITEID, BUNDLESKU, UPC, WALPACTYP) 
VALUES
('$coddetord', '$codorden', '$productid', '$disnam', '$qty', '$linetotal', '$oriunipri', '$adjunipri', '$orditeid', '$bundlesku', '$upc', '$walpactyp');
";
}

function getORDITEID() {
    global $gcountry;
    $query = "
        SELECT 
            (ORDITEID + 1) AS val
        FROM
            tra_ord_det
        WHERE
            orditeid LIKE '99%'
        ORDER BY orditeid DESC
        LIMIT 1;
    ";
    $result = mysqli_query(conexion($gcountry), $query);
    $row = mysqli_fetch_array($result);
    $response = $row[0];
    $response = ($response == "") ? "9900000001" : $response;
    return $response;
}

function getInsertTraOrdShiQuery($codordshi, $codorddet, $lineNumber, $prodName, $sku, $chargeType, $chargeName, $chCurrency, $chAmount, $txName, $txCurrency, $txAmount, $oluniOfMea, $olAmount, $statusDate, $status, $sqUniOfmea, $sqAmount, $shiDatTim, $carrier, $methodCode, $tranum, $traurl, $oriCarMet, $FulOption, $shipMethod, $cht2, $chn2, $chc2, $cha2) {
    /*
    switch ($chargeType){
        case "PRODUCT":
            return "
            INSERT INTO tra_ord_shi 
            (codordshi, codorddet, lineNumber, prodName, sku, chargeType, chargeName, chCurrency, chAmount, txName, txCurrency, txAmount, shchatyp, shchanam, shcurrency, shamount, oluniOfMea, olAmount, statusDate, status, sqUniOfmea, sqAmount, shiDatTim, carrier, methodCode, tranum, traurl, oriCarMet, FulOption, shipMethod)
            VALUES
            ('$codordshi', '$codorddet', '$lineNumber', '$prodName', '$sku', '$chargeType', '$chargeName', '$chCurrency', '$chAmount', '$txName', '$txCurrency', '$txAmount', '$shchatyp', '$shchanam', '$shcurrency', '$shamount', '$oluniOfMea', '$olAmount', '$statusDate', '$status', '$sqUniOfmea', '$sqAmount', '$shiDatTim', '$carrier', '$methodCode', '$tranum', '$traurl', '$oriCarMet', '$FulOption', '$shipMethod');
        ";
            break;

        case "SHIPPING":
            return "
                INSERT INTO tra_ord_shi 
                (codordshi, codorddet, lineNumber, prodName, sku, shchatyp, shchanam, shcurrency, shamount, txName, txCurrency, txAmount, shchatyp, shchanam, shcurrency, shamount, oluniOfMea, olAmount, statusDate, status, sqUniOfmea, sqAmount, shiDatTim, carrier, methodCode, tranum, traurl, oriCarMet, FulOption, shipMethod)
                VALUES
                ('$codordshi', '$codorddet', '$lineNumber', '$prodName', '$sku', '$chargeType', '$chargeName', '$chCurrency', '$chAmount', '$txName', '$txCurrency', '$txAmount', '$shchatyp', '$shchanam', '$shcurrency', '$shamount', '$oluniOfMea', '$olAmount', '$statusDate', '$status', '$sqUniOfmea', '$sqAmount', '$shiDatTim', '$carrier', '$methodCode', '$tranum', '$traurl', '$oriCarMet', '$FulOption', '$shipMethod');
            ";
            break;
    }
    */
    return "
            INSERT INTO tra_ord_shi 
            (codordshi, codorddet, lineNumber, prodName, sku, chargeType, chargeName, chCurrency, chAmount, taxName, txCurrency, txAmount, oluniOfMea, olAmount, statusDate, status, sqUniOfmea, sqAmount, shiDatTim, carrier, methodCode, tranum, traurl, oriCarMet, FulOption, shipMethod, shchatyp, shchanam, shcurrency, shamount)
            VALUES
            ('$codordshi', '$codorddet', '$lineNumber', '$prodName', '$sku', '$chargeType', '$chargeName', '$chCurrency', '$chAmount', '$txName', '$txCurrency', '$txAmount', '$oluniOfMea', '$olAmount', '$statusDate', '$status', '$sqUniOfmea', '$sqAmount', '$shiDatTim', '$carrier', '$methodCode', '$tranum', '$traurl', '$oriCarMet', '$FulOption', '$shipMethod', '$cht2', '$chn2', '$chc2', '$cha2');
        ";
}

function getUPC($sku) {
    global $gcountry;
    $query = "
        SELECT 
            upc
        FROM
            tra_bun_det
        WHERE
            amazonsku = '$sku';
    ";
    $result = mysqli_query(conexion($gcountry), $query);
    $row = mysqli_fetch_array($result);
    $response = $row[0];
    return $response;
}