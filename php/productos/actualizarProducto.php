<?php

    require_once('../coneccion.php');

    require_once('../fecha.php');

    $idioma = idioma();

    include('../idiomas/' . $idioma . '.php');

    session_start();

    verTiempo2();

//echo '<script> console.log("called"); </script>';

//echo '<script> console.log("' . $_POST['tipo'] . '"); </script>';

## usuario y clave pasados por el formulario

    $masterSKU = limpiar_caracteres_sql($_POST['masterSKU']);

    $prodName = limpiar_caracteres_sql($_POST['prodName']);

    $tipo = limpiar_caracteres_sql($_POST['tipo']);

    $obserbs = limpiar_caracteres_sql($_POST['obserbs']);

    $keyWords = limpiar_caracteres_sql($_POST['keyWords']);

    $metaTitle = limpiar_caracteres_sql($_POST['metaTitle']);

    $prodDesc = str_replace("\n","",limpiar_caracteres_sql($_POST['prodDesc']));

    $codPres = limpiar_caracteres_sql($_POST['codPres']);

    $pesoTotLB = limpiar_caracteres_sql($_POST['pesoTotLB']);

    $libras = limpiar_caracteres_sql($_POST['libras']);

    $onzas = limpiar_caracteres_sql($_POST['onzas']);

    $alto = limpiar_caracteres_sql($_POST['alto']);

    $ancho = limpiar_caracteres_sql($_POST['ancho']);

    $largo = limpiar_caracteres_sql($_POST['largo']);

    $uniVenta = limpiar_caracteres_sql($_POST['uniVenta']);

    $ubundle = limpiar_caracteres_sql($_POST['ubundle']);

    $cosPri = limpiar_caracteres_sql($_POST['cospri']);

    $bunName = limpiar_caracteres_sql($_POST['bunName']);

    $amSKU = limpiar_caracteres_sql($_POST['bunAmSKU']);
    $itemcode = limpiar_caracteres_sql($_POST['itemcode']);

    $codEmpresa = limpiar_caracteres_sql($_SESSION['codEmpresa']);

    $mmax = '';
    $ejecuta="";
  // $descshort = limpiar_caracteres_sql($_POST["descshort"]);

    if (isset($_POST['mmax'])) {

        $mmax = ", mmax='" . $_POST['mmax'] . "'";

    }



    if ($prodName == null) {

        echo "<span>" . $lang[$idioma]['CompletarCampos'] . "</span>";

    } else {



        //echo '<script> console.log("' . $tipo . '"); </script>';

        switch ($tipo) {

            case 'metaData': {
                 $shortdesc = $_POST['shortdesc'];
                 $shortdesc1 = $_POST['shortdesc1'];
                 $shortdesc2 = $_POST['shortdesc2'];
                 $shortdesc3 = $_POST['shortdesc3'];
                 $shortdesc4 = $_POST['shortdesc4'];

                 $tItemCode = "";
                 if($itemcode != ""){
                     $tItemCode = ", ITEMCODE = '$itemcode'";
                 }

                $squery = "update cat_prod set descshort='$shortdesc', keywords='" . $keyWords . "',obser='" . $obserbs . "',metatitles='" . $metaTitle . "',descprod='" . $prodDesc . "',descshor2='" . $shortdesc2 . "',descshor3='" . $shortdesc3 . "',descshor4='" . $shortdesc4 . "',descshor1='" . $shortdesc1 . "' $tItemCode where masterSKU='" . $masterSKU . "' and codprod='" . $_SESSION['codprod'] . "' and prodName='" . $prodName . "' and codempresa='" . $_SESSION['codEmpresa'] . "'";
                //echo '<script> alert("' . $squery . '"); </script>';
                $ejecuta= "guardaro = 1;producto(9,'".$_SESSION['codEmpresa']."','".$_SESSION['pais']."','".$_SESSION['codprod']."');";
               //echo $squery;

                break;

            }

            case 'dimensiones': {

                $altoCA = $_POST['altoCA'];

                $anchoCA = $_POST['anchoCA'];

                $profCA = $_POST['profCA'];

                $pesoLBCA = $_POST['pesoLBCA'];

                $pesoOZCA = $_POST['pesoOZCA'];

                $altoPA = $_POST['altoPA'];

                $anchoPA = $_POST['anchoPA'];

                $profPA = $_POST['profPA'];

                $pesoLBPA = $_POST['pesoLBPA'];

                $pesoOZPA = $_POST['pesoOZPA'];



                if ($altoCA == '') {

                    $altoCA = '0';

                }

                if ($profCA == '') {

                    $profCA = '0';

                }

                if ($anchoCA == '') {

                    $anchoCA = '0';

                }

                if ($altoPA == '') {

                    $altoPA = '0';

                }

                if ($anchoPA == '') {

                    $anchoPA = '0';

                }

                if ($profPA == '') {

                    $profPA = '0';

                }



                $squery = "update cat_prod set codpres='" . $codPres . "',peso=" . $pesoTotLB . ",peso_lb=" . $libras . ",peso_oz=" . $onzas . ",alto=" . $alto . ",ancho=" . $ancho . ",profun=" . $largo . ",univenta=" . $uniVenta . ",alto_CA=" . $altoCA . ",ancho_CA=" . $anchoCA . ",profun_CA=" . $profCA . ",peso_LBCA=" . $pesoLBCA . ",peso_OZCA=" . $pesoOZCA . ",alto_PA=" . $altoPA . ",ancho_PA=" . $anchoPA . ",profun_PA=" . $profPA . ",peso_LBPA=" . $pesoLBPA . ",peso_ozPA=" . $pesoOZPA . " where masterSKU='" . $masterSKU . "' and codprod='" . $_SESSION['codprod'] . "' and prodName='" . $prodName . "' and codempresa='" . $_SESSION['codEmpresa'] . "'";

                echo '<script> console.log("' . $squery . '"); </script>';

                break;

            }

            case 'dimensionesC': {

                $altoCA = $_SESSION['altoCAC'];

                $anchoCA = $_SESSION['anchoCAC'];

                $profCA = $_SESSION['profCAC'];

                $pesoLBCA = $_SESSION['pesoLBCAC'];

                $pesoOZCA = $_SESSION['pesoOZCAC'];

                $altoPA = $_SESSION['altoPAC'];

                $anchoPA = $_SESSION['anchoPAC'];

                $profPA = $_SESSION['profPAC'];

                $pesoLBPA = $_SESSION['pesoLBPAC'];

                $pesoOZPA = '0';



                if ($altoCA == '') {

                    $altoCA = '0';

                }

                if ($profCA == '') {

                    $profCA = '0';

                }

                if ($anchoCA == '') {

                    $anchoCA = '0';

                }

                if ($altoPA == '') {

                    $altoPA = '0';

                }

                if ($anchoPA == '') {

                    $anchoPA = '0';

                }

                if ($profPA == '') {

                    $profPA = '0';

                }



                $squery = "update cat_prod set codpres='" . $codPres . "',peso=" . $pesoTotLB . ",peso_lb=" . $libras . ",peso_oz=" . $onzas . ",alto=" . $alto . ",ancho=" . $ancho . ",profun=" . $largo . ",univenta=" . $uniVenta . ",alto_CA=" . $altoCA . ",ancho_CA=" . $anchoCA . ",profun_CA=" . $profCA . ",peso_LBCA=" . $pesoLBCA . ",peso_OZCA=" . $pesoOZCA . ",alto_PA=" . $altoPA . ",ancho_PA=" . $anchoPA . ",profun_PA=" . $profPA . ",peso_LBPA=" . $pesoLBPA . ",peso_ozPA=" . $pesoOZPA . " where masterSKU='" . $masterSKU . "' and codprod='" . $_SESSION['codprod'] . "' and prodName='" . $prodName . "' and codempresa='" . $_SESSION['codEmpresa'] . "'";

//                echo '<script> console.log("' . $squery . '"); </script>';

                break;

            }

            case 'costos': {

                $squery = "update cat_prod set 

							pcosto='" . $cosPri . "',

							codpres='" . $codPres . "',

							univenta='" . $uniVenta . "',

							ubundle='" . $ubundle . "' 

							" . $mmax . " 

							where masterSKU='" . $masterSKU . "' 

							and codprod='" . $_SESSION['codprod'] . "' 

							and prodName='" . $prodName . "' 

							and codempresa='" . $_SESSION['codEmpresa'] . "'";

                //echo $squery;

                //echo '<script> console.log("' . $squery . '"); </script>';

                break;

            }

            case 'costo': {

                $squery = "update cat_prod set 

							pcosto='" . $cosPri . "' 

							where masterSKU='" . $masterSKU . "' 

							and codprod='" . $_SESSION['codprod'] . "' 

							and prodName='" . $prodName . "' 

							and codempresa='" . $_SESSION['codEmpresa'] . "'";

                break;

            }

            case 'estibar': {

                $squery = "update cat_prod set palcontenedor=" . $codPres . ",cajcontenedor=" . $pesoTotLB . ",estiva='" . $libras . "',nivpalet=" . $alto . ",cajanivel=" . $onzas . " where masterSKU='" . $masterSKU . "' and codprod='" . $_SESSION['codprod'] . "' and prodName='" . $prodName . "' and codempresa='" . $_SESSION['codEmpresa'] . "'";
                 $ejecuta="setTimeout(function(){ventana('cargaLoad',300,400); producto(3,'".$_SESSION['codEmpresa']."','".$_SESSION['pais']."','".$_SESSION['codprod']."');},1000);";

                //echo '<script> console.log("' . $squery . '"); </script>';

                break;

            }

            case 'Exporta': {

                $squery = "update cat_prod set comercanal='" . $keyWords . "',temp='" . $obserbs . "',formexport='" . $metaTitle . "',tipcontenedor='" . $prodDesc . "',transport='" . $codPres . "',prodprocess='" . $pesoTotLB . "',codaran='" . $libras . "',prodcapaci='" . $onzas . "' where masterSKU='" . $masterSKU . "' and codprod='" . $_SESSION['codprod'] . "' and prodName='" . $prodName . "' and codempresa='" . $_SESSION['codEmpresa'] . "'";

                //echo '<script> console.log("' . $squery . '"); </script>';

                break;

            }

            case "assignUPC": {

                $tSKU = $_POST["SKU"];

                $tAmazonSKU = "";

                $tUPC = "";

                $tCodUPC = "";

                $getUPCQuery = "SELECT CODUPC, UPC FROM cat_upc WHERE CANTIDAD = 0 AND MASTERSKU = '' AND AMAZONSKU = '' AND CODPAIS = '' ORDER BY UPC DESC LIMIT 1;";

                $getUPCResult = mysqli_query(conexion(""), $getUPCQuery);

                if($getUPCResult){

                    if($getUPCResult->num_rows > 0){

                        $getUPCRow = mysqli_fetch_array($getUPCResult);

                        $tCodUPC = $getUPCRow[0];

                        $tUPC = $getUPCRow[1];

                        $getAmazonSKUQuery = "SELECT AMAZONSKU FROM tra_bun_det WHERE MASTERSKU = '$tSKU' AND UNITBUNDLE = '1';";

                        $getAmazonSKUResult = mysqli_query(conexion($_SESSION["pais"]), $getAmazonSKUQuery);

                        if($getAmazonSKUResult){

                            if($getAmazonSKUResult->num_rows > 0){

                                $tAmazonSKU = mysqli_fetch_array($getAmazonSKUResult)[0];

                            }

                        }

                        $updateUPCQuery = "UPDATE cat_upc SET MASTERSKU = '$tSKU', AMAZONSKU = '$tAmazonSKU', CANTIDAD = '1', CODPAIS = '" . $_SESSION["codEmpresa"] . "' WHERE CODUPC = '$tCodUPC';";

                        $updateBundleQuery = "UPDATE tra_bun_det SET UPC = '$tUPC' WHERE MASTERSKU = '$tSKU' AND UNITBUNDLE = '1';";

                        $updateProductQuery = "UPDATE cat_prod SET UPC = '$tUPC' WHERE MASTERSKU = '$tSKU';";

                        echo $getUPCQuery . ' +++++ ' . $updateUPCQuery . ' +++++ ' . $updateBundleQuery . ' +++++ ' . $updateProductQuery;

                        mysqli_query(conexion(""), $updateUPCQuery);

                        mysqli_query(conexion($_SESSION["pais"]), $updateBundleQuery);

                        mysqli_query(conexion($_SESSION["pais"]), $updateProductQuery);

                    }

                }

                break;

            }

            case 'publish': {

                $tSKU = $_POST['sku'];

                $tStatus = $_POST['status'];



                $query = "UPDATE tra_bun_det SET PUBLICAR = '$tStatus' WHERE AMAZONSKU = '$tSKU'";

                $query1 = "UPDATE cat_prod AS prod INNER JOIN tra_bun_det AS bundle ON prod.MASTERSKU = bundle.MASTERSKU SET prod.ESTATUS = 'A' WHERE bundle.AMAZONSKU = '$tSKU';";

                mysqli_query(conexion($_SESSION['pais']), $query1);

                $result = mysqli_query(conexion($_SESSION['pais']), $query);

                $response = 0;

                if ($result) {

                    $response = 1;

                }

                echo $response . " - " . $query;

            }

        }



        if (mysqli_query(conexion($_SESSION['pais']), $squery)) {

            echo "<span>Guardado correctamente</span><<script>
                $ejecuta
                
            </script>";

            mysqli_close(conexion($_SESSION['pais']));

        }

    }

?>