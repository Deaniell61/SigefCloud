<?php
session_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
if (isset($_POST["method"])) {
    $method = $_POST["method"];
    switch ($method) {
        case "getBalance":
            $balanceId = $_POST["balanceId"];
            echo getBalance($balanceId);
            break;
        case "getBalanceDetail":
            $balanceId = $_POST["balanceId"];
            echo getBalanceDetail($balanceId);
            break;
        case "getOrdenesDetail":
            $balanceId = $_POST["balanceId"];
            echo getOrdenesDetail($balanceId);
            break;
        case "getCargosCanalDetail":
            $balanceId = $_POST["balanceId"];
            echo getCargosCanalDetail($balanceId);
            break;
        case "getShippingDetail":
            $balanceId = $_POST["balanceId"];
            echo getShippingDetail($balanceId);
            break;
        case "getOtrosCargosDetail":
            $balanceId = $_POST["balanceId"];
            echo getOtrosCargosDetail($balanceId);
            break;
    }
}

function getBalance($balanceId) {

    $codProv = $_SESSION["codprov"];
    $getBalancesQuery = "
        SELECT 
            *
        FROM
            tra_balances
        WHERE
            CODBALANCE = '$balanceId'
        AND
            CODPROV = '$codProv'
    ";

    //
    $vpQuery = "
        SELECT 
            LINETOTAL
        FROM
            tra_ord_det
        WHERE
            CODORDEN IN (SELECT 
                    CODORDEN
                FROM
                    tra_ord_enc
                WHERE
                    CODBALCOM IN (SELECT 
                            CODBALCOM
                        FROM
                            tra_balances
                        WHERE
                            CODBALANCE = '$balanceId'
                                AND CODPROV = '$codProv'));
    ";

    $vpResult = mysqli_query(conexion($_SESSION["pais"]), $vpQuery);
    $vp = 0;
    while ($vpRow = mysqli_fetch_array($vpResult)) {
        $vp += $vpRow[0];
    }

    //
    $esQuery = "
        SELECT 
            SHITOT, GIFTWRAP
        FROM
            tra_ord_enc
        WHERE
            CODBALCOM IN (SELECT 
                    CODBALCOM
                FROM
                    tra_balances
                WHERE
                    CODBALANCE = '$balanceId'
                        AND CODPROV = '$codProv');
    ";

    $esResult = mysqli_query(conexion($_SESSION["pais"]), $esQuery);
    $es = 0;
    while ($esRow = mysqli_fetch_array($esResult)) {
        $es += $esRow[0] + $esRow[1];
    }

    //cargos de canal
    $ocQuery = "
        SELECT 
            CODCARGO, VALOR
        FROM
            tra_bit_cobro
        WHERE
            CODDOCTO IN (SELECT 
                    CODORDEN
                FROM
                    tra_ord_enc
                WHERE
                    CODBALCOM IN (SELECT 
                            CODBALCOM
                        FROM
                            tra_balances
                        WHERE
                            CODBALANCE = '$balanceId'
                                AND CODPROV = '$codProv'));    
    ";
    $ocResult = mysqli_query(conexion($_SESSION["pais"]), $ocQuery);

    $cf = 0;
    $sh = 0;
    while ($ocRow = mysqli_fetch_array($ocResult)) {
        $tCodCargo = $ocRow["CODCARGO"];
        $tuQuery = "
            SELECT 
                UBICACION
            FROM
                cat_car_proyecto
            WHERE
                CODCARGO = '$tCodCargo';
        ";
        $tuResult = mysqli_query(conexion(""), $tuQuery);
        $tu = mysqli_fetch_array($tuResult)[0];

        switch ($tu) {
            case "SH":
                $sh += $ocRow["VALOR"];
                break;
            case "CF":
                $cf += $ocRow["VALOR"];
                break;
        }
    }

    $getBalancesResult = mysqli_query(conexion($_SESSION["pais"]), $getBalancesQuery);
    $response = mysqli_fetch_array($getBalancesResult);
    $response["vp"] = $vp;
    $response["es"] = $es;
    $response["sh"] = $sh;
    $response["cf"] = $cf;
    return json_encode($response);
}

function getBalanceDetail($balanceId) {

    //ordenes

    //otros cargos
    //cargos de canal
    $ocQuery = "
        SELECT 
            *
        FROM
            tra_bit_cobro AS a
        INNER JOIN
            tra_ord_enc AS b ON a.CODDOCTO = b.CODORDEN
        WHERE
            CODDOCTO IN (SELECT 
                    CODORDEN
                FROM
                    tra_ord_enc
                WHERE
                    CODBALCOM IN (SELECT 
                            CODBALCOM
                        FROM
                            tra_balances
                        WHERE
                            CODBALANCE = '$balanceId'
                                AND CODPROV = '$codProv'));    
    ";
//    return $ocQuery;
    $ocResult = mysqli_query(conexion($_SESSION["pais"]), $ocQuery);

    while ($ocRow = mysqli_fetch_array($ocResult)) {
        $tCodCargo = $ocRow["CODCARGO"];
        $tuQuery = "
            SELECT 
                UBICACION
            FROM
                cat_car_proyecto
            WHERE
                CODCARGO = '$tCodCargo';
        ";
        $tuResult = mysqli_query(conexion(""), $tuQuery);
        $tu = mysqli_fetch_array($tuResult)[0];

        switch ($tu) {
            case "SH":
                $sh[] = $ocRow;
                break;
            case "CF":
                $cf[] = $ocRow;
                break;
        }
    }

    $response["ordenes"] = $oResponse;
    $response["ordenesQuery"] = $oQuery;
    $response["otrosCargos"] = $cf;
    $response["shipping"] = $sh;
    $response["ocQuery"] = $ocQuery;
    $response["cargosCanal"] = ["cargos canal detail"];
    return json_encode($response);
}

function getOrdenesDetail($balanceId) {

    $codProv = $_SESSION["codprov"];
    $oQuery = "
        SELECT 
            *, sum(LINETOTAL) as TLINETOTAL, SUM(bun.COSPRI) AS COSPRI
        FROM
            tra_ord_enc AS enc 
        INNER JOIN 
            tra_ord_det AS det 
        ON enc.CODORDEN = det.CODORDEN
        INNER JOIN
            tra_bun_det AS bun 
        ON bun.amazonsku = det.productid
        WHERE
            CODBALCOM IN (SELECT 
                    CODBALCOM
                FROM
                    tra_balances
                WHERE
                    CODBALANCE = '$balanceId'
                        AND CODPROV = '$codProv')
            AND (CODTORDEN = 'ONL' OR CODTORDEN = 'OFL')
        GROUP BY ORDERID;
    ";
//    echo $oQuery . "<br>";
    $oResult = mysqli_query(conexion($_SESSION["pais"]), $oQuery);
    $tBody = "";
    $ttUnidades = 0;
    $ttSubtotal = 0;
    $ttShipping = 0;
    $ttTotal = 0;
    $ttCosto = 0;
    $ttCargosCanal = 0;
    $ttCargosShipping = 0;
    $ttNeto = 0;
    while ($oRow = mysqli_fetch_array($oResult)) {

        $tCF = 0;
        $tSH = 0;
        $tCodOrden = $oRow["CODORDEN"];
        $tCargosQuery = "
            SELECT 
                CODCARGO, VALOR
            FROM
                tra_bit_cobro
            WHERE
                CODDOCTO = '$tCodOrden'; 
        ";
        $tCargosResult = mysqli_query(conexion($_SESSION["pais"]), $tCargosQuery);

        while ($tCargosRow = mysqli_fetch_array($tCargosResult)) {
            $tCodCargo = $tCargosRow["CODCARGO"];
            $tCargoQuery = "
                SELECT 
                    UBICACION
                FROM
                    cat_car_proyecto
                WHERE
                    CODCARGO = '$tCodCargo';
            ";
//            echo $tCargoQuery."<br>";
            $tCargoResult = mysqli_query(conexion(""), $tCargoQuery);
            if ($tCargoResult->num_rows > 0) {
                while ($tCargoRow = mysqli_fetch_array($tCargoResult)) {
                    $tCargo = $tCargoRow["UBICACION"];
//                    echo "$tCargo : <br>";
                    switch ($tCargo) {
                        case "CF":
                            $tCF += $tCargosRow["VALOR"];
                            break;

                        case "SH":
                            $tSH += $tCargosRow["VALOR"];
                            break;
                    }
                }
            }
        }

        $tOrdenId = $oRow["ORDERID"];
        $tCanalVenta = $oRow["ORDSOU"];
        $tDate = explode(" ", $oRow["TIMOFORD"])[0];
        $tDate = explode("-", $tDate)[2] . "/" . explode("-", $tDate)[1] . "/" . explode("-", $tDate)[0];
        $tFecha = $tDate;
        $tEstado = $oRow["SHIPSTATE"];
        $tUnidades = $oRow["ORDERUNITS"];
        $ttUnidades += $tUnidades;
        $tSubtotal = number_format($oRow["TLINETOTAL"], 2);
        $ttSubtotal += $tSubtotal;
        $ttSubtotal = number_format($ttSubtotal, 2);
        $tShipping = number_format($oRow["SHITOT"] + $oRow["GIFTWRAP"], 2);
        $ttShipping += $tShipping;
        $ttShipping = number_format($ttShipping, 2);
        $tTotal = number_format($oRow["GRANDTOTAL"], 2);
        $ttTotal += $tTotal;
        $ttTotal = number_format($ttTotal, 2);
        $tCargosCanal = "-" . number_format($tCF, 2);
        $ttCargosCanal += $tCargosCanal;
        $ttCargosCanal = number_format($ttCargosCanal, 2);
        $tCargosShipping = "-" . number_format($tSH, 2);
        $ttCargosShipping += $tCargosShipping;
        $ttCargosShipping = number_format($ttCargosShipping, 2);
        $tNeto = number_format($oRow["GRANDTOTAL"] - $tCF - $tSH, 2);
        $ttNeto += $tNeto;
        $ttNeto = number_format($ttNeto, 2);
        $tCosto = number_format($oRow["COSPRI"], 2);
        $ttCosto += $tCosto;
        $ttCosto = number_format($ttCosto, 2);
        $tMargen = ($tNeto - $tCosto) / $tCosto;
        $tMargen = number_format($tMargen, 2);
        $ttMargen += $tMargen;
        $ttMargen = number_format($ttMargen, 2);
        $tBody .= "
            <tr>
                <td>$tOrdenId</td>
                <td>$tCanalVenta</td>
                <td>$tFecha</td>
                <td>$tEstado</td>
                <td>$tUnidades</td>
                <td>$$tSubtotal</td>
                <td>$$tShipping</td>
                <td>$$tTotal</td>
                <td>$$tCargosCanal</td>
                <td>$$tCargosShipping</td>
                <td>$$tNeto</td>
                <td>$$tCosto</td>
                <td>$$tMargen</td>
            </tr>
        ";
    }

    $tFoot = "
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>$ttUnidades</td>
            <td>$$ttSubtotal</td>
            <td>$$ttShipping</td>
            <td>$$ttTotal</td>
            <td>$$ttCargosCanal</td>
            <td>$$ttCargosShipping</td>
            <td>$$ttNeto</td>
            <td>$$ttCosto</td>
            <td>$$ttMargen</td>
        </tr>
    ";
    $table = "
        <table style='width: 100%' id=\"ordenesTable\" class=\"cell-border\">
            <thead>
            <tr>
                <td>ID Orden</td>
                <td>Canal de Venta</td>
                <td>Fecha</td>
                <td>Estado</td>
                <td>Unidades</td>
                <td>Subtotal</td>
                <td>Shipping y Otro</td>
                <td>Total</td>
                <td>Cargos de Canal</td>
                <td>Cargos de Shipping</td>
                <td>Neto Orden</td>
                <td>Costo</td>
                <td>Margen de Utilidad</td>
            </tr>
            </thead>
            <tbody>$tBody</tbody>
            <tfoot>$tFoot</tfoot>
        </table>
        <script>
        $('#ordenesTable').DataTable({
            'paging': true,
            'filter': false,
            'info': false,
            'scrollY': '500px',
            'scrollX': 'true',
            'scrollCollapse': true,
        });
        </script>
    ";
    $response = $table;
    return $response;
}

function getCargosCanalDetail($balanceId) {

    $ocQuery = "
        SELECT 
            CODCARGO, NOMBRE
        FROM
            cat_car_proyecto;
    ";

    $cResult = mysqli_query(conexion(""), $ocQuery);

    $ttCantidad = 0;
    $ttPrecio = 0;
    $ttTotal = 0;
    while ($cRow = mysqli_fetch_array($cResult)) {
        $cargos[$cRow["CODCARGO"]] = utf8_encode($cRow["NOMBRE"]);
    }

    $codProv = $_SESSION["codprov"];
    $ocQuery = "
        SELECT 
            b.ORDERID, a.VALOR, b.TIMOFORD, b.ORDERUNITS, a.PRECIO, a.CODCARGO
        FROM
            tra_bit_cobro AS a
        INNER JOIN
            tra_ord_enc AS b ON a.CODDOCTO = b.CODORDEN
        WHERE
            CODDOCTO IN (SELECT 
                    CODORDEN
                FROM
                    tra_ord_enc
                WHERE
                    CODBALCOM IN (SELECT 
                            CODBALCOM
                        FROM
                            tra_balances
                        WHERE
                            CODBALANCE = '$balanceId'
                                AND CODPROV = '$codProv'));    
    ";
//    echo $ocQuery;
    $ocResult = mysqli_query(conexion($_SESSION["pais"]), $ocQuery);
    $tBody = "";
    while ($ocRow = mysqli_fetch_array($ocResult)) {
        $tCodCargo = $ocRow["CODCARGO"];
        $tuQuery = "
            SELECT 
                UBICACION
            FROM
                cat_car_proyecto
            WHERE
                CODCARGO = '$tCodCargo';
        ";
        $tuResult = mysqli_query(conexion(""), $tuQuery);
        $tu = mysqli_fetch_array($tuResult)[0];

        switch ($tu) {
            case "CF":
                $tId = $ocRow["ORDERID"];
                $tDate = date_create($ocRow["TIMOFORD"]);
                $tDate = date_format($tDate, "M/d/Y");
                $tDesc = $tId . " - " . $cargos[$ocRow["CODCARGO"]] . " - " . $tDate;
                $tQuantity = $ocRow["ORDERUNITS"];
                $ttCantidad += $tQuantity;
                $tPrice = sprintf("%.2f", $ocRow["PRECIO"]);
                $ttPrecio += $tPrice;
                $tTotal = $ocRow["VALOR"];
                $ttTotal += $tTotal;
                $ttTotal = number_format($ttTotal, 2);
                $tBody .= "
                    <tr>
                        <td>$tDesc</td>
                        <td>$tQuantity</td>
                        <td>$$tPrice</td>
                        <td>$$tTotal</td>
                    </tr>
                ";
                break;
        }
    }

    $tFoot = "
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>$$ttTotal</td>
        </tr>
    ";

    $table = "
        <table id=\"cargosCanalTable\" class=\"cell-border\">
            <thead>
            <tr>
                <td>Descripcion / Fecha / Detalle</td>
                <td>Cantidad</td>
                <td>Precio</td>
                <td>Total</td>
            </tr>
            </thead>
            <tbody>$tBody</tbody>
            <tfoot>$tFoot</tfoot>
            </table>
        <script>
        $('#cargosCanalTable').DataTable({
            'paging': true,
            'filter': false,
            'info': false,
            'scrollY': '500px',
            'scrollCollapse': true,
        });
        </script>
    ";
    $response = $table;
    return $response;
}

function getShippingDetail($balanceId) {

    $ocQuery = "
        SELECT 
            CODCARGO, NOMBRE
        FROM
            cat_car_proyecto;
    ";

    $cResult = mysqli_query(conexion(""), $ocQuery);

    while ($cRow = mysqli_fetch_array($cResult)) {
        $cargos[$cRow["CODCARGO"]] = utf8_encode($cRow["NOMBRE"]);
    }

    $codProv = $_SESSION["codprov"];
    $ocQuery = "
        SELECT 
            b.ORDERID, a.VALOR, b.TIMOFORD, b.ORDERUNITS, a.PRECIO, a.CODCARGO
        FROM
            tra_bit_cobro AS a
        INNER JOIN
            tra_ord_enc AS b ON a.CODDOCTO = b.CODORDEN
        WHERE
            CODDOCTO IN (SELECT 
                    CODORDEN
                FROM
                    tra_ord_enc
                WHERE
                    CODBALCOM IN (SELECT 
                            CODBALCOM
                        FROM
                            tra_balances
                        WHERE
                            CODBALANCE = '$balanceId'
                                AND CODPROV = '$codProv'));    
    ";
//    echo $ocQuery;
    $ocResult = mysqli_query(conexion($_SESSION["pais"]), $ocQuery);
    $tBody = "";
    $ttCantidad = 0;
    $ttPrecio = 0;
    $ttTotal = 0;
    while ($ocRow = mysqli_fetch_array($ocResult)) {
        $tCodCargo = $ocRow["CODCARGO"];
        $tuQuery = "
            SELECT 
                UBICACION
            FROM
                cat_car_proyecto
            WHERE
                CODCARGO = '$tCodCargo';
        ";
        $tuResult = mysqli_query(conexion(""), $tuQuery);
        $tu = mysqli_fetch_array($tuResult)[0];

        switch ($tu) {
            case "SH":
                $tId = $ocRow["ORDERID"];
                $tDate = date_create($ocRow["TIMOFORD"]);
                $tDate = date_format($tDate, "M/d/Y");
                $tDesc = $tId . " - " . $cargos[$ocRow["CODCARGO"]] . " - " . $tDate;
                $tQuantity = $ocRow["ORDERUNITS"];
                $ttCantidad +=  $tQuantity;
                $tPrice = sprintf("%.2f", $ocRow["PRECIO"]);
                $ttPrecio += $tPrice;
                $tTotal = $ocRow["VALOR"];
                $ttTotal += $tTotal;
                $ttTotal = number_format($ttTotal, 2);
                $tBody .= "
                    <tr>
                        <td>$tDesc</td>
                        <td>$tQuantity</td>
                        <td>$$tPrice</td>
                        <td>$$tTotal</td>
                    </tr>
                ";
                break;
        }
    }
    $tFoot = "
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>$$ttTotal</td>
        </tr>
    ";
    $table = "
        <table id=\"shippingTable\" class=\"cell-border\">
            <thead>
            <tr>
                <td>Descripcion / Fecha / Detalle</td>
                <td>Cantidad
                </td>
                <td>Precio</td>
                <td>Total</td>
            </tr>
            </thead>
            <tbody>$tBody</tbody>
            <tfoot>$tFoot</tfoot>
        </table>
        <script>
        $('#shippingTable').DataTable({
            'paging': true,
            'filter': false,
            'info': false,
            'scrollY': '500px',
            'scrollCollapse': true,
        });
        </script>
    ";
    $response = $table;
    return $response;
}

function getOtrosCargosDetail($balanceId) {
    $ocQuery = "
        SELECT 
            CODCARGO, NOMBRE
        FROM
            cat_car_proyecto;
    ";

    $cResult = mysqli_query(conexion(""), $ocQuery);

    while ($cRow = mysqli_fetch_array($cResult)) {
        $cargos[$cRow["CODCARGO"]] = utf8_encode($cRow["NOMBRE"]);
    }

    $codProv = $_SESSION["codprov"];
//cargos de canal
    $ocQuery = "
        SELECT 
            *
        FROM
            tra_det_cobro AS a
                INNER JOIN
            tra_bit_cobro AS b ON a.CODDETCOB = b.CODDETCOB
        WHERE
            CODBALANCE = '$balanceId'
                AND CODPROV = '$codProv'
        ORDER BY FECHACAR;    
    ";
    $ocResult = mysqli_query(rconexionProveedorLocal($_SESSION["pais"]), $ocQuery);
    $oc1Result = mysqli_query(conexion($_SESSION["pais"]), $ocQuery);
//    echo $ocQuery."<br>";
//    var_dump($oc1Result);
    $tBody = "";
    $ttTotal = 0;
    while ($ocRow = mysqli_fetch_array($ocResult)) {
        $tCodCargo = $ocRow["CODCARGO"];
        $tuQuery = "
            SELECT 
                UBICACION, OBSER
            FROM
                cat_car_proyecto
            WHERE
                CODCARGO = '$tCodCargo';
        ";
        $tuResult = mysqli_query(conexion(""), $tuQuery);
        $tuRow = mysqli_fetch_array($tuResult);
        $tu = $tuRow[0];
        $tuObser = $tuRow[1];
        switch ($tu) {
            case "OC":
                $tId = "";
                $tDate = date_create($ocRow["FECHACAR"]);
                $tDate = date_format($tDate, "M/d/Y");
                $tD = explode(" ", $ocRow["OBSER"]);
                $tMiddle1 = substr($tD[4], 0, 4);
                $tMiddle2 = substr($tD[4], 5, strlen($tD[4]) - 1);
                $tD1 = $tD[0] . " " . $tD[1] . " " . $tD[2] . " " . $tD[3] . " " . $tMiddle1;
                $tD2 = $tMiddle2 . " " . $tD[5] . " " . $tD[6] . " " . $tD[7] . " " . $tD[8] . " " . $tD[9];
                $tDesc = $cargos[$ocRow["CODCARGO"]] . " - " . $tDate."<br>" . $tD1 . "<br>" . $tD2;
                $tQuantity = number_format($ocRow["CANTIDAD"], 0);
                $tPrice = number_format($ocRow["PRECIO"], 2);
                $tTotal = $ocRow["VALOR"];
                $tObservaciones = $tuObser;
                $ttTotal +=  $tTotal;
                $ttTotal = number_format($ttTotal, 2);
                $tBody .= "
                    <tr>
                        <td>$tDesc</td>
                        <td>$tQuantity</td>
                        <td>$$tPrice</td>
                        <td>$$tTotal</td>
                        <td>$tObservaciones</td>
                    </tr>
                ";
                break;
        }
    }
    while ($ocRow = mysqli_fetch_array($oc1Result)) {
        $tCodCargo = $ocRow["CODCARGO"];
        $tuQuery = "
            SELECT 
                UBICACION, OBSER
            FROM
                cat_car_proyecto
            WHERE
                CODCARGO = '$tCodCargo';
        ";
        $tuResult = mysqli_query(conexion(""), $tuQuery);
        $tuRow = mysqli_fetch_array($tuResult);
        $tu = $tuRow[0];
        $tuObser = $tuRow[1];
        switch ($tu) {
            default:
                $tId = "";
                $tDate = date_create($ocRow["FECHACAR"]);
                $tDate = date_format($tDate, "M/d/Y");
                $tD = explode(" ", $ocRow["OBSER"]);
                $tMiddle1 = substr($tD[4], 0, 4);
                $tMiddle2 = substr($tD[4], 5, strlen($tD[4]) - 1);
                $tD1 = $tD[0] . " " . $tD[1] . " " . $tD[2] . " " . $tD[3] . " " . $tMiddle1;
                $tD2 = $tMiddle2 . " " . $tD[5] . " " . $tD[6] . " " . $tD[7] . " " . $tD[8] . " " . $tD[9];
                $tDesc = $cargos[$ocRow["CODCARGO"]] . " - " . $tDate."<br>" . $tD1 . "<br>" . $tD2;
                $tQuantity = number_format($ocRow["CANTIDAD"], 0);
                $tPrice = number_format($ocRow["PRECIO"], 2);
                $tTotal = $ocRow["VALOR"];
                $tObservaciones = $tuObser;
                $ttTotal +=  $tTotal;
                $ttTotal = number_format($ttTotal, 2);
                $tBody .= "
                    <tr>
                        <td>$tDesc</td>
                        <td>$tQuantity</td>
                        <td>$$tPrice</td>
                        <td>$$tTotal</td>
                        <td>$tObservaciones</td>
                    </tr>
                ";
                break;
        }
    }

    $tFoot = "
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>$$ttTotal</td>
            <td>&nbsp;</td>
        </tr>
    ";
    $table = "
        <table id=\"otrosCargosTable\" class=\"cell-border\">
            <thead>
            <tr>
                <td>Descripcion / Fecha / Detalle</td>
                <td>Cantidad</td>
                <td>Precio</td>
                <td>Total</td>
                <td>Observaciones</td>
            </tr>
            </thead>
            <tbody>$tBody</tbody>
            <tfoot>$tFoot</tfoot>
        </table>
        <script>
        $('#otrosCargosTable').DataTable({
            'paging': true,
            'filter': false,
            'info': false,
            'scrollY': '500px',
            'scrollCollapse': true,
        });
        </script>
    ";
    $response = $table;
    return $response;
}