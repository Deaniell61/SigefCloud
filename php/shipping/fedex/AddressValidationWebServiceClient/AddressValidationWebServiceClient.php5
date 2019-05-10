<?php

session_start();

if(isset($_POST["method"])){
    $method = $_POST["method"];
    switch ($method){
        case "validate":
            $id = $_POST["id"];
            echo validateAddressByOrderId($id);
            break;
    }
}

function validateAddressByOrderId($id){

    require_once('../fedex-common.php5');
    include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

    $addressQ = "
        SELECT 
            shicou, shipstate, shipcity, shizipcod, shiadd1, shiadd2
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

    $selectedAddress = "$address, $city, $state, $zip, $countryCode.";

    $path_to_wsdl = "AddressValidationService_v4.wsdl";
    ini_set("soap.wsdl_cache_enabled", "0");
    $client = new SoapClient($path_to_wsdl, array('trace' => 1));

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
    $request['TransactionDetail'] = array('CustomerTransactionId' => ' *** Address Validation Request using PHP ***');
    $request['Version'] = array(
        'ServiceId' => 'aval',
        'Major' => '4',
        'Intermediate' => '0',
        'Minor' => '0'
    );
    $request['InEffectAsOfTimestamp'] = date('c');
    $request['AddressesToValidate'] = array(
        0 => array(
            'ClientReferenceId' => 'ClientReferenceId1',
            'Address' => array(
                'StreetLines' => array("$address"),
                'PostalCode' => "$zip",
                'City' => "$city",
                'StateOrProvinceCode' => "$state",
                'CountryCode' => "$countryCode"
            )
        )
    );

    try {
        if (setEndpoint('changeEndpoint')) {
            $newLocation = $client->__setLocation(setEndpoint('endpoint'));
        }
        $response = $client->addressValidation($request);

//        var_dump($response);

        $tSeverity = $response->HighestSeverity;

        if ($tSeverity != 'FAILURE' && $tSeverity != 'ERROR') {
            return ($response->AddressResults->State == "STANDARDIZED") ? $selectedAddress : "INVALID " . $selectedAddress;
        } else {
            $tMessage = $response->Notifications->Message;
//            echo "ERROR DE RESPUESTA: $tMessage";
            return "INVALID ERROR DE RESPUESTA: $tMessage";
        }
    } catch (SoapFault $exception) {
        echo "ERROR DE WS: $exception";
        return "INVALID ERROR DE WS: $exception";
    }
}