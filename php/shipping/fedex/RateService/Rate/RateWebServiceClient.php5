<?php

session_start();

$testData = [
    "id" => "4781985612033",
    "dropoffType" => "REGULAR_PICKUP",
    "shipDate" => date("c"),
    "serviceType" => "GROUND_HOME_DELIVERY",
    "lblWUnit" => "LB",
    "lblW" => "50",
    "lblDUnit" => "IN",
    "lblDLength" => "10",
    "lblDHeight" => "10",
    "lblDWidth" => "10",
];

$testData = [
    "address1" => "10907 Silhouette St",
    "address2" => "","state" => "TX",
    "city" => "San Antonio",
    "zip" => "78216",
    "dropoffType" => "REGULAR_PICKUP",
    "shipDate" => "2018-07-27T00:00:00-04:00",
    "shippingMethod" => "FEDEX_2_DAY",
    "weightUnit" => "LB",
    "weight" => "5",
    "dimensionUnit" => "IN",
    "length" => "12.00",
    "height" => "24.00",
    "width" => "18.00",
    "orderType" => "1"
];

//echo quoteShipping($testData);
//echo genericQuote($testData);


function genericQuote($data){

    $address1 = $data["address1"];
    $address2 = $data["address2"];
    $state = $data["sate"];
    $city = $data["city"];
    $zip = $data["zip"];
    $shipDate = $data["shipDate"];
    $shippingMethod = $data["shippingMethod"];
    $weightUnit = $data["weightUnit"];
    $weight = $data["weight"];
    $dimensionUnit = $data["dimensionUnit"];
    $length = $data["length"];
    $height = $data["height"];
    $width = $data["width"];
    $orderType = $data["orderType"];
    $residential = ($shippingMethod == "FEDEX_GROUND") ? false : true;

    require_once($_SERVER["DOCUMENT_ROOT"] . "/php/shipping/fedex/fedex-common.php5");

    $path_to_wsdl = $_SERVER["DOCUMENT_ROOT"] . "/php/shipping/fedex/RateService/RateService_v22.wsdl";

    ini_set("soap.wsdl_cache_enabled", "0");
    $client = new SoapClient($path_to_wsdl, array('trace' => 1, 'cache_wsdl' => WSDL_CACHE_NONE)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information

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
    $request['TransactionDetail'] = array('CustomerTransactionId' => ' *** Rate Request using PHP ***');
    $request['Version'] = array(
        'ServiceId' => 'crs',
        'Major' => '22',
        'Intermediate' => '0',
        'Minor' => '0'
    );
    $request['ReturnTransitAndCommit'] = true;
    $request['RequestedShipment']['DropoffType'] = "REGULAR_PICKUP"; // valid values REGULAR_PICKUP, REQUEST_COURIER, ...
    $request['RequestedShipment']['ShipTimestamp'] = $shipDate;
    $request['RequestedShipment']['ServiceType'] = $shippingMethod; // valid values STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_GROUND, ...
    $request['RequestedShipment']['PackagingType'] = 'YOUR_PACKAGING'; // valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...
    $request['RequestedShipment']['TotalInsuredValue']=array(
        'Ammount'=>0,
        'Currency'=>'USD'
    );
    $request['RequestedShipment']['Shipper'] = addShipperGeneric($orderType);
    $request['RequestedShipment']['Recipient'] = addRecipientGeneric($address1, $address2, $state, $city, $zip, $residential);
    $request['RequestedShipment']['ShippingChargesPayment'] = addShippingChargesPayment();
    $request['RequestedShipment']['PackageCount'] = '1';
    $request['RequestedShipment']['RequestedPackageLineItems'] = addPackageLineItem1($weightUnit, $weight, $dimensionUnit, $length, $width, $height);

    try {
        if(setEndpoint('changeEndpoint')){
            $newLocation = $client->__setLocation(setEndpoint('endpoint'));
        }

//        var_dump($request);
//        echo "<br><br><br>";

        $response = $client -> getRates($request);

//        echo "<br><br><br>";
//        var_dump($response);
        if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR'){
            $rateReply = $response -> RateReplyDetails;
            return number_format($rateReply->RatedShipmentDetails->ShipmentRateDetail->TotalNetCharge->Amount,2,".",",");
        }else{
            return "ERROR " . $response->Notifications->Message;
        }


    } catch (SoapFault $exception) {
        printFault($exception, $client);
//        return $exception->faultcode . " - " . $exception->faultstring . $exception;
        return "ERROR ";
    }
}

function quoteShipping($data){

    $id = $data["id"];
    $dropoffType = $data["dropoffType"];
    $shipDate = $data["shipDate"];
    $serviceType = $data["serviceType"];
    $lblWUnit = $data["lblWUnit"];
    $lblW = $data["lblW"];
    $lblDUnit = $data["lblDUnit"];
    $lblDLength = $data["lblDLength"];
    $lblDWidth = $data["lblDWidth"];
    $lblDHeight = $data["lblDHeight"];


    require_once($_SERVER["DOCUMENT_ROOT"] . "/php/shipping/fedex/fedex-common.php5");

    $path_to_wsdl = $_SERVER["DOCUMENT_ROOT"] . "/php/shipping/fedex/RateService/RateService_v22.wsdl";

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
    $request['TransactionDetail'] = array('CustomerTransactionId' => ' *** Rate Request using PHP ***');
    $request['Version'] = array(
        'ServiceId' => 'crs',
        'Major' => '22',
        'Intermediate' => '0',
        'Minor' => '0'
    );
    $request['ReturnTransitAndCommit'] = true;
    $request['RequestedShipment']['DropoffType'] = $dropoffType; // valid values REGULAR_PICKUP, REQUEST_COURIER, ...
    $request['RequestedShipment']['ShipTimestamp'] = $shipDate;
    $request['RequestedShipment']['ServiceType'] = $serviceType; // valid values STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_GROUND, ...
    $request['RequestedShipment']['PackagingType'] = 'YOUR_PACKAGING'; // valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...
    $request['RequestedShipment']['TotalInsuredValue']=array(
        'Ammount'=>0,
        'Currency'=>'USD'
    );
    $request['RequestedShipment']['Shipper'] = addShipper($id);
//    $request['RequestedShipment']['Recipient'] = addRecipient($id);
    $request['RequestedShipment']['Recipient'] = addRecipientOther($id);
    $request['RequestedShipment']['ShippingChargesPayment'] = addShippingChargesPayment();
    $request['RequestedShipment']['PackageCount'] = '1';
    $request['RequestedShipment']['RequestedPackageLineItems'] = addPackageLineItem1($lblWUnit, $lblW, $lblDUnit, $lblDLength, $lblDWidth, $lblDHeight);



    try {
        if(setEndpoint('changeEndpoint')){
            $newLocation = $client->__setLocation(setEndpoint('endpoint'));
        }

        $response = $client -> getRates($request);

        if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR'){
            $rateReply = $response -> RateReplyDetails;
            /*
            echo '<table border="1">';
            echo '<tr><td>Service Type</td><td>Amount</td><td>Delivery Date</td></tr><tr>';
            $serviceType = '<td>'.$rateReply -> ServiceType . '</td>';
            if($rateReply->RatedShipmentDetails && is_array($rateReply->RatedShipmentDetails)){
                $amount = '<td>$' . number_format($rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount,2,".",",") . '</td>';
            }elseif($rateReply->RatedShipmentDetails && ! is_array($rateReply->RatedShipmentDetails)){
                $amount = '<td>$' . number_format($rateReply->RatedShipmentDetails->ShipmentRateDetail->TotalNetCharge->Amount,2,".",",") . '</td>';
            }
            if(array_key_exists('DeliveryTimestamp',$rateReply)){
                $deliveryDate= '<td>' . $rateReply->DeliveryTimestamp . '</td>';
            }else if(array_key_exists('TransitTime',$rateReply)){
                $deliveryDate= '<td>' . $rateReply->TransitTime . '</td>';
            }else {
                $deliveryDate='<td>&nbsp;</td>';
            }
            echo $serviceType . $amount. $deliveryDate;
            echo '</tr>';
            echo '</table>';
            */
//            printSuccess($client, $response);
            return number_format($rateReply->RatedShipmentDetails->ShipmentRateDetail->TotalNetCharge->Amount,2,".",",");
        }else{
//            printError($client, $response);
//            return $response->Notifications->Message;
            return $response->Notifications[0]->Message;
        }
        writeToLog($client);    // Write to log file
    } catch (SoapFault $exception) {
//        printFault($exception, $client);
        return $exception->faultcode . " - " . $exception->faultstring;
    }
}

function addShipper($id){
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

function addShipperGeneric($id){

    switch ($id){
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

function addRecipient($id){
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

function addRecipientOther(){

    $recipient = array(
        'Contact' => array(
            'PersonName' => "test",
            'CompanyName' => '',
            'PhoneNumber' => "5551526"
        ),
        'Address' => array(
            'StreetLines' => array("414 East 75th St"),
            'City' => "NY",
            'StateOrProvinceCode' => "NY ",
            'PostalCode' => "10021",
            'CountryCode' => "US",
            'Residential' => true
        )
    );

    return $recipient;
}

function addRecipientGeneric($address1, $address2, $state, $city, $zip, $residential){

    $recipient = array(
        'Contact' => array(
            'PersonName' => "",
            'CompanyName' => '',
            'PhoneNumber' => ""
        ),
        'Address' => array(
            'StreetLines' => array($address1 . " " . $address2),
            'City' => $city,
            'StateOrProvinceCode' => $state,
            'PostalCode' => $zip,
            'CountryCode' => "US",
            'Residential' => $residential,
        )
    );

    return $recipient;
}

function addShippingChargesPayment(){
	$shippingChargesPayment = array(
		'PaymentType' => 'SENDER', // valid values RECIPIENT, SENDER and THIRD_PARTY
		'Payor' => array(
			'ResponsibleParty' => array(
				'AccountNumber' => getProperty('billaccount'),
				'CountryCode' => 'US'
			)
		)
	);
	return $shippingChargesPayment;
}

function addLabelSpecification(){
	$labelSpecification = array(
		'LabelFormatType' => 'COMMON2D', // valid values COMMON2D, LABEL_DATA_ONLY
		'ImageType' => 'PDF',  // valid values DPL, EPL2, PDF, ZPLII and PNG
		'LabelStockType' => 'PAPER_7X4.75'
	);
	return $labelSpecification;
}

function addSpecialServices(){
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

function addPackageLineItem1($lblWUnit, $lblW, $lblDUnit, $lblDLength, $lblDWidth, $lblDHeight){

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
    );

    return $packageLineItem;
}