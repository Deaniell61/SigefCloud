<?php

session_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

$carrier = $_GET["carrier"];
$carrierMethods = null;

showOrders($carrier);

function getOrders($carrier)
{

    switch ($carrier){
        case "all":
            $carrierQ = " ";
            break;
        case "ups":
            $tIds = getCodCarrierIds("ups");
            $carrierQ = " AND (shi.oricarmet in ($tIds))";
            break;
        case "fedex":
            $tIds = getCodCarrierIds("fedex");
            $carrierQ = " AND (shi.oricarmet in ($tIds))";
            break;
        case "usps":
            $tIds = getCodCarrierIds("usps");
            $carrierQ = " AND (shi.oricarmet in ($tIds))";
            break;
    }

    $query = "
            SELECT 
                CONCAT(enc.shifirnam, ' ', enc.shilasnam) AS name,
                enc.orderid,
                enc.timoford,
                shi.oricarmet,
                enc.orderunits  
            FROM
                tra_ord_enc AS enc
                    INNER JOIN
                (select * from tra_ord_det group by codorden) AS det ON enc.codorden = det.codorden
                    INNER JOIN
                (select * from tra_ord_shi group by codorddet) AS shi ON det.coddetord = shi.codorddet
            WHERE
                enc.tranum = ''
                AND enc.ordsou = 'Walmart'
                AND enc.estatus != 'Canceled'
                AND enc.estatus != 'Cancelled'
                $carrierQ
            ORDER BY
                enc.timoford DESC;
        ";

    $query = "
            SELECT 
                CONCAT(enc.shifirnam, ' ', enc.shilasnam) AS name,
                enc.orderid,
                enc.timoford,
                shi.oricarmet,
                enc.orderunits  
            FROM
                tra_ord_enc AS enc
                    INNER JOIN
                tra_ord_det AS det ON enc.codorden = det.codorden
                    INNER JOIN
                tra_ord_shi AS shi ON det.coddetord = shi.codorddet
            WHERE
                enc.tranum = ''
                AND enc.ordsou = 'Walmart'
                AND enc.estatus != 'Canceled'
                AND enc.estatus != 'Cancelled'
                $carrierQ
            GROUP BY enc.codorden , det.coddetord
            ORDER BY
                enc.timoford DESC;
        ";

//    echo "$query";

    $result = mysqli_query(conexion($_SESSION["pais"]), $query);

    return $result;
}

function showOrders($carrier)
{
    $data = getOrders($carrier);
    $htmlBlock = "
        
    ";
    $cont = 1;
    while ($row = mysqli_fetch_array($data)) {
        $tOrderId = $row["orderid"];
        $tName = utf8_encode($row["name"]);
        $tTimoford = explode(" ", $row["timoford"])[0];
        $tCarrier = getCarrierName(($row["oricarmet"]));
        $tUnits = $row["orderunits"];
        if($cont%2 == 0){
            $color = "";
        }
        else{
            $color = "shadowRow";
        }

        $tIdef = $tOrderId . "|" . $tCarrier;

        $label = "&nbsp";
        if(strpos(strtolower($tCarrier), "fedex") !== false){
            $label = "<image class='generateLabel' width='18px' height='18px' src='../images/printer.png' onClick='generateLabel(\"$tOrderId\", \"$tCarrier\")'></image>";
        }

        $label = "&nbsp;";

        $htmlBlock .= "
            <div  class='gridRow $color'>
                <div class='stackHorizontally upsCsvCellS'>$cont</div>
                <div class='stackHorizontally upsCsvCell'>$tOrderId</div>
                <div class='stackHorizontally upsCsvCellL'>$tName</div>
                <div class='stackHorizontally upsCsvCell'>$tTimoford</div>
                <div class='stackHorizontally upsCsvCell'>$tCarrier</div>
                <div class='stackHorizontally upsCsvCellS alignCenter'> $label</div>
                <div class='stackHorizontally upsCsvCellS alignCenter'><image class='editShipping' width='18px' height='18px' src='../images/editar.png' onClick='editShipping(\"$tOrderId\", \"$tCarrier\")'></image></div>
                <div class='stackHorizontally upsCsvCellS alignCenter'><image class='cancelShipping' width='18px' height='18px' src='../images/cancel.png' onClick='cancelShipping(\"$tOrderId\")'></image></div>
                <div class='stackHorizontally upsCsvCellS alignCenter'><input type='checkbox' name='orderids[]' class='orderidchk' value='$tOrderId' checked></div>
            </div>
        ";
        $cont += 1;
    }

    echo $htmlBlock;
}

function getCarrierName($code){

    global $carrierMethods;

    if(array_key_exists($code,$carrierMethods)){
        return $carrierMethods[$code];
    }else{
        $q = "
            SELECT nombre FROM cat_shi_mdo WHERE codcarrier = '$code';
        ";

        $r = mysqli_query(conexion(""), $q);

        if($r->num_rows > 0){
            $carrierMethods[$code] = mysqli_fetch_array($r)[0];
            return $carrierMethods[$code];
        }
        else{
            return "Shipping Method Undefined: $code";
        }
    }
}

function getCodCarrierIds($carrier){
    $query = "
        SELECT 
            mdo.codcarrier
        FROM
            cat_shi_mdo AS mdo
                INNER JOIN
            cat_shi_carrier AS car ON mdo.carrier = car.codcarrier
        WHERE
            car.nombre = '$carrier';
    ";
    $result = mysqli_query(conexion(""), $query);
    while($row = mysqli_fetch_array($result)) {
        $tCode = $row[0];
        if($tCode != ""){
            $response .= "$tCode,";
        }
    }
    $response = substr($response, 0, -1);
    return $response;
}
