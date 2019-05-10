<?php
use PayPal\Service\InvoiceService;
use PayPal\Types\Common\RequestEnvelope;
use PayPal\Types\Common\BaseAddress;
use PayPal\Types\PT\CreateAndSendInvoiceRequest;
use PayPal\Types\PT\InvoiceItemListType;
use PayPal\Types\PT\InvoiceItemType;
use PayPal\Types\PT\InvoiceType;
use PayPal\Types\PT\BusinessInfoType;
use PayPal\Types\PT\RemindInvoiceRequest;
use PayPal\Auth\PPSignatureCredential;
use PayPal\Auth\PPTokenAuthorization;

//error_reporting(E_ALL);
//ini_set('display_errors', 'On');

session_start();
require_once('PPBootStrap.php');
require_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

if(isset($_POST["method"])){
    $method = $_POST["method"];

    switch ($method){
        case "generateInvoice":
            $id = $_POST["id"];
            echo generateInvoice($id);
            break;
        case "remindInvoice":
            $id = $_POST["id"];
            echo remindInvoice($id);
            break;
    }
}

function generateInvoice($id){
    $q1 = "
        SELECT 
            enc.codfact,
            CODCLIE,
            (enc.total - abonos) AS pago,
            left(CONCAT(det.codprod,
                    ' ',
                    det.descrip,
                    ' ',
                    det.detobser), 99) AS descrip,
            CONCAT(enc.serie, ' ', enc.numero) AS numero,
            det.cantidad,
            enc.serie
        FROM
            tra_fact_enc AS enc
                INNER JOIN
            tra_fact_det AS det ON enc.codfact = det.codfact
        WHERE
            enc.codfact = '$id';
    ";

    $r1 = mysqli_query(rconexion04(), $q1);
    $row1 = mysqli_fetch_array($r1);

    $tCodFact = $row1["codfact"];
    $tCodClie = $row1["CODCLIE"];
    $tPago = $row1["pago"];
    $tDescrip = $row1["descrip"];
    $tNumero = $row1["numero"];
    $tCantidad = $row1["cantidad"];
    $tSerie = $row1["serie"];

    $q2 = "
        SELECT 
            cont.EMAIL, prov.PAYPALMAIL, prov.MAILCONTAC, prov.NOMBRE, prov.DIRECCION, prov.TELEFONO, prov.NOMCONTACTO, prov.APELCONTACTO, prov.WEBSITE
        FROM
             as prov inner join tra_prov_cont AS piv ON prov.CODPROV = piv.codigo
        INNER JOIN
    cat_cont AS cont ON piv.codcont = cont.codcont
        WHERE
            codprov = '$tCodClie' AND cont.form = 'C';
    ";

    $r2 = mysqli_query(conexion($_SESSION["lastFactCountry"]), $q2);
    $row2 = mysqli_fetch_array($r2);

    $tMail =

    $tMail = ($row2["EMAIL"] != "") ? $row2["EMAIL"] : $row2["MAILCONTAC"];
//    $tMail = "paulo.armas-buyer@coexport.net";
    $tMail = "solus.huargo@gmail.com";

    $item1 = new InvoiceItemType($tDescrip, $tCantidad, $tPago);
    $itemList = new InvoiceItemListType();
    $itemList->item =  array($item1);

    $invoice = new InvoiceType("paulo.armas-facilitator@coexport.net", $tMail, $itemList, "USD", "DueOnReceipt");
    $invoice->number = $tNumero;
    $requestEnvelope = new RequestEnvelope("en_US");

    //billing info
    $tBIFirstName = $row2["NOMCONTACTO"];
    $tBILastName = $row2["APELCONTACTO"];
    $tBIBusinessName = $row2["NOMBRE"];
    $tBIPhone = $row2["TELEFONO"];
    $tBIFax = $row2["FAX"];
    $tBIWebsite = $row2["website"];
    $tBIAddress = new BaseAddress();
    $tBIAddress->line1 = $row2["DIRECCION"];
    $tBIAddress->countryCode = "CR";

    $billingInfo = new BusinessInfoType();
    $billingInfo->firstName = $tBIFirstName;
    $billingInfo->lastName = $tBILastName;
    $billingInfo->businessName = $tBIBusinessName;
    $billingInfo->phone = $tBIPhone;
    $billingInfo->fax = $tBIFax;
    $billingInfo->website = $tBIWebsite;
    $billingInfo->address = $tBIAddress;

    $invoice->billingInfo = $billingInfo;
    $invoice->shippingInfo = $billingInfo;

    //merchant
    if($tSerie = "WDCR"){

        $wdQ = "
            SELECT 
                NOMBRE, RSOCIAL, TELEFONO, FAX, WWW, DIRECCION
            FROM
                cat_empresas
            WHERE
                codigo = 04;
        ";

        $wdR = mysqli_query(rconexion(), $wdQ);
        $wdRow = mysqli_fetch_array($wdR);

        $tWDFirstName = $wdRow["NOMBRE"];
        $tWDLastName = $wdRow["NOMBRE"];
        $tWDBusinessName = $wdRow["RSOCIAL"];
        $tWDPhone = $wdRow["TELEFONO"];
        $tWDFax = $wdRow["FAX"];
        $tWDWebsite = $wdRow["WWW"];
        $tWDAddress = new BaseAddress();
        $tWDAddress->line1 =  $wdRow["DIRECCION"];
        $tWDAddress->countryCode =  "US";

        $wdInfo = new BusinessInfoType();
        $wdInfo->firstName = $tWDFirstName;
        $wdInfo->lastName = $tWDLastName;
        $wdInfo->businessName = $tWDBusinessName;
        $wdInfo->phone = $tWDPhone;
        $wdInfo->fax = $tWDFax;
        $wdInfo->website = $tWDWebsite;
        $wdInfo->address = $tWDAddress;
    }
    else{

    }
    $invoice->merchantInfo = $wdInfo;
    $invoice->logoUrl = "https://desarrollo.sigefcloud.com/images/logoweb.png";

//    var_dump($invoice);

//    echo "!!!!!";

    $createAndSendInvoiceRequest = new CreateAndSendInvoiceRequest($requestEnvelope, $invoice);

    $invoiceService = new InvoiceService(Configuration::getAcctAndConfig());

    try {
        $createAndSendInvoiceResponse = $invoiceService->CreateAndSendInvoice($createAndSendInvoiceRequest);

    } catch (Exception $ex) {
    }

    if($createAndSendInvoiceResponse->responseEnvelope->ack == "Success"){

        $id = $createAndSendInvoiceResponse->invoiceID;

        $q = "
            insert into tra_pp_det (`transaction`, fac_id) values ('$id', '$tCodFact');
        ";

//        echo $q;

        mysqli_query(rconexion04(), $q);

        return $id;

    }
    else{
//        var_dump($createAndSendInvoiceResponse);
        return "ERROR";
    }
}

function remindInvoice($id){
//    echo "$id";
    $invoiceService = new InvoiceService(Configuration::getAcctAndConfig());
    $requestEnvelope = new RequestEnvelope("en_US");
    $request = new RemindInvoiceRequest($requestEnvelope, $id);
    try {
        $response = $invoiceService->RemindInvoice($request);
//        var_dump($request);

    } catch (Exception $ex) {
//        var_dump($ex);
    }

    if($response->responseEnvelope->ack == "Success"){

        $id = $response->invoiceID;

        $q1 = "
            select (tries + 1) as tries, fac_id from tra_pp_det where `transaction` = '$id' order by tries desc limit 1;
        ";

        $r1 = mysqli_query(rconexion04(), $q1);
        $row1 = mysqli_fetch_array($r1);
        $tCodFact = $row1["fac_id"];
        $tTries = $row1["tries"];

        $q = "
            insert into tra_pp_det (`transaction`, fac_id, tries) values ('$id', '$tCodFact', '$tTries');
        ";
        mysqli_query(rconexion04(), $q);

        return $id;

    }
    else{
        var_dump($response);
        return "ERROR";
    }
}
