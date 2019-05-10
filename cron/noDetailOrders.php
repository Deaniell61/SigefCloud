<?php
$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/sellercloud/sellercloud.php");

$sellercloud = new sellercloud();

$ordersQuery = "
    SELECT * FROM tra_ord_enc WHERE codpedido = 'SINDETALLE';
";

$ordersResult = mysqli_query(conexion("Guatemala"), $ordersQuery);

$cOrds = 0;
$cIns = 0;

$ordersTotal = count($ordersResult);

//echo "ORDERS:$ordersTotal<br>";

while ($ordersRow = mysqli_fetch_array($ordersResult)){
    $tCodOrden = $ordersRow["CODORDEN"];
    $tOrderId = $ordersRow["ORDERID"];
    $tFullOrder = $sellercloud->getOrderFull($tOrderId);
//    echo "$tOrderId<br>";
//    var_dump($tFullOrder);
    $cOrds += 1;
    insertOrderDetail($tCodOrden, $tFullOrder, "Guatemala");
}

function insertOrderDetail($codOrden, $fullOrder, $country) {
    global $cIns;
    include_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");
    $fullOrder = $fullOrder->GetOrderFullResult;
//    var_dump($fullOrder1);
//    echo "<br><br>";
    if(count($fullOrder->Items->OrderItem) == 1){
        $items = $fullOrder->Items;
    }
    else{
        $items = $fullOrder->Items->OrderItem;
    }
//    var_dump($items);

    foreach ($items as $orderItem) {
        $CODDETORD = sys2015();
        $CODORDEN = $codOrden;
        $ORDITEID = $fullOrder->Packages->Package->OrderItemID;
        $PRODUCTID = $orderItem->ProductID;
        $QTY = $orderItem->Qty;
        $DISNAM = $orderItem->DisplayName;
        $LINETOTAL = $orderItem->LineTotal;
        $EBAYITEMID = $orderItem->eBayItemID;
        $BACORDQTY = $orderItem->BackOrderQty;
        $ORIUNIPRI = $orderItem->SitePrice;
        $ORISHICOS = '';
        $ADJSHICOS = $fullOrder->Packages->Package->FinalShippingFee;
        $ADJUNIPRI = $orderItem->AdjustedSitePrice;
        $INVAVAQTY = '';
        $UPC = '';
        $CODAMABAL = '';
        $QUAPUR = '';
        $LIQID = '';
        $bucle = '';
        $CODORDEND = '';
        $CODPROD = '';
        $CANTIDAD = '';
        $CANFACT = '';
        $CANINV = '';
        $PRECIO = '';
        $TOTAL = '';
        $BUNDLESKU = $fullOrder->ShippingItems->OrderItem->ProductIDOriginal;

        $tCodProv = getCodProv($BUNDLESKU);

        $ordDetQuery = "INSERT INTO tra_ord_det 
                            (CODDETORD, CODORDEN, ORDITEID, PRODUCTID, QTY, DISNAM, LINETOTAL, EBAYITEMID, BACORDQTY, ORIUNIPRI, ORISHICOS, ADJUNIPRI, ADJSHICOS, INVAVAQTY, UPC, CODAMABAL, QUAPUR, LIQID, bucle, CODORDEND, CODPROD, CANTIDAD, CANFACT, CANINV, PRECIO, TOTAL, BUNDLESKU) 
                            VALUES
                            ('$CODDETORD', '$CODORDEN', '$ORDITEID', '$PRODUCTID', '$QTY', '$DISNAM', '$LINETOTAL', '$EBAYITEMID', '$BACORDQTY', '$ORIUNIPRI', '$ORISHICOS', '$ADJUNIPRI', '$ADJSHICOS', '$INVAVAQTY', '$UPC', '$CODAMABAL', '$QUAPUR', '$LIQID', '$bucle', '$CODORDEND', '$CODPROD', '$CANTIDAD', '$CANFACT', '$CANINV', '$PRECIO', '$TOTAL', '$BUNDLESKU');";

//        echo "$ordDetQuery<br><br>";

        $cIns += 1;
        mysqli_query(conexion($country), $ordDetQuery);
    }
    $updateOrdEnc = "UPDATE tra_ord_enc SET CODPEDIDO = '' WHERE CODORDEN = '$CODORDEN';";
    mysqli_query(conexion($country), $updateOrdEnc);

//    echo "<br>$updateOrdEnc<br><br>";
}

echo "ORDENES:$cOrds - INSERTS:$cIns<br>";

function getCodProv($bundleSKU) {
    $query = "(SELECT product.CODPROV FROM tra_bun_det AS bundle INNER JOIN cat_prod AS product ON bundle.MASTERSKU = product.MASTERSKU WHERE bundle.AMAZONSKU = '$bundleSKU' OR bundle.MASTERSKU = '$bundleSKU' LIMIT 1)";
    $response = $query;
    return $response;
}