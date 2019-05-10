<?php
error_reporting(E_ERROR);
ini_set('display_errors', '1');
require_once('../coneccion.php');
require_once('../fecha.php');
$idioma = idioma();
include('../idiomas/' . $idioma . '.php');
## usuario y clave pasados por el formulario
$formul = strtoupper($_POST['formul']);
$codempresa = strtoupper($_POST['empresa']);
$nombre = limpiar_caracteres_sql($_POST['nombre']);
$pais = limpiar_caracteres_sql($_POST['pais']);
$ancho = limpiar_caracteres_sql($_POST['ancho']);
$alto = limpiar_caracteres_sql($_POST['alto']);
$largo = limpiar_caracteres_sql($_POST['largo']);
$pesoUni = limpiar_caracteres_sql($_POST['pesoUni']);
$pesoUni2 = limpiar_caracteres_sql($_POST['pesni']);
$codigoUnico = "";
$idunico = "";
session_start();
verTiempo2();
switch ($formul) {
    case 'MARCA':
        {
            $cod = sys2015();
            $codigoUnico = $cod;
            $idunico = "marca";
            $codprov = limpiar_caracteres_sql($_POST['alto']);

            $tCODIGO = getBrandId($nombre);

            $squery = "insert into cat_marcas(codmarca,nombre,codigo,codempresa) values('" . $cod . "','" . $nombre . "','$tCODIGO','" . $codempresa . "');";
            $squery2 = "insert into tra_cat_prov(codprov,codcat,tipo) values('" . $codprov . "','" . $cod . "',1);";

            echo "$squery - $squery2";
            break;
        }
    case 'CATEGORY':
        {
            $squery = "insert into cat_cat_pro(codcate,nombre,codempresa) values('" . sys2015() . "','" . $nombre . "','" . $codempresa . "');";
            break;
        }
    case 'SUBCATEGORY':
        {
            $squery = "insert into cat_sca_pro(codscapro,nombre,url,codempresa) values('" . sys2015() . "','" . $nombre . "','" . $alto . "','" . $codempresa . "');";
            break;
        }
    case 'PRODLIN':
        {
            $cod = sys2015();
            $codigoUnico = $cod;
            $idunico = "prodLin";
            $codprov = limpiar_caracteres_sql($_POST['ancho']);
            $squery = "insert into cat_pro_lin(codprolin,prodline,codigo,codempresa) values('" . $cod . "','" . $nombre . "','" . $alto . "','" . $codempresa . "');";
            $squery2 = "insert into tra_cat_prov(codprov,codcat,tipo) values('" . $codprov . "','" . $cod . "',3);";
            break;
        }
    case 'COMERCIALIZA':
        {
            $squery = "insert into cat_COM_CANALES(codcomcan,nombre,codigo) values('" . sys2015() . "','" . $nombre . "','" . $alto . "');";
            break;
        }
    case 'EXPORTACION':
        {
            $squery = "insert into cat_For_exportar(codforexp,nombre,codigo) values('" . sys2015() . "','" . $nombre . "','" . $alto . "');";
            break;
        }
    case 'TRANSPORTE':
        {
            $squery = "insert into cat_transportes(codtransporte,nombre,codigo) values('" . sys2015() . "','" . $nombre . "','" . $alto . "');";
            break;
        }
    case 'PAKAGE':
        {
            $cod = sys2015();
            $squery = "insert into cat_tip_emp(codpack,nombre,codempresa,alto,ancho,largo) values('" . $cod . "','" . $nombre . "','" . $codempresa . "','" . $alto . "','" . $ancho . "','" . $largo . "');";
            break;
        }
    case 'SIZE':
        {
            $cod = sys2015();
            $codigoUnico = $cod;
            $idunico = "size";
            $codprov = limpiar_caracteres_sql($_POST['pesoUni']);
            $squery = "insert into cat_pre_prod(codprepro,nombre,codempresa,peso,unidades,presenta,pesouni) values('" . $cod . "','" . $nombre . "','" . $codempresa . "','" . $alto . "','" . $ancho . "','" . $largo . "','" . $pesoUni2 . "');";
            $squery2 = "insert into tra_cat_prov(codprov,codcat,tipo) values('" . $codprov . "','" . $cod . "',8);";
            break;
        }
    case 'FLAVOR':
        {
            $cod = sys2015();
            $codigoUnico = $cod;
            $idunico = "flavor";
            $codprov = limpiar_caracteres_sql($_POST['alto']);
            $squery = "insert into cat_flavors(codflavor,nombre,codempresa) values('" . $cod . "','" . $nombre . "','" . $codempresa . "');";
            $squery2 = "insert into tra_cat_prov(codprov,codcat,tipo) values('" . $codprov . "','" . $cod . "',4);";
            break;
        }
    case 'AGESEGMENT':
        {
            $squery = "insert into cat_agesegment(codageseg,nameageseg,code,codempresa) values('" . sys2015() . "','" . $nombre . "','" . $alto . "','" . $codempresa . "');";
            break;
        }
    case 'COCINA':
        {
            $cod = sys2015();
            $codigoUnico = $cod;
            $idunico = "cocina";
            $codprov = limpiar_caracteres_sql($_POST['alto']);
            $squery = "insert into cat_cocina(codcocina,nombre,codempresa) values('" . $cod . "','" . $nombre . "','" . $codempresa . "');";
            $squery2 = "insert into tra_cat_prov(codprov,codcat,tipo) values('" . $codprov . "','" . $cod . "',6);";
            break;
        }
    case 'CONCERNS':
        {
            $squery = "insert into cat_concerns(codconcern,nombre,codempresa) values('" . sys2015() . "','" . $nombre . "','" . $codempresa . "');";
            break;
        }
    case 'SELLER':
        {
            $cod = sys2015();
            $codigoUnico = $cod;
            $idunico = "competencia";
            $codprov = limpiar_caracteres_sql($_POST['pesoUni']);
            $squery = "insert into cat_sellers(codseller,nombre,codempresa,codprov) values('" . $cod . "','" . $nombre . "','" . $_SESSION['codEmpresa'] . "','" . $_SESSION['codprov'] . "');";
            $squery2 = "insert into tra_cat_prov(codprov,codcat,tipo) values('" . $codprov . "','" . $cod . "',7);";
            break;
        }
    case 'FORMULA':
        {
            $cod = sys2015();
            $codigoUnico = $cod;
            $idunico = "formula";
            $codprov = limpiar_caracteres_sql($_POST['pesoUni']);
            $squery = "insert into cat_forms(codform,nombre,codempresa) values('" . $cod . "','" . $nombre . "','" . $codempresa . "');";
            $squery2 = "insert into tra_cat_prov(codprov,codcat,tipo) values('" . $codprov . "','" . $cod . "',5);";
            break;
        }
    case 'MANUFACT':
        {
            $cod = sys2015();
            $codigoUnico = $cod;
            $idunico = "manufacturadores";
            $codprov = limpiar_caracteres_sql($_POST['pesoUni']);
            $ciudad = limpiar_caracteres_sql($_POST['ciudad']);
            $estado = limpiar_caracteres_sql($_POST['estado']);
            $codpos = limpiar_caracteres_sql($_POST['codpos']);
            $pais23 = limpiar_caracteres_sql($_POST['pais2']);
            $squery = "insert into cat_manufacturadores(codmanufac,nombre,codigo,codempresa,fda,direccion,ciudad,estado,codpos,pais) values('" . $cod . "','" . $nombre . "','" . $alto . "','" . $codempresa . "','" . $ancho . "','" . $largo . "','" . $ciudad . "','" . $estado . "','" . $codpos . "','" . $pais23 . "');";
            $squery2 = "insert into tra_cat_prov(codprov,codcat,tipo) values('" . $codprov . "','" . $cod . "',2);";
            break;
        }
    case 'ARANCEL':
        {
            $squery = "insert into cat_par_arancel(codarancel,nombre,codigo) values('" . sys2015() . "','" . $nombre . "','" . $alto . "');";
            break;
        }
    case 'PAISORIGEN':
        {
            $cod1 = $_POST['cod1'];
            $cod2 = $_POST['cod2'];
            $cod3 = $_POST['cod3'];
            $squery = "insert into cat_country(codcountry,nombre,nombreonu,codeco,codigo1,codigo2,codigo3,codigo4,codigo5,codigo6) values('" . sys2015() . "','" . $nombre . "','" . $codempresa . "','" . $alto . "','" . $ancho . "','" . $largo . "','" . $pesoUni . "','" . $cod1 . "','" . $cod2 . "','" . $cod3 . "');";
            $pais = '';
            break;
        }
    case 'BUNDLE':
        {
            require_once('../formulas.php');
            $masteSKU = $alto;
            $prodName = $ancho;
            $uBundle = $nombre;
            $bundle = $largo;
            $uniVenta = $pesoUni;
            $bundles = intval($uniVenta / $bundle);
            $cantBundle = $uniVenta - ($bundles * $bundle);
            $amSKU = "";
            $amazonQuery = "SELECT amazonsku FROM tra_bun_det ORDER BY amazonsku DESC LIMIT 1";
            if ($ejecutaAmazon = mysqli_query(conexion($_SESSION['pais']), $amazonQuery)) {
                if (mysqli_num_rows($ejecutaAmazon) > 0) {
                    if ($row = mysqli_fetch_array($ejecutaAmazon, MYSQLI_ASSOC)) {
                        $amSKU = $row['amazonsku'];
                        if (strlen($amSKU) == 6) {
                            $amSKU = $_SESSION['CodSKUPais'] . intval($amSKU);
                        }
                        $amSKU = intval($amSKU) + 1;
                    }
                } else {
                    $amSKU = $_SESSION['CodSKUPais'] . "500001";
                    $amSKU = intval($amSKU);
                }
            }
            $contadors = 0;
            $chanelQuery = "SELECT codchan FROM cat_sal_cha WHERE columna!='' AND channel = 'sales on line'";
            if ($ejecutaChanel = mysqli_query(conexion($_SESSION['pais']), $chanelQuery)) {
                if (mysqli_num_rows($ejecutaChanel) > 0) {
                    while ($rowChanel = mysqli_fetch_array($ejecutaChanel, MYSQLI_ASSOC)) {
                        $findBundleQuery = "select * from tra_bun_det where MASTERSKU = '$masteSKU' and CODCANAL = '" . $rowChanel['codchan'] . "' and CODEMPRESA = '$codempresa' and UNITBUNDLE = '$uBundle';";
                        echo $findBundleQuery;
                        if ($findBundle = mysqli_query(conexion($_SESSION['pais']), $findBundleQuery)) {
                            if (mysqli_num_rows($findBundle) == 0) {
                                crearBundle($codempresa, $masteSKU, $prodName, $rowChanel['codchan'], $uBundle, $amSKU, $uniVenta, $cantBundle);
                            }
                        }
                    }
                }
            }
            $squery = "SELECT * FROM tra_bun_det";
            break;
        }
    default:
        {
            $squery = "SELECT * FROM tra_bun_det";
            break;
        }
}
if ($nombre == '') {
    echo "Debe ingresar un Dato";
} else {
    if (mysqli_query(conexion($pais), $squery)) {
        if (isset($squery2)) {
            mysqli_query(conexion($pais), $squery2);
        }
        if ($idunico == "size") {
            echo "<span>Guardado correctamente <script>setTimeout(function(){if(window.opener.document.getElementById('" . $idunico . "')){window.opener.document.getElementById('" . $idunico . "').value='" . $codigoUnico . "';window.opener.document.getElementById('uniVenta').value='" . $ancho . "';}},1300);</script></span>";
        } else {
            echo "<span>Guardado correctamente <script>setTimeout(function(){if(window.opener.document.getElementById('" . $idunico . "')){window.opener.document.getElementById('" . $idunico . "').value='" . $codigoUnico . "';}},1300);</script></span>";
        }
        mysqli_close(conexion($pais));
    } else {
        echo "$squery";
    }
}

function getBrandId($brand){

    $tCODIGO = "";
    include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/channels/sellercloud/sellercloud.php");
    $sellercloud = new \channels\sellercloud();
    $response = $sellercloud->getBrandByName($brand);

    if($response["status"] == "success"){

        $result = $response["result"];
        $tCODIGO = $result->Brands_GetByNameResult->ID;
    }
    else{
        $response = $sellercloud->createBrand($brand);
        if($response["status"] == "success"){
            $result = $response["result"];
            $tCODIGO = $result->Brands_CreateNewResult;
        }
    }

    return $tCODIGO;
}
?>
