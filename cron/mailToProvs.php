<meta charset='utf-8'>
<?php
$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));
require_once($_SERVER["DOCUMENT_ROOT"] . '/php/coneccion.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/php/fecha.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/php/mails/mensajeOrdenMail.php');
$tiempo_inicio = microtime_float();
$con = conexion('');
$contador = 0;
$aOrdenes = array();
$sPais = 'select d.codigo,d.nompais,d.codproloc,(select se.nombre from cat_empresas se where se.pais=d.codpais limit 1),(select se.notiprov from cat_empresas se where se.pais=d.codpais limit 1) from direct d where d.codproloc!="" and d.nompais!="DEMO" AND d.nompais != "Guatemala"';
if ($ePais = $con->query($sPais)) {
    while ($pais = $ePais->fetch_row()) {
        $conP = conexion($pais[1]);
        $tDate = date("Y-03-01");
        $sOrdenes = "select e.CODORDEN,e.ORDERID,e.CODPROV, e.codtorden, (select p.NOMBRE from cat_prov p where p.codprov=e.codprov) as NOMPROV,e.timoford,e.ordsou,e.grandtotal,e.shifee,(select p.MAILCONTAC from cat_prov p where p.codprov=e.codprov) as EMAPROV, concat(firstname,' ',lastname) as tname from tra_ord_enc e where e.notiprov=0 and e.tranum!='' and e.codprov!='' order by e.timoford desc";
//         echo "$tDate";
        if ($eOrdenes = $conP->query($sOrdenes)) {
            echo $eOrdenes->num_rows . "<br>";
            while ($ordenes = $eOrdenes->fetch_assoc()) {
                $ordenes['pais'] = $pais[1];
                $ordenes['empresa'] = $pais[3];
                $ordenes['notiprov'] = $pais[4];
                $aOrdenes[$contador][] = $ordenes;
//                var_dump($ordenes);
            }
        }
        $contador++;
        $conP->close();
    }
    $con->close();
}
$tiempo_fin = microtime_float();
$tiempo = $tiempo_fin - $tiempo_inicio;
echo "Tiempo empleado1: " . ($tiempo_fin - $tiempo_inicio) . "<br>";
//$aOrdenes[0][0]['CODORDEN']
//Variable[pais][fila][columna]
$detalleOrden = array();
$contadorD = 0;
foreach ($aOrdenes as $paises) {
    $pais = $paises[0]['pais'];
    $conP = conexion($pais);
    echo $pais . "<br>";
    foreach ($paises as $orden) {
//         echo $orden['CODORDEN']."<br>";
        $sOrdenDet = "select productid,codorden,qty,ORIUNIPRI,ADJUNIPRI,LINETOTAL from tra_ord_det where codorden='" . $orden['CODORDEN'] . "'";
        if ($eOrdenDet = $conP->query($sOrdenDet)) {
            while ($ordenDet = $eOrdenDet->fetch_assoc()) {
                $sProducto = "select amazonsku,mastersku,prodname from tra_bun_det where (amazonsku='" . $ordenDet['productid'] . "' or mastersku='" . $ordenDet['productid'] . "')";
                if ($eProducto = $conP->query($sProducto)) {
                    if ($producto = $eProducto->fetch_assoc()) {
                        $productoDet[$orden['CODORDEN']][$contadorD] = $producto;
                        $productoDet[$orden['CODORDEN']][$contadorD]['CODPROV'] = $orden['CODPROV'];
                        $productoDet[$orden['CODORDEN']][$contadorD]['NOMPROV'] = $orden['NOMPROV'];
                        $productoDet[$orden['CODORDEN']][$contadorD]['qty'] = $ordenDet['qty'];
                        $productoDet[$orden['CODORDEN']][$contadorD]['LINETOTAL'] = $ordenDet['LINETOTAL'];
                        $productoDet[$orden['CODORDEN']][$contadorD]['ORIUNIPRI'] = ($ordenDet['ADJUNIPRI'] > 0) ? $ordenDet['ADJUNIPRI'] : $ordenDet['ORIUNIPRI'];
                    }
                }
                //$detalleOrden[$orden['CODORDEN']][$contadorD]=$ordenDet;
                echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp" . $ordenDet['productid'] . " - " . $ordenDet['codorden'] . "<br>";
                $contadorD++;
            }
//             echo "<br>";
        }
//        echo "<br>";
    }
    $conP->close();
}
$tiempo_fin = microtime_float();
$tiempo = $tiempo_fin - $tiempo_inicio;
echo "Tiempo empleado2: " . ($tiempo_fin - $tiempo_inicio) . "<br>";
$dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
foreach ($aOrdenes as $paises) {
    $pais = $paises[0]['pais'];
    $conP = conexion($pais);
    $empresa = $paises[0]['empresa'];
    $notiprov = $paises[0]['notiprov'];
    echo "<strong>" . $pais . "</strong><br>";
    foreach ($paises as $orden) {
        if (isset($productoDet[$orden['CODORDEN']])) {
            foreach ($productoDet[$orden['CODORDEN']] as $detalleOr) {
//                    var_dump($detalleOr);
//                    echo "<br><br>";
                $id = "";
                if ($detalleOr['amazonsku'] != "") {
                    $id = $detalleOr['amazonsku'];
                } else
                    if ($detalleOr['mastersku'] != "") {
                        $id = $detalleOr['mastersku'];
                    }
                if ($id != "") {
//                        echo $orden['ORDERID']."<br>";
//                         echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp".$id." - ".$detalleOr['NOMPROV']."<br>";
                    $tpq = "
                            select NOMBRE from cat_tipos_proyecto where tipo = '" . $orden["codtorden"] . "'; 
                         ";
                    $tpr = mysqli_query(conexion(""), $tpq);
                    $tprr = mysqli_fetch_array($tpr);
                    $tTipoOrden = $tprr[0];
                    $asunto = "Orden  recibida - " . $orden['ordsou'] . " - $tTipoOrden";
                    $destino = $orden['EMAPROV'];
//                    $destino = "solus.huargo@gmail.com";
                    $ordId = $orden['ORDERID'];
                    $timoford = $orden['timoford'];
                    $headDate = explode(" ", $timoford)[0];
                    $headDateData = explode("-", $headDate);
                    $headDate = $meses[$headDateData[1] - 1] . ", " . $headDateData[2] . " " . $headDateData[0];
                    $nuevafecha2 = strtotime('+0 day', strtotime($timoford));
                    $timoford = date('d-m-Y H:i:s', $nuevafecha2);

                    $tDet .= "
<br><br>
Master SKU....: " . $detalleOr['mastersku'] . " 
<br>
Bundle SKU....: " . $detalleOr['amazonsku'] . " 
<br>
Descripcion...: " . $detalleOr['prodname'] . "
<br>
Cantidad......: " . $detalleOr['qty'] . "
<br>
Precio Unitario: " . toMoney($detalleOr['ORIUNIPRI']) . "
<br>
Total.........: " . toMoney($detalleOr['LINETOTAL']) . "
                    ";
                }
            }
            $mensaje = utf8_decode(
                "
<html>
<head>
</head>
<body>
<div style=\"text-align:left; color:black; width:60%;\">
<span style=\"text-align:left; color:black; width:60%;\">
<strong>" . $headDate . "</strong>
</span>
<br>
<br>
Estimado <strong>" . $orden['NOMPROV'] . "</strong>
<br><br>
Es un gusto informarle que hemos recibido la siguiente orden en su cuenta.
<br><br>
Orden: " . $orden['ORDERID'] . "
<br>
Fecha: " . $timoford . "
<br>
Canal: " . $orden['ordsou'] . "
<br>
Tipo de Orden: " . $tTipoOrden . "
<br>
Cliente: " . $orden['tname'] . "
$tDet
</div>
<br>
<br>
 
<a href=\"http://www.sigefcloud.com/\" style=\"text-decoration:none;\" target=\"_blank\">
<div style=\"text-align:left; color:blue; width:100%;\" >
$empresa Sales Team<br><br>
</div>
<img style=\"cursor:pointer;\" src=\"http://sigefcloud.com/images/paises/" . str_replace(" ", "%20", $pais) . ".png\"  width='200' height='auto' alt=\"World Direct\">
<br>
<br>
http://www.sigefcloud.com/ </a>

</body>	
</html>
                        ");
            //echo $mensaje;
                        $sUpOrden="update tra_ord_enc set notiprov=1 where codorden='".$orden['CODORDEN']."'";
            // try{
            if ($notiprov == '1') {
                if (enviaEmailOrdenAProveedor2($mensaje, $ordId, $asunto, $destino)) {
//                    echo "$mensaje<br><br>";
                    if ($conP->query($sUpOrden)) {
                        echo "Enviado y modificado " . $ordId . "<br>";
                    }
                } else {
                    echo "No Enviado " . $ordId;
                }
            } else {
                if ($conP->query($sUpOrden)) {
                    echo "Solo modificado " . $ordId . "<br>";
                }
            }
        }
    }
    echo "<br>";
}
//enviaEmailOrdenAProveedor($mensaje,$codigo,$asunto,$destino);
$tiempo_fin = microtime_float();
$tiempo = $tiempo_fin - $tiempo_inicio;
echo "Tiempo empleado3: " . ($tiempo_fin - $tiempo_inicio);
?>