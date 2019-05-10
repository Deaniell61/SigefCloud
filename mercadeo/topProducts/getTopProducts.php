<?php
session_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
$method = $_POST["method"];
switch ($method) {
    case"auto":
        $startDate = $_POST["startDate"];
        $endDate = $_POST["endDate"];
        $quantity = $_POST["quantity"];
        echo getTopProducts($method, $startDate, $endDate, $quantity);
        break;
    case"skuList":
        $startDate = $_POST["startDate"];
        $endDate = $_POST["endDate"];
        $skuList = rtrim($_POST["skuList"],",");
        echo getTopProducts($method, $startDate, $endDate, $skuList);
        break;
}
function getTopProducts($method, $startDate, $endDate, $par1) {
    switch ($method) {
        case "auto":
            $quantity = $par1;
            $productsQ = "
                SELECT 
                    det.productid AS sku,
                    det.disnam,
                    ROUND (SUM(det.linetotal), 2) AS tot,
                    SUM(det.qty) AS qty,
                    prod.imaurlbase,
                    cat.nombre
                FROM
                    tra_ord_enc AS enc
                        INNER JOIN
                    tra_ord_det AS det ON enc.codorden = det.codorden
                        INNER JOIN
                    cat_prod AS prod ON det.productid = prod.mastersku
                        INNER JOIN
                    cat_cat_pro AS cat ON prod.categori = cat.codcate
                WHERE
                    timoford BETWEEN '$endDate' AND '$startDate'
                GROUP BY det.productid
                ORDER BY tot desc limit $quantity;
            ";
            $statesQ = "
                SELECT 
                    enc.shipstate,
                    ROUND(SUM(det.linetotal), 2) AS tot,
                    SUM(det.qty) AS qty
                FROM
                    tra_ord_enc AS enc
                        INNER JOIN
                    tra_ord_det AS det ON enc.codorden = det.codorden
                WHERE
                    timoford BETWEEN '2018-04-05T10:59:29' AND '2018-04-12T10:59:29'
                        AND det.productid IN (@skuList)
                GROUP BY enc.shipstate
                ORDER BY tot DESC
                LIMIT 10;
            ";
            break;
        case"skuList":
            $skuList = $par1;
            $productsQ = "
                SELECT 
                    det.productid AS sku,
                    det.disnam,
                    ROUND (SUM(det.linetotal), 2) AS tot,
                    SUM(det.qty) AS qty,
                    prod.imaurlbase,
                    cat.nombre
                FROM
                    tra_ord_enc AS enc
                        INNER JOIN
                    tra_ord_det AS det ON enc.codorden = det.codorden
                        INNER JOIN
                    cat_prod AS prod ON det.productid = prod.mastersku
                        INNER JOIN
                    cat_cat_pro AS cat ON prod.categori = cat.codcate
                WHERE
                    det.productid in ($skuList)
                GROUP BY det.productid
                ORDER BY tot desc;
            ";
            break;
    }
    echo $productsQ;
    $productsR = mysqli_query(conexion("Guatemala"), $productsQ);
    $ttot = 0;
    $tSkuList;
    while ($row = mysqli_fetch_array($productsR)) {
        $ttot += $row["tot"];
        $tSkuList[] = $row["sku"];
    }
    $statesQ = str_replace("@skuList", $tSkuList, $statesQ);
    echo $tSkuList;
    mysqli_data_seek($productsR, 0);
    while ($row = mysqli_fetch_array($productsR)) {
        $sku = $row["sku"];
        $image = "https://sigefcloud.com/imagenes/media/guatedirect_llc" . $row["imaurlbase"];
        $name = $row["disnam"];
        $qty = $row["qty"];
        $sales = $row["tot"];
        $percentage = round($row["tot"] * 100 / $ttot, 2);
        $category = $row["nombre"];
        $data .= "
            <tr>
                <td><input type='checkbox' id='selectSomething'></td>
                <td>$sku</td>
                <td><img width='32px' height='32px' src='$image'></td>
                <td>$name</td>
                <td>$qty</td>
                <td>$sales</td>
                <td>$percentage</td>
                <td>$category</td>
            </tr>
        ";
    }
    $response = "
        <table id='topProducts1'>
            <thead>
                <tr>
                    <th><img src='../../images/yes.jpg'></th>
                    <th>Master SKU</th>
                    <th>Imagen</th>
                    <th>Nombre de Producto</th>
                    <th>Unidades Vendidas</th>
                    <th>Monto Vendido</th>
                    <th>% Participacion</th>
                    <th>Categoria</th>
                </tr>
            </thead>
            <tbody>
                $data
            </tbody>            
        </table>
        
        <br>
        <br>
        
        $statesQ
        
        <table id='topStates1'>
            <thead>
                <tr>
                    <th><img src='../../images/yes.jpg'></th>
                    <th>Estado</th>
                    <th>Correos</th>
                    <th>Unidades</th>
                    <th>Montos</th>
                </tr>
            </thead>
            <tbody>
                $data1
            </tbody>            
        </table>
    ";
    return $response;
}