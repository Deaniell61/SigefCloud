<?php

session_start();
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

$sku = $_POST["sku"];

$factsQ = "
        SELECT 
            enc.SHIFEE, det.QTY, concat(enc.SHICOU, ' ', enc.SHIPSTATE, ' ', enc.SHIPCITY) AS DEST 
        FROM
            tra_ord_det AS det
                INNER JOIN
            tra_ord_enc AS enc ON det.codorden = enc.codorden
        WHERE
            det.productid = '$sku'
        ORDER BY enc.timoford DESC
        LIMIT 5;
    ";

$factsR = mysqli_query(conexion($_SESSION["pais"]), $factsQ);

if($factsR->num_rows > 0){
    while($factsRow = mysqli_fetch_array($factsR)){
        $tPRECIO = "$" . number_format($factsRow["SHIFEE"], "2", ".", "");
        $tQTY = $factsRow["QTY"];
        $tDEST = $factsRow["DEST"];
        $data .= "
        <tr>
            <td>$tPRECIO</div>
            <td>$tQTY</div> 
            <td>$tDEST</div>
        </tr>
    ";
    }
}
else{
    $data = "
        <tr>
            <td colspan='3'>NO HISTORIC DATA</div>
        </tr>
    ";
}



$response = "
    <table>
        <thead>
            <td>Fee</td>
            <td>Qty</td>
            <td style='overflow: hidden'>Destination</td>
        </thead>
        <tbody>
            $data
        </tbody> 
    </table>
";

echo $response;