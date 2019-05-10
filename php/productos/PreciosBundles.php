<?php

require_once('../fecha.php');
require_once('../coneccion.php');
require_once('../formulas.php');
$idioma = idioma();
include('../idiomas/' . $idioma . '.php');
$masterSKU = $_POST['masterSKU'];
session_start();
$contars = 0;

    $altosql = "(select pd.alto+(select te.alto from cat_tip_emp te where te.codpack=pd.codpack) as alto from cat_prod pd where pd.mastersku='" . $masterSKU . "')";
    $anchosql = "(select pd.ancho+(select te.ancho from cat_tip_emp te where te.codpack=pd.codpack) as ancho from cat_prod pd where pd.mastersku='" . $masterSKU . "')";
    $largosql = "(select pd.profun+(select te.largo from cat_tip_emp te where te.codpack=pd.codpack) as prof from cat_prod pd where pd.mastersku='" . $masterSKU . "')";
    $retornar = "";
    $squery = "select 
                (select peso_lb*16+peso_oz from cat_prod where codempresa='" . $_SESSION['codEmpresa'] . "' and mastersku='" . $masterSKU . "' and codprod='" . $_SESSION['codprod'] . "' limit 1) as pesoOz,
                (select peso from cat_prod where codempresa='" . $_SESSION['codEmpresa'] . "' and mastersku='" . $masterSKU . "' and codprod='" . $_SESSION['codprod'] . "' limit 1) as peso,
                (select peso_lb from cat_prod where codempresa='" . $_SESSION['codEmpresa'] . "' and mastersku='" . $masterSKU . "' and codprod='" . $_SESSION['codprod'] . "' limit 1) as pesoLB,
                $altosql as alto,
                $anchosql as ancho,
                $largosql as largo,
                masterSKU,codempresa,prodName,amazondesc,unitcase,codbundle,amazonsku,asin,unitbundle,cospri,pacmat,shipping,shirate,
                (subtotfbac) as subtotfbac,fbaordhanf,fbapicpacf,fbaweihanf,fbainbshi,basmar,basmarin,comsalpri,bununipri,fbareffeeo,
                sugsalpri,marovesugp,maroveitec,salprionsi,incovesugs,fbarefossp,marovecoss,marminsalp,marmaxsalp,minpri,maxpri,cant,cantidad,psite,pcompe,psuger,tipo,upc,
                (select channel from cat_sal_cha where codchan=codcanal) as canal,netrevoves,sugsalpric,netrevossp,marovessp,codbundle from tra_bun_det where";
    $squery = $squery . " codempresa='" . $_SESSION['codEmpresa'] . "' and mastersku='" . $masterSKU . "' and CODCANAL = (SELECT CODCHAN FROM cat_sal_cha WHERE CHANNEL = 'sales on line') order by amazonsku ";
//    echo $squery . '<br>';
    $bundleCounter = 1;

    if ($ejecutar = mysqli_query(conexion($_SESSION['pais']), $squery)) {
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
//            $codigoEmpresa = $_SESSION['codEmpresa'];
//            $codprov = $_SESSION['codprov'];
//            echo 'codEmp:' . $codigoEmpresa . ' codProv:' . $codprov . '<br>';
//            echo  ' AMAZONSKU: ' .$row['amazonsku'] . ' UNITBUNDLE: ' . $row['unitbundle'] . ' MASTERSKU: ' . $masterSKU . ' PRODNAME: ' . substr($row['prodName'], 0, strlen($row['prodName']) - 12) . ' OZ: ' . $row['pesoOz'] . ' LB: ' . $row['pesoLB'] . ' PESO: ' . $row['peso'] . ' AMAZONSKU: ' .$row['amazonsku'] . ' ALTO: ' . round(intval($row['alto']), 2) . ' LARGO: ' . round(intval($row['largo']), 2) . ' ANCHO: ' . round(intval($row['ancho']), 2) . ' UNITCASE: ' . $row['unitcase'] . ' CANAL: ' . $row['canal'] . '<BR>';


            echo (agregarParametrosBundle(
                $row['amazonsku'],
                $row['unitbundle'],
                $masterSKU,
                substr($row['prodName'], 0, strlen($row['prodName']) - 12),
                $row['pesoOz'],
                $row['pesoLB'],
                $row['peso'],
                $row['amazonsku'],
                round(intval($row['alto']), 2),
                round(intval($row['largo']), 2),
                round(intval($row['ancho']), 2),
                $bundleCounter,
                $row['canal'],
                -1,
                $row['unitbundle'])
            );
            $bundleCounter += 1;
        }
    } else {
        echo "error";
    }