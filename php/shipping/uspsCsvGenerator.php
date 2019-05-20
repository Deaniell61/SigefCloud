<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

$catPackages = getCatPackages();

print_r(json_encode($catPackages)) . "<br>";

generateCSV("Guatemala");

function generateCSV($connectionCountry)
{
    $data[] = [
        "Contact Name",
        "Company or Name",
        "Country",
        "Address 1",
        "Address 2",
        "Address 3",
        "City",
        "State/Province/Other",
        "Postal Code",
        "Telephone",
        "Ext",
        "Residential Indicator",
        "E-mail address",
        "Packaging Type",
        "Customs Value",
        "Weight",
        "Length",
        "Width",
        "Height",
        "Unit of Measure",
        "Description of Goods",
        "Documents of No Commercial value",
        "GNIFC (Goods not in Free Circulation)",
        "Package Declared Value",
        "Service",
        "Delivery Confirmation",
        "Shipper Release/Deliver without Signature",
        "Return of Document",
        "Deliver on Saturday",
        "UPS Carbon Neutral",
        "Large Package",
        "Additional Handling",
        "Reference 1",
        "Reference 2",
        "Reference 3",
        "E-mail Notification 1 – Address",
        "E-mail Notification 1 – Ship",
        "E-mail Notification 1 – Exception",
        "E-mail Notification 1 – Delivery",
        "E-mail Notification 2 – Address",
        "E-mail Notification 2 – Ship",
        "E-mail Notification 2 – Exception",
        "E-mail Notification 2 – Delivery",
        "E-mail Notification 3 – Address",
        "E-mail Notification 3 – Ship",
        "E-mail Notification 3 – Exception",
        "E-mail Notification 3 – Delivery",
        "E-mail Notification 4 – Address",
        "E-mail Notification 4 – Ship",
        "E-mail Notification 4 – Exception",
        "E-mail Notification 4 – Delivery",
        "E-mail Notification 5 – Address",
        "E-mail Notification 5 – Ship",
        "E-mail Notification 5 – Exception",
        "E-mail Notification 5 – Delivery",
        "E-Mail Message",
        "E-mail Failure Address",
        "UPS Premium Care",
        "Location ID",
        "Media Type",
        "Language",
        "Notification Address",
        "ADL COD Value",
        "ADL Deliver to Addressee",
        "ADL Shipper Media Type",
        "ADL Shipper Language",
        "ADL Shipper Notification"
    ];


    $q = "
        SELECT 
            CONCAT(shifirnam, ' ', shilasnam) AS name, shicou, shiadd1, shiadd2, shipcity, shipstate, shizipcod, shiphonum, orderid, CODORDEN
        FROM
            tra_ord_enc LIMIT 10;
    ";

    $r = mysqli_query(conexion($connectionCountry), $q);

    while ($row = mysqli_fetch_array($r)) {

        $shippingValues = getShippingValues($row["CODORDEN"], $connectionCountry);
        $pacTyp = findPackage($shippingValues["peso"]);
        // echo "<script>console.log(".$shippingValues["peso"] . " - $pacTyp);</script>";

        $contactName = $row["name"];
        $companyOrName = $row["name"];
        $country = $row["shicou"];
        $address1 = $row["shiadd1"];
        $address2 = $row["shiadd2"];
        $address3 = "";
        $city = $row["shipcity"];
        $state = $row["shipstate"];
        $postalCode = $row["shizipcod"];
        $telephone = $row["shiphonum"];
        $ext = "";
        $residentialIndicator = getResidentialIndicator($row["WALRESIND"]);
        $email = "";
        $packagingType = "2";
        $customsValue = $shippingValues["sugsalpric"];
        $weight = $shippingValues["peso"];
        $length = $shippingValues["profun"];
        $width = $shippingValues["ancho"];
        $height = $shippingValues["alto"];
        $unitOfMeasure = "LB";
        $descriptionOfGoods = "";
        $documentsOfNoComercialValue = "";
        $gnifc = "";
        $packageDeclaredValue = $shippingValues["packageDeclaredValue"];
        $service = "";
        $deliveryConfirmation = "N";
        $shipperReleaseDeliverWithoutConfirmation = "0";
        $returnOfDocument = "0";
        $deliverOnSaturday = "0";
        $upsCarbonNeutral = "0";
        $largePackage = "0";
        $aditionalHandling = "";
        $reference1 = "";
        $reference2 = $row["orderid"];
        $reference3 = "";
        $emailNtification1Address = "";
        $emailNtification1Ship = "";
        $emailNtification1Exception = "";
        $emailNtification1Delivery = "";
        $emailNtification2Address = "";
        $emailNtification2Ship = "";
        $emailNtification2Exception = "";
        $emailNtification2Delivery = "";
        $emailNtification3Address = "";
        $emailNtification3Ship = "";
        $emailNtification3Exception = "";
        $emailNtification3Delivery = "";
        $emailNtification4Address = "";
        $emailNtification4Ship = "";
        $emailNtification4Exception = "";
        $emailNtification4Delivery = "";
        $emailNtification5Address = "";
        $emailNtification5Ship = "";
        $emailNtification5Exception = "";
        $emailNtification5Delivery = "";
        $emailMessage = "";
        $emailFailureAddress = "";
        $upsPremiumCare = "0";
        $locationId = "";
        $mediaType = "";
        $language = "";
        $notificationAddress = "webmaster@worldirect.com";
        $adlCodValue = "";
        $adlDeliverToAddressee = "";
        $adlShipperMediaType = "";
        $adlShipperLanguage = "";
        $adlShipperNotification = "";
        
        $data[] = [
            "$contactName",
            "$companyOrName",
            "$country",
            "$address1",
            "$address2",
            "$address3",
            "$city",
            "$state",
            "$postalCode",
            "$telephone",
            "$ext",
            "$residentialIndicator",
            "$email",
            "$packagingType",
            "$customsValue",
            "$weight",
            "$length",
            "$width",
            "$height",
            "$unitOfMeasure",
            "$descriptionOfGoods",
            "$documentsOfNoComercialValue",
            "$gnifc",
            "$packageDeclaredValue",
            "$service",
            "$deliveryConfirmation",
            "$shipperReleaseDeliverWithoutConfirmation",
            "$returnOfDocument",
            "$deliverOnSaturday",
            "$upsCarbonNeutral",
            "$largePackage",
            "$aditionalHandling",
            "$reference1",
            "$reference2",
            "$reference3",
            "$emailNtification1Address",
            "$emailNtification1Ship",
            "$emailNtification1Exception",
            "$emailNtification1Delivery",
            "$emailNtification2Address",
            "$emailNtification2Ship",
            "$emailNtification2Exception",
            "$emailNtification2Delivery",
            "$emailNtification3Address",
            "$emailNtification3Ship",
            "$emailNtification3Exception",
            "$emailNtification3Delivery",
            "$emailNtification4Address",
            "$emailNtification4Ship",
            "$emailNtification4Exception",
            "$emailNtification4Delivery",
            "$emailNtification5Address",
            "$emailNtification5Ship",
            "$emailNtification5Exception",
            "$emailNtification5Delivery",
            "$emailMessage",
            "$emailFailureAddress",
            "$upsPremiumCare",
            "$locationId",
            "$mediaType",
            "$language",
            "$notificationAddress",
            "$adlCodValue",
            "$adlDeliverToAddressee",
            "$adlShipperMediaType",
            "$adlShipperLanguage",
            "$adlShipperNotification"
        ];
    }

    $date = date("Y-m-d");
    $fileName = "usps-$date.csv";

    $file = fopen($fileName, "w");

    foreach ($data as $row) {
        fputcsv($file, $row);
    }
    fclose($file);


    
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($fileName).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($fileName));
    echo "<script type='text/javascript'>window.close();</script>";
    

}

function getResidentialIndicator($value){
    switch ($value){
        case "RESIDENTIAL":
            return "1";
            break;
        case "COMMERCIAL":
            return "0";
            break;
    }
}

function getShippingValues($codorden, $connectionCountry){
    $query = "
        SELECT 
             enc.codorden, prod.ancho, bun.unitbundle, prod.alto, prod.profun, prod.peso, bun.sugsalpric, det.qty
        FROM
            tra_ord_enc AS enc
        INNER JOIN
            tra_ord_det AS det ON enc.codorden = det.codorden
        INNER JOIN
            tra_bun_det AS bun ON det.productid = bun.amazonsku
        INNER JOIN
            cat_prod AS prod ON bun.mastersku = prod.mastersku where enc.codorden = '$codorden';
    ";

    $result = mysqli_query(conexion($connectionCountry), $query);

    if($result){
        $values[] = null;

        while ($row = mysqli_fetch_array($result)){
            $values[] = [
                "ancho" => $row["ancho"] * $row["unitbundle"],
                "alto" => $row["alto"],
                "profun" => $row["profun"],
                "peso" => $row["peso"],
                "sugsalpric" => $row["sugsalpric"],
                "packageDeclaredValue" => $row["sugsalpric"] * $row["qty"],
            ];
        }

    //    echo var_dump($values);
        $ancho='';
        $alto='';
        $profun='';
        $peso='';
        $sugsalpric='';
        $packageDeclaredValue='';
        foreach ($values as $value){
            $ancho += $value["ancho"];
            $alto += $value["alto"];
            $profun += $value["profun"];
            $peso += $value["peso"];
            $sugsalpric += $value["sugsalpric"];
            $packageDeclaredValue += $value["packageDeclaredValue"];
        }

        $response = [
            "ancho" => $ancho,
            "alto" => $alto,
            "profun" => $profun,
            "value" => ($ancho * $alto * $profun) / 1728,
            "peso" => $peso,
            "sugsalpric" => $sugsalpric,
            "packageDeclaredValue" => $packageDeclaredValue,
        ];

//        var_dump($response);
//        echo "<br>";

        return $response;
    }
}

function getCatPackages(){

    $query = "
        SELECT 
            nombre, ((alto * ancho * largo) / 1728) as val
        FROM
            cat_package havin val > 0 order by val ASC;
    ";

    $result = mysqli_query(conexion(""), $query);

    while ($row = mysqli_fetch_array($result)){
        $response[] = $row;
    }

    return $response;
}

function findPackage($value){
    global $catPackages;

    foreach ($catPackages as $catPackage){
        $tVal = $catPackage["val"];
        $tNombre = $catPackage["nombre"];
        echo "->$value - $tVal - $tNombre<br>";
        if($value > $tVal){
            return $tNombre;
        }
    }
}