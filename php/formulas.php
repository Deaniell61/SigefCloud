<?php
function crearBundle($codigoEmpresa, $masterSKU, $prodName, $canal, $uBundle, $amSKU, $unidadesCaja, $lbundle)
{
    $cospri = "((select cap1.pcosto from cat_prod cap1 where cap1.codempresa='" . $codigoEmpresa . "' and cap1.mastersku='" . $masterSKU . "')";
    $subTotal = "(select cap1.pcosto*" . intval($uBundle) . " from cat_prod cap1 where cap1.codempresa='" . $codigoEmpresa . "' and cap1.mastersku='" . $masterSKU . "')";
//    $basmar = "(select cap1.mmax from cat_prod cap1 where cap1.codempresa='" . $codigoEmpresa . "' and cap1.mastersku='" . $masterSKU . "')";
    $basmar = "(select cap1.marmax from cat_prov cap1 where cap1.codprov='$codprov')";
    $salprionsi = "(select cap1.pventa from cat_prod cap1 where cap1.codempresa='" . $codigoEmpresa . "' and cap1.mastersku='" . $masterSKU . "')";
    $basmar = "(select cap1.marmax from cat_prov cap1 where cap1.codprov='" . $_SESSION['codprov'] . "')";

    $comsalPri = "(select cap2.preciomin from tra_pre_com cap2 where cap2.codempresa='" . $codigoEmpresa . "' and cap2.codprod=(select cap1.codprod from cat_prod cap1 where cap1.codempresa='" . $codigoEmpresa . "' and cap1.mastersku='" . $masterSKU . "') and cap2.unidades=$uBundle and cap2.aplica=1 order by cap2.fecha desc limit 1)";

    $comsalpri = "0";
    $sugsalpri = "0";
    $incoveSugs = "(($sugsalpri-$comsalPri)/$comsalPri)";
    $incovesugs = "0";
    $upc = "(select cap1.upc from cat_prod cap1 where cap1.codempresa='" . $codigoEmpresa . "' and cap1.mastersku='" . $masterSKU . "' and cap1.prodname='" . $prodName . "')";

    //AL: _4EX0ME76Q, SO: _4Q90XMVNL

    $tUbundle = intval($uBundle);
    if ($canal == "_4Q90XMVNL") {
        $askuQuery = "SELECT AMAZONSKU FROM tra_bun_det WHERE MASTERSKU = '$masterSKU' AND CODCANAL = '_4EX0ME76Q' AND UNITBUNDLE = '$tUbundle';";
        $askuResult = mysql_query(conexion($_SESSION["pais"]), $askuQuery);
        if ($askuResult) {
            if ($askuResult->num_rows > 0) {
                $row = mysqli_fetch_array($askuResult);
                if ($row[0] != "") {
                    $amSKU = $row[0];
                }
            }
        }
    }
    $squery = "
		insert into tra_bun_det(
			masterSKU,
			prodname,
			codempresa,
			amazonsku,
			unitbundle,
			unitcase,
			cospri,pacmat,subtotfbac,
			basmar,
			salprionsi,comsalpri,incovesugs,sugsalpri,bununipri,
			upc,codcanal)
		values(
			'" . $masterSKU . "',
			'" . $prodName . " (Pack of " . intval($uBundle) . ")',
			'" . $codigoEmpresa . "',
			'" . $amSKU . "',
			" . intval($uBundle) . ",
			$unidadesCaja,
			$cospri*" . intval($uBundle) . "),
			0,0,0,
			0.45,
			0,0,0,0,
			'',
			'" . $canal . "')";

    if (mysqli_query(conexion($_SESSION['pais']), $squery)) {

        #echo "<script>detalleBundle('".$masterSKU."','".$prodName." (Pack of ".intval($uBundle).")','0','".$_SESSION['codEmpresa']."','".$amSKU."','".$canal."','".$_SESSION['codprov']."',$lbundle);/script>";
    }
}

function assignUPC($mMasterSKU, $mAmazonSKU)
{

    //$
}

function createCompetitionBundle($codigoEmpresa, $masterSKU, $prodName, $canal, $uBundle, $amSKU, $unidadesCaja, $competitionPrice)
{
    $cospri = "((select cap1.pcosto from cat_prod cap1 where cap1.codempresa='" . $codigoEmpresa . "' and cap1.mastersku='" . $masterSKU . "')";
    $subTotal = "(select cap1.pcosto*" . intval($uBundle) . " from cat_prod cap1 where cap1.codempresa='" . $codigoEmpresa . "' and cap1.mastersku='" . $masterSKU . "')";
//    $basmar = "(select cap1.mmax from cat_prod cap1 where cap1.codempresa='" . $codigoEmpresa . "' and cap1.mastersku='" . $masterSKU . "')";
    $basmar = "(select cap1.marmax from cat_prov cap1 where cap1.codprov='" . $_SESSION['codprov'] . "')";
    $salprionsi = "(select cap1.pventa from cat_prod cap1 where cap1.codempresa='" . $codigoEmpresa . "' and cap1.mastersku='" . $masterSKU . "')";
    $comsalPri = "(select cap2.preciomin from tra_pre_com cap2 where cap2.codempresa='" . $codigoEmpresa . "' and cap2.codprod=(select cap1.codprod from cat_prod cap1 where cap1.codempresa='" . $codigoEmpresa . "' and cap1.mastersku='" . $masterSKU . "') and cap2.unidades=$uBundle and cap2.aplica=1 order by cap2.fecha desc limit 1)";

    $comsalpri = "0";
    $sugsalpri = "0";
    $incoveSugs = "(($sugsalpri-$comsalPri)/$comsalPri)";
    $incovesugs = "0";
    $upc = "(select cap1.upc from cat_prod cap1 where cap1.codempresa='" . $codigoEmpresa . "' and cap1.mastersku='" . $masterSKU . "' and cap1.prodname='" . $prodName . "')";


    $squery = "
		insert into tra_bun_det(
			masterSKU,prodname,codempresa,amazonsku,unitbundle,unitcase,cospri,
			pacmat,subtotfbac,basmar,salprionsi,
			comsalpri,
			incovesugs,sugsalpri,bununipri,
			upc,codcanal)
		values(
			'" . $masterSKU . "',
			'" . $prodName . " (Pack of " . intval($uBundle) . ")',
			'" . $codigoEmpresa . "',
			'" . $amSKU . "',
			" . intval($uBundle) . ",
			$unidadesCaja,
			$cospri*" . intval($uBundle) . "),
			0,0,0,0,
			'$competitionPrice',
			0,0,0,
			$upc,
			'" . $canal . "')";

    if (mysqli_query(conexion($_SESSION['pais']), $squery)) {


        #echo "<script>detalleBundle('".$masterSKU."','".$prodName." (Pack of ".intval($uBundle).")','0','".$_SESSION['codEmpresa']."','".$amSKU."','".$canal."','".$_SESSION['codprov']."',$lbundle);/script>";

    }


}

function shipping($ubundle, $xpesoOz, $alto, $largo, $ancho)
{
//        echo '     !!'.$ubundle.'-'.$xpesoOz.'-'.$alto.'-'.$largo.'-'.$ancho.'!!     ';
    require_once('coneccion.php');
    $pesoShi = '';
    $xcube = ((($largo * $ancho) * $alto) / 1728);
    $precio = 0;
    $squery = "select maxi,mini,precio,prioridad from det_shi_par";
    $ejecutar = mysqli_query(conexion($_SESSION['pais']), $squery);
    if ($ejecutar) {

//            echo " ub:" . $ubundle . " :" . (round($ubundle * $xpesoOz, 4) + 3) . ' ';

        if ((round($ubundle * $xpesoOz, 3) + 3) <= 13) {
            //echo '   !1!   ';
            $pesoOz = (round($ubundle * $xpesoOz, 4) + 3);
            //$pesoOz / 16
            $pesoShi = ', pesoshi=' . ($pesoOz / 16);
            while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
                if ($row['prioridad'] == '1') {
                    if ($pesoOz >= $row['mini'] and $pesoOz <= $row['maxi']) {
                        $precio = $row['precio'];
//                            echo $precio . "  ";
                        break;
                    }
                }
            }
        } else {
//                echo ' xcube:' . (round($ubundle * $xcube, 4)). '          ';
            //cubicshi
            if ((round($ubundle * $xcube, 4)) <= 0.4) {
//                    echo $ubundle . " c1, ";
                $cube = (round($ubundle * $xcube, 4));
                $cube = (ceil($cube * 100)) / 100;
                $pesoShi = ', cubicshi=' . $cube;
//                    echo '   !'.$cube . '-' . $pesoShi .'!   ';
                while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
//                        echo 'p1,';
                    if ($row['prioridad'] == '2') {
//                            echo '     '.$cube.'-'.$row['mini'].'-'.$row['maxi'].'     ';
                        if ($cube >= $row['mini'] and $cube <= $row['maxi']) {
//                                echo '     '.$cube.'-'.$row['mini'].'-'.$row['maxi'].'     ';
                            //echo 'p3,';
                            $precio = $row['precio'];
//                                echo ' precio:' . $precio;
//                                echo ' - xcube:' . (round($ubundle * $xcube, 4)). ' ';
//                                echo ' - data:'.$ubundle.'-'.$xpesoOz.'-'.$alto.'-'.$largo.'-'.$ancho.' ';
//                                echo " - p:" . $precio . " cube:" . $cube . " min:" . $row["mini"] . " maxi:" . $row["maxi"]."     ";
                            break;
                        }
                    }
                }
            } else {
//                    echo '   !3!   ';
//                    echo $ubundle . " c2, ";
                $pesolb = round(((round($ubundle * $xpesoOz, 2)) + 3) / 16, 2);
                $pesoShi = ', pesoshi=' . $pesolb;
                while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
                    if ($row['prioridad'] == '4') {
                        if ($pesolb >= $row['mini'] and $pesolb <= $row['maxi']) {
                            $precio = $row['precio'];
//                                echo $precio . "  ";
//                  1              echo " - p:" . $precio . " cube:" . $pesolb . " min:" . $row["mini"] . " maxi:" . $row["maxi"]."     ";
                            break;
                        }
                    }
                }
            }
        }
    }

    $squery = "select cantidad,valor from cat_ext_shi";
    $ejecutar = mysqli_query(conexion($_SESSION['pais']), $squery);
    if ($ejecutar) {
        $hs = 0;
        $valor = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $valor = intval($row['valor']);
            $cant = intval($row['cantidad']);
            if ($ubundle <= $cant) {
                $precio = ($precio * (1 + $valor * 1 / 100));
                $hs = 1;
                break;
            }
        }
        if ($hs == 0) {
            $precio = ($precio * (1 + $valor * 1 / 100));
        }
    }
//        echo " P:".$precio . $pesoShi.":p ";
    return $precio . $pesoShi;
}

function fbaweihanf($lcCantidad, $peso, $canal)
{
    #echo $peso;
    //echo ' peso:' . $peso . ' cantidad:' . $lcCantidad . ' canal:' . $canal . '   ';
//    echo ' p1:' . $peso;
//    $peso = ceil($peso);
//    echo ' p2:' . $peso;
    $peso = $peso * $lcCantidad;
//    echo '          p3:' . $peso . '          ';
    $valor = 0;
    require_once('coneccion.php');

    $tchan = '';
    $resQC = mysqli_query(conexion($_SESSION['pais']), $canal);
    if ($resQC) {
        if ($resQC->num_rows > 0) {
            $row = mysqli_fetch_row($resQC);
            $tchan = $row[0];
        }
    }

    $squery = "select valorbase,valor,rango_de,rango_a,resta,formula from cat_chan_fee WHERE codcanal = '$tchan'";
//    echo '  ' . $squery . '   ';
    if ($ejecutar = mysqli_query(conexion($_SESSION['pais']), $squery)) {
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
//            echo ">>>$peso<<<";
            if ($peso <= round($row['rango_a'], 3) && $peso >= round($row['rango_de'], 3)) {
                switch ($row['formula']) {
                    case 'VALOR':
//                        echo ">>1<<";
                        $valor = round($row['valorbase'], 3) + (round($row['valor'], 3));
                        break;
                    case 'MULTI':
//                        echo ">>2<<";
                        $valor = round($row['valorbase'], 3) + (round($row['valor'], 3) * ($peso - round($row['resta'], 3)));
//                        echo ' c2: v:' . $valor . ' peso:' . $peso . ' ';
                        break;
                    default:
//                        echo ">>3<<";
                        $valor = round($row['valorbase'], 3) + (round($row['valor'], 3));
                        break;
                }
            }
        }
    }
//    echo '          v:' . $valor . '          ';
    return $valor . ', pesochafee=' . $peso;
}

function fbainbshi($lcCantidad, $peso, $mastersku)
{
    require_once('coneccion.php');
    $valor = 0;
    $squery = "select univenta from cat_prod where mastersku='" . $mastersku . "'";
    if ($ejecutar = mysqli_query(conexion($_SESSION['pais']), $squery)) {
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
//            echo "<<<<<<" . $row['univenta'] . ">>>>>>>";
            $valor = 0;
            /*
            if (round($row['univenta'], 3) > 1) {

                $valor = (1 / round($row['univenta'], 3)) * intval($lcCantidad);
            } else {
                if (round($row['univenta'], 3) == 1 and $peso < 15) {
                    $valor = (1 / round($row['univenta'], 3));
                } else {
                    $valor = 0;
                }
            }
            */
        }
    }
    return $valor;
}

function lnIncremento($lcCantidad, $peso, $codprov, $unitBundle)
{
    require_once('coneccion.php');

    //echo '          !' . $lcCantidad . '!          ';

    $valor = 0;

    $squery = "SELECT INCRE1, INCRE2, INCRE3, INCRE4 FROM cat_empresas WHERE codempresa = '" . $_SESSION['codEmpresa'] . "';";

//    echo $squery . '         <>         ';

    if ($ejecutar = mysqli_query(conexion(""), $squery)) {
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            switch ($lcCantidad) {
                case 1:
                    {
                        $valor = ((round($row['INCRE1'], 3)));
                        break;
                    }
                case 2:
                    {
                        $valor = round($row['INCRE2'], 3);
                        break;
                    }
                case 3:
                    {
                        $valor = round($row['INCRE3'], 3);
                        break;
                    }
                case 4:
                    {
                        $valor = round($row['INCRE4'], 3);
                        break;
                    }
                default:
                    {
                        $valor = round($row['INCRE4'], 3);
                        break;
                    }
            }
        }
    }
    if ($unitBundle == 1) {
        $valor = $valor / 2;
    }

    return $valor;
}

function getMMAX()
{

    $tres = 0;

    $q = "SELECT MMAX FROM cat_empresas WHERE CODEMPRESA = '" . $_SESSION['codEmpresa'] . "'";
    $r = mysqli_query(conexion(""), $q);
    if ($r) {
        if ($r->num_rows > 0) {
            $row = mysqli_fetch_array($r);
            $tres = $row[0];
        }
    }

    return $tres;
}

function getMarmincom()
{
    require_once('coneccion.php');
    $marmincom = 0.975;

    $q = "SELECT MARMINCOM from cat_empresas WHERE CODEMPRESA = '" . $_SESSION['codEmpresa'] . "';";
    $r = mysqli_query(conexion(""), $q);
    if ($r) {
        if ($r->num_rows > 0) {
            $row = mysqli_fetch_array($r);
            $marmincom = $row[0];
        }
    }

    $marmincom = 1 - ($marmincom / 100);

//    echo '          !' . $marmincom . '!          ';
    return $marmincom;
}

function comsalpri($lcCantidad, $peso, $amazonSKU, $codprov, $cospri)
{
    require_once('coneccion.php');
    $valor = 0;
    $squery = "select preciomin,preciomax,aplica,azsku,unidades,shipping,$cospri) as precio from tra_pre_com where azsku='" . $amazonSKU . "' and unidades='" . $lcCantidad . "' and codprov='" . $codprov . "' and aplica=1";
    if ($ejecutar = mysqli_query(conexion($_SESSION['pais']), $squery)) {
        if (mysqli_num_rows($ejecutar) > 0) {
            while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
                if ($row['precio'] > (round($row['preciomin'], 3) + round($row['shipping'], 3))) {

                    $valor = (round($row['preciomin'], 3) + round($row['shipping'], 3)) * getMarmincom();
                    $squery = "select pcosto,unitbundle from tra_bun_det where amazonsku='" . $amazonSKU . "' and unitbundle='" . $lcCantidad . "'";
                    if ($ejecutar = mysqli_query(conexion($_SESSION['pais']), $squery)) {
                        if (mysqli_num_rows($ejecutar) > 0) {
                            $vez = 0;

                            while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
                                for ($i = $lcCantidad - 1; $i >= 1; $i--) {

                                    if ($i == $row['unitbundle']) {
                                        if (round($row['pcosto'], 3) > round($valor, 3) and $vez < 1) {
                                            #update
                                            $vez = 1;
                                        }

                                    }
                                }
                            }
                        }
                    }
                } else {
                    $valor = (round($row['precio'], 3));
                }

            }
        }
    }

    return $valor;
}

function minpri($codbundle, $canal, $facval, $mmax, $mmin)
{
    require_once('coneccion.php');

    $minpri = round(llamarQuery("select ((1-(($mmax-$mmin)/100))*sugsalpric) from tra_bun_det where amazonsku='" . $codbundle . "' and codcanal='" . $canal . "'"), 2);
    $subtotfbac = round(llamarQuery("select subtotfbac from tra_bun_det where amazonsku='" . $codbundle . "' and codcanal='" . $canal . "'"), 2);
    $fbarefossp = ($minpri * (($facval) / 100));
    $minpri2 = round((($minpri - $fbarefossp) - $subtotfbac), 2);
    $retornar = 0;
    #echo $facval."<br>";
    if ($minpri2 < 0) {
        $retornar = $subtotfbac * 1.05;
        $fbarefossp = ($retornar * (($facval + 2.5) / 100));
        $retornar = $retornar + $fbarefossp;
    } else {
        $retornar = $minpri;
    }

    //echo 'fv:' . $facval . '<br>max:' . $mmax . '<br>min:' . ($mmin/100) . '<br>res:' . $retornar.'<br><br>';
    return $retornar;

}

function agregarParametrosBundle($codbundle, $lcCantidad, $masterSKU, $prodName, $pesoOZ, $pesoLB, $peso, $amazonSKU, $alto, $largo, $ancho, $lbundle, $canal2, $customPrice = '-1', $unitBundle)
{
    require_once('coneccion.php');
    $return = "";
    $codigoEmpresa = $_SESSION['codEmpresa'];
    $codprov = $_SESSION['codprov'];
    $pesoLB = round($pesoLB, 3);
    $pesoOZ = round($pesoOZ, 3);
    $peso = round($peso, 3);
    $facreff = 0;

    if ($unitBundle != 1) {
        $checkUPCQuery = "SELECT UPC, PUBLICAR FROM tra_bun_det WHERE AMAZONSKU = '$amazonSKU';";
        $checkUPCResult = mysqli_query(conexion($_SESSION['pais']), $checkUPCQuery);
        if ($checkUPCResult) {
            if ($checkUPCResult->num_rows > 0) {
                $row = mysqli_fetch_array($checkUPCResult);
                if ($row[1] == 1) {
                    if ($row[0] != '') {
                        $checkIfSameUPCQuery = "SELECT UPC FROM tra_bun_det WHERE MASTERSKU = '$masterSKU' AND UNITBUNDLE = '1';";
                        $checkIfSameUPCResult = mysqli_query(conexion($_SESSION['pais']), $checkIfSameUPCQuery);
                        if ($checkIfSameUPCResult) {
                            if ($checkIfSameUPCResult->num_rows > 0) {
                                $checkUPC = mysqli_fetch_array($checkIfSameUPCResult)[0];
                                $currentUPC = $row[0];
                                echo $checkUPC . ' - ' . $currentUPC . '    ';
                                if ($checkUPC == $currentUPC) {
                                    $getUPCQuery = "SELECT CODUPC, UPC FROM cat_upc WHERE CANTIDAD = 0 AND MASTERSKU = '' AND AMAZONSKU = '' AND CODPAIS = '' ORDER BY UPC ASC LIMIT 1;";
                                    $getUPCResult = mysqli_query(conexion($_SESSION['']), $getUPCQuery);
                                    if ($getUPCResult) {
                                        if ($getUPCResult->num_rows > 0) {
                                            $row = mysqli_fetch_array($getUPCResult);
                                            $tCOD = $row[0];
                                            $tUPC = $row[1];
                                            $updateBundleQuery = "UPDATE tra_bun_det  SET UPC = '$tUPC' WHERE AMAZONSKU = '$amazonSKU';";
                                            $updateUPCQuery = "UPDATE cat_upc SET MASTERSKU = '$masterSKU', AMAZONSKU = '$amazonSKU', CODPAIS = '" . $_SESSION['codEmpresa'] . "', CANTIDAD = '1' WHERE CODUPC = '$tCOD';";

                                            mysqli_query(conexion($_SESSION['pais']), $updateBundleQuery);
                                            mysqli_query(conexion($_SESSION['']), $updateUPCQuery);
                                        }
                                    }
                                }
                            }
                        }

                    } else {
                        $getUPCQuery = "SELECT CODUPC, UPC FROM cat_upc WHERE CANTIDAD = 0 AND MASTERSKU = '' AND AMAZONSKU = '' AND CODPAIS = '' ORDER BY UPC ASC LIMIT 1;";
                        $getUPCResult = mysqli_query(conexion($_SESSION['']), $getUPCQuery);
                        if ($getUPCResult) {
                            if ($getUPCResult->num_rows > 0) {
                                $row = mysqli_fetch_array($getUPCResult);
                                $tCOD = $row[0];
                                $tUPC = $row[1];
                                $updateBundleQuery = "UPDATE tra_bun_det  SET UPC = '$tUPC' WHERE AMAZONSKU = '$amazonSKU';";
                                $updateUPCQuery = "UPDATE cat_upc SET MASTERSKU = '$masterSKU', AMAZONSKU = '$amazonSKU', CODPAIS = '" . $_SESSION['codEmpresa'] . "', CANTIDAD = '1' WHERE CODUPC = '$tCOD';";

                                mysqli_query(conexion($_SESSION['pais']), $updateBundleQuery);
                                mysqli_query(conexion($_SESSION['']), $updateUPCQuery);
                            }
                        }
                    }
                }
            }
        }
    }

    $phpMMAX = getMMAX();

    $cospri = "((select cap1.pcosto from cat_prod cap1 where cap1.codempresa='" . $codigoEmpresa . "' and cap1.mastersku='" . $masterSKU . "')";
    $ncospri = "((SELECT (NETREVOSSP/COSPRI) as resp FROM tra_bun_det WHERE AMAZONSKU = '$amazonSKU')";
    $basmar = "(select cap1.mmax*100 from cat_prod cap1 where cap1.codempresa='" . $codigoEmpresa . "' and cap1.mastersku='" . $masterSKU . "')";
//        $basmar = "(select cap1.marmax from cat_prov cap1 where cap1.codprov='$codprov')";
    //echo ' basmar:' . $basmar . ' ';
    $sugsalpri = "0";


    if ($unitBundle == 1) {
        $upcQuery = "(select cap1.upc from cat_prod cap1 where cap1.codempresa='" . $codigoEmpresa . "' and cap1.mastersku='" . $masterSKU . "')";
        $upcResult = mysqli_query(conexion($_SESSION["pais"]), $upcQuery);
        $upc = mysqli_fetch_array($upcResult)[0];
        $upUPC = "update tra_bun_det set upc = '$upc' where amazonsku = '$amazonSKU';";
        mysqli_query(conexion($_SESSION["pais"]), $upUPC);
    }
    //$upc = "(select cap1.upc from cat_prod cap1 where cap1.codempresa='" . $codigoEmpresa . "' and cap1.mastersku='" . $masterSKU . "')";
    $comsalpri = comsalpri($lcCantidad, $pesoLB, $amazonSKU, $codprov, $cospri);
//    echo ' basmar:'.$basmar . '          <br>          ';
//    echo ' codprov:'.$codprov . '          <br>          ';
    $qryCusPri = "SELECT CUSSALPRI FROM tra_bun_det WHERE amazonsku='" . $codbundle . "';";
    //echo $qryCusPri . ' <br> ';
    $resCusPri = mysqli_query(conexion($_SESSION['pais']), $qryCusPri);
    if ($resCusPri) {
        if ($resCusPri->num_rows > 0) {
            $row = mysqli_fetch_array($resCusPri);
            $tCusPri = $row[0];
            //echo 'this:' . $tCusPri;
            if ($tCusPri != 0) {
                $customPrice = $row[0];
            }
        }
    }

    $time_pre = microtime(true);
    ##canales
    $canal = "select codchan,channel from cat_sal_cha where columna!='' and channel='$canal2' order by channel";
    $ejecutarCanal = mysqli_query(conexion($_SESSION['pais']), $canal);
    if ($ejecutarCanal) {
        while ($rowCanal = mysqli_fetch_array($ejecutarCanal, MYSQLI_ASSOC)) {
            //echo 'Loop1 ' . (microtime(true) - $time_pre) . '<br>';
            $subtotfbac = "";
            ##Parametros de canal
            $parametro = "select tpc.codparam as codparpri,cpp.acosto as acosto,cpp.descrip as descrip,cpp.columna as columna,cpp.formula as formula,cpp.fac_val as fac_val from cat_par_pri cpp inner join tra_par_cha tpc on tpc.codparam=cpp.codparpri where cpp.columna!='' and tpc.codcanal='" . $rowCanal['codchan'] . "' order by cpp.orden ";
            $ejecutarParametro = mysqli_query(conexion($_SESSION['pais']), $parametro);
            //echo $parametro . '<br>';
            if ($ejecutarParametro) {
                if (mysqli_num_rows($ejecutarParametro) > 0) {
                    $return = "update tra_bun_det set ";
                    while ($rowParametro = mysqli_fetch_array($ejecutarParametro, MYSQLI_ASSOC)) {
                        //echo $rowParametro['columna'] . ':' . (microtime(true) - $time_pre) . '<br>';
                        $time_pre = microtime(true);
                        switch ($rowParametro['columna']) {
                            case "FBAPICPACF" || "FBAORDHANF" || "PACMAT" || "FBAREFOSSP":
                                {
                                    $facval = llamarQuery("select fac_val from tra_par_cha where codcanal='" . $rowCanal['codchan'] . "' and codparam='" . $rowParametro['codparpri'] . "'");
                                }
                            case "FBAWEIHANF":
                                {
                                    $fbaweihanf = fbaweihanf($lcCantidad, $peso, $canal);
                                    $fbaweihanf = number_format($fbaweihanf, 2, '.', '');
                                }
                            case "FBAINBSHI":
                                {
                                    $fbainbshi = fbainbshi($lcCantidad, $pesoOZ, $masterSKU);
                                }
                            case "SHIPPING" || "SHIRATE":
                                {
                                    $shipping = shipping($lcCantidad, $pesoOZ, $alto, $largo, $ancho);
                                    //echo ' disship'.$shipping.'  ';
                                }
                            case "BASMARIN":
                                {
                                    $lnIncremento = lnIncremento($lbundle, $pesoOZ, $codprov, $unitBundle);
                                    $lnIncremento = number_format($lnIncremento, 2, '.', '');
                                }
                            case "MARMINSALP":
                                {
                                    //$mmin="(select cap1.mmin from cat_prod cap1 where cap1.codempresa='".$codigoEmpresa."' and cap1.mastersku='".$masterSKU."')";
                                    $mmin = llamarQuery("(select cap1.marmin from cat_prov cap1 where cap1.codempresa='" . $codigoEmpresa . "')");
                                    // echo "(select cap1.marmin from cat_prov cap1 where cap1.codempresa='" . $codigoEmpresa . "')";
                                }
                            case "MARMAXSALP":
                                {
                                    //$mmax="(select cap1.mmax from cat_prod cap1 where cap1.codempresa='".$codigoEmpresa."' and cap1.mastersku='".$masterSKU."')";
                                    $mmax = llamarQuery("(select cap1.marmax from cat_prov cap1 where cap1.codempresa='" . $codigoEmpresa . "')");
                                }
                            case "FBAREFFEEO" || "SUGSALPRI":
                                {
                                    $lcVenta = "(((subtotfbac)*(((basmar+$lnIncremento)/100)+1)))";
                                }
                            case "FBAREFFEEO" || "SUGSALPRI":
                                {
                                    $fbareffeeo = "($lcVenta*(($facval+2.5)/100))";
                                }
                            case "SUGSALPRI":
                                {
                                    $lVenta = "($lcVenta+fbareffeeo)";
                                }
                            case "MAROVEITEC":
                                {
                                    $cosp = round(llamarQuery($cospri . ")"), 2);
//                                $cosp = round(llamarQuery($ncospri . ")"), 2);
                                }
                            case "SALPRIONSI":
                                {
                                    if ($lcCantidad == 1) {
                                        $salprionsi = "(select cap1.pventa from cat_prod cap1 where cap1.codempresa='" . $codigoEmpresa . "' and cap1.mastersku='" . $masterSKU . "')";
                                    } else {
                                        $salprionsi = number_format(0, 2, '.', '');
                                    }
                                }
                            case "COMSALPRI":
                                {
                                    //$comsalPri="(select cap2.preciomin from tra_pre_com cap2 where cap2.codempresa='".$codigoEmpresa."' and cap2.codprod=(select cap1.codprod from cat_prod cap1 where cap1.codempresa='".$codigoEmpresa."' and cap1.mastersku='".$masterSKU."') and cap2.unidades=$lcCantidad and cap2.aplica=1 and codCanal='".$rowCanal['codchan']."' order by cap2.fecha desc limit 1)";
                                    $comsalPri = "(select cap2.preciomax + cap2.shipping from tra_pre_com cap2 where cap2.codempresa='" . $codigoEmpresa . "' and cap2.codprod=(select cap1.codprod from cat_prod cap1 where cap1.codempresa='" . $codigoEmpresa . "' and cap1.mastersku='" . $masterSKU . "') and cap2.unidades=$lcCantidad and cap2.aplica=1 and codCanal='" . $rowCanal['codchan'] . "' order by cap2.fecha desc limit 1)";
                                }
                            case "SUGSALPRIC" || "FBAREFOSSP":
                                {
                                    if ($customPrice == '-1') {
                                        $venta = calcularCompetencia($codbundle, $rowCanal['codchan'], $facreff);
                                        $sugsalpric = "($venta)";
                                    } else {
                                        $sugsalpric = "($customPrice)";
                                        $venta = $customPrice;
                                    }


                                }
                            case "INCOVESUGS":
                                {
                                    $incovesugs = "((sugsalpric-sugsalpri)/sugsalpri)*100";
                                }
                            case "FBAREFOSSP":
                                {
                                    $facreff = llamarQuery("select fac_val from tra_par_cha where codcanal='" . $rowCanal['codchan'] . "' and codparam='" . $rowParametro['codparpri'] . "'");
                                    $fbarefossp = "(($venta)*(($facval)/100))";
                                }
                            case "FBAREFFEEO":
                                {
                                    $facreff = llamarQuery("select fac_val from tra_par_cha where codcanal='" . $rowCanal['codchan'] . "' and codparam='" . $rowParametro['codparpri'] . "'");
                                }
                            case "PACMAT":
                                {
                                    $pacmat = llamarQuery("(select pacmat from tra_bun_det where amazonsku='" . $codbundle . "' and codcanal='" . $rowCanal['codchan'] . "')");
                                }
                        }
                        $maxpri = "((1+(" . $mmax . "-(" . $mmin . "/100)))*sugsalpric)";
                        $compe = (round(llamarQuery("(select comsalpri from tra_bun_det where amazonsku='" . $codbundle . "' and codcanal='" . $rowCanal['codchan'] . "')"), 2)) * getMarmincom();
                        $minpri = round(minpri($codbundle, $rowCanal['codchan'], $facreff, $mmax, $mmin), 2);#calcular elfee se le resta ese valor se resta al costo y si es positivo se le da utilidad si no es costo por 1.05

                        $minpri = number_format($minpri, 2, '.', '');

                        //8002 8000 maria
                        if ($rowParametro['formula'] == '') {
                            $return = $return;
                        } else {
                            if (substr($rowParametro['formula'], 0, 1) == '@') {
                                $return = $return;
                            } else {
                                if ($rowParametro['acosto'] == '1' and $rowParametro['columna'] != 'NETREVOVES' and $rowParametro['columna'] != 'FBAREFFEEO') {
                                    $subtotfbac = $subtotfbac . $rowParametro['columna'] . '+';
                                } else {
                                    if ($rowParametro['columna'] == 'SUBTOTFBAC') {
                                        if (strlen($subtotfbac) > 0) {
                                            $subtotfbac = substr($subtotfbac, 0, strlen($subtotfbac) - 1);
                                        }
                                    }
                                }
                                #echo $subtotfbac."<br>";
                                $str = $rowParametro['formula'];
                                eval("\$str = \"$str\";");
                                //echo $rowParametro['columna']."=".$str.'<br>';
                                $return = $return . strtolower($rowParametro['columna']) . "=" . $str . " ,";
                                #echo $venta."<br>";
                                #echo $fbaweihanf."<br>";
                            }
                        }#cierra si la formula no esta vacia else
                    }#cierra while parametros
                    //fix name
                    $prodNameQry = "SELECT PRODNAME FROM cat_prod WHERE MASTERSKU = '$masterSKU';";
                    $prodNameRes = mysqli_query(conexion($_SESSION['pais']), $prodNameQry);
                    $prodName = '';
                    if ($prodNameRes) {
                        if ($prodNameRes->num_rows > 0) {
                            $row = mysqli_fetch_array($prodNameRes);
                            $prodName = $row[0];
                        }
                    }
                    //'" . $prodName . " (Pack of " . intval($uBundle) . ")',
                    $return = $return . " PRODNAME = '$prodName (Pack of $unitBundle)',";
                    $return = substr($return, 0, strlen($return) - 1) . " where amazonsku='" . $codbundle . "' and codcanal='" . $rowCanal['codchan'] . "';";
                }#cierra si numero de filas >0
            }#cierra paramaetros

            if ($return != "") {
                //echo '          !' . $return . '!          ';
                //echo microtime(true) - $time_pre . '<br>';

                if (!mysqli_query(conexion($_SESSION['pais']), $return)) {
                    return "\n\n$return\n\n";
                } else {
                    return 1;
                }
            } else {
                return 1;
            }
            #echo $lcVenta;#echo $fbaordhanf.",";
        }#cierra while canales
    }#cierra ejecutar canales
}

function agregarParametrosBundleC($codbundle, $lcCantidad, $masterSKU, $prodName, $pesoOZ, $pesoLB, $peso, $amazonSKU, $alto, $largo, $ancho, $lbundle, $canal2, $customPrice = '-1', $unitBundle)
{
    require_once('coneccion.php');
    //echo 'here1';

    //echo '!!!!!HERE'.$customPrice.'!!!!!';

    //clean aux table
    $cleanTable = "TRUNCATE tra_bun_detc;";
    mysqli_query(conexion($_SESSION['pais']), $cleanTable);

    ///echo 'here2';
    //copy bundle to aux table
    $getBundleQry = "SELECT * FROM tra_bun_det WHERE AMAZONSKU = '$codbundle';";
    $getBundleRes = mysqli_query(conexion($_SESSION['pais']), $getBundleQry);

    //echo $getBundleQry . '    ////    ';

    if ($getBundleRes) {
        if ($getBundleRes->num_rows > 0) {
            $row = mysqli_fetch_array($getBundleRes);

            $insertAuxTable = "
		insert into tra_bun_detc(
			masterSKU,
			prodname,
			codempresa,
			amazonsku,
			unitbundle,
			unitcase,
			cospri,pacmat,subtotfbac,
			basmar,salprionsi,
			comsalpri,incovesugs,bununipri,
			upc,
			codcanal,
			sugsalpri,
			sugsalpric)
		values(
			'" . $row['MASTERSKU'] . "',
			'" . $row['PRODNAME'] . "',
			'" . $row['CODEMPRESA'] . "',
			'" . $row['AMAZONSKU'] . "',
			'" . $row['UNITBUNDLE'] . "',
			'" . $row['UNITCASE'] . "',
			'" . $row['COSPRI'] . "',
			0,0,0,
			0.45,
			0,0,0,
			'" . $row['UPC'] . "',
			'" . $row['CODCANAL'] . "',
			'$customPrice',
			'$customPrice')";

//            echo $insertAuxTable . '    ////    ';


            mysqli_query(conexion($_SESSION['pais']), $insertAuxTable);
        }
    }

    $return = "";
    $codigoEmpresa = $_SESSION['codEmpresa'];
    $codprov = $_SESSION['codprov'];
    $pesoLB = round($pesoLB, 3);
    $pesoOZ = round($pesoOZ, 3);
    $peso = round($peso, 3);
    $facreff = 0;

    $phpMMAX = getMMAX();

    $cospri = "((select cap1.pcosto from cat_prod cap1 where cap1.codempresa='" . $codigoEmpresa . "' and cap1.mastersku='" . $masterSKU . "')";
    $ncospri = "((SELECT (NETREVOSSP/COSPRI) as resp FROM tra_bun_det WHERE AMAZONSKU = '$amazonSKU')";
//    $basmar = "(select cap1.mmax*100 from cat_prod cap1 where cap1.codempresa='" . $codigoEmpresa . "' and cap1.mastersku='" . $masterSKU . "')";
    $basmar = "(select cap1.marmax from cat_prov cap1 where cap1.codprov='$codprov')";
    //echo ' basmar:' . $basmar . ' ';
    $sugsalpri = "0";
    $upc = "(select cap1.upc from cat_prod cap1 where cap1.codempresa='" . $codigoEmpresa . "' and cap1.mastersku='" . $masterSKU . "')";
    $comsalpri = comsalpri($lcCantidad, $pesoLB, $amazonSKU, $codprov, $cospri);
//    echo ' basmar:'.$basmar . '          <br>          ';
//    echo ' codprov:'.$codprov . '          <br>          ';

    //$qryCusPri = "SELECT CUSSALPRI FROM tra_bun_detc WHERE amazonsku='" . $codbundle . "';";
    //echo $qryCusPri . ' <br> ';
//    $resCusPri = mysqli_query(conexion($_SESSION['pais']), $qryCusPri);
//    if ($resCusPri) {
//        if ($resCusPri->num_rows > 0) {
//            $row = mysqli_fetch_array($resCusPri);
//            $tCusPri = $row[0];
//            //echo 'this:' . $tCusPri;
//            if ($tCusPri != 0) {
//                $customPrice = $row[0];
//            }
//        }
//    }

    $time_pre = microtime(true);
    ##canales
    $canal = "select codchan,channel from cat_sal_cha where columna!='' and channel='$canal2' order by channel";
    $ejecutarCanal = mysqli_query(conexion($_SESSION['pais']), $canal);
    if ($ejecutarCanal) {
        while ($rowCanal = mysqli_fetch_array($ejecutarCanal, MYSQLI_ASSOC)) {
            //echo 'Loop1 ' . (microtime(true) - $time_pre) . '<br>';
            $subtotfbac = "";
            ##Parametros de canal
            $parametro = "select tpc.codparam as codparpri,cpp.acosto as acosto,cpp.descrip as descrip,cpp.columna as columna,cpp.formula as formula,cpp.fac_val as fac_val from cat_par_pri cpp inner join tra_par_cha tpc on tpc.codparam=cpp.codparpri where cpp.columna!='' and tpc.codcanal='" . $rowCanal['codchan'] . "' order by cpp.orden ";
            $ejecutarParametro = mysqli_query(conexion($_SESSION['pais']), $parametro);
            //echo $parametro . '<br>';
            if ($ejecutarParametro) {
                if (mysqli_num_rows($ejecutarParametro) > 0) {
                    $return = "update tra_bun_detc set ";
                    while ($rowParametro = mysqli_fetch_array($ejecutarParametro, MYSQLI_ASSOC)) {
                        //echo $rowParametro['columna'] . ':' . (microtime(true) - $time_pre) . '<br>';
                        $time_pre = microtime(true);
                        switch ($rowParametro['columna']) {
                            case "FBAPICPACF" || "FBAORDHANF" || "PACMAT" || "FBAREFOSSP":
                                {
                                    $facval = llamarQuery("select fac_val from tra_par_cha where codcanal='" . $rowCanal['codchan'] . "' and codparam='" . $rowParametro['codparpri'] . "'");
                                }
                            case "FBAWEIHANF":
                                {
                                    $fbaweihanf = fbaweihanf($lcCantidad, $peso, $canal);
                                    $fbaweihanf = number_format($fbaweihanf, 2, '.', '');
                                }
                            case "FBAINBSHI":
                                {
                                    $fbainbshi = fbainbshi($lcCantidad, $pesoOZ, $masterSKU);
                                }
                            case "SHIPPING" || "SHIRATE":
                                {
                                    $shipping = shipping($lcCantidad, $pesoOZ, $alto, $largo, $ancho);
                                }
                            case "BASMARIN":
                                {
                                    $lnIncremento = lnIncremento($lbundle, $pesoOZ, $codprov, $unitBundle);
                                    $lnIncremento = number_format($lnIncremento, 2, '.', '');
                                }
                            case "MARMINSALP":
                                {
                                    //$mmin="(select cap1.mmin from cat_prod cap1 where cap1.codempresa='".$codigoEmpresa."' and cap1.mastersku='".$masterSKU."')";
                                    $mmin = llamarQuery("(select cap1.mmin from cat_prod cap1 where cap1.codempresa='" . $codigoEmpresa . "' and cap1.mastersku='" . $masterSKU . "')");
                                }
                            case "MARMAXSALP":
                                {
                                    //$mmax="(select cap1.mmax from cat_prod cap1 where cap1.codempresa='".$codigoEmpresa."' and cap1.mastersku='".$masterSKU."')";
                                    $mmax = llamarQuery("(select cap1.mmax from cat_prod cap1 where cap1.codempresa='" . $codigoEmpresa . "' and cap1.mastersku='" . $masterSKU . "')");
                                }
                            case "FBAREFFEEO" || "SUGSALPRI":
                                {
                                    $lcVenta = "(((subtotfbac)*(((basmar+$lnIncremento)/100)+1)))";
                                }
                            case "FBAREFFEEO" || "SUGSALPRI":
                                {
                                    $fbareffeeo = "($lcVenta*(($facval+2.5)/100))";
                                }
                            case "SUGSALPRI":
                                {
                                    $lVenta = "($lcVenta+fbareffeeo)";
                                }
                            case "MAROVEITEC":
                                {
                                    $cosp = round(llamarQuery($cospri . ")"), 2);
//                                $cosp = round(llamarQuery($ncospri . ")"), 2);
                                }
                            case "SALPRIONSI":
                                {
                                    if ($lcCantidad == 1) {
                                        $salprionsi = "(select cap1.pventa from cat_prod cap1 where cap1.codempresa='" . $codigoEmpresa . "' and cap1.mastersku='" . $masterSKU . "')";
                                    } else {
                                        $salprionsi = number_format(0, 2, '.', '');
                                    }
                                }
                            case "COMSALPRI":
                                {
                                    //$comsalPri="(select cap2.preciomin from tra_pre_com cap2 where cap2.codempresa='".$codigoEmpresa."' and cap2.codprod=(select cap1.codprod from cat_prod cap1 where cap1.codempresa='".$codigoEmpresa."' and cap1.mastersku='".$masterSKU."') and cap2.unidades=$lcCantidad and cap2.aplica=1 and codCanal='".$rowCanal['codchan']."' order by cap2.fecha desc limit 1)";
                                    $comsalPri = "(select cap2.preciomax + cap2.shipping from tra_pre_com cap2 where cap2.codempresa='" . $codigoEmpresa . "' and cap2.codprod=(select cap1.codprod from cat_prod cap1 where cap1.codempresa='" . $codigoEmpresa . "' and cap1.mastersku='" . $masterSKU . "') and cap2.unidades=$lcCantidad and cap2.aplica=1 and codCanal='" . $rowCanal['codchan'] . "' order by cap2.fecha desc limit 1)";
                                }
                            case "SUGSALPRIC" || "FBAREFOSSP":
                                {
                                    if ($customPrice == '-1') {
                                        $venta = calcularCompetencia($codbundle, $rowCanal['codchan'], $facreff);
                                        $sugsalpric = "($venta)";
                                    } else {
                                        $sugsalpric = "($customPrice)";
                                        $venta = $customPrice;
                                    }

//                                echo '     !!!!!'.$customPrice.'-'.$venta.'-'.$sugsalpric.'!!!!!     ';
                                }
                            case "INCOVESUGS":
                                {
                                    $incovesugs = "((sugsalpric-sugsalpri)/sugsalpri)*100";
                                }
                            case "FBAREFOSSP":
                                {
                                    $facreff = llamarQuery("select fac_val from tra_par_cha where codcanal='" . $rowCanal['codchan'] . "' and codparam='" . $rowParametro['codparpri'] . "'");
                                    $fbarefossp = "(($venta)*(($facval)/100))";
                                }
                            case "FBAREFFEEO":
                                {
                                    $facreff = llamarQuery("select fac_val from tra_par_cha where codcanal='" . $rowCanal['codchan'] . "' and codparam='" . $rowParametro['codparpri'] . "'");
                                }
                            case "PACMAT":
                                {
                                    $pacmat = llamarQuery("(select pacmat from tra_bun_det where amazonsku='" . $codbundle . "' and codcanal='" . $rowCanal['codchan'] . "')");
                                }
                        }
                        $maxpri = "((1+($mmax-($mmin/100)))*sugsalpric)";
                        $compe = (round(llamarQuery("(select comsalpri from tra_bun_det where amazonsku='" . $codbundle . "' and codcanal='" . $rowCanal['codchan'] . "')"), 2)) * getMarmincom();
                        $minpri = round(minpri($codbundle, $rowCanal['codchan'], $facreff, $mmax, $mmin), 2);#calcular refeelfee se le resta ese valor se resta al costo y si es positivo se le da utilidad si no es costo por 1.05
                        $minpri = number_format($minpri, 2, '.', '');
                        //8002 8000 maria
                        if ($rowParametro['formula'] == '') {
                            $return = $return;
                        } else {
                            if (substr($rowParametro['formula'], 0, 1) == '@') {
                                $return = $return;
                            } else {
                                if ($rowParametro['acosto'] == '1' and $rowParametro['columna'] != 'NETREVOVES' and $rowParametro['columna'] != 'FBAREFFEEO') {
                                    $subtotfbac = $subtotfbac . $rowParametro['columna'] . '+';
                                } else {
                                    if ($rowParametro['columna'] == 'SUBTOTFBAC') {
                                        if (strlen($subtotfbac) > 0) {
                                            $subtotfbac = substr($subtotfbac, 0, strlen($subtotfbac) - 1);
                                        }
                                    }
                                }
                                #echo $subtotfbac."<br>";
                                $str = $rowParametro['formula'];
                                eval("\$str = \"$str\";");
                                //echo $rowParametro['columna']."=".$str.'<br>';
                                $return = $return . strtolower($rowParametro['columna']) . "=" . $str . " ,";
                                #echo $venta."<br>";
                                #echo $fbaweihanf."<br>";
                            }
                        }#cierra si la formula no esta vacia else
                    }#cierra while parametros
                    $return = substr($return, 0, strlen($return) - 1) . " where amazonsku='" . $codbundle . "' and codcanal='" . $rowCanal['codchan'] . "';";
                }#cierra si numero de filas >0
            }#cierra paramaetros

            if ($return != "") {
//                echo '          !' . $return . '!          ';
//                echo $return;
//                echo microtime(true) - $time_pre . '<br>';
//                echo microtime(true) - $time_pre . '<br>';

                if (mysqli_query(conexion($_SESSION['pais']), $return)) {
                    $getLas = "select *, (FBAORDHANF + FBAPICPACF + FBAWEIHANF + FBAINBSHI + PACMAT + FBAREFOSSP) as CHANNELFEE, ((((sugsalpric-subtotfbac)-fbarefossp)/(cospri))*100) as MAROVEITEC from tra_bun_detc;";
                    $getLasRes = mysqli_query(conexion($_SESSION['pais']), $getLas);
                    if ($getLasRes) {
                        if ($getLasRes->num_rows > 0) {
                            $row1 = mysqli_fetch_array($getLasRes);
                            echo json_encode($row1);
                        }
                    }
                } else {
//                    return 1;
                    echo 'error aca';
                }
            } else {
                //return 1;
            }
            #echo $lcVenta;#echo $fbaordhanf.",";
        }#cierra while canales
    }#cierra ejecutar canales
}

function calcularCompetencia($codbundle, $canal, $facval)
{
    $venta = round(llamarQuery("(select sugsalpri from tra_bun_det where amazonsku='" . $codbundle . "' and codcanal='" . $canal . "')"), 2);
    //echo $codbundle . ' - ' . $venta . "(select sugsalpri from tra_bun_det where amazonsku='".$codbundle."' and codcanal='".$canal."')<br>";
    $costos = round(llamarQuery("(select subtotfbac from tra_bun_det where amazonsku='" . $codbundle . "' and codcanal='" . $canal . "')"), 2);
    $compe = (round(llamarQuery("(select comsalpri from tra_bun_det where amazonsku='" . $codbundle . "' and codcanal='" . $canal . "')"), 2)) * getMarmincom();
    $fbarefossp = "($compe*(($facval)/100))";
    #compe-refee<br=ventasc  pmax-pmin-*pactual si pcompe>0 esto  preciomin-costo=utilidad/psugerido

    $sugsalpric = 0;
    if ($compe > 1) {
        $ventaSc = ($compe - $fbarefossp);

        if ($ventaSc < 5) {
            $sugsalpric = $costos * 1.05;
        } else {
            $sugsalpric = $compe;
        }
    } else {
        $sugsalpric = $venta;
    }

    return $sugsalpric;
}

function calcularCompetenciaC($codbundle, $canal, $facval)
{
    $venta = round(llamarQuery("(select sugsalpric from tra_bun_detc where amazonsku='" . $codbundle . "' and codcanal='" . $canal . "')"), 2);
    //echo $codbundle . ' - ' . $venta . "(select sugsalpri from tra_bun_det where amazonsku='".$codbundle."' and codcanal='".$canal."')<br>";
    $costos = round(llamarQuery("(select subtotfbac from tra_bun_detc where amazonsku='" . $codbundle . "' and codcanal='" . $canal . "')"), 2);
    $compe = (round(llamarQuery("(select comsalpri from tra_bun_detc where amazonsku='" . $codbundle . "' and codcanal='" . $canal . "')"), 2)) * getMarmincom();
    $fbarefossp = "($compe*(($facval)/100))";
    #compe-refee<br=ventasc  pmax-pmin-*pactual si pcompe>0 esto  preciomin-costo=utilidad/psugerido
//    echo '              ' . $venta . '                 ';
    $sugsalpric = 0;
    if ($compe > 1) {
        $ventaSc = ($compe - $fbarefossp);

        if ($ventaSc < 5) {
            $sugsalpric = $costos * 1.05;
        } else {
            $sugsalpric = $compe;
        }
    } else {
        $sugsalpric = $venta;
    }

    return $sugsalpric;
}

function llamarQuery($query)
{
    if ($ejecutar = mysqli_query(conexion($_SESSION['pais']), $query)) {
        if (mysqli_num_rows($ejecutar) > 0) {
            if ($row = mysqli_fetch_array($ejecutar, MYSQLI_NUM)) {
                return $row[0];
            }
        }
    }
}

function updateCat_par_pri($codbundle, $lcCantidad, $masterSKU, $codigoEmpresa, $prodName, $pesoOZ, $pesoLB, $amazonSKU, $codprov)
{
    $return = "";
    $canal = "select codchan from cat_sal_cha where columna!=''";
    $ejecutarCanal = mysqli_query(conexion($_SESSION['pais']), $canal);
    if ($ejecutarCanal) {
        while ($rowCanal = mysqli_fetch_array($ejecutarCanal, MYSQLI_ASSOC)) {
            $parametro = "select cpp.columna as columna,cpp.formula as formula,cpp.fac_val as fac_val from cat_par_pri cpp inner join tra_par_cha tpc on tpc.codparam=cpp.codparpri where cpp.columna!='' and tpc.codcanal='" . $rowCanal['codchan'] . "' ";
            $ejecutarParametro = mysqli_query(conexion($_SESSION['pais']), $parametro);
            if ($ejecutarParametro) {
                if (mysqli_num_rows($ejecutarParametro) > 0) {
                    while ($rowParametro = mysqli_fetch_array($ejecutarParametro, MYSQLI_ASSOC)) {
                        if ($rowParametro['formula'] == '') {

                            $return = $return;
                        } else {
                            if (substr($rowParametro['formula'], 0, 1) == '@') {

                                $return = $return;
                            } else {
                                $return = "update cat_par_pri set ";
                                $str = $rowParametro['formula'];
                                #eval("\$str = \"$str\";");
                                $return = $return . "formula=\"" . $str . "\" where columna='" . $rowParametro['columna'] . "' <br>";
                                //echo $return."<br>";
                            }
                        }
                    }
                    #$return=substr($return,0,strlen($return)-1)." where amazonsku='".$codbundle."' and codcanal='".$rowCanal['codchan']."';";
                }
                #if(!mysqli_query(conexion($_SESSION['pais']),$return))
                {
                    #	echo "Error al actualizar";
                }
            }
        }
    }
}