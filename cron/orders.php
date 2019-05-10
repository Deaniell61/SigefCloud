<?php

class orders {

    public function write($orders) {
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/sellercloud/sellercloud.php");
        $sellercloud = new sellercloud();
        $newCounter = 0;
        $updateCounter = 0;

//        var_dump($orders);
//        echo "<br><br>";
        foreach ($orders as $order) {
//            echo "<br><br>!!!";
//            var_dump(json_encode($order));
//            echo "!!!<br><br>";
//            echo "W:" . $order->OrderID . "<br>";
            $fullOrder = $sellercloud->getOrderFull($order->OrderID);
            $fullOrder = $fullOrder->GetOrderFullResult;

            if(count($fullOrder->Items->OrderItem) == 1){
                $tProductId = $fullOrder->Items->OrderItem->ProductID;
//                echo "one: " . $tProductId . "<br>";
            }
            else{

                $tBundleItemQ = (isset($fullOrder->Items->OrderItem[0]->BundleItems->OrderBundleItem)) ? count($fullOrder->Items->OrderItem[0]->BundleItems->OrderBundleItem) : 0   ;
                if($tBundleItemQ > 1){
                    $tProductId = $fullOrder->Items->OrderItem[0]->BundleItems->OrderBundleItem->ProductID;
                }
                else{
                    $tProductId = $fullOrder->Items->OrderItem[0]->ProductID;
                }
//                echo "two: " . $tProductId . "<br>";
            }

            $aProduct = $sellercloud->getProduct($tProductId);
            $companyId = (!empty($aProduct->GetProductResult->SpecialFeatures10)) ? $aProduct->GetProductResult->SpecialFeatures10 : "" ;
            if(empty($aProduct->GetProductResult->SpecialFeatures10)){
//                echo "W:" . $order->OrderID . " - " . $companyId . "<br>";
//                var_dump($aProduct);
//                echo "<br><br><br><br>";
            }
//            echo "W:" . $order->OrderID . " - " . $companyId . "<br>";
            $country = $this->getCountryNameByCompanyId($companyId);

//            $t = $this->getInboundShipping($country);
//            echo "IS: $t<br>";

//            $t = $this->getPackagingMaterial("Large Box", $country);
//            echo "PM: $t<br>";

            $getCodOrdenQuery = "SELECT CODORDEN FROM tra_ord_enc WHERE ORDERID = '" . $order->OrderID . "';";
            $getCodOrdenResult = mysqli_query(conexion($country), $getCodOrdenQuery);
            $orderExists = ($getCodOrdenResult->num_rows == 0) ? false : true;

            if (!$orderExists) {
                if($country == "DEMO"){
                    echo "DEMO/ERROR:" . $order->OrderID . " - $country - $companyId <br>";
                    $errors[] = $order->OrderID;
//                    echo "<pre>";
//                    echo "$tProductId<br>";
//                    var_dump($aProduct);
//                    echo "</pre>";

                    mail("mauricio.aldana@guatedirect.com", "ORDER ERROR", "ORDER ERROR " . $order->OrderID);
                }
                $newCounter += 1;
                $this->insertOrder($fullOrder, $country);
//                echo "INSERT:" . $order->OrderID . "<br>";
            } else {
                $updateCounter += 1;
                $this->updateOrder(mysqli_fetch_array($getCodOrdenResult)[0], $fullOrder, $country);
//                echo "UPDATE:" . $order->OrderID . "<br>";
            }
        }
        /*
        if(count($errors) > 0){
            require_once($_SERVER["DOCUMENT_ROOT"] . "/php/lib/PHPMailer-master/class.phpmailer.php");
            require_once($_SERVER["DOCUMENT_ROOT"] . "/php/lib/PHPMailer-master/class.smtp.php");
            $destino ="mauricio.aldana@guatedirect.com";
            $from="sigefcloud";

            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "ssl";
            $mail->Host = "srv70.hosting24.com";
            $mail->Port = 465;
            $mail->Username = "support@sigefcloud.com";
            $mail->Password = "5upp0rt51g3fCl0ud";
            $mail->From = "support@sigefcloud.com";
            $mail->FromName = $from;
            $mail->Subject = "Ordenes con Problema";

            $mensaje = "revisar las siguiente(s) ordenes: ";
            foreach ($errors as $error){
                $mensaje .= $error;
            }

            $mail->MsgHTML($mensaje);
            $mail->IsHTML(true);

            $mail->AddAddress($destino, $destino);
            $mail->addCC("solus.huargo@gmail.com");
//            echo "<br>enviando mail<br>$mensaje";
            $mail->Send();
        }
        */
        echo "new: $newCounter, update: $updateCounter<br>";
    }

    function insertOrder($fullOrder, $country) {
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");
        include_once ("getCorrectState.php");
        $CODORDEN = sys2015();
        $ORDERID = $fullOrder->ID;
        $KITITEMID = '';
        $USERID = $fullOrder->UserID;
        $USERNAME = $fullOrder->UserName;
        $FIRSTNAME = $fullOrder->ShippingAddressOriginal->FirstName;
        $LASTNAME = $fullOrder->ShippingAddressOriginal->LastName;
        $SITECODE = $fullOrder->SiteCode;
        $TIMOFORD = $fullOrder->TimeOfOrder;
        $SUBTOTAL = $fullOrder->SubTotal;
        $SHITOT = $fullOrder->ShippingTotal;
        $ORDDISTOT = $fullOrder->OrderDiscountsTotal;
        $GRANDTOTAL = $fullOrder->GrandTotal;
        $ESTATUS = $fullOrder->StatusName;
        $PAYSTA = $fullOrder->PaymentStatus;
        $PAYDAT = $fullOrder->PaymentDate;
        $PAYREFNUM = (!empty($fullOrder->Payments->OrderPayment->TransactionReferenceNumber)) ? $fullOrder->Payments->OrderPayment->TransactionReferenceNumber : "";
        $PAYMET = (!empty($fullOrder->Payments->OrderPayment->PaymentMethod)) ? $fullOrder->Payments->OrderPayment->PaymentMethod : "";
        $SHISTA = $fullOrder->ShippingStatus;
        $SHIPDATE = $fullOrder->ShipDate;
        $SHIFEE = $fullOrder->Packages->Package->FinalShippingFee; //rev
        if($SHIFEE == 0){
            $SHIFEE = $fullOrder->Packages->Package->ShippingCost;
        }
        $SHIFIRNAM = $fullOrder->ShippingAddressOriginal->FirstName;
        $SHILASNAM = $fullOrder->ShippingAddressOriginal->LastName;
        $SHIADD1 = $fullOrder->ShippingAddressOriginal->StreetLine1;
        $SHIADD2 = $fullOrder->ShippingAddressOriginal->StreetLine2;
        $SHIPCITY = $fullOrder->ShippingAddressOriginal->City;
        $SHIPSTATE = $fullOrder->ShippingAddressOriginal->StateName;
//        $SHIPSTATE = getCorrectState($ORDERID, $fullOrder->ShippingAddressOriginal->PostalCode, $fullOrder->ShippingAddressOriginal->StateName)[0];
        $SHIZIPCOD = $fullOrder->ShippingAddressOriginal->PostalCode;
        $SHICOU = $this->getCountryName($fullOrder->ShippingCountry); //codeco, nombri,
        $SHIPHONUM = $fullOrder->ShippingAddressOriginal->PhoneNumber;
        $ORDSOU = $fullOrder->OrderSource;
        $ORDSOUORDI = $fullOrder->OrderSourceOrderId;
        $EBAYSALREC = $fullOrder->eBaySellingManagerSalesRecordNumber;
        $SHIMETSEL = $fullOrder->Packages->Package->ShippingMethodName;
        $ISRUSORD = $fullOrder->RushOrder == false ? "0" : "1";
        $INVPRI = $fullOrder->InvoicePrinted;
        $INVPRIDAT = $fullOrder->InvoicePrintedDate;
        $SHICAR = $fullOrder->ShippingCarrier;
        $COMPANYID = $fullOrder->CompanyId;
        $ORDSOUORDT = $fullOrder->OrderSourceOrderTotal;
        $STATIONID = $fullOrder->StationID;
        $CUSSERSTA = $fullOrder->CustomerServiceStatus;
        $TAXRATE = $fullOrder->TaxRate;
        $TAXTOTAL = $fullOrder->TaxTotal;
        $GOOORDNUM = $fullOrder->GoogleOrderNumber;
        $ISINDIS = $fullOrder->IsInDispute == false ? "0" : "1";
        $DISSTAON = $fullOrder->DisputeStartedOn;
        $PAYFEETOT = $fullOrder->PaypalFeeTotal;
        $POSFEETOT = $fullOrder->PostingFeeTotal;
        $FINVALTOT = $fullOrder->FinalValueTotal;
        $SHIWEITOTO = $fullOrder->Packages->Package->Weight;
        $TRANUM = $fullOrder->TrackingNumber;
        $LOCNOT = ''; //???
        $UPC = ''; //???
        $MARSOU = $fullOrder->MarkettingSourceID;
        $GIFTWRAP = $fullOrder->ShippingItems->OrderItem->GiftWrap == false ? "0" : "1";
        $MARDISCOUN = '';//???
        $CODMOVBOD = '';//???
        $CODPOLIZA = '';//???
        $CODCOS = '';//???
        $CODAMADET = '';//???
        $CODAMABAL = '';//???
        $ORDERUNITS = $fullOrder->OrderItemsCount;//???<
        $OLDSTATE = '';//???
//        $OLDSTATE = getCorrectState($ORDERID, $fullOrder->ShippingAddressOriginal->PostalCode, $fullOrder->ShippingAddressOriginal->StateName)[1];
        $LIQID = '';//?1??
        $SHIAMOCAR = '';//???
        $LIQID2 = '';//???
        $LIQID3 = '';//???
        $LIQID4 = '';//???
        $LIQID5 = '';//???
//        $CODPROV = '';//???
        $NUMORDEN = '';//???
        $CODTORDEN = 'ONL';//???
        $NOMBRE = '';//???
        $CODUSUA = '';//???
        $CODPROVE = '';//???
        $FECHA = '';//???
        $FCHESPERA = '';//???
        $VALOR = '';//???
        $ABONOS = '';//???
        $CODAUTO = '';//???
        $FCHAUTO = '';//???
        $ANTICIPO = '';//???
        $PAGOS = '';//???
        $CONDPAGO = '';//???
        $DIASCRED = '';//???
        $CODMONE = '';//???
        $TCAMBIO = '';//???
        $CODEMPLCH = '';//???
        $LIQCC = '';//???
        $NUMPEDIDO = '';//???
        $CODPEDIDO = '';//???
        $CODCATPED = '';//???
        $CODBOD = '';//???
        $CODPROY = '';//???
        $NOTIPROV = '';//???
        $BITCOBRO = '';//???
        $PACKAGETYPE = ($fullOrder->PackageType != "") ? $fullOrder->PackageType : "Default";

        $FIRSTNAME = addslashes($FIRSTNAME);
        $LASTNAME = addslashes($LASTNAME);
        $SHIFIRNAM = addslashes($SHIFIRNAM);
        $SHILASNAM = addslashes($SHILASNAM);
        $ordEncQuery = "INSERT INTO tra_ord_enc
                        (CODORDEN, ORDERID, KITITEMID, USERID, USERNAME, FIRSTNAME, LASTNAME, SITECODE, TIMOFORD, SUBTOTAL, SHITOT, ORDDISTOT, GRANDTOTAL, ESTATUS, PAYSTA, PAYDAT, PAYREFNUM, PAYMET, SHISTA, SHIPDATE, SHIFEE, SHIFIRNAM, SHILASNAM, SHIADD1, SHIADD2, SHIPCITY, SHIPSTATE, SHIZIPCOD, SHICOU, SHIPHONUM, ORDSOU, ORDSOUORDI, EBAYSALREC, SHIMETSEL, ISRUSORD, INVPRI, INVPRIDAT, SHICAR, COMPANYID, ORDSOUORDT, STATIONID, CUSSERSTA, TAXRATE, TAXTOTAL, GOOORDNUM, ISINDIS, DISSTAON, PAYFEETOT, POSFEETOT, FINVALTOT, SHIWEITOTO, TRANUM, LOCNOT, UPC, MARSOU, GIFTWRAP, MARDISCOUN, CODMOVBOD, CODPOLIZA, CODCOS, CODAMADET, CODAMABAL, ORDERUNITS, OLDSTATE, LIQID, SHIAMOCAR, LIQID2, LIQID3, LIQID4, LIQID5, NUMORDEN, CODTORDEN, NOMBRE, CODUSUA, CODPROVE, FECHA, FCHESPERA, VALOR, ABONOS, CODAUTO, FCHAUTO, ANTICIPO, PAGOS, CONDPAGO, DIASCRED, CODMONE, TCAMBIO, CODEMPLCH, LIQCC, NUMPEDIDO, CODPEDIDO, CODCATPED, CODBOD, CODPROY, NOTIPROV, BITCOBRO, PACKAGETYPE)
                        VALUES
                        ('$CODORDEN', '$ORDERID', '$KITITEMID', '$USERID', '$USERNAME', '$FIRSTNAME', '$LASTNAME', '$SITECODE', '$TIMOFORD', '$SUBTOTAL', '$SHITOT', '$ORDDISTOT', '$GRANDTOTAL', '$ESTATUS', '$PAYSTA', '$PAYDAT', '$PAYREFNUM', '$PAYMET', '$SHISTA', '$SHIPDATE', '$SHIFEE', '$SHIFIRNAM', '$SHILASNAM', '$SHIADD1', '$SHIADD2', '$SHIPCITY', '$SHIPSTATE', '$SHIZIPCOD', '$SHICOU', '$SHIPHONUM', '$ORDSOU', '$ORDSOUORDI', '$EBAYSALREC', '$SHIMETSEL', '$ISRUSORD', '$INVPRI', '$INVPRIDAT', '$SHICAR', '$COMPANYID', '$ORDSOUORDT', '$STATIONID', '$CUSSERSTA', '$TAXRATE', '$TAXTOTAL', '$GOOORDNUM', '$ISINDIS', '$DISSTAON', '$PAYFEETOT', '$POSFEETOT', '$FINVALTOT', '$SHIWEITOTO', '$TRANUM', '$LOCNOT', '$UPC', '$MARSOU', '$GIFTWRAP', '$MARDISCOUN', '$CODMOVBOD', '$CODPOLIZA', '$CODCOS', '$CODAMADET', '$CODAMABAL', '$ORDERUNITS', '$OLDSTATE', '$LIQID', '$SHIAMOCAR', '$LIQID2', '$LIQID3', '$LIQID4', '$LIQID5', '$NUMORDEN', '$CODTORDEN', '$NOMBRE', '$CODUSUA', '$CODPROVE', '$FECHA', '$FCHESPERA', '$VALOR', '$ABONOS', '$CODAUTO', '$FCHAUTO', '$ANTICIPO', '$PAGOS', '$CONDPAGO', '$DIASCRED', '$CODMONE', '$TCAMBIO', '$CODEMPLCH', '$LIQCC', '$NUMPEDIDO', '$CODPEDIDO', '$CODCATPED', '$CODBOD', '$CODPROY', '$NOTIPROV', '$BITCOBRO', '$PACKAGETYPE');";
        $result = mysqli_query(conexion($country), $ordEncQuery);
        if ($result) {
            $this->insertOrderDetail($CODORDEN, $fullOrder, $country);
        }

        $this->processNotes($CODORDEN, $fullOrder->Notes->OrderNote, $country);
    }

    public function processNotes($codOrden, $notes, $country){
        if(count($notes) == 1){
            $notes = [$notes];
        }
//        echo "<br>COUNT:" . count($notes) . "<br>";
//        var_dump($notes);
        foreach ($notes as $note) {
            $id = $note->ID;
            $orderId = $codOrden;
            $date = $note->AuditDate;
            $createdBy = $note->CreatedBy;
            $text = $note->Note;
//            echo "<br>$text<br>";
            if ($createdBy != -1 && $createdBy != 0) {
                $processNoteQ = "
                    INSERT INTO 
                        tra_sc_not 
                        (id, orderid, `date`, createdby, note)
                    values
                        ('$id', '$orderId', '$date', '$createdBy', '$text')
                    on duplicate key update id = '$id';
                ";
//                echo "<br>$processNoteQ<br>";
                mysqli_query(conexion($country), $processNoteQ);
            }
        }
    }

    function insertOrderDetail($codOrden, $fullOrder, $country) {
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");
        if(count($fullOrder->Items->OrderItem) == 1){
            $items = $fullOrder->Items;
        }
        else{
            $items = $fullOrder->Items->OrderItem;
        }
        $cont = 0;
        foreach ($items as $orderItem) {
            $CODDETORD = sys2015();
            $CODORDEN = $codOrden;
            $ORDITEID = $fullOrder->Packages->Package->OrderItemID;
            $PRODUCTID = $orderItem->ProductID;
            $QTY = $orderItem->Qty;
            $DISNAM = $orderItem->DisplayName;
            $LINETOTAL = $orderItem->LineTotal;
            $EBAYITEMID = $orderItem->eBayItemID;
            $BACORDQTY = $orderItem->BackOrderQty;
            $ORIUNIPRI = $orderItem->SitePrice;
            $ORISHICOS = '';
            $ADJSHICOS = $fullOrder->Packages->Package->FinalShippingFee;
            $ADJUNIPRI = $orderItem->AdjustedSitePrice;
            $INVAVAQTY = '';
            $UPC = '';
            $CODAMABAL = '';
            $QUAPUR = '';
            $LIQID = '';
            $bucle = '';
            $CODORDEND = '';
            $CODPROD = '';
            $CANTIDAD = '';
            $CANFACT = '';
            $CANINV = '';
            $PRECIO = '';
            $TOTAL = '';
            $BUNDLESKU = $fullOrder->ShippingItems->OrderItem->ProductIDOriginal;

            $tCodProv = $this->getCodProv($BUNDLESKU);
            if ($tCodProv != "") {
                $CODPROV = $tCodProv;
                $update = "UPDATE tra_ord_enc SET CODPROV = '$CODPROV' WHERE CODORDEN = '$CODORDEN';";
                mysqli_query(conexion($country), $update);
            }

            if ($CODORDEN != "" && $cont == 0) {
                include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
                $delete = "DELETE FROM tra_ord_det WHERE CODORDEN = '$CODORDEN';";
                mysqli_query(conexion($country), $delete);
            }
            $ordDetQuery = "INSERT INTO tra_ord_det 
                            (CODDETORD, CODORDEN, ORDITEID, PRODUCTID, QTY, DISNAM, LINETOTAL, EBAYITEMID, BACORDQTY, ORIUNIPRI, ORISHICOS, ADJUNIPRI, ADJSHICOS, INVAVAQTY, UPC, CODAMABAL, QUAPUR, LIQID, bucle, CODORDEND, CODPROD, CANTIDAD, CANFACT, CANINV, PRECIO, TOTAL, BUNDLESKU) 
                            VALUES
                            ('$CODDETORD', '$CODORDEN', '$ORDITEID', '$PRODUCTID', '$QTY', '$DISNAM', '$LINETOTAL', '$EBAYITEMID', '$BACORDQTY', '$ORIUNIPRI', '$ORISHICOS', '$ADJUNIPRI', '$ADJSHICOS', '$INVAVAQTY', '$UPC', '$CODAMABAL', '$QUAPUR', '$LIQID', '$bucle', '$CODORDEND', '$CODPROD', '$CANTIDAD', '$CANFACT', '$CANINV', '$PRECIO', '$TOTAL', '$BUNDLESKU');";

            mysqli_query(conexion($country), $ordDetQuery);

            $cont += 1;
        }
    }

    function updateOrder($codOrden, $fullOrder, $country) {
        include_once ("getCorrectState.php");
        $CODORDEN = $codOrden;
        $ESTATUS = $fullOrder->StatusName;
        $PAYSTA = $fullOrder->PaymentStatus;
        $PAYDAT = $fullOrder->PaymentDate;
        $PAYREFNUM = (!empty($fullOrder->Payments->OrderPayment->TransactionReferenceNumber)) ? $fullOrder->Payments->OrderPayment->TransactionReferenceNumber : "";
        $PAYMET = (!empty($fullOrder->Payments->OrderPayment->PaymentMethod)) ? $fullOrder->Payments->OrderPayment->PaymentMethod : "";
        $SHISTA = $fullOrder->ShippingStatus;
        $SHIPDATE = $fullOrder->ShipDate;
        $SHIFEE = $fullOrder->Packages->Package->FinalShippingFee; //rev
        $SHIFIRNAM = $fullOrder->ShippingAddressOriginal->FirstName;
        $SHILASNAM = $fullOrder->ShippingAddressOriginal->LastName;
        $SHIADD1 = $fullOrder->ShippingAddressOriginal->StreetLine1;
        $SHIADD2 = $fullOrder->ShippingAddressOriginal->StreetLine2;
        $SHIPCITY = $fullOrder->ShippingAddressOriginal->City;
        $SHIZIPCOD = $fullOrder->ShippingAddressOriginal->PostalCode;
        $SHICOU = $this->getCountryName($fullOrder->ShippingCountry);
        $SHIPHONUM = $fullOrder->ShippingAddressOriginal->PhoneNumber;
        $SHIMETSEL = $fullOrder->Packages->Package->ShippingMethodName;
        $SHICAR = $fullOrder->ShippingCarrier;
        $ISINDIS = $fullOrder->IsInDispute == false ? "0" : "1";
        $TRANUM = $fullOrder->TrackingNumber;
//        $SHIPSTATE = getCorrectState($CODORDEN, $fullOrder->ShippingAddressOriginal->PostalCode, $fullOrder->ShippingAddressOriginal->StateName)[0];
//        $OLDSTATE = getCorrectState($CODORDEN, $fullOrder->ShippingAddressOriginal->PostalCode, $fullOrder->ShippingAddressOriginal->StateName)[1];
        $CODMOVBOD = '';//???
        $BUNDLESKU = (!empty($fullOrder->Items->OrderItem->ProductIDOriginal)) ? $fullOrder->Items->OrderItem->ProductIDOriginal : (!empty($fullOrder->ShippingItems->OrderItem->ProductIDOriginal)) ? $fullOrder->ShippingItems->OrderItem->ProductIDOriginal : "";

        if(count($fullOrder->Items->OrderItem) > 1){
            $BUNDLESKU = $fullOrder->Items->OrderItem[0]->ProductIDOriginal;
        }

        $tCodProv = $this->getCodProv($BUNDLESKU);
        if ($tCodProv != "") {
            $CODPROV = $tCodProv;
        }

        $ordEncUpdateQuery = "
            UPDATE tra_ord_enc SET
            ESTATUS = '$ESTATUS',
            PAYSTA = '$PAYSTA',
            PAYDAT = '$PAYDAT',
            PAYREFNUM = '$PAYREFNUM',
            PAYMET = '$PAYMET',
            SHISTA = '$SHISTA',
            SHIPDATE = '$SHIPDATE',
            SHIFEE = '$SHIFEE',
            SHIFIRNAM = '$SHIFIRNAM',
            SHILASNAM = '$SHILASNAM',
            SHIADD1 = '$SHIADD1',
            SHIADD2 = '$SHIADD2',
            SHIPCITY = '$SHIPCITY',
            SHIZIPCOD = '$SHIZIPCOD',
            SHICOU = '$SHICOU',
            SHIPHONUM = '$SHIPHONUM',
            SHIMETSEL = '$SHIMETSEL',
            SHICAR = '$SHICAR',
            ISINDIS = '$ISINDIS',
            TRANUM = '$TRANUM',
            CODPROV = $CODPROV
            WHERE CODORDEN = '$CODORDEN';";

        mysqli_query(conexion($country), $ordEncUpdateQuery);

        $checkOrderDetailQuery = "SELECT * FROM tra_ord_det WHERE CODORDEN = '$CODORDEN';";
        $checkOrderDetailResult = mysqli_query(conexion($country), $checkOrderDetailQuery);

        if ($checkOrderDetailResult->num_rows == 0) {
            $this->insertOrderDetail($CODORDEN, $fullOrder, $country);
        }
        $this->processNotes($CODORDEN, $fullOrder->Notes->OrderNote, $country);
    }

    public function processPolicies($country, $initialDate = "", $finalDate = "") {
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");
        $dateFilter = "";
        if($initialDate != "" && $finalDate != ""){
            $dateFilter = "AND TIMOFORD BETWEEN '$initialDate-01 00:00:00' AND '$finalDate-31 23:59:59'";
        }
        $getOrdersQuery = "SELECT * FROM tra_ord_enc WHERE CODPOLIZA = '' $dateFilter ORDER BY TIMOFORD;";
        $getOrdersData = mysqli_query(conexion($country), $getOrdersQuery);
        $counter = 0;

        foreach ($getOrdersData as $item) {
            $counter += 1;
            $tOrderId = $item["ORDERID"];
            $tDate = explode(" ", $item["TIMOFORD"])[0];
            $tPeri = $this->getPeri($tDate);

            $TIPO = "PO";
            $NUMERO = "(SELECT CAST(NUMERO + 1 AS UNSIGNED) FROM (SELECT NUMERO FROM tra_pol_enc) sub ORDER BY CAST(NUMERO AS UNSIGNED) DESC LIMIT 1)";
            $OLDNUMERO = "";
            $FECHA = $tDate;
            $TASACAMBIO = "1";
            $CODDOCTO = "";
            $NUMDOCTO = "";
            $NUDOCTO = "";
            $CODPERI = $tPeri;
            $ESTATUS = "";
            $CONCILIA = "";

            $CODPOLIZA = sys2015();
            $POLIZAREF = $CODPOLIZA;
            $incomePolicyQuery = $this->getIncomePolicyEncQuery($country, $tOrderId, $tDate, $CODPOLIZA, $TIPO, $NUMERO, $OLDNUMERO, $FECHA, $TASACAMBIO, $CODDOCTO, $NUMDOCTO, $NUDOCTO, $CODPERI, $ESTATUS, $CONCILIA);
            mysqli_query(conexion($country), $incomePolicyQuery);
            $this->polizaIngreso($CODPOLIZA, $item, $country);

            $CODPOLIZA = sys2015();
            $costPolicyQuery = $this->getCostPolicyEncQuery($country, $tOrderId, $tDate, $CODPOLIZA, $TIPO, $NUMERO, $OLDNUMERO, $FECHA, $TASACAMBIO, $CODDOCTO, $NUMDOCTO, $NUDOCTO, $CODPERI, $ESTATUS, $CONCILIA);
            mysqli_query(conexion($country), $costPolicyQuery);
            $this->polizaCosto($CODPOLIZA, $item, $country);

            $updateEncQuery = "UPDATE tra_ord_enc SET CODPOLIZA = '$POLIZAREF' WHERE CODORDEN = '" . $item["CODORDEN"] . "';";
            mysqli_query(conexion($country), $updateEncQuery);
        }
        return $counter;
    }

    function getIncomePolicyEncQuery($country, $tOrderId, $tDate, $CODPOLIZA, $TIPO, $NUMERO, $OLDNUMERO, $FECHA, $TASACAMBIO, $CODDOCTO, $NUMDOCTO, $NUDOCTO, $CODPERI, $ESTATUS, $CONCILIA){
        $findPolicyQuery = "SELECT * FROM tra_pol_enc WHERE DESCRIPCIO LIKE 'Revenue recognition policy of the day $tDate%';";
        $findPolicyResult = mysqli_query(conexion($country), $findPolicyQuery);
        $records = mysqli_fetch_array($findPolicyResult);

        if ($findPolicyResult->num_rows == 0) {
            $DESCRIPCIO = "Revenue recognition policy of the day $tDate $tOrderId";
            $policyEncQuery = "
                    INSERT INTO tra_pol_enc 
                    (CODPOLIZA, TIPO, NUMERO, OLDNUMERO, FECHA, TASACAMBIO, CODDOCTO, NUMDOCTO, NUDOCTO, CODPERI, ESTATUS, DESCRIPCIO, CONCILIA) 
                    VALUES 
                    ('$CODPOLIZA', '$TIPO', $NUMERO, '$OLDNUMERO', '$FECHA', '$TASACAMBIO', '$CODDOCTO', '$NUMDOCTO', '$NUDOCTO', '$CODPERI', '$ESTATUS', '$DESCRIPCIO', '$CONCILIA');";
        } else {
            $CODPOLIZA = $records[0];
            $tDescripcio = $records[11];
            if (strpos($tDescripcio, $tOrderId) !== true) {
                $DESCRIPCIO = $tDescripcio . " " . $tOrderId;
                $policyEncQuery = "
                        UPDATE tra_pol_enc 
                        SET DESCRIPCIO='$DESCRIPCIO' WHERE CODPOLIZA = '" . $CODPOLIZA . "';";
            }
        }
        return $policyEncQuery;
    }

    function getCostPolicyEncQuery($country, $tOrderId, $tDate, $CODPOLIZA, $TIPO, $NUMERO, $OLDNUMERO, $FECHA, $TASACAMBIO, $CODDOCTO, $NUMDOCTO, $NUDOCTO, $CODPERI, $ESTATUS, $CONCILIA){
        $findPolicyQuery = "SELECT * FROM tra_pol_enc WHERE DESCRIPCIO LIKE 'Cost recognition policy of the day $tDate%';";
        $findPolicyResult = mysqli_query(conexion($country), $findPolicyQuery);
        $records = mysqli_fetch_array($findPolicyResult);

        if ($findPolicyResult->num_rows == 0) {
            $DESCRIPCIO = "Cost recognition policy of the day $tDate $tOrderId";
            $policyEncQuery = "
                    INSERT INTO tra_pol_enc
                    (CODPOLIZA, TIPO, NUMERO, OLDNUMERO, FECHA, TASACAMBIO, CODDOCTO, NUMDOCTO, NUDOCTO, CODPERI, ESTATUS, DESCRIPCIO, CONCILIA)
                    VALUES
                    ('$CODPOLIZA', '$TIPO', $NUMERO, '$OLDNUMERO', '$FECHA', '$TASACAMBIO', '$CODDOCTO', '$NUMDOCTO', '$NUDOCTO', '$CODPERI', '$ESTATUS', '$DESCRIPCIO', '$CONCILIA');";
        } else {
            $CODPOLIZA = $records[0];
            $tDescripcio = $records[11];
            if (strpos($tDescripcio, $tOrderId) !== true) {
                $DESCRIPCIO = $tDescripcio . " " . $tOrderId;
                $policyEncQuery = "
                        UPDATE tra_pol_enc
                        SET DESCRIPCIO='$DESCRIPCIO' WHERE CODPOLIZA = '" . $CODPOLIZA . "';";
            }
        }
        return $policyEncQuery;
    }

    function polizaIngreso($codPoliza, $item, $country) {
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
        $CODDPOL = sys2015();

        $CODPOLIZA = $codPoliza;
        $CUENTAOLD = "";

        $getCtaPagoQuery = "SELECT CTAPAGO FROM cat_empresas WHERE companyid = '" . $item["COMPANYID"] . "';";
        $getCtaCobroQuery = "SELECT CUENTACOB FROM cat_pay_mdo WHERE nombre = '" . $item["PAYMET"] . "';";
        $getCtaIngresoQuery = "SELECT CUENTAING FROM cat_sal_cha WHERE CODORDER = '" . $item["ORDSOU"] . "';";

        $ctaPago = getSingleValue($getCtaPagoQuery);
        $ctaCobro = getSingleValue($getCtaCobroQuery);
        $ctaIngreso = getSingleValue($getCtaIngresoQuery, $country);

        //debe
        $getOrdenQuery = "SELECT ORDEN FROM tra_pol_det AS det INNER JOIN tra_pol_enc AS enc ON det.CODPOLIZA = enc.CODPOLIZA WHERE enc.CODPOLIZA = '$CODPOLIZA' ORDER BY ORDEN DESC LIMIT 1;";
        $ORDEN = getSingleValue($getOrdenQuery, $country);
        $ORDEN = intval($ORDEN) + 1;

        $CUENTA = $ctaCobro;
        $DEBE = $item["GRANDTOTAL"];
        $findCtaQuery = "SELECT * FROM tra_pol_det WHERE CODPOLIZA = '$CODPOLIZA' AND CUENTA = '$CUENTA';";

        $this->mailNotification($CUENTA, $getCtaCobroQuery);

        $findCtaResult = mysqli_query(conexion($country), $findCtaQuery);
        if ($findCtaResult->num_rows == 0) {
            $QRY = "
                INSERT INTO tra_pol_det (CODDPOL, CODPOLIZA, CUENTA, DEBE, ORDEN, CUENTAOLD)
                VALUES
                ('$CODDPOL', '$CODPOLIZA', '$CUENTA', '$DEBE', '$ORDEN', '$CUENTAOLD');";
        } else {
            $findCtaRow = mysqli_fetch_array($findCtaResult)[3];
            $QRY = "UPDATE tra_pol_det SET DEBE = '" . ($DEBE + floatval($findCtaRow)) . "' WHERE CODPOLIZA = '$CODPOLIZA' AND CUENTA = '$CUENTA';";
        }
        mysqli_query(conexion($country), $QRY);

        //haber
        $CODDPOL = sys2015();
        $getOrdenQuery = "SELECT ORDEN FROM tra_pol_det AS det INNER JOIN tra_pol_enc AS enc ON det.CODPOLIZA = enc.CODPOLIZA WHERE enc.CODPOLIZA = '$CODPOLIZA' ORDER BY ORDEN DESC LIMIT 1;";
        $ORDEN = getSingleValue($getOrdenQuery, $country);
        $ORDEN = intval($ORDEN) + 1;

        $CUENTA = ($ctaPago != '') ? $ctaPago : $ctaIngreso;
        $HABER = $item["GRANDTOTAL"];
        $findCtaQuery = "SELECT * FROM tra_pol_det WHERE CODPOLIZA = '$CODPOLIZA' AND CUENTA = '$CUENTA';";

        $this->mailNotification($CUENTA, ($ctaPago != '') ? $getCtaPagoQuery : $getCtaIngresoQuery);

        $findCtaResult = mysqli_query(conexion($country), $findCtaQuery);
        if ($findCtaResult->num_rows == 0) {
            $QRY = "
                INSERT INTO tra_pol_det (CODDPOL, CODPOLIZA, CUENTA, HABER, ORDEN, CUENTAOLD)
                VALUES
                ('$CODDPOL', '$CODPOLIZA', '$CUENTA', '$HABER', '$ORDEN', '$CUENTAOLD');";
        } else {
            $findCtaRow = mysqli_fetch_array($findCtaResult)[4];
            $QRY = "UPDATE tra_pol_det SET HABER = '" . ($HABER + floatval($findCtaRow)) . "' WHERE CODPOLIZA = '$CODPOLIZA' AND CUENTA = '$CUENTA';";
        }
        mysqli_query(conexion($country), $QRY);
    }

    function polizaCosto($codPoliza, $item, $country) {
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

        $codorden = $item["CODORDEN"];
        $amountQuery = "SELECT det.PRECIO FROM tra_factcomdet AS det INNER JOIN tra_factcomenc AS enc ON det.CODFACTCOM = enc.CODFACTCOM WHERE CODPROD = (SELECT CODPROD FROM cat_prod WHERE MASTERSKU = (SELECT MASTERSKU FROM tra_bun_det WHERE MASTERSKU = (SELECT PRODUCTID FROM tra_ord_det WHERE CODORDEN = '$codorden') OR AMAZONSKU = (SELECT PRODUCTID FROM tra_ord_det WHERE CODORDEN = '$codorden') LIMIT 1)) AND det.SALIDAS = '0.00000' ORDER BY enc.FECHA;";
        $amount = getSingleValue($amountQuery, $country);

        $debeQuery = "SELECT CTAGASTO FROM cat_prod WHERE MASTERSKU = (SELECT MASTERSKU FROM tra_bun_det WHERE MASTERSKU = (SELECT PRODUCTID FROM tra_ord_det WHERE CODORDEN = '$codorden') OR AMAZONSKU = (SELECT PRODUCTID FROM tra_ord_det WHERE CODORDEN = '$codorden') LIMIT 1);";
        $debe = getSingleValue($debeQuery, $country);
        $this->mailNotification($debe, $debeQuery);

        $ordsou = $item["ORDSOU"];
        $haberQuery = "SELECT CUENTAINV FROM cat_sal_cha WHERE CODORDER = '$ordsou';";
        $haber = getSingleValue($haberQuery, $country);
        $this->mailNotification($haber, $haberQuery);

        $CODDPOL = sys2015();
        $CODPOLIZA = $codPoliza;
        $CUENTAOLD = "";

        //debe
        $getOrdenQuery = "SELECT ORDEN FROM tra_pol_det AS det INNER JOIN tra_pol_enc AS enc ON det.CODPOLIZA = enc.CODPOLIZA WHERE enc.CODPOLIZA = '$CODPOLIZA' ORDER BY ORDEN DESC LIMIT 1;";
        $ORDEN = getSingleValue($getOrdenQuery, $country);
        $ORDEN = intval($ORDEN) + 1;

        $CUENTA = $debe;
        $DEBE = $amount;
        $findCtaQuery = "SELECT * FROM tra_pol_det WHERE CODPOLIZA = '$CODPOLIZA' AND CUENTA = '$CUENTA';";

        $findCtaResult = mysqli_query(conexion($country), $findCtaQuery);
        if ($findCtaResult->num_rows == 0) {
            $QRY = "
                INSERT INTO tra_pol_det (CODDPOL, CODPOLIZA, CUENTA, DEBE, ORDEN, CUENTAOLD)
                VALUES
                ('$CODDPOL', '$CODPOLIZA', '$CUENTA', '$DEBE', '$ORDEN', '$CUENTAOLD');";
        } else {
            $findCtaRow = mysqli_fetch_array($findCtaResult)[3];
            $QRY = "UPDATE tra_pol_det SET DEBE = '" . ($DEBE + floatval($findCtaRow)) . "' WHERE CODPOLIZA = '$CODPOLIZA' AND CUENTA = '$CUENTA';";
        }
        mysqli_query(conexion($country), $QRY);

        //haber
        $CODDPOL = sys2015();
        $getOrdenQuery = "SELECT ORDEN FROM tra_pol_det AS det INNER JOIN tra_pol_enc AS enc ON det.CODPOLIZA = enc.CODPOLIZA WHERE enc.CODPOLIZA = '$CODPOLIZA' ORDER BY ORDEN DESC LIMIT 1;";
        $ORDEN = getSingleValue($getOrdenQuery, $country);
        $ORDEN = intval($ORDEN) + 1;

        $CUENTA = $haber;
        $HABER = $amount;
        $findCtaQuery = "SELECT * FROM tra_pol_det WHERE CODPOLIZA = '$CODPOLIZA' AND CUENTA = '$CUENTA';";

        $findCtaResult = mysqli_query(conexion($country), $findCtaQuery);
        if ($findCtaResult->num_rows == 0) {
            $QRY = "
                INSERT INTO tra_pol_det (CODDPOL, CODPOLIZA, CUENTA, HABER, ORDEN, CUENTAOLD)
                VALUES
                ('$CODDPOL', '$CODPOLIZA', '$CUENTA', '$HABER', '$ORDEN', '$CUENTAOLD');";
        } else {
            $findCtaRow = mysqli_fetch_array($findCtaResult)[4];
            $QRY = "UPDATE tra_pol_det SET HABER = '" . ($HABER + floatval($findCtaRow)) . "' WHERE CODPOLIZA = '$CODPOLIZA' AND CUENTA = '$CUENTA';";
        }
        mysqli_query(conexion($country), $QRY);
    }

    public function processWarehouses($country, $initialDate = "", $finalDate = "") {
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");
        $dateFilter = "";
        if($initialDate != "" && $finalDate != ""){
                $dateFilter = "AND TIMOFORD BETWEEN '$initialDate-01 00:00:00' AND '$finalDate-31 23:59:59'";
        }
        $getOrdersQuery = "
            SELECT 
                *
            FROM
                tra_ord_enc
            WHERE
                CODMOVBOD = '' AND tranum != ''
                    AND (ESTATUS != 'Cancelled'
                    OR ESTATUS != 'Canceled');
        "; // $dateFilter;
//        $getOrdersQuery = "SELECT * FROM tra_ord_enc WHERE orderid = '5530874'"; // $dateFilter;
//        echo "$getOrdersQuery<br>";
        $getOrdersData = mysqli_query(conexion($country), $getOrdersQuery);
        $counter = 0;
        $tNumQ = "SELECT NUMERO FROM tra_mob_enc ORDER BY CAST(NUMERO AS UNSIGNED) DESC LIMIT 1;";
        $tNum = getSingleValue($tNumQ, $country);

        foreach ($getOrdersData as $item) {

            //obser items
            $codMovBod = $item["CODMOVBOD"];
            $orderId = $item["ORDERID"];
            $orderSource = $item["ORDSOU"];
            $shipCity = $item["SHIPCITY"];
            $shipState = $item["SHIPSTATE"];
            $shipCountry = $item["SHICOU"];
            $firstName = $item["FIRSTNAME"];
            $lastName = $item["LASTNAME"];
            $tName = "$firstName $lastName";

            echo "OID: $orderId<br>";


            $checkQ = "
                select * from tra_mob_enc where obser like '%$orderId%';
            ";

            $checkR = mysqli_query(conexion($country), $checkQ);

            if($checkR->num_rows == 0){
                $counter += 1;
                $tNum += 1;
                $ORDERID = $item["ORDERID"];
                $CODMOVBOD = sys2015();
                $TIPOMOV = "SB";
                $NUMERO = $tNum;
                $FECHA = $item["TIMOFORD"];
                $CODBOD = "(SELECT BODEGA FROM cat_sal_cha WHERE CODORDER = '" . $item["ORDSOU"] . "')";
                $SOLICITA = "";
                $CODPROY = "";
//            $OBSER = "Despacho de Orden " . $item["ORDSOU"] . " - " . $ORDERID;
//            $OBSER = "Orden:$orderId, Canal:$orderSource, Ciudad:$shipCity, Estado:$shipState, Pais:$shipCountry"; // WHERE CODMOVBOD = '$codMovBod'
                $tOrdSou = strtoupper($orderSource);
                $OBSER = "Despacho de orden $orderId - $tOrdSou - $shipCity - $shipState - $shipCountry - $tName"; // WHERE CODMOVBOD = '$codMovBod'
                $ORDENCOMP = "FV" . $ORDERID;
                $CODPROVE = $item["CODPROV"];
                $CODCLIE = "(SELECT CODCHAN FROM cat_sal_cha WHERE CODORDER = '" . $item["ORDSOU"] . "')";
                $warehouseMovementEncQuery = "
                INSERT INTO tra_mob_enc
                (CODMOVBOD, TIPOMOV, NUMERO, FECHA, CODBOD, SOLICITA, CODPROY, OBSER, ORDENCOMP, CODPROVE, CODCLIE)
                VALUES
                ('$CODMOVBOD', '$TIPOMOV', $NUMERO, '$FECHA', $CODBOD, '$SOLICITA', '$CODPROY', '$OBSER', '$ORDENCOMP', '$CODPROVE', $CODCLIE);";

                $res = $warehouseMovementResult = mysqli_query(conexion($country), $warehouseMovementEncQuery);

//            echo "<br>ENC:<br>$warehouseMovementEncQuery<br>";

                if ($warehouseMovementResult) {
                    $this->processWarehouseDetail($CODMOVBOD, $item, $CODBOD, $country);
                }
                $orderCodMobQuery = "UPDATE tra_ord_enc SET CODMOVBOD = '$CODMOVBOD' WHERE ORDERID = '$ORDERID';";

//            echo "<br>UP:<br>$orderCodMobQuery<br>";

//            echo "$orderCodMobQuery<br>";
                mysqli_query(conexion($country), $orderCodMobQuery);
            }
        }
        return $counter;
    }

    function processWarehouseDetail($codMovBod, $item, $codBod, $country) {
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");
        $getOrderDetailsQuery = "SELECT * FROM tra_ord_det WHERE CODORDEN = '" . $item["CODORDEN"] . "';";
        $getOrderDetailsResult = mysqli_query(conexion($country), $getOrderDetailsQuery);
        if ($getOrderDetailsResult) {
            if ($getOrderDetailsResult->num_rows > 0) {
                while($getOrderDetailsRow = mysqli_fetch_array($getOrderDetailsResult)){
                    $CODTMOV = sys2015();
                    $CODMOVBOD = $codMovBod;
//                $CODPROD = "(SELECT product.CODPROD FROM cat_prod AS product INNER JOIN tra_bun_det AS bundle ON bundle.MASTERSKU = product.MASTERSKU WHERE bundle.MASTERSKU = '" . $getOrderDetailsRow["PRODUCTID"] . "' OR AMAZONSKU = '" . $getOrderDetailsRow["PRODUCTID"] . "' LIMIT 1)";
//                $CANTIDAD = "(" . $getOrderDetailsRow["QTY"] . " * SELECT * FROM tra_bun_det WHERE MASTERSKU = '" . $getOrderDetailsRow["PRODUCTID"] . "' OR AMAZONSKU = '" . $getOrderDetailsRow["PRODUCTID"] . "'"; // AND CODCANAL =  (SELECT channel.CODCHAN FROM cat_sal_cha AS channel INNER JOIN tra_ord_enc as enc ON channel.CODORDER = enc.ORDSOU WHERE enc.CODORDEN = '".$item["CODORDEN"]."')
                    $OBSER = "";
                    $UBICACION = "";

                    //codprod
                    $tProductId = $getOrderDetailsRow["PRODUCTID"];
                    $codprodQ = "
                        SELECT 
                            product.CODPROD, product.CODTPROD
                        FROM
                            cat_prod AS product
                                INNER JOIN
                            tra_bun_det AS bundle ON bundle.MASTERSKU = product.MASTERSKU
                        WHERE
                            bundle.MASTERSKU = '$tProductId'
                                OR AMAZONSKU = '$tProductId'
                        LIMIT 1;
                    ";

                    $codprodR = mysqli_query(conexion($country), $codprodQ);
                    $codprodRow = mysqli_fetch_array($codprodR);
                    $CODPROD = $codprodRow["CODPROD"];
                    $CODTPROD = $codprodRow["CODTPROD"];

                    if($CODTPROD == "KIT"){
                        $kitProdsQ = "select codprokit, cantidad from cat_prod_kit where codprod = '$CODPROD';";
                        $kitProdsR = mysqli_query(conexion($country), $kitProdsQ);
                        while ($kitProdsRow = mysqli_fetch_array($kitProdsR)){
                            $CODTMOV = sys2015();
                            $tProductId = $kitProdsRow["codprokit"];
                            $tCantidadKit = $kitProdsRow["cantidad"];

//                            echo "<br>productid:<br>$tProductId<br>";
                            //cantidad
                            $cantidadQ = "
                                SELECT 
                                    UNITBUNDLE
                                FROM
                                    tra_bun_det
                                WHERE
                                    MASTERSKU = '$tProductId'
                                        OR AMAZONSKU = '$tProductId'
                                ORDER BY unitbundle
                                LIMIT 1;
                            ";


                            $cantidadR = mysqli_query(conexion($country), $cantidadQ);
                            $CANTIDAD = mysqli_fetch_array($cantidadR)[0];
                            $CANTIDAD = $getOrderDetailsRow["QTY"] * $CANTIDAD;

                            $checkDQ = "select CODTMOV, CANTIDAD from tra_mob_det where CODMOVBOD = '$CODMOVBOD' and CODPROD = '$tProductId';";
                            $checkDR = mysqli_query(conexion($country), $checkDQ);

                            if($checkDR->num_rows == 0){
                                $insertDetailQuery = "
                                    INSERT INTO tra_mob_det 
                                    (CODTMOV, CODMOVBOD, CODPROD, CANTIDAD, OBSER, UBICACION)
                                    VALUES
                                    ('$CODTMOV', '$CODMOVBOD', '$tProductId', '$CANTIDAD', '$OBSER', '$UBICACION');
                                ";

//                                echo "<br>DETAIL:<br>$insertDetailQuery<br><br>";
                                $res = mysqli_query(conexion($country), $insertDetailQuery);
                            }
                            else{
                                $checkDRow = mysqli_fetch_array($checkDR);
                                $tCantidadD = intval($checkDRow["CANTIDAD"]) + intval($CANTIDAD);
                                $tCodTMovD = $checkDRow["CODTMOV"];
                                $updateDetailQuery = "
                                    UPDATE tra_mob_det 
                                    SET
                                      CANTIDAD = '$tCantidadD'
                                    WHERE
                                      CODTMOV = '$tCodTMovD';
                                ";

//                                echo "<br>DETAIL:<br>$updateDetailQuery<br><br>";
                                $res = mysqli_query(conexion($country), $updateDetailQuery);
                            }

                            $exiProQuery = "SELECT * FROM tra_exi_pro WHERE CODPROD = $tProductId AND CODBODEGA = '$CODTMOV';";
//                            echo "check exipro:$exiProQuery<br>";
                            $exiProResult = mysqli_query(conexion($country), $exiProQuery);
                            if ($exiProResult) {
                                if ($exiProResult->num_rows > 0) {
                                    $exiProDQuery = "UPDATE tra_exi_pro SET EXISTENCIA = (EXISTENCIA - $CANTIDAD);";
                                } else {
                                    $CODEPROD = sys2015();
                                    $CODPROD = $tProductId;
                                    $CODBODEGA = $codBod;
                                    $EXISTENCIA = intval($getOrderDetailsRow["QTY"])  . intval($tCantidadKit);
                                    $exiProDQuery = "
                                        INSERT INTO tra_exi_pro
                                        (CODEPROD, CODPROD, CODBODEGA, EXISTENCIA)
                                        VALUES
                                        ('$CODEPROD', '$CODPROD', $CODBODEGA, '$EXISTENCIA  ');
                                    ";
                                }
//                                echo "<br>EXIPRO:<br>$exiProDQuery<br><br>";
                                mysqli_query(conexion($country), $exiProDQuery);
                            }
                        }
                    }
                    else{
                        //cantidad
                        $cantidadQ = "
                            SELECT 
                                UNITBUNDLE
                            FROM
                                tra_bun_det
                            WHERE
                                MASTERSKU = '$tProductId'
                                    OR AMAZONSKU = '$tProductId'
                            ORDER BY unitbundle
                            LIMIT 1;
                        ";

                        $cantidadR = mysqli_query(conexion($country), $cantidadQ);
                        $CANTIDAD = mysqli_fetch_array($cantidadR)[0];
                        $CANTIDAD = $getOrderDetailsRow["QTY"] * $CANTIDAD;

                        $checkDQ = "select CODTMOV, CANTIDAD from tra_mob_det where CODMOVBOD = '$CODMOVBOD' and CODPROD = '$CODPROD';";
                        $checkDR = mysqli_query(conexion($country), $checkDQ);

                        if($checkDR->num_rows == 0){
                            $insertDetailQuery = "
                                INSERT INTO tra_mob_det 
                                (CODTMOV, CODMOVBOD, CODPROD, CANTIDAD, OBSER, UBICACION)
                                VALUES
                                ('$CODTMOV', '$CODMOVBOD', '$CODPROD', '$CANTIDAD', '$OBSER', '$UBICACION');
                            ";

                            echo "<br>DETAIL:<br>$insertDetailQuery<br><br>";
                            $res = mysqli_query(conexion($country), $insertDetailQuery);
                        }
                        else{
                            $checkDRow = mysqli_fetch_array($checkDR);
                            $tCantidadD = intval($checkDRow["CANTIDAD"]) + intval($CANTIDAD);
                            $tCodTMovD = $checkDRow["CODTMOV"];
                            $updateDetailQuery = "
                                UPDATE tra_mob_det 
                                SET
                                  CANTIDAD = '$tCantidadD'
                                WHERE
                                  CODTMOV = '$tCodTMovD';
                            ";

                            echo "<br>DETAIL:<br>$updateDetailQuery<br><br>";
                            $res = mysqli_query(conexion($country), $updateDetailQuery);
                        }

                        $exiProQuery = "SELECT * FROM tra_exi_pro WHERE CODPROD = $CODPROD AND CODBODEGA = '$CODTMOV';";
                        $exiProResult = mysqli_query(conexion($country), $exiProQuery);
                        if ($exiProResult) {
                            if ($exiProResult->num_rows > 0) {
                                $exiProDQuery = "UPDATE tra_exi_pro SET EXISTENCIA = (EXISTENCIA - $CANTIDAD);";
                            } else {
                                $CODEPROD = sys2015();
                                $CODPROD = $CODPROD;
                                $CODBODEGA = $codBod;
                                $EXISTENCIA = "(" . $getOrderDetailsRow["QTY"] . " * (SELECT UNITBUNDLE FROM tra_bun_det WHERE MASTERSKU = '" . $getOrderDetailsRow["PRODUCTID"] . "' OR AMAZONSKU = '" . $getOrderDetailsRow["PRODUCTID"] . "' AND CODCANAL = (SELECT channel.CODCHAN FROM cat_sal_cha AS channel INNER JOIN tra_ord_enc as enc ON channel.CODORDER = enc.ORDSOU WHERE enc.CODORDEN = '".$item["CODORDEN"]."')))";
                                $exiProDQuery = "
                                    INSERT INTO tra_exi_pro
                                    (CODEPROD, CODPROD, CODBODEGA, EXISTENCIA)
                                    VALUES
                                    ('$CODEPROD', '$CODPROD', $CODBODEGA, $EXISTENCIA);
                                ";
                            }
                            mysqli_query(conexion($country), $exiProDQuery);
                        }
                    }
                }
            }
        }
    }

    public function updateShippingDimensions($orders, $country) {
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/sellercloud/sellercloud.php");
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/lib/PHPMailer-master/PHPMailerAutoload.php");
        $sellercloud = new sellercloud();
        $newCounter = 0;
        $mailCounter = 0;
        foreach ($orders as $order) {

//            echo "W:" . $order->OrderID . "<br>";
            $fullOrder = $sellercloud->getOrderFull($order->OrderID);
            $fullOrder = $fullOrder->GetOrderFullResult;

            if(count($fullOrder->Items->OrderItem) == 1){
                $tProductId = $fullOrder->Items->OrderItem->ProductID;
//                echo "one: " . $tProductId . "<br>";
                $tLength = $fullOrder->Packages->Package->Length;
                $tWidth = $fullOrder->Packages->Package->Width;
                $tHeight = $fullOrder->Packages->Package->Height;

                if($tLength != 0 && $tWidth != 0 && $tHeight != 0){
//                    echo "$tLength - $tWidth - $tHeight<br>";
                    $productDimensionsQ ="
                        SELECT 
                            ALTO, ANCHO, LARGO
                        FROM
                            tra_bun_det
                        WHERE
                            amazonsku = '$tProductId';
                    ";

                    $productDimensionsR = mysqli_query(conexion($country), $productDimensionsQ);
                    if($productDimensionsR->num_rows == 1){
                        $productDimensionsRow = mysqli_fetch_array($productDimensionsR);
                        $tProductLength = $productDimensionsRow["LARGO"];
                        $tProductWidth = $productDimensionsRow["ANCHO"];
                        $tProductHeight = $productDimensionsRow["ALTO"];

                        if($tProductLength == 0 && $tProductWidth == 0 && $tProductHeight == 0){
//                            echo "PR: $tProductLength - $tProductWidth - $tProductHeight<br>";

                            $updateDimensionsQ = "
                                UPDATE tra_bun_det 
                                SET 
                                    alto = '$tHeight',
                                    ancho = '$tWidth',
                                    largo = '$tLength'
                                WHERE
                                    amazonsku = '$tProductId';
                            ";
                            mysqli_query(conexion($country), $updateDimensionsQ);
                            $newCounter += 1;
                        }
                        else if($tProductLength != $tLength && $tProductHeight != $tHeight && $tProductWidth != $tWidth){
                            $subject = "Shipping Dimensions Update";
                            $message = "
AMAZONSKU: $tProductId

ORIGINAL - Lenght:$tProductLength, Width:$tProductWidth, Height:$tProductHeight

NEW - Lenght:$tLength, Width:$tWidth, Height:$tHeight";
//                            $this->mailMessage("Shipping Dimensions Update", $message, "solus.huargo@gmail.com");
                            $recipient = "romalch@gmail.com";
                            $mail = new PHPMailer(true);
                            try{
                                $mail->IsSMTP();
                                $mail->SMTPAuth = true;
                                $mail->SMTPSecure = "ssl";
                                $mail->Host = "srv70.hosting24.com";
                                $mail->Port = 465;
                                $mail->Username = "support@sigefcloud.com";
                                $mail->Password = "5upp0rt51g3fCl0ud";
                                $mail->setFrom("sigefcloud@sigefcloud.com", "SigefCloud");
                                $mail->addAddress($recipient, $recipient);
//                                $mail->addCC("$cc", "$cc");
                                $mail->Subject = $subject;
                                $mail->Body = $message;
                            }catch (phpmailerException $e){
                                echo $e->errorMessage();
                            }

                            $mailCounter += 1;
                        }
                    }
                }
            }
        }
        echo "NEW:$newCounter - MAIL:$mailCounter<br>";
    }

    /*
     * auxs
     * */

    function getPeri($mDate) {
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
        $tPeriNameData = explode("-", $mDate);
        $tPeriName = $tPeriNameData[0] . "-" . $tPeriNameData[1];
        $query = "SELECT CODPERI FROM cat_peri WHERE NOMBRE = '$tPeriName';";
        $response = getSingleValue($query);
        return $response;
    }

    function getCodProv($bundleSKU) {
        $query = "(SELECT product.CODPROV FROM tra_bun_det AS bundle INNER JOIN cat_prod AS product ON bundle.MASTERSKU = product.MASTERSKU WHERE bundle.AMAZONSKU = '$bundleSKU' OR bundle.MASTERSKU = '$bundleSKU' LIMIT 1)";
        $response = $query;
        return $response;
    }

    function getCountryName($countryCode) {
        $response = $countryCode;
        if (strlen($countryCode) == "2") {
            include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
            $query = "SELECT NOMBRI FROM cat_country WHERE CODECO = '$countryCode';";
            $response = getSingleValue($query);
        }
        return $response;
    }

    function getCountryNameByCompanyId($companyId) {
        $query = "SELECT dir.nomPais FROM cat_empresas AS emp INNER JOIN direct AS dir ON emp.pais = dir.codPais WHERE emp.companyid = '$companyId';";
        $response = getSingleValue($query);
        return $response;
    }

    function mailMessage($subject, $message, $mail = "mauricio.aldana@sigefcloud.com"){
        $result = mail(
            $mail,
            $subject,
            $message
        );
    }

    function mailNotification($value, $query){
        if($value == ""){
            $this->mailMessage("cuenta no existe", "la cuenta no existe. query: " . $query);
        }
    }

    function getInboundShipping($country){
        $getProdCodQuery = "
            SELECT 
                emp.INBOUNDSHI
            FROM
                cat_empresas AS emp
                    INNER JOIN
                direct AS dir ON emp.pais = dir.codPais
            WHERE
                dir.nomPais = '$country';
        ";

        $tProdCod = getSingleValue($getProdCodQuery);

        $getPrecioQuery = "
            SELECT 
                det.PRECIO
            FROM
                tra_factcomenc AS enc
                    INNER JOIN
                tra_factcomdet AS det ON enc.CODFACTCOM = det.CODFACTCOM
                    INNER JOIN
                cat_prod AS prod ON det.CODPROD = prod.CODPROD
            WHERE
                prod.CODPROD = '$tProdCod'
                  AND (det.CANFACT - det.SALIDAS) > 0
            ORDER BY enc.FECHA;
        ";

//        echo $getPrecioQuery."<br>";

        $tPrecio = getSingleValue($getPrecioQuery, $country);

        return $tPrecio;
    }

    function getPackagingMaterial($packageName, $country){
        $getPackageCodQuery = "
            SELECT 
                CODPACK
            FROM
                cat_package
            WHERE
                NOMBRE = '$packageName';
        ";

        $tPackageCod = getSingleValue($getPackageCodQuery);

        $getPrecioQuery = "
            SELECT 
                det.PRECIO
            FROM
                tra_factcomenc AS enc
                    INNER JOIN
                tra_factcomdet AS det ON enc.CODFACTCOM = det.CODFACTCOM
                    INNER JOIN
                cat_prod AS prod ON det.CODPROD = prod.CODPROD
            WHERE
                prod.CODPROD = '$tPackageCod'
                  AND (det.CANFACT - det.SALIDAS) > 0
            ORDER BY enc.FECHA;
        ";

        $tPrecio = getSingleValue($getPrecioQuery, $country);

        return $tPrecio;
    }
}