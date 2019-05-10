<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
if (isset($_GET["method"])) {
    $method = $_GET["method"];

    switch ($method) {
        case "getPrices":
            $country = $_GET["country"];
            echo getPrices($country);
            break;
        case "checkASIN":
            $country = $_GET["country"];
            $page = $_GET["page"];
            echo checkASIN($country, $page);
            break;
        case "checkStock":
            $country = $_GET["country"];
            echo checkStock($country);
            break;
        default:
            $response = [
                "status" => "error",
                "message" => "no method"
            ];
            echo json_encode($response);
            break;
    }
}

else {
    $response = [
        "status" => "error",
        "message" => "empty"
    ];

    echo json_encode($response);
}

function getPrices($country) {

    include_once($_SERVER["DOCUMENT_ROOT"] . "/php/lib/amazonMWS/src/MarketplaceWebServiceProducts/amazonMWS.php");
    $amazonMWS = new amazonMWS();

    $countQuery = "
        SELECT 
            count(AMAZONSKU)
        FROM
            tra_bun_det;
    ";
    $countResult = mysqli_query(conexion($country), $countQuery);
    echo mysqli_fetch_array($countResult)[0] . "<br>";

    $query = "
        SELECT 
            AMAZONSKU, UNITBUNDLE, SUGSALPRI, SUGSALPRIC
        FROM
            tra_bun_det WHERE MASTERSKU = '300003';
    ";
    $result = mysqli_query(conexion($country), $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $tMASTERSKU = $row["AMAZONSKU"];
        $tUNITBUNDLE = $row["UNITBUNDLE"];
        $tSUGSALPRI = $row["SUGSALPRI"];
        $tSUGSALPRIC = $row["SUGSALPRIC"];
        $amazonPrice = $amazonMWS->getPriceForSKU($tMASTERSKU);
        $price = ($tSUGSALPRIC > 0) ? $tSUGSALPRIC : $tSUGSALPRI;
//        echo "$price<br>$amazonPrice<br>";
        if ($amazonPrice != null && $price != $amazonPrice) {
            foreach ($amazonPrice as $key => $value) {
//                var_dump();
//                echo "<br>";
                $tPrice = round(floatval(json_decode($value)) / floatval($tUNITBUNDLE), 2);
                $data[] = [
                    "SKU" => $tMASTERSKU,
                    "QUANTITY" => $tUNITBUNDLE,
                    "PRICE" => $tPrice,
                ];
            }

        }
    }
    $response = [
        "stauts" => "success",
        "data" => $data,
    ];

    return json_encode($response);
}

function checkASIN($country, $page) {

    $totalQuery = "SELECT count(*) FROM tra_bun_det;";
    $totalResult = mysqli_query(conexion($country), $totalQuery);
    $total = intval(mysqli_fetch_array($totalResult)[0]);
    $limit = 250;
    $offset = $page * $limit;
    $date = date("Ymd-hms");
//    echo "limit:$limit - offset:$offset<br>";

    include_once($_SERVER["DOCUMENT_ROOT"] . "/php/lib/amazonMWS/src/MarketplaceWebServiceProducts/amazonMWS.php");
    $amazonMWS = new amazonMWS();

    $query = "
        SELECT 
            MASTERSKU, AMAZONSKU, ASIN
        FROM
            tra_bun_det ORDER BY AMAZONSKU LIMIT $limit OFFSET $offset;
    ";


    echo "$query<br>";

    $query = "
        SELECT 
            MASTERSKU, AMAZONSKU, ASIN
        FROM
            tra_bun_det WHERE MASTERSKU = '502300483';
    ";


    $result = mysqli_query(conexion($country), $query);
    $file = fopen($_SERVER["DOCUMENT_ROOT"] . "/csv/checkASIN-$date.txt", "w");
    fwrite($file, "MASTERSKU\tAMAZONSKU\tSIGEF_ASIN\tAMAZON_ASIN\r\n");

    while ($row = mysqli_fetch_assoc($result)) {
        $tSKU = $row["AMAZONSKU"];
        $tSKU1 = $row["MASTERSKU"];
        $tASIN = $row["ASIN"];
        $amazonASIN = $amazonMWS->getASINForSKU($tSKU);

//        if ($amazonASIN != "") {
            $updateQuery = "UPDATE tra_bun_det SET ASIN = '$amazonASIN' WHERE AMAZONSKU = '$tSKU';";

            if ($tASIN != $amazonASIN) {
                $data[] = [
                    "AMAZON_SKU" => $tSKU,
                    "SIGEF_ASIN" => $tASIN,
                    "AMAZON_ASIN" => (string)$amazonASIN,
                    "QUERY" => $updateQuery,
                ];
                fwrite($file, "$tSKU1\t$tSKU\t$tASIN\t$amazonASIN\r\n");

//            mysqli_query(conexion($country), $updateQuery);
            }
//        }
    }

    $response = [
        "stauts" => "success",
        "data" => $data,
        "report" => "http://desarrollo.sigefcloud.com/csv/checkASIN-$date.txt",
    ];

    fclose($file);

    return json_encode($response);
}

/*
 * 502300569 - Café Incasa - Activo
502300483 - Dulce Jaramillo - Inactivo (out stock)
502300524 - Vick Vaporub - Inactivo (Cerrado)
502300550 - Santemicina - Eliminado
300003
 */
function checkStock($country) {

    include_once($_SERVER["DOCUMENT_ROOT"] . "/php/lib/amazonMWS/src/FBAInventoryServiceMWS/amazonMWS.php");

    $amazonMWS = new amazonMWS();

    $query = "
        SELECT 
            MASTERSKU, AMAZONSKU, ASIN
        FROM
            tra_bun_det WHERE MASTERSKU = '502300569';
    ";

    $result = mysqli_query(conexion($country), $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $tSKU = $row["AMAZONSKU"];
        $tSKU1 = $row["MASTERSKU"];
        $tASIN = $row["ASIN"];
        $amazonMWS->getStockForSKU($tSKU);

        $data[] = [
            "AMAZON_SKU" => $tSKU,
            "SIGEF_ASIN" => $tASIN,
            "AMAZON_ASIN" => "",
        ];
    }

    $response = [
        "stauts" => "success",
        "data" => $data,
    ];

    return json_encode($response);
}

/*
 * master
amazon
asin
santemicina
estatus	activs	inactivos fuera	inactivos cerrados

 */