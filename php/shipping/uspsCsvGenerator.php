<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

$catPackages = getCatPackages();

if(isset($_GET["orderids"])){
    $orderIds = $_GET["orderids"];
}

$carrierName = $_GET["carrierName"];

//print_r(json_encode($catPackages)) . "<br>";

generateCSV("Guatemala", $orderIds);

function generateCSV($connectionCountry, $orderIds)
{
    global $catPackages, $carrierName;

    /*
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
    */

    $today = date("Y-m-d H:i:s", strtotime("today"));
    $yesterday = date("Y-m-d H:i:s", strtotime("yesterday"));

//    echo "$today - $yesterday";

    if($orderIds){
        $orderidsq = " AND enc.orderid IN ($orderIds)";
    }

    $q = "
        SELECT 
            CONCAT(shifirnam, ' ', shilasnam) AS name,
            shicou,
            shiadd1,
            shiadd2,
            shipcity,
            shipstate,
            shizipcod,
            shiphonum,
            orderid,
            enc.CODORDEN,
            shi.oricarmet,
            enc.timoford,
            enc.username,
            enc.walresind
        FROM
            tra_ord_enc AS enc
                INNER JOIN
            (select * from tra_ord_det group by codorden) AS det ON enc.codorden = det.codorden
                INNER JOIN
            (select * from tra_ord_shi group by codorddet) AS shi ON det.coddetord = shi.codorddet
        WHERE
            enc.orderid IN ($orderIds);
    ";

    $r = mysqli_query(conexion($connectionCountry), $q);

    while ($row = mysqli_fetch_array($r)) {

        $shippingValues = getShippingValues($row["CODORDEN"], $connectionCountry);
        $pacTyp = findPackage($shippingValues["value"]);
        $tSV = $catPackages[$pacTyp];
//        $pacTyp = findPackage("0.0346");
//        echo $shippingValues["value"] . " - $pacTyp<br>";

        $contactName = $row["name"];
        $companyOrName = $row["name"];
        $country = getCountryCode($row["shicou"]);
        $address1 = $row["shiadd1"];
        $address2 = $row["shiadd2"];
        $address3 = $row[""];
        $city = $row["shipcity"];
        $state = $row["shipstate"];
        $postalCode = str_pad((string)$row["shizipcod"],5,'0',STR_PAD_LEFT);
        $telephone = $row["shiphonum"];
        $ext = $row[""];
        $residentialIndicator = getResidentialIndicator($row["walresind"]);
        $email = $row[""];
        $packagingType = "2";
        $customsValue = $shippingValues["sugsalpric"];
        $weight = ceil($shippingValues["peso"]);
        $length = $tSV["largo"];
        $length = "";
        $width = $tSV["ancho"];
        $width = "";
        $height = $tSV["alto"];
        $height = "";
        $unitOfMeasure = "LB";
        $descriptionOfGoods = $row[""];
        $documentsOfNoComercialValue = "0";
        $gnifc = "0";
        $packageDeclaredValue = $shippingValues["packageDeclaredValue"];
        $service = "03";
        $deliveryConfirmation = "";
        $shipperReleaseDeliverWithoutConfirmation = "0";
        $returnOfDocument = "0";
        $deliverOnSaturday = "0";
        $upsCarbonNeutral = "0";
        $largePackage = "0";
        $aditionalHandling = $row[""];
        $reference1 = $row[""];
        $reference2 = $row["orderid"];
        $reference3 = $row[""];
//        $emailNtification1Address = $row[""];
//        $emailNtification1Ship = $row[""];
//        $emailNtification1Exception = $row[""];
//        $emailNtification1Delivery = $row[""];
//        $emailNtification2Address = $row[""];
//        $emailNtification2Ship = $row[""];
//        $emailNtification2Exception = $row[""];
//        $emailNtification2Delivery = $row[""];
//        $emailNtification3Address = $row[""];
//        $emailNtification3Ship = $row[""];
//        $emailNtification3Exception = $row[""];
//        $emailNtification3Delivery = $row[""];
//        $emailNtification4Address = $row[""];
//        $emailNtification4Ship = $row[""];
//        $emailNtification4Exception = $row[""];
//        $emailNtification4Delivery = $row[""];
//        $emailNtification5Address = $row[""];
//        $emailNtification5Ship = $row[""];
//        $emailNtification5Exception = $row[""];
//        $emailNtification5Delivery = $row[""];
//        $emailMessage = $row[""];
//        $emailFailureAddress = $row[""];
//        $upsPremiumCare = "0";
//        $locationId = $row[""];
//        $mediaType = $row[""];
//        $language = $row[""];
//        $notificationAddress = "webmaster@worldirect.com";
//        $adlCodValue = $row[""];
//        $adlDeliverToAddressee = $row[""];
//        $adlShipperMediaType = $row[""];
//        $adlShipperLanguage = $row[""];
//        $adlShipperNotification = $row[""];
        
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
//            "$emailNtification1Address",
//            "$emailNtification1Ship",
//            "$emailNtification1Exception",
//            "$emailNtification1Delivery",
//            "$emailNtification2Address",
//            "$emailNtification2Ship",
//            "$emailNtification2Exception",
//            "$emailNtification2Delivery",
//            "$emailNtification3Address",
//            "$emailNtification3Ship",
//            "$emailNtification3Exception",
//            "$emailNtification3Delivery",
//            "$emailNtification4Address",
//            "$emailNtification4Ship",
//            "$emailNtification4Exception",
//            "$emailNtification4Delivery",
//            "$emailNtification5Address",
//            "$emailNtification5Ship",
//            "$emailNtification5Exception",
//            "$emailNtification5Delivery",
//            "$emailMessage",
//            "$emailFailureAddress",
//            "$upsPremiumCare",
//            "$locationId",
//            "$mediaType",
//            "$language",
//            "$notificationAddress",
//            "$adlCodValue",
//            "$adlDeliverToAddressee",
//            "$adlShipperMediaType",
//            "$adlShipperLanguage",
//            "$adlShipperNotification"
        ];
    }

    $date = date("Y-m-d");
    $fileName = "labels-$carrierName-$date.csv";

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
    readfile($fileName);
    exit;
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
//            print_r(json_encode($row)) . "<br>";
            $values[] = [
                "ancho" => $row["ancho"] * $row["unitbundle"],
                "alto" => $row["alto"],
                "profun" => $row["profun"],
                "peso" => $row["peso"],
                "sugsalpric" => $row["sugsalpric"],
                "packageDeclaredValue" => $row["sugsalpric"] * $row["qty"],
            ];
        }

//        var_dump($values);

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

//        echo "<br>RESPONSE:";
//        var_dump($response);
//        echo "<br>";

        return $response;
    }
}

function getCatPackages(){

    $query = "
        SELECT 
            nombre, ((alto * ancho * largo) / 1728) as val, alto, ancho, largo
        FROM
            cat_package having val > 0 order by val ASC;
    ";

    $result = mysqli_query(conexion(""), $query);

    while ($row = mysqli_fetch_array($result)){
        $tNombre = $row["nombre"];
        $response[$tNombre] = $row;
    }

    return $response;
}

function findPackage($value){
    global $catPackages;

    foreach ($catPackages as $catPackage){
        $tVal = $catPackage["val"];
        $tNombre = $catPackage["nombre"];
//        echo "->$value - $tVal - $tNombre<br>";
        if($tVal >= $value){
            return $tNombre;
        }
    }
}

function getCountryCode($value){
    switch ($value){
        case "USA":
            return "US";
    }
}