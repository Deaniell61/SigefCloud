<?php

$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/sellercloud/sellercloud.php");
$sellercloud = new sellercloud();


$filename=date("W-Y");
$filename .= ".txt";

if(date('D', $timestamp) === 'Mon'){

}

$file = fopen($filename, "w");
fwrite($file, "test\r\n");
fclose($file);














echo "5337532<br>";
$tFullOrder = $sellercloud->getOrderFull("5337532");
$tFullOrder = $tFullOrder->GetOrderFullResult;
orderDetail($tFullOrder, "");
echo "5339971<br>";
$tFullOrder = $sellercloud->getOrderFull("5339971");
$tFullOrder = $tFullOrder->GetOrderFullResult;
orderDetail($tFullOrder, "");
echo "5338559<br>";
$tFullOrder = $sellercloud->getOrderFull("5338559");
$tFullOrder = $tFullOrder->GetOrderFullResult;
orderDetail($tFullOrder, "");
echo "5337794<br>";
$tFullOrder = $sellercloud->getOrderFull("5337794");
$tFullOrder = $tFullOrder->GetOrderFullResult;
orderDetail($tFullOrder, "");

function orderDetail($fullOrder, $codOrden){
    include_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");

    if(count($fullOrder->Items->OrderItem) == 1){
        $items = $fullOrder->Items;
    }
    else{
        $items = $fullOrder->Items->OrderItem;
    }
    $cont = 0;
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
        if ($tCodProv != "") {
            $CODPROV = $tCodProv;
            $update = "UPDATE tra_ord_enc SET CODPROV = '$CODPROV' WHERE CODORDEN = '$CODORDEN';";
//        mysqli_query(conexion($country), $update);
        }

        if ($CODORDEN != "" && $cont == 0) {
            include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
            $delete = "DELETE FROM tra_ord_det WHERE CODORDEN = '$CODORDEN';";
//        mysqli_query(conexion($country), $delete);
        }
        $ordDetQuery = "INSERT INTO tra_ord_det 
                            (CODDETORD, CODORDEN, ORDITEID, PRODUCTID, QTY, DISNAM, LINETOTAL, EBAYITEMID, BACORDQTY, ORIUNIPRI, ORISHICOS, ADJUNIPRI, ADJSHICOS, INVAVAQTY, UPC, CODAMABAL, QUAPUR, LIQID, bucle, CODORDEND, CODPROD, CANTIDAD, CANFACT, CANINV, PRECIO, TOTAL, BUNDLESKU) 
                            VALUES
                            ('$CODDETORD', '$CODORDEN', '$ORDITEID', '$PRODUCTID', '$QTY', '$DISNAM', '$LINETOTAL', '$EBAYITEMID', '$BACORDQTY', '$ORIUNIPRI', '$ORISHICOS', '$ADJUNIPRI', '$ADJSHICOS', '$INVAVAQTY', '$UPC', '$CODAMABAL', '$QUAPUR', '$LIQID', '$bucle', '$CODORDEND', '$CODPROD', '$CANTIDAD', '$CANFACT', '$CANINV', '$PRECIO', '$TOTAL', '$BUNDLESKU');";

        echo "$ordDetQuery<br><br>";
//    mysqli_query(conexion($country), $ordDetQuery);

        $cont += 1;
    }
}



function getCodProv($bundleSKU) {
    $query = "(SELECT product.CODPROV FROM tra_bun_det AS bundle INNER JOIN cat_prod AS product ON bundle.MASTERSKU = product.MASTERSKU WHERE bundle.AMAZONSKU = '$bundleSKU' OR bundle.MASTERSKU = '$bundleSKU' LIMIT 1)";
    $response = $query;
    return $response;
}

//var_dump($items);


