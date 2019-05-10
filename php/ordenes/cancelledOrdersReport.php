<?php
session_start();
include_once $_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php";

$startDate = $_GET["startDate"];
$endDate = $_GET["endDate"];
$orderType = $_GET["orderType"];

if($orderType != "all"){
    $filter = "AND estatus = '$orderType'";
}

$filter = "AND (estatus = 'Cancelled' || estatus = 'Canceled')";

$getOrdersQuery = "
    SELECT 
        enc.CODORDEN, enc.ORDSOU, enc.ORDERID, enc.FIRSTNAME, enc.LASTNAME, enc.TIMOFORD, GRANDTOTAL, det.PRODUCTID, det.DISNAM, det.QTY, det.LINETOTAL, det.BUNDLESKU
    FROM
        tra_ord_enc AS enc
            INNER JOIN
        tra_ord_det AS det ON enc.codorden = det.codorden
    WHERE
        (tranum = '' || tranum = 'Cancelled')
            AND timoford BETWEEN '$startDate' AND '$endDate' $filter
    ORDER BY grandtotal DESC;
";
//echo "$getOrdersQuery<br>";
$getOrdersResult = mysqli_query(conexion($_SESSION["pais"]), $getOrdersQuery);
// output headers so that the file is downloaded rather than displayed
$name = "cancelledOrdersReport" . date("Ymd-hms");
header('Content-Type: text/csv; charset=utf-8');
header("Content-Disposition: attachment; filename=$name.csv");

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// output the column headings
fputcsv($output, array("order id", "channel", "first name", "last name", "time of order", "grand total", "product id", "product name", "quantity", "units", "sub total", "note id", "note date", "created by", "note"));
//echo $getOrdersResult->num_rows;

//
$usersQ = "
    SELECT * FROM sigef_usuarios WHERE scid != '';
";
$usersR = mysqli_query(conexion(""), $usersQ);

while ($usersRow = mysqli_fetch_array($usersR)){
    $users[$usersRow["scid"]] = $usersRow["NOMBRE"] . " " . $usersRow["APELLIDO"];
}

//Loop through the array and add to the csv
while ($getOrdersRow = mysqli_fetch_array($getOrdersResult)){
    $orderId = $getOrdersRow["ORDERID"];
    $orderSource = $getOrdersRow["ORDSOU"];
    $firstName = $getOrdersRow["FIRSTNAME"];
    $lastName = $getOrdersRow["LASTNAME"];
    $timeOfOrder = $getOrdersRow["TIMOFORD"];
    $grandTotal = $getOrdersRow["GRANDTOTAL"];
    $productId = $getOrdersRow["PRODUCTID"];
    $productName = $getOrdersRow["DISNAM"];
    $qty = $getOrdersRow["QTY"];
    $subTotal = $getOrdersRow["LINETOTAL"];
    $bundleSKU = $getOrdersRow["BUNDLESKU"];
    $tProductID = ($bundleSKU != '') ? $bundleSKU : $productId;

    $ubq = "SELECT UNITBUNDLE FROM TRA_BUN_DET WHERE AMAZONSKU = '$tProductID'";
    $ubr = mysqli_query(conexion($_SESSION["pais"]), $ubq);
    $units = mysqli_fetch_array($ubr)[0] * $qty;
    $t = [$orderId, $orderSource, $firstName, $lastName, $timeOfOrder, $grandTotal, $productId, $productName, $qty, $units, $subTotal, "", "", "", ""];
    fputcsv($output, $t);

    //
    $notesQ = "
        SELECT 
            *
        FROM
            tra_sc_not AS notes
                INNER JOIN
            tra_ord_enc AS enc ON notes.orderid = enc.codorden
        WHERE
            enc.orderid = '$orderId';
    ";

    $notesR = mysqli_query(conexion($_SESSION["pais"]), $notesQ);

    while($notesRow = mysqli_fetch_array($notesR)){
        $noteId = $notesRow["id"];
        $noteDate = $notesRow["date"];
        $createdBy = $notesRow["createdby"];
        $note = $notesRow["note"];
        $t = [$orderId, "", "", "", "", "", "", "", "", "", "", $noteId, $noteDate, $users[$createdBy], $note];
        fputcsv($output, $t);
    }
}
