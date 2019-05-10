<?php
require_once('../coneccion.php');
require_once('../fecha.php');
$idioma = idioma();
include('../idiomas/' . $idioma . '.php');
session_start();
verTiempo2();
## usuario y clave pasados por el formulario
$mastersKU = limpiar_caracteres_sql($_POST['masterSKU']);
$descSis = limpiar_caracteres_sql($_POST['descSis']);
$prodName = limpiar_caracteres_sql($_POST['prodName']);
$SName = limpiar_caracteres_sql($_POST['SName']);
$EName = limpiar_caracteres_sql($_POST['EName']);
$prodLin = limpiar_caracteres_sql($_POST['prodLin']);
$subCategory2 = limpiar_caracteres_sql($_POST['subCategory2']);
$subCategory1 = limpiar_caracteres_sql($_POST['subCategory1']);
$marca = limpiar_caracteres_sql($_POST['marca']);
$package = limpiar_caracteres_sql($_POST['pakage']);
$UPC = limpiar_caracteres_sql($_POST['UPC']);
$category = limpiar_caracteres_sql($_POST['category']);
$genero = limpiar_caracteres_sql($_POST['genero']);
$flavor = limpiar_caracteres_sql($_POST['flavor']);
$manufacturadores = limpiar_caracteres_sql($_POST['manufacturadores']);
$age = limpiar_caracteres_sql($_POST['age']);
$formula = limpiar_caracteres_sql($_POST['formula']);
$paisOrigen = limpiar_caracteres_sql($_POST['paisOrigen']);
$concerns = limpiar_caracteres_sql($_POST['concerns']);
$cocina = limpiar_caracteres_sql($_POST['cocina']);
$itemCode = limpiar_caracteres_sql($_POST['itemCode']);
$existe = limpiar_caracteres_sql($_POST['existe']);
$SID = limpiar_caracteres_sql($_POST['SID']);
$FCE = limpiar_caracteres_sql($_POST['FCE']);
$SizeCount = limpiar_caracteres_sql($_POST['SizeCount']);
$codprod = "";
$newCodprod = "";
if ($prodName == NULL) {
    echo "<span>" . $lang[$idioma]['CompletarCampos'] . "</span><script>document.getElementById('masterSKU').focus();</script>";
}
else {

    if ($existe == 'true') {
        $squery = "UPDATE cat_prod SET descsis='" . $descSis . "',prodName='" . $prodName . "',nombre='" . $SName . "',nombri='" . $EName . "',marca='" . $marca . "',codProLin='" . $prodLin . "',categori='" . $category . "',subcate1='" . $subCategory1 . "',subcate2='" . $subCategory2 . "',codPack='" . $package . "',upc='" . $UPC . "',gender='" . $genero . "',flavor='" . $flavor . "',codmanufac='" . $manufacturadores . "',agesegment='" . $age . "',codform='" . $formula . "',codconcern='" . $concerns . "',codcocina='" . $cocina . "',SisCount='" . $SizeCount . "',SID='" . $SID . "',FCE='" . $FCE . "',country='" . $paisOrigen . "' WHERE masterSKU='" . $mastersKU . "' AND codprod='" . $_SESSION['codprod'] . "' AND codempresa='" . $_SESSION['codEmpresa'] . "'";
//        echo $squery."<br>";
    }
    else {
        $masterSKU = "";

        $skuQuery = "SELECT mastersku FROM cat_prod WHERE SEVENDE=1 AND estatus='D' ORDER BY mastersku DESC LIMIT 1";
        if ($ejecutaSKU = mysqli_query(conexion($_SESSION['pais']), $skuQuery)) {
            if (mysqli_num_rows($ejecutaSKU) > 0) {
                if ($sku = mysqli_fetch_array($ejecutaSKU, MYSQLI_ASSOC)) {
                    $masterSKU = $sku['mastersku'];

                }
            }
            else {
                $amazonQuery = "SELECT mastersku FROM cat_prod WHERE SEVENDE=1 ORDER BY mastersku DESC LIMIT 1";
                if ($ejecutaAmazon = mysqli_query(conexion($_SESSION['pais']), $amazonQuery)) {
                    if (mysqli_num_rows($ejecutaAmazon) > 0) {
                        if ($row = mysqli_fetch_array($ejecutaAmazon, MYSQLI_ASSOC)) {
                            $masterSKU = $row['mastersku'];
                            if (substr($row['mastersku'], 0, 3) == '300') {
                                $masterSKU = $_SESSION['CodSKUPais'] . (intval($masterSKU) + 1);
                            }
                            else {
                                $masterSKU = (intval($masterSKU) + 1);
                            }
                        }
                    }
                    else {
                        $masterSKU = $_SESSION['CodSKUPais'] . "300001";
                        $masterSKU = intval($masterSKU);
                    }
                }
            }
            $metatitles = str_replace("{keyword}", $EName, metatitles());
            $metatitles = str_replace("{keyword (whithout the size)}", $SName, $metatitles);
            $codprod = sys2015();
            $newCodprod = $codprod;
            $_SESSION['codprod'] = $masterSKU;
            $squery = "INSERT INTO cat_prod(codprod,masterSKU,itemcode,codempresa,descsis,prodName,nombre,nombri,marca,codProLin 	,categori,subcate1,subcate2,codPack,upc,gender,flavor,ubundle,codmanufac,agesegment,codform,codconcern,codcocina,country,codprov,metatitles,SisCount,SID,FCE,estiva,SEVENDE) VALUES('" . $codprod . "','" . $masterSKU . "','" . $itemCode . "','" . $_SESSION['codEmpresa'] . "','" . $descSis . "','" . $prodName . "','" . $SName . "','" . $EName . "','" . $marca . "','" . $prodLin . "','" . $category . "','" . $subCategory1 . "','" . $subCategory2 . "','" . $package . "','" . $UPC . "','" . $genero . "','" . $flavor . "',6,'" . $manufacturadores . "','" . $age . "','" . $formula . "','" . $concerns . "','" . $cocina . "','" . $paisOrigen . "','" . $_SESSION['codprov'] . "','" . $metatitles . "','" . $SizeCount . "','" . $SID . "','" . $FCE . "','000',1)";
        }
    }
//    echo $squery;
    if (mysqli_query(conexion($_SESSION['pais']), $squery)) {
        $_SESSION['guardadoprod'] = 1;
        if ($codprod == "") {
            $codprod = $_SESSION['codprod'];
        }

        $origCodprod = '';
//metadata
        $mdQ = "SELECT masterSKU,codempresa,descsis,prodName,nombre,nombri,marca,codProLin,keywords,categori,metatitles,descprod,obser,subcate1,subcate2,codPack,upc,itemcode,codprod FROM cat_prod WHERE codempresa='" . $_SESSION['codEmpresa'] . "' AND mastersku='" . $_SESSION['origSKU'] . "'";
        if ($mdE = mysqli_query(conexion($_SESSION['pais']), $mdQ)) {
            if ($mdR = mysqli_fetch_array($mdE, MYSQLI_ASSOC)) {
                $origCodprod = $mdR['codprod'];
                $_SESSION['codprod'] = $newCodprod;
                ?>
                <script>
                    actualizaProducto(
                        'metaData',
                        '<?php echo $masterSKU; ?>',
                        '<?php echo $mdR['prodName']; ?>',
                        '<?php echo $mdR['itemcode']; ?>',
                        '<?php echo $mdR['keywords']; ?>',
                        '',
                        '<?php echo $mdR['metatitles']; ?>',
                        '<?php echo $mdR['descprod']; ?>',
                        '', '', '', '', '', '', '', '', '', '', '', '');
                </script>
                <?php
            }
        }

        //es
        $esQ = "SELECT codprod,masterSKU,codempresa,descsis,prodName,nombre,nombri,itemcode,palcontenedor,cajcontenedor,estiva,nivpalet,cajanivel,(cajanivel*nivpalet) AS totalCajaPallets FROM cat_prod WHERE codempresa='" . $_SESSION['codEmpresa'] . "' AND codprod='" . $origCodprod . "'";
        //echo '<script> console.log("' . $esQ . '"); /script>';
        if ($esE = mysqli_query(conexion($_SESSION['pais']), $esQ)) {
            if ($esR = mysqli_fetch_array($esE, MYSQLI_ASSOC)) {
                ?>
                <script>
                    actualizaProducto(
                        'estibarC', //1
                        '<?php echo $masterSKU; ?>',
                        '<?php echo $esR['prodName']; ?>',
                        '<?php echo $esR['itemcode']; ?>',
                        '', '', '', '', //8
                        '<?php echo $esR['palcontenedor']; ?>',
                        '<?php echo $esR['cajcontenedor']; ?>',
                        '<?php echo $esR['estiva']; ?>',
                        '<?php echo $esR['cajanivel']; ?>',
                        '<?php echo $esR['nivpalet']; ?>',
                        '<?php echo $esR['totalCajaPallets']; ?>',
                        '', '', '', '', '', '');
                </script>
                <?php
            }
        }

        //peso
        $pdQ = "SELECT masterSKU,codempresa,descsis,prodName,nombre,nombri,marca,codProLin,keywords,categori,metatitles,descprod,obser,subcate1,subcate2,codPack,upc,codpres,peso,peso_lb,peso_oz,alto,ancho,profun,univenta,itemcode,codprod,palcontenedor,cajcontenedor,nivpalet,cajanivel,(nivpalet*cajanivel) AS totalPalets,(cajanivel*nivpalet) AS totalCajaPallets,imaurlbase,peso_lbCA,peso_ozCA,alto_CA,ancho_CA,profun_CA,peso_lbPA,peso_ozPA,alto_PA,ancho_PA,profun_PA FROM cat_prod WHERE codempresa='" . $_SESSION['codEmpresa'] . "' AND codprod='" . $origCodprod . "'";
        //echo '<script> console.log("' . $pdQ . '"); /script>';
        if ($pdE = mysqli_query(conexion($_SESSION['pais']), $pdQ)) {
            if ($pdR = mysqli_fetch_array($pdE, MYSQLI_ASSOC)) {
                //$tdemas = '&altoCA=' . $pdR['alto_CA'] . '&anchoCA=' . $pdR['ancho_CA'] . '&profCA=' . $pdR['profun_CA'] . '&pesoLBCA=' . $pdR['peso_lbCA'] . '&pesoOZCA=' . $pdR['peso_ozCA'] . '&altoPA=' . $pdR['alto_PA'] . '&anchoPA=' . $pdR['ancho_PA'] . '&profPA=' . $pdR['profun_PA'] . '&pesoLBPA=' . $pdR['peso_lbPA'] .  '&pesoOZPA=0';

                $_SESSION['altoCAC'] = $pdR['alto_CA'];
                $_SESSION['anchoCAC'] = $pdR['ancho_CA'];
                $_SESSION['profCAC'] = $pdR['profun_CA'];
                $_SESSION['pesoLBCAC'] = $pdR['peso_lbCA'];
                $_SESSION['pesoOZCAC'] = $pdR['peso_ozCA'];
                $_SESSION['altoPAC'] = $pdR['alto_PA'];
                $_SESSION['anchoPAC'] = $pdR['ancho_PA'];
                $_SESSION['profPAC'] = $pdR['profun_PA'];
                $_SESSION['pesoLBPAC'] = $pdR['peso_lbPA'];

                ?>
                <script>
                    actualizaProducto(
                        'dimensionesC',
                        '<?php echo $masterSKU; ?>',
                        '<?php echo $pdR['prodName']; ?>',
                        '<?php echo $pdR['itemcode']; ?>',
                        '', '', '', '',
                        '<?php echo $pdR['codpres']; ?>',
                        '<?php echo $pdR['peso']; ?>',
                        '<?php echo $pdR['peso_lb']; ?>',
                        '<?php echo $pdR['peso_oz']; ?>',
                        '<?php echo $pdR['alto']; ?>',
                        '<?php echo $pdR['ancho']; ?>',
                        '<?php echo $pdR['profun']; ?>',
                        '<?php echo $pdR['univenta']; ?>',
                        '', '', '', '');
                </script>
                <?php
            }
        }

        //exportacion
        $exQ = "SELECT masterSKU,codempresa,descsis,prodName,nombre,itemcode,codprod,codaran,prodprocess,transport,formexport,tipcontenedor,temp,comercanal,prodcapaci FROM cat_prod WHERE codempresa='" . $_SESSION['codEmpresa'] . "' AND mastersku='" . $_SESSION['origSKU'] . "'";
        //echo '<script> console.log("' . $exQ . '"); /script>';
        if ($exE = mysqli_query(conexion($_SESSION['pais']), $exQ)) {
            if ($exR = mysqli_fetch_array($exE, MYSQLI_ASSOC)) {
                ?>
                <script>
                    actualizaProducto(
                        'Exporta',
                        '<?php echo $masterSKU; ?>',
                        '<?php echo $exR['prodName']; ?>',
                        '<?php echo $exR['itemcode']; ?>',
                        '<?php echo $exR['comercanal']; ?>',
                        '<?php echo $exR['temp']; ?>',
                        '<?php echo $exR['formexport']; ?>',
                        '<?php echo $exR['tipcontenedor']; ?>',
                        '<?php echo $exR['trasnport']; ?>',
                        '<?php echo $exR['prodprocess']; ?>',
                        '<?php echo $exR['codaran']; ?>',
                        '<?php echo $exR['prodcapaci']; ?>',
                        '', '', '', '', '', '', '', '');
                </script>
                <?php
            }
        }

        $_SESSION['refreshProducts'] = 1;

        ?>
        <script>
            window.opener.location.reload();
        </script>
        <?php

        echo "<span>Guardado Correctamente</span><script>setTimeout(function(){guardarEspecificosProductos('" . $codprod . "');},0);</script>";

        //echo '<script> console.log("' . $_SESSION['isCopy'] . '"); /script>';

        if ($_SESSION['isCopy'] == "0") {
            echo "<script>window.location=\"paginaNuevoProducto.php?empresa=" . $_SESSION['codEmpresa'] . "&ctr=" . $_SESSION['pais'] . "&mt=" . $mastersKU . "\";</script>";
        }
        else {
            $_SESSION['isCopy'] = '0';
            echo "
                <script>
                setTimeout(function() {
                    window.location=\"paginaNuevoProducto.php?empresa=" . $_SESSION['codEmpresa'] . "&ctr=" . $_SESSION['pais'] . "&mt=" . $masterSKU . "\";  
                }, 1500);
                </script>";
        }
    }
    else {
        echo "<script>alert(\"$squery\");</script>";
    }
}

function metatitles() {

    $squery = "SELECT codmeta,metatitle FROM cat_metatitles WHERE estado=1 ORDER BY estado LIMIT 1";
    $retornar = "";
    if ($ejecutar = mysqli_query(conexion($_SESSION['pais']), $squery)) {
        if ($ejecutar->num_rows > 0) {
            if ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {

                $squery2 = "UPDATE cat_metatitles SET estado=0 WHERE codmeta=" . $row['codmeta'];
                if ($ejecutar2 = mysqli_query(conexion($_SESSION['pais']), $squery2)) {
                    $retornar = $row['metatitle'];
                }
            }
        }
        else {
            $squery2 = "UPDATE cat_metatitles SET estado=1";
            if ($ejecutar2 = mysqli_query(conexion($_SESSION['pais']), $squery2)) {
                $retornar = metatitles();
            }
        }
    }
    return $retornar;
}

?>