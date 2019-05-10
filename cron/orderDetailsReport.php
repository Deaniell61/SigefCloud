<?php
$gCountry = "Guatemala";
$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));
require_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");

$data = getData($gCountry);
$email = template($data);
//echo $email;
sendMail($email);


function getData($gCountry)
{
    $qDate = date("Y-m-d");
    $query = "
        SELECT 
            ordsou, timoford, horaproc, shipdate, estatus, tranum, orderid
        FROM
            tra_ord_enc
        WHERE
            (tranum = '' AND paysta != 'NoPayment'
                AND estatus NOT IN ('Completed' , 'Cancelled',
                'OnHold',
                'ProblemOrder',
                ''))
                OR (shipdate >= '$qDate'
                AND estatus IN ('Completed' , 'Cancelled'))
                AND (ordsouordi NOT IN (SELECT 
                    orderid
                FROM
                    tra_ord_enc));
    ";

    $data = [
        "AMAZON" => [
            "label" => "Amazon Listing",
            "total" => "",
            "hoy" => "",
            "antes" => "",
        ],
        "FBA" => [
            "label" => "Amazon FBA",
            "total" => "",
            "hoy" => "",
            "antes" => "",
        ],
        "EBAYORDER" => [
            "label" => "eBay",
            "total" => "",
            "hoy" => "",
            "antes" => "",
        ],
        "SEARS" => [
            "label" => "Sears",
            "total" => "",
            "hoy" => "",
            "antes" => "",
        ],
        "PRICEFALLS" => [
            "label" => "PriceFalls",
            "total" => "",
            "hoy" => "",
            "antes" => "",
        ],
        "WEBSITE" => [
            "label" => "Shopify",
            "total" => "",
            "hoy" => "",
            "antes" => "",
        ],
        "WALMART" => [
            "label" => "Walmart",
            "total" => "",
            "hoy" => "",
            "antes" => "",
        ],
        "MAGENTO" => [
            "label" => "GuateDirect",
            "total" => "",
            "hoy" => "",
            "antes" => "",
        ],
        "LOCAL_STORE" => [
            "label" => "Local Store",
            "total" => "",
            "hoy" => "",
            "antes" => "",
        ],
    ];

    $saleChannelsQ = "
        SELECT 
            codorder, nombre
        FROM
            cat_sal_cha
        WHERE
            estadistic = 1;
    ";

    $saleChannelsR = mysqli_query(conexion(""), $saleChannelsQ);

    while ($row = mysqli_fetch_array($saleChannelsR)){
        $saleChannels[$row["codorder"]] = $row["nombre"];
    }

    $result = mysqli_query(conexion($gCountry), $query);
    $cont = 0;
    while ($row = mysqli_fetch_array($result)) {
        $ordsou = strtoupper($row["ordsou"]);
        $horaproc = $row["horaproc"];
        $timoford = explode(" ", $row["timoford"])[0];
        $shipdate = explode(" ", $row["shipdate"])[0];
        $shiphour = explode(":", explode(" ", $row["shipdate"])[1])[0];
        $estatus = $row["estatus"];
        $tranum = $row["tranum"];
        $orderid = $row["orderid"];
//        echo "$ordsou<br>";
        if ($estatus == "Canceled" || $estatus == 'Cancelled') {
            $data[$ordsou]["cancelled"] += 1;
        }
//        var_dump($row);
//        echo "<br>";
//        echo "$ordsou - $horaproc - $timoford - $shipdate<br>";
        $data[$ordsou]["total"] += 1;

        //timeoforder es hoy o antes

        $tToday = date("Y-m-d");
        $flagToday = ($timoford < $tToday) ? false : true;
        $flagProc = ($tranum == "") ? false : true;

        if($flagToday){
            $data[$ordsou]["hoy"] += 1;
            $data["olHoy"] .= "$orderid, ";
            $data["channelList"][$ordsou]["hoy"] .= "$orderid, ";
        }else{
            $data[$ordsou]["antes"] += 1;
            $data["olAntes"] .= "$orderid, ";
            $data["channelList"][$ordsou]["antes"] .= "$orderid, ";
        }

//        echo "ORIG HORAPROC $ordsou - $horaproc<br>";
//        if($ordsou == "LOCAL_STORE"){
//            echo "horaproc orig: $ordsou - $horaproc<br>";
//        }
        //
//        echo "$horaproc<br>";
        if($horaproc == 0){
            if($shiphour != 00){
                $horaproc = $shiphour;
//                echo "horaproc shiphour: $ordsou - $horaproc<br>";
                $horaproc = ($horaproc < 8) ? 8 : $horaproc;
                $horaproc = ($horaproc > 17) ? 17 : $horaproc;
//                if($ordsou == "LOCAL_STORE"){
//                    echo $row["shipdate"] . "<br>";
//                    echo "horaproc shiphour: $ordsou - $horaproc<br>";
//                }
            }
            else{
                $horaserver = date("H");
                $horaserver = ($horaserver < 8) ? 8 : $horaserver;
                $horaserver = ($horaserver > 17) ? 17 : $horaserver;
                $horaproc = $horaserver;
//                updateHoraProc($orderid, $horaproc);
//                if($ordsou == "LOCAL_STORE"){
//                    echo "horaproc server: $ordsou - $horaproc<br>";
//                }
            }
        }
        else{
//            echo "horaproc directa: $horaproc<br>";
        }
        $horaproc = sprintf("%02d", $horaproc);

        //

        $flagProcToday = ($timoford < $shipdate) ? false : true;

        if(!$flagProc){
            $flagProcToday = ($timoford < date("Y-m-d")) ? false : true;
        }

//        if($ordsou == "AMAZON"){
//            echo "$ordsou - PROC: $flagProc - TODAY: $flagProcToday<br>";
//        }



        if($flagProc && $flagProcToday){
            $data[$ordsou]["procHoy"] += 1;
            $data[$ordsou]["procTotal"] += 1;
            $data["olProcHoy"] .= "$orderid, ";
            $data[$ordsou][$horaproc] += 1;
//            echo "proc hoy: timoford:$timoford - shipdate:$shipdate - tranum:$tranum<br>";
            $data["channelList"][$ordsou]["procHoy"] .= "$orderid, ";
        }else if($flagProc && !$flagProcToday){
            $data[$ordsou]["procAntes"] += 1;
            $data[$ordsou]["procTotal"] += 1;
            $data["olProcAntes"] .= "$orderid, ";
            $data[$ordsou][$horaproc] += 1;
//            echo "proc antes: timoford:$timoford - shipdate:$shipdate - tranum:$tranum<br>";
//            if($ordsou == "LOCAL_STORE"){
//                echo "$ordsou - $horaproc<br>";
//            }
            $data["channelList"][$ordsou]["procAntes"] .= "$orderid, ";
        }else if(!$flagProc && $flagProcToday){
            $data[$ordsou]["noProcHoy"] += 1;
            $data[$ordsou]["noProcTotal"] += 1;
            $data["olNoProcHoy"] .= "<br>$orderid - timoford: $timoford - shipdate: $shipdate - estatus: $estatus, ";
            $data["channelList"][$ordsou]["noProcHoy"] .= "$orderid, ";
//            if($ordsou == "AMAZON"){
//                echo "$flagProc - TODAY: $flagProcToday TIMOFORD: $timoford SHIPDATE: $shipdate<br>";
//            }
        }else if(!$flagProc && !$flagProcToday){
            $data[$ordsou]["noProcAntes"] += 1;
            $data[$ordsou]["noProcTotal"] += 1;
            $data["olNoProcAntes"] .= "<br>$orderid - timoford: $timoford - shipdate: $shipdate - estatus: $estatus, ";
            $data["channelList"][$ordsou]["noProcAntes"] .= "$orderid, ";
//            if($ordsou == "AMAZON"){
//                echo "$flagProc - TODAY: $flagProcToday TIMOFORD: $timoford SHIPDATE: $shipdate<br>";
//            }
        }
    }

//    var_dump($data["LOCAL_STORE"]);
//    var_dump($data);

    $response = [
        $data,
        $saleChannels
    ];
    return $response;
}

function template($data)
{
    global $gCountry;
    $channels = $data[1];
    $data = $data[0];

    $tDate = date("m/d/Y");
    $tHour = date("H:i:s");

    $date = "$tDate a las $tHour";

    $rows = "";$tTotal = "";
    $tHoy = "";
    $tAntes = "";
    $tHora8 = "";
    $tHora9 = "";
    $tHora10 = "";
    $tHora11 = "";
    $tHora12 = "";
    $tHora13 = "";
    $tHora14 = "";
    $tHora15 = "";
    $tHora16 = "";
    $tHora17 = "";
    $tProcHoy = "";
    $tProcAntes = "";
    $tProcTotal = "";
    $tNoProcHoy = "";
    $tNoProcAntes = "";
    $tNoProcTotal = "";
    $tCanceladas = "";

    foreach ($data as $key => $value) {
        if($key != "olProcHoy" &&
            $key != "olNoProcHoy" &&
            $key != "olProcAntes" &&
            $key != "olNoProcAntes" &&
            $key != "olHoy" &&
            $key != "olAntes" &&
            $key != "channelList"){
            $label = $data[$key]["label"];
            $total = $data[$key]["total"];
            $hoy = $data[$key]["hoy"];
            $antes = $data[$key]["antes"];
            $hora8 = $data[$key]["08"];
            $hora9 = $data[$key]["09"];
            $hora10 = $data[$key]["10"];
            $hora11 = $data[$key]["11"];
            $hora12 = $data[$key]["12"];
            $hora13 = $data[$key]["13"];
            $hora14 = $data[$key]["14"];
            $hora15 = $data[$key]["15"];
            $hora16 = $data[$key]["16"];
            $hora17 = $data[$key]["17"];
            $procHoy = $data[$key]["procHoy"];
            $procAntes = $data[$key]["procAntes"];
            $procTotal = $procHoy + $procAntes;
            $noProcHoy = $data[$key]["noProcHoy"];
            $noProcAntes = $data[$key]["noProcAntes"];
            $noProcTotal = $noProcHoy + $noProcAntes;
            $canceladas = $data[$key]["cancelled"];
            if ($procTotal == 0) {
                $procTotal = "";
            }
            if ($noProcTotal == 0) {
                $noProcTotal = "";
            }

            $tTotal += $total;
            $tHoy += $hoy;
            $tAntes += $antes;
            if ($hora8 != "") {
                $tHora8 += $hora8;
            }
            if ($hora9 != "") {
                $tHora9 += $hora9;
            }
            if ($hora10 != "") {
                $tHora10 += $hora10;
            }
            if ($hora11 != "") {
                $tHora11 += $hora11;
            }
            if ($hora12 != "") {
                $tHora12 += $hora12;
            }
            if ($hora13 != "") {
                $tHora13 += $hora13;
            }
            if ($hora14 != "") {
                $tHora14 += $hora14;
            }
            if ($hora15 != "") {
                $tHora15 += $hora15;
            }
            if ($hora16 != "") {
                $tHora16 += $hora16;
            }
            if ($hora17 != "") {
                $tHora17 += $hora17;
            }

            if ($procHoy != "") {
                $tProcHoy += $procHoy;
            }
            if ($procAntes != "") {
                $tProcAntes += $procAntes;
            }
            if ($procTotal != "") {
                $tProcTotal += $procTotal;
            }
            if ($noProcHoy != "") {
                $tNoProcHoy += $noProcHoy;
            }
            if ($noProcAntes != "") {
                $tNoProcAntes += $noProcAntes;
            }
            if ($noProcTotal != "") {
                $tNoProcTotal += $noProcTotal;
            }
            if ($canceladas != "") {
                $tCanceladas += $canceladas;
            }

            if(array_key_exists($key, $channels)){
                $CODREPORD = sys2015();
                $FECHA = date("Y-m-d H:i:s");
                $CANAL = ($channels[$key] == '$gcSite') ? $gCountry : $channels[$key];
                $TOTALOR = $total;
                $REC_HOY = $hoy;
                $REC_ANTES = $antes;
                $OCHO = $hora8;
                $NUEVE = $hora9;
                $DIEZ = $hora10;
                $ONCE = $hora11;
                $DOCE = $hora12;
                $TRECE = $hora13;
                $CATORCE = $hora14;
                $QUINCE = $hora15;
                $DIECISEIS = $hora16;
                $DIECISIETE = $hora17;
                $PROCESADAS = $procTotal;
                $PROCESAHOY = $procHoy;
                $PROCESAANT = $procAntes;
                $CANCELADAS = $canceladas;

                $hours = abs(date("08:00:00") - date("H:m:s"));
                $hours = ($hours > 6) ? $hours - 1 : $hours;
                $orders = $procTotal;
                $minutes = round(($hours * 60) / $orders, 2);

                $hoyList = ($data["channelList"][$key]["hoy"] != "") ? " - " . substr($data["channelList"][$key]["hoy"], 0, -2) : "";
                $antesList = ($data["channelList"][$key]["antes"] != "") ? " - " . substr($data["channelList"][$key]["antes"], 0, -2) : "";
                $procHoyList = ($data["channelList"][$key]["procHoy"] != "") ? " - " . substr($data["channelList"][$key]["procHoy"], 0, -2) : "";
                $procAntesList = ($data["channelList"][$key]["procAntes"] != "") ? " - " . substr($data["channelList"][$key]["procAntes"], 0, -2) : "";
                $noProcHoyList = ($data["channelList"][$key]["noProcHoy"] != "") ? " - " . substr($data["channelList"][$key]["noProcHoy"], 0, -2) : "";
                $noProcAntesList = ($data["channelList"][$key]["noProcAntes"] != "") ? " - " . substr($data["channelList"][$key]["noProcAntes"], 0, -2) : "";

                $hours = abs(date("08:00:00") - date("H:m:s"));
                $hours = ($hours > 6) ? $hours - 1 : $hours;
                $fbaOrders = $data["FBA"]["procTotal"];
                $fbaOrders = ($fbaOrders == "") ? 0 : $fbaOrders;
                $orders = $tProcTotal - $fbaOrders;
                $minutes = round(($hours * 60) / $orders, 2);
                $olProcHoy = substr($data["olProcHoy"], 0, -2);
                $olNoProcHoy = substr($data["olNoProcHoy"], 0, -2);
                $olProcAntes = substr($data["olProcAntes"], 0, -2);
                $olNoProcAntes = substr($data["olNoProcAntes"], 0, -2);
                $olHoy = substr($data["olHoy"], 0, -2);
                $olAntes = substr($data["olAntes"], 0, -2);

                $OBSER = "
                    $orders Ordenes procesadas en $hours horas de trabajo.
                    Estableciendo $minutes minutos de proceso por orden. $fbaOrders ordenes de Amazon FBA fueron descartadas ya que el  proceso no se realiza en GuateDirect.
                    Ordenes Pendientes de Hoy: $tNoProcHoy  $olNoProcHoy
                    Ordenes Pendientes de Antes: $tNoProcAntes  $olNoProcAntes
                    Ordenes Recibidas Hoy: $tHoy  $olHoy
                    Ordenes Recibidas Antes: $tAntes  $olAntes
                    Ordenes Procesadas Hoy: $tProcHoy  $olProcHoy
                    Ordenes Procesadas Antes: $tProcAntes  $olProcAntes
                ";

                $repOrdenesQ = "
                    insert into rep_ordenes 
                    (CODREPORD, FECHA, CANAL, TOTALOR, REC_HOY, REC_ANTES, OCHO, NUEVE, DIEZ, ONCE, DOCE, TRECE, CATORCE, QUINCE, DIECISEIS, DIECISIETE, PROCESADAS, PROCESAHOY, PROCESAANT, CANCELADAS, OBSER) values 
                    ('$CODREPORD', '$FECHA', '$CANAL', '$TOTALOR', '$REC_HOY', '$REC_ANTES', '$OCHO', '$NUEVE', '$DIEZ', '$ONCE', '$DOCE', '$TRECE', '$CATORCE', '$QUINCE', '$DIECISEIS', '$DIECISIETE', '$PROCESADAS', '$PROCESAHOY', '$PROCESAANT', '$CANCELADAS', '$OBSER');
                ";
                mysqli_query(conexion(""), $repOrdenesQ);
            }
            else{
                echo "CANAL NO ESTA: $key<br><br>";
            }

            $rows .= "
                <tr>
                    <td align='center'>$label</td>
                    <td align='center'>$total</td>
                    <td align='center'>$hoy</td>
                    <td align='center'>$antes</td>
                    <td align='center'>$hora8</td>
                    <td align='center'>$hora9</td>
                    <td align='center'>$hora10</td>
                    <td align='center'>$hora11</td>
                    <td align='center'>$hora12</td>
                    <td align='center'>$hora13</td>
                    <td align='center'>$hora14</td>
                    <td align='center'>$hora15</td>
                    <td align='center'>$hora16</td>
                    <td align='center'>$hora17</td>
                    <td align='center'>$procHoy</td>
                    <td align='center'>$procAntes</td>
                    <td align='center'>$procTotal</td>
                    <td align='center'>$noProcHoy</td>
                    <td align='center'>$noProcAntes</td>
                    <td align='center'>$noProcTotal</td>
                    <td align='center'>$canceladas</td>
                </tr>
            ";
        }
    }


    $hours = abs(date("08:00:00") - date("H:m:s"));
    $hours = ($hours > 6) ? $hours - 1 : $hours;
    $fbaOrders = $data["FBA"]["procTotal"];
    $fbaOrders = ($fbaOrders == "") ? 0 : $fbaOrders;
    $orders = $tProcTotal - $fbaOrders;
    $minutes = round(($hours * 60) / $orders, 2);
    $olProcHoy = substr($data["olProcHoy"], 0, -2);
    $olNoProcHoy = substr($data["olNoProcHoy"], 0, -2);
    $olProcAntes = substr($data["olProcAntes"], 0, -2);
    $olNoProcAntes = substr($data["olNoProcAntes"], 0, -2);
    $olHoy = substr($data["olHoy"], 0, -2);
    $olAntes = substr($data["olAntes"], 0, -2);

    return "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                #canales {
                    font-family: Trebuchet MS, Arial, Helvetica, sans-serif;
                    boder-collapse: collapse;
                    width: 100%;
                }
                #canales td, #canales th {
                    boder: 1px solid #ddd;
                    padding: 8px;
                }
                #canales tr:nth-child(even){background-color: #f2f2f2;}
                #canales tr:hover {background-color: #ddd;}
                #canales th {
                    padding-top: 12px;
                    padding-bottom: 12px;
                    text-aling: left;
                    background-color: #4CAF50;
                    color: white;
                }
            </style>
        </head>
        <body><table id=\"canales\">
            <tr>
                <th colspan=\"21\">GuateDirect LLC<br>Detalle de Ordenes Recibidas y Procesadas el $date</th>
            </tr>
            <tr>
                <th rowspan=\"2\">CANALES</th>
                <th rowspan=\"2\">TOTALES</th>
                <th colspan=\"2\">RECIBIDAS</th>
                <th colspan=\"10\">PROCESADAS POR HORA</th>
                <th colspan=\"2\">PROCESADAS</th>
                <th>TOTAL</th>
                <th colspan=\"2\">SIN PROCESAR</th>
                <th>TOTAL</th>
                <th rowspan=\"2\">CANCELADAS</th>
            </tr>
            <tr>
                <th>HOY</th>
                <th>ANTES</th>
                <th>08</th>
                <th>09</th>
                <th>10</th>
                <th>11</th>
                <th>12</th>
                <th>13</th>
                <th>14</th>
                <th>15</th>
                <th>16</th>
                <th>17</th>
                <th>HOY</th>
                <th>ANTES</th>
                <th>PROCESADAS</th>
                <th>HOY</th>
                <th>ANTES</th>
                <th>SIN PROCESAR</th>
            </tr>
            $rows
            <tr>
                <th>T O T A L E S</th>
                <th>$tTotal</th>
                <th>$tHoy</th>
                <th>$tAntes</th>
                <th>$tHora8</th>
                <th>$tHora9</th>
                <th>$tHora10</th>
                <th>$tHora11</th>
                <th>$tHora12</th>
                <th>$tHora13</th>
                <th>$tHora14</th>
                <th>$tHora15</th>
                <th>$tHora16</th>
                <th>$tHora17</th>
                <th>$tProcHoy</th>
                <th>$tProcAntes</th>
                <th>$tProcTotal</th>
                <th>$tNoProcHoy</th>
                <th>$tNoProcAntes</th>
                <th>$tNoProcTotal</th>
                <th>$tCanceladas</th>
            </tr>
        </table>
        
        <br>
        <b>$orders</b> Ordenes procesadas en <b>$hours</b> horas de trabajo.
        <br>Estableciendo <b>$minutes</b> minutos de proceso por orden. <b>$fbaOrders</b> ordenes de Amazon FBA fueron descartadas ya que el  proceso no se realiza en GuateDirect.
        <br><br>Ordenes Pendientes de Hoy: <b>$tNoProcHoy</b> <br> $olNoProcHoy
        <br><br>Ordenes Pendientes de Antes: <b>$tNoProcAntes</b> <br> $olNoProcAntes
        <br><br>Ordenes Recibidas Hoy: <b>$tHoy</b> <br> $olHoy
        <br><br>Ordenes Recibidas Antes: <b>$tAntes</b> <br> $olAntes
        <br><br>Ordenes Procesadas Hoy: <b>$tProcHoy</b> <br> $olProcHoy
        <br><br>Ordenes Procesadas Antes: <b>$tProcAntes</b> <br> $olProcAntes
        </html>
    ";
}

function sendMail($mensaje){
    $date = date("m/d/Y");
    $asunto = "Detalle de Ordenes Recibidas el $date";
    require_once($_SERVER["DOCUMENT_ROOT"] . "/php/lib/PHPMailer-master/class.phpmailer.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/php/lib/PHPMailer-master/class.smtp.php");

    $from="SigefCloud Team Support <support@sigefcloud.com>";

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "ssl";
    $mail->Host = "srv70.hosting24.com";
    $mail->Port = 465;
    $mail->Username = "support@sigefcloud.com";
    $mail->Password = "5upp0rt51g3fCl0ud";
    $mail->From = "support@sigefcloud.com";
    $mail->FromName = $from;
    $mail->Subject = $asunto;
    $mail->AltBody = $asunto;
    $mail->MsgHTML($mensaje);

    $mail->IsHTML(true);
    $direcciones[0]="solus.huargo@gmail.com";
    $direcciones[1]="mauricio.aldana@guatedirect.com";
//    $direcciones[2]="paulo.armas@guatedirect.com";


    $mail->IsHTML(true);

    $sentMailCounter = 0;
    foreach($direcciones as $destinoT){
        $mail->AddAddress($destinoT, $destinoT);
        if($mail->send()){
            $sentMailCounter += 1;
        }

        $mail->ClearAddresses();
    }

    echo "sent mails: $sentMailCounter";
}

function updateHoraProc($orderid, $horaproc){

    global $gCountry;

    $query = "
        UPDATE tra_ord_enc SET horaproc = '$horaproc' WHERE orderid = '$orderid';
    ";

//    echo $query . "<br>";
    mysqli_query(conexion($gCountry), $query);
}
