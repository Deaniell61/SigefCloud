<?php
session_start();
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
$orderID = $_POST["orderID"];
$orderQ = "
    SELECT det.productid, det.disnam, det.qty as units FROM tra_ord_enc AS enc INNER JOIN tra_ord_det AS det ON enc.codorden = det.codorden WHERE orderid = '$orderID';
";

//echo $orderQ;

$orderR = mysqli_query(conexion($_SESSION["pais"]), $orderQ);

if($orderR->num_rows == 0){
    return "ORDER $orderID DOES NOT EXISTS...";
}


while ($orderRow = mysqli_fetch_array($orderR)){
    $id = $orderRow["productid"];
    $name = $orderRow["disnam"];
    $qty = $orderRow["units"];


    $bundQ = "
        select unitbundle, upc from tra_bun_det where (mastersku = '$id' or amazonsku = '$id') order by unitbundle asc limit 1;
    ";
    $bundR = mysqli_query(conexion($_SESSION["pais"]), $bundQ);
    $bundRow = mysqli_fetch_array($bundR);

    $upc = $bundRow["upc"];
    $unitbundle = $bundRow["unitbundle"];

    $input = "<input type='text' name='$id' class='entradaTexto singlePackageProduct' value='$unitbundle' onKeyUp='getLimits();'>";

    $data .= "
        <tr>
            <td>$id</td>
            <td>$name</td>
            <td>$qty</td>
            <td>$unitbundle</td>
            <td>$input</td>
        </tr>
    ";
}

$table = "
    <table id='singlePackageDetail'>
        <thead>
            <th>ID</th>
            <th>NAME</th>
            <th>QUANTITY</th>
            <th>UNITS</th>
            <th>LABELS</th>
        </thead>
        <tbody>
            $data
        </tbody>
    </table>
";

$response = $table;

echo $response;