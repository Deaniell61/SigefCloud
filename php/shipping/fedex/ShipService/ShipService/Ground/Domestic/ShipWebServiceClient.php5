<?php

session_start();


if(!isset($_SESSION["pais"])){
    $_SESSION["pais"] = "Guatemala";
}

if (isset($_POST["method"])) {
    $method = $_POST["method"];
    switch ($method) {
        case "generateGroundDomestic":
            $id = $_POST["id"];
            $lblWUnit = $_POST["lblWUnit"];
            $lblW = $_POST["lblW"];
            $lblDUnit = $_POST["lblDUnit"];
            $lblDLength = $_POST["lblDLength"];
            $lblDWidth = $_POST["lblDWidth"];
            $lblDHeight = $_POST["lblDHeight"];
            echo generateGroundDomestic($id, $lblWUnit, $lblW, $lblDUnit, $lblDLength, $lblDWidth, $lblDHeight);
            break;
    }
}else{
    echo generateGroundDomestic("2582616221799", "LB", "1", "IN", "5", "5", "4"); // 2781380445307
}

function generateGroundDomestic($id, $lblWUnit, $lblW, $lblDUnit, $lblDLength, $lblDWidth, $lblDHeight)
{
    require_once('../../../../fedex-common.php5');

    $path_to_wsdl = "../../../ShipService_v21.wsdl";

    define('SHIP_LABEL', 'shipgroundlabel.pdf');  // PDF label file. Change to file-extension .png for creating a PNG label (e.g. shiplabel.png)
    define('SHIP_CODLABEL', 'CODgroundreturnlabel.pdf');  // PDF label file. Change to file-extension ..png for creating a PNG label (e.g. CODgroundreturnlabel.png)

    ini_set("soap.wsdl_cache_enabled", "0");

    $client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information

    $request['WebAuthenticationDetail'] = array(
        'ParentCredential' => array(
            'Key' => getProperty('parentkey'),
            'Password' => getProperty('parentpassword')
        ),
        'UserCredential' => array(
            'Key' => getProperty('key'),
            'Password' => getProperty('password')
        )
    );

    $request['ClientDetail'] = array(
        'AccountNumber' => getProperty('shipaccount'),
        'MeterNumber' => getProperty('meter')
    );
    $request['TransactionDetail'] = array('CustomerTransactionId' => '*** Ground Domestic Shipping Request using PHP ***');
    $request['Version'] = array(
        'ServiceId' => 'ship',
        'Major' => '21',
        'Intermediate' => '0',
        'Minor' => '0'
    );
    $request['RequestedShipment'] = array(
        'ShipTimestamp' => date('c'),
        'DropoffType' => 'REGULAR_PICKUP', // valid values REGULAR_PICKUP, REQUEST_COURIER, DROP_BOX, BUSINESS_SERVICE_CENTER and STATION
        'ServiceType' => 'GROUND_HOME_DELIVERY', // valid values STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_GROUND, ...
        'PackagingType' => 'YOUR_PACKAGING', // valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...
        'Shipper' => addShipper($id),
        'Recipient' => addRecipient($id),
        'ShippingChargesPayment' => addShippingChargesPayment(),
        'LabelSpecification' => addLabelSpecification(),
        'PackageCount' => 1,
        'PackageDetail' => 'INDIVIDUAL_PACKAGES',
        'RequestedPackageLineItems' => array(
            '0' => addPackageLineItem1($lblWUnit, $lblW, $lblDUnit, $lblDLength, $lblDWidth, $lblDHeight)
        )
    );


    try {

        if (setEndpoint('changeEndpoint')) {
            $newLocation = $client->__setLocation(setEndpoint('endpoint'));
        }
        $response = $client->processShipment($request); // FedEx web service invocation
        if ($response->HighestSeverity != 'FAILURE' && $response->HighestSeverity != 'ERROR') {
//            printSuccess($client, $response);

            $fp = fopen(SHIP_CODLABEL, 'wb');
            fwrite($fp, $response->CompletedShipmentDetail->CompletedPackageDetails->CodReturnDetail->Label->Parts->Image); //Create COD Return PNG or PDF file
            fclose($fp);
//            echo '<a href="./' . SHIP_CODLABEL . '">' . SHIP_CODLABEL . '</a> was generated.' . Newline;

            // Create PNG or PDF label
            // Set LabelSpecification.ImageType to 'PNG' for generating a PNG label

            $fp = fopen(SHIP_LABEL, 'wb');
            fwrite($fp, ($response->CompletedShipmentDetail->CompletedPackageDetails->Label->Parts->Image));
            fclose($fp);
//            echo '<a href="./' . SHIP_LABEL . '">' . SHIP_LABEL . '</a> was generated.';
            return "1";
        } else {
//            printError($client, $response);
//            var_dump($response->Notifications);
            return $response->HighestSeverity . " " . $response->Notifications->Code . ":" . $response->Notifications->Message;
        }
    } catch (SoapFault $exception) {
//        printFault($exception, $client);
        return $exception->faultcode . " - " . $exception->faultstring;
    }


    /* Thermal Label */
    /*
    'LabelSpecification' => array(
        'LabelFormatType' => 'COMMON2D', // valid values COMMON2D, LABEL_DATA_ONLY
        'ImageType' => 'EPL2', // valid values DPL, EPL2, PDF, ZPLII and PNG
        'LabelStockType' => 'STOCK_4X6.75_LEADING_DOC_TAB',
        'LabelPrintingOrientation' => 'TOP_EDGE_OF_TEXT_FIRST'
    ),
    */
}

function addShipper($id)
{

    include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

    $ordSouQ = "
        SELECT 
            ordsou
        FROM
            tra_ord_enc
        WHERE
            orderid = '$id';
    ";

    $ordSouR = mysqli_query(conexion($_SESSION["pais"]), $ordSouQ);

    $ordSou = mysqli_fetch_array($ordSouR)[0];

    if($ordSou != "Walmart"){
        //es de nosotros
        $ordType = 1;
    }
    else{
        //es de walmart, ver si es home o store
        $shipOpQ = "
            SELECT 
                shi.fuloption
            FROM
                tra_ord_enc AS enc
                    INNER JOIN
                tra_ord_det AS det ON enc.codorden = det.codorden
                    INNER JOIN
                tra_ord_shi AS shi ON det.coddetord = shi.codorddet
            WHERE
                enc.orderid = '$id';
        ";

        $shipOpR = mysqli_query(conexion($_SESSION["pais"]), $shipOpQ);
        $shipOp = mysqli_fetch_array($shipOpR)[0];

        if($shipOp == "S2H"){
            $ordType = 2;
        }
        else{
            $ordType = 3;
        }
    }

    switch ($ordType){
        case 1:
            $name = "";
            $companyName = "GuateDirect LLC";
            $phone = "(678) 213-1226";
            $address = "7055 Amwiler Industrial Drive Suite";
            $city = "Atlanta";
            $state = "GA";
            $zip = "30360";
            $countryCode= "US";
            break;
        case 2:
            $name = "";
            $companyName = "WALMART.COM";
            $phone = "(678) 213-1226";
            $address = "1301 SE 10th St";
            $city = "BENTONVILLE";
            $state = "AR";
            $zip = "72712-5698";
            $countryCode= "US";
            break;
        case 3:
            $name = "";
            $companyName = "WALMART.COM";
            $phone = "(678) 213-1226";
            $address = "1301 SE 10TH STREET";
            $city = "BENTONVILLE";
            $state = "AR";
            $zip = "727129998";
            $countryCode= "US";
            break;
    }

    $shipper = array(
        'Contact' => array(
            'PersonName' => "$name",
            'CompanyName' => "$companyName",
            'PhoneNumber' => "$phone"
        ),
        'Address' => array(
            'StreetLines' => array("$address"),
            'City' => "$city",
            'StateOrProvinceCode' => "$state",
            'PostalCode' => "$zip",
            'CountryCode' => "$countryCode"
        )
    );
    return $shipper;
}

function addRecipient($id)
{

    include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

    $addressQ = "
        SELECT 
            shifirnam, shilasnam, shiphonum, shicou, shipstate, shipcity, shizipcod, shiadd1, shiadd2
        FROM
            tra_ord_enc
        WHERE
            orderid = '$id';
    ";

    $addressR = mysqli_query(conexion($_SESSION["pais"]), $addressQ);
    $addressRow = mysqli_fetch_array($addressR);
    $countryCode = $addressRow["shicou"];
    $state = $addressRow["shipstate"];
    $city = $addressRow["shipcity"];
    $zip = $addressRow["shizipcod"];
    $address = $addressRow["shiadd1"] . " " . $addressRow["shiadd2"];
    $address = $addressRow["shiadd1"];
    $name = $addressRow["shifirnam"] . " " .$addressRow["shilasnam"];
    $phone = $addressRow["shiphonum"];

//    echo "$addressQ<br>";

    if($countryCode == "USA"){
        $countryCode = "US";
    }

    $recipient = array(
        'Contact' => array(
            'PersonName' => "$name",
            'CompanyName' => '',
            'PhoneNumber' => "$phone"
        ),
        'Address' => array(
            'StreetLines' => array($address),
            'City' => "$city",
            'StateOrProvinceCode' => "$state",
            'PostalCode' => "$zip",
            'CountryCode' => $countryCode,
            'Residential' => true
        )
    );
    return $recipient;
}

function addShippingChargesPayment()
{
    $shippingChargesPayment = array(
        'PaymentType' => 'SENDER',
        'Payor' => array(
            'ResponsibleParty' => array(
                'AccountNumber' => getProperty('billaccount'),
                'Contact' => null,
                'Address' => array(
                    'CountryCode' => 'US'
                )
            )
        )
    );
    return $shippingChargesPayment;
}

function addLabelSpecification()
{
    $labelSpecification = array(
        'LabelFormatType' => 'COMMON2D', // valid values COMMON2D, LABEL_DATA_ONLY
        'ImageType' => 'PDF',  // valid values DPL, EPL2, PDF, ZPLII and PNG
        'LabelStockType' => 'PAPER_7X4.75'
    );
    return $labelSpecification;
}

function addSpecialServices()
{
    $specialServices = array(
        'SpecialServiceTypes' => array('COD'),
        'CodDetail' => array(
            'CodCollectionAmount' => array(
                'Currency' => 'USD',
                'Amount' => 150
            ),
            'CollectionType' => 'ANY' // ANY, GUARANTEED_FUNDS
        )
    );
    return $specialServices;
}

function addPackageLineItem1($lblWUnit, $lblW, $lblDUnit, $lblDLength, $lblDWidth, $lblDHeight, $poBox = "")
{

    $customerReferences = null;

    if($poBox != ""){
        $customerReferences = array(
            '0' => array(
                'CustomerReferenceType' => 'P_O_NUMBER',
                'Value' => "$poBox"
            )
        );
    }

    $packageLineItem = array(
        'SequenceNumber' => 1,
        'GroupPackageCount' => 1,
        'Weight' => array(
            'Value' => $lblW,
            'Units' => "$lblWUnit"
        ),
        'Dimensions' => array(
            'Length' => $lblDLength,
            'Width' => $lblDWidth,
            'Height' => $lblDHeight,
            'Units' => "$lblDUnit"
        ),

        'CustomerReferences' => $customerReferences,

//        'SpecialServicesRequested' => addSpecialServices()
    );
    return $packageLineItem;

    /*
     'CustomerReferences' => array(
            '0' => array(
                'CustomerReferenceType' => 'CUSTOMER_REFERENCE', // valid values CUSTOMER_REFERENCE, INVOICE_NUMBER, P_O_NUMBER and SHIPMENT_INTEGRITY
                'Value' => 'GR4567892'
            ),
            '1' => array(
                'CustomerReferenceType' => 'INVOICE_NUMBER',
                'Value' => 'INV4567892'
            ),
            '2' => array(
                'CustomerReferenceType' => 'P_O_NUMBER',
                'Value' => 'PO4567892'
            )
        ),
     * */
}

?>