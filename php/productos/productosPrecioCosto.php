<?php
require_once('../coneccion.php');
require_once('../fecha.php');
require_once('combosProductos.php');
$idioma = idioma();
include('../idiomas/' . $idioma . '.php');
$codigoEmpresa = $_POST['codEmpresa'];
$codigoProveedor = $_POST['codprov'];
$pais = $_POST['pais'];
$itemCode = limpiar_caracteres_sql($_POST['icode']);
session_start();
verTiempo2();
verTiempo2();
$_SESSION['codprov'] = $codigoProveedor;
$squery = "select masterSKU,codprod,codempresa,descsis,prodName,nombre,nombri,marca,codProLin,keywords,categori,metatitles,descprod,obser,subcate1,subcate2,codPack,upc,codpres,peso,peso_lb,peso_oz,alto,ancho,profun,univenta,ubundle,pcosto,itemcode,codprod, mmin, mmax, mpro, incre1, incre2, incre3, incre4 from cat_prod where codempresa='" . $codigoEmpresa . "' and codprod='" . $_SESSION['codprod'] . "'";
$dlog = 'init';
if ($ejecutar = mysqli_query(conexion($_SESSION['pais']), $squery)) {
    if ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
        if ($row['masterSKU'] != '') {
            /*$msku = $row['masterSKU'];
            if($row['mmin'] == 0
                || $row['mmax'] == 0
                || $row['mpro'] == 0
                || $row['incre1'] == 0
                || $row['incre2'] == 0
                || $row['incre3'] == 0
                || $row['incre4'] == 0){
                $qryProvData = "SELECT marmin, marmax, marpro, incre1, incre2, incre3, incre4 FROM cat_prov WHERE codprov = '".$_SESSION['codprov']."';";
                $resProvData = mysqli_query(conexion($_SESSION['pais']), $qryProvData);
                if($resProvData){
                    if($resProvData->num_rows > 0){
                        $rowProvData = mysqli_fetch_array($resProvData);
                        $marmin = $rowProvData[0];
                        $marmax = $rowProvData[1];
                        $marpro = $rowProvData[2];
                        $incre1 = $rowProvData[3];
                        $incre2 = $rowProvData[4];
                        $incre3 = $rowProvData[5];
                        $incre4 = $rowProvData[6];

                        $values = '';

                        if($row['mmin'] == 0){
                            $values = $values + " mmin='$marmin',";
                        }
                        if($row['mmax'] == 0){
                            $values = $values + " mmax='$marmax',";
                        }
                        if($row['mpro'] == 0){
                            $values = $values + " mpro='$marpro',";
                        }
                        if($row['incre1'] == 0){
                            $values = $values + " incre1='$incre1',";
                        }
                        if($row['incre2'] == 0){
                            $values = $values + " incre2='$incre2',";
                        }
                        if($row['incre3'] == 0){
                            $values = $values + " incre3='$incre3',";
                        }
                        if($row['incre4'] == 0){
                            $values = $values + " incre4='$incre4',";
                        }
                        $dlog = $dlog . ' v' .$values . '-';
                        if($values != ''){
                            rtrim($string, ",");
                            $qryUpdateProd = "UPDATE cat_prod set $values WHERE mastersku = '$msku';";
                        }
                    }
                }
                else{
                    $dlog = $dlog . ' error';
                }
            }
            */

            $squery2 = "select masterSKU,codempresa,prodName,amazondesc,unitcase,codbundle,amazonSKU from tra_bun_det where codempresa='" . $codigoEmpresa . "' and mastersku='" . $row['masterSKU'] . "' order by codbundle ";
            //echo $squery2;
            if ($ejecutar2 = mysqli_query(conexion($_SESSION['pais']), $squery2)) {

                if (mysqli_num_rows($ejecutar2) > 0) {

                    if (isset($_SESSION['refreshBundles'])) {

                        if ($_SESSION['refreshBundles'] == 1) {

                            $_SESSION['refreshBundles'] = 0;
                            ?>
                            <script>
                                llamarBundleN('<?php echo $row['masterSKU'];?>', '<?php echo $itemCode;?>', '<?php echo $row['prodName'];?>', document.getElementById('uniVenta').value, document.getElementById('ubundle').value, document.getElementById('paquetes').value, document.getElementById('canal').value, '<?php echo $_SESSION['codprov'];?>');
                                document.getElementById('canal').hidden = false;
                                document.getElementById('nuevoBundle').style.display = 'inline-block';
                                document.getElementById('nuevoBundles').style.display = 'none';
                                document.getElementById('uniVenta').disabled = true;
                            </script>
                            <?php
                        } else {
                            ?>
                            <script>
                                llamarBundle('<?php echo $row['masterSKU'];?>', '<?php echo $itemCode;?>', '<?php echo $row['prodName'];?>', document.getElementById('uniVenta').value, document.getElementById('ubundle').value, document.getElementById('paquetes').value, document.getElementById('canal').value);
                                document.getElementById('canal').hidden = false;
                                document.getElementById('nuevoBundle').style.display = 'inline-block';
                                document.getElementById('nuevoBundles').style.display = 'none';
                                document.getElementById('uniVenta').disabled = true;
                            </script>
                            <?php
                        }
                    } else {
                        ?>
                        <script>
                            llamarBundle('<?php echo $row['masterSKU'];?>', '<?php echo $itemCode;?>', '<?php echo $row['prodName'];?>', document.getElementById('uniVenta').value, document.getElementById('ubundle').value, document.getElementById('paquetes').value, document.getElementById('canal').value);
                            document.getElementById('canal').hidden = false;
                            document.getElementById('nuevoBundle').style.display = 'inline-block';
                            document.getElementById('nuevoBundles').style.display = 'none';
                            document.getElementById('uniVenta').disabled = true;
                        </script>
                        <?php
                    }
                } else {
                    ?>
                    <script>

                        document.getElementById('nuevoBundle').style.display = 'none';
                        document.getElementById('nuevoBundles').style.display = 'inline-block';

                    </script>
                    <?php
                }

            }

            $_SESSION['codprod'] = $row['codprod']; ?>
            <script>
                function verificaCosto() {
                    if (document.getElementById('precioBundle').value != "0.00000" && document.getElementById('precioBundle').value != "") {
                        document.getElementById('nuevoBundles').disabled = false;
                    }
                    else {
                        document.getElementById('nuevoBundles').disabled = true;
                    }
                }

                verificaCosto();
                setTimeout(function () {
                    $("#cargaLoad").dialog("close");
                }, 500);
            </script>

            <div id="productos">

                <!--<h3><?php echo $dlog; ?></h3>-->

                <script>seleccion(document.getElementById('TabprecioCosto'));</script>
                <form id="ProductosGeneral" action="return false" onSubmit="return false" method="POST">
                    <center>
                        <br>
                        <table>
                            <tr>
                                <div id="resultado"></div>
                                <progress max="100" value="0" id="barraProgreso" hidden><input type="text"
                                                                                               class='entradaTexto'
                                                                                               hidden="" id="paquetes"
                                                                                               readonly
                                                                                               value="<?php echo intval($row['univenta'] / $row['ubundle']); ?>"/>
                            </tr>
                            <tr>
                                <div id="advertencia" style="color:red;"
                                     hidden><?php echo $lang[$idioma]['Adevertencia_Rojo']; ?></div>
                            </tr>
                            <tr>
                                <td class="text"><span><?php echo $lang[$idioma]['MasterSKU']; ?></span></td>
                                <td><input type="text" name="masterSKU" class='entradaTexto' disabled id="masterSKU"
                                           value="<?php echo $row['masterSKU']; ?>"></td>

                                <td class="text"><span><?php echo $lang[$idioma]['ItemCode']; ?></span></td>
                                <td><input type="text" name="itemCode" class='entradaTexto' disabled id="itemCode"
                                           autofocus value="<?php echo $row['itemcode']; ?>"></td>
                            </tr>
                            <tr>
                                <td class="text"><span><?php echo $lang[$idioma]['ProdName']; ?></span></td>
                                <td colspan="2"><input type="text" class='entradaTexto' name="prodName" disabled
                                                       id="prodName" value="<?php echo $row['prodName']; ?>"></td>

                            </tr>
                            <tr>
                                <td class="text"><span><?php echo $lang[$idioma]['Size1']; ?><span class="validaraster">*</span></span>
                                </td>

                                <td><select class='entradaTexto' id="size"
                                            onChange="verificaImportantes('Precio','nuevoBundles');"
                                            disabled><?php echo comboSize($codigoEmpresa, $pais, $row['codpres'], $_SESSION['codprov']); ?></select>
                                </td>

                                <td class="text"><span><?php echo $lang[$idioma]['UnidadesCaja']; ?><span
                                                class="validaraster">*</span></span></td>
                                <td style="text-align:left;"><input class='entradaTexto' type="number" min="0"
                                                                    max="1000" id="uniVenta"
                                                                    onChange="document.getElementById('guardar2').disabled = false;verificaImportantes('Precio','nuevoBundles'); calcularUnidades(document.getElementById('uniVenta').value,document.getElementById('ubundle').value,'<?php echo $row['masterSKU']; ?>','<?php echo $itemCode; ?>','<?php echo $row['prodName']; ?>');"
                                                                    value="<?php echo $row['univenta']; ?>"/></td>

                            </tr>
                            <tr>
                                <td class="text"><span><?php echo $lang[$idioma]['UnidadesBundle']; ?><span
                                                class="validaraster">*</span></span></td>
                                <td style="text-align:left;"><input class='entradaTexto' type="number" min="0"
                                                                    max="1000" id="ubundle"
                                                                    onChange="document.getElementById('guardar2').disabled = false;verificaImportantes('Precio','nuevoBundles'); calcularUnidades(document.getElementById('uniVenta').value,document.getElementById('ubundle').value,'<?php echo $row['masterSKU']; ?>','<?php echo $itemCode; ?>','<?php echo $row['prodName']; ?>');"
                                                                    value="<?php echo $row['ubundle']; ?>"/></td>

                                <td class="text"><span><?php echo $lang[$idioma]['cospri']; ?><span
                                                class="validaraster">*</span></span></td>

                                <td style="text-align:left;">
                                    <input style="width: 175px !important; float: left;" class='entradaTexto'
                                                                    onChange="document.getElementById('guardar2').disabled = false;document.getElementById('nuevoBundles').disabled = false; verificaImportantes('Precio','nuevoBundles');"
                                                                    onKeyUP="document.getElementById('nuevoBundles').disabled = false;document.getElementById('guardar2').disabled = false;"
                                                                    type="number" min="0" max="10000" id="precioBundle"
                                                                    placeholder="<?php echo $lang[$idioma]['cospri']; ?>"
                                                                    value="<?php echo $row['pcosto']; ?>"/>
                                    <div <?php echo showDetail() ?> style="float: left;" class="bodegaDeclara">
                                        <a>
                                            <img src="../../css/lupa.png">
                                            <div class="globoFlotanteExistencia">
                                                <div class="parrafoFlotanteExistencia"><?php echo getLastSales($row['codprod']) ?></div>
                                            </div>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text"><span><?php echo $lang[$idioma]['Canales']; ?></span></td>
                                <td colspan="1">

                                    <select disabled
                                            class='entradaTexto'
                                            id="canal" hidden=""
                                            onChange="llamarBundle(
                                                    '<?php echo $row['masterSKU']; ?>',
                                                    '<?php echo $row['itemcode']; ?>',
                                                    '<?php echo $row['prodName']; ?>',
                                                    document.getElementById('uniVenta').value,
                                                    document.getElementById('ubundle').value,
                                                    document.getElementById('paquetes').value,
                                                    document.getElementById('canal').value,
                                                    '<?php echo $codigoProveedor; ?>');">
                                        <?php echo comboCanal($codigoEmpresa, $pais, ''); ?></select>
                                </td>
                                <td hidden class="text"><span><?php echo $lang[$idioma]['basmar']; ?></span></td>
                                <?php

                                $mmaxQry = "SELECT MMAX FROM cat_prod WHERE MASTERSKU = '" . $row['masterSKU'] . "';";
                                //echo $mmaxQry . '<br>';
                                $mmaxRes = mysqli_query(conexion($_SESSION['pais']), $mmaxQry);
                                $mmax = '0';
                                if ($mmaxRes) {
                                    if ($mmaxRes->num_rows > 0) {
                                        $row1 = mysqli_fetch_array($mmaxRes);
                                        $mmax = $row1[0];
                                    }
                                }
                                //echo $mmax . '<br>';

                                if ($mmax == '0.00000') {
                                    $tCodEmpresaQry = "SELECT CODEMPRESA FROM cat_prov WHERE CODPROV = '" . $_SESSION['codprov'] . "';";
                                    //echo $tCodEmpresaQry . '<br>';
                                    $tCodEmpresaRes = mysqli_query(conexion($_SESSION['pais']), $tCodEmpresaQry);
                                    $tCodEmpresa = '0';
                                    if ($tCodEmpresaRes) {
                                        if ($tCodEmpresaRes->num_rows > 0) {
                                            $row2 = mysqli_fetch_array($tCodEmpresaRes);
                                            $tCodEmpresa = $row2[0];
                                        }
                                    }

                                    //echo $tCodEmpresa . '<br>';

                                    $mmaxQry = "SELECT MMAX FROM cat_empresas WHERE CODEMPRESA = '$tCodEmpresa';";
                                    //echo $mmaxQry . '<br>';
                                    $mmaxRes = mysqli_query(conexion(''), $mmaxQry);
                                    $tmmax = '0';
                                    if ($mmaxRes) {
                                        if ($mmaxRes->num_rows > 0) {
                                            $row3 = mysqli_fetch_array($mmaxRes);
                                            $tmmax = $row3[0];
                                        }
                                    }

                                    //echo $tmmax;

                                    $updateMMAXQry = "UPDATE cat_prod SET MMAX = '$tmmax' WHERE MASTERSKU = '" . $row['masterSKU'] . "';";
                                    //echo $updateMMAXQry . '<br>';
                                    mysqli_query(conexion($_SESSION['pais']), $updateMMAXQry);
                                }

                                $mmaxQry = "SELECT MMAX FROM cat_prod WHERE MASTERSKU = '" . $row['masterSKU'] . "';";
                                $mmaxRes = mysqli_query(conexion($_SESSION['pais']), $mmaxQry);
                                $mmax = '';
                                if ($mmaxRes) {
                                    if ($mmaxRes->num_rows > 0) {
                                        $row4 = mysqli_fetch_array($mmaxRes);
                                        $mmax = $row4[0];
                                    }
                                }
                                ?>
                                <td style="text-align:right;"><input hidden class='entradaTexto'
                                                                    onChange="document.getElementById('guardar2').disabled = false;document.getElementById('nuevoBundles').disabled = false; verificaImportantes('Precio','nuevoBundles');"
                                                                    onKeyUP="document.getElementById('nuevoBundles').disabled = false;document.getElementById('guardar2').disabled = false;"
                                                                    type="number" min="0" max="10000" id="mmax"
                                                                    placeholder="<?php echo $lang[$idioma]['cospri']; ?>"
                                                                    value="<?php echo $mmax; ?>"/>
                                    Last Shippments
                                </td>
                                <td height="60px;">
                                    <div style="width: 300px; position: absolute;" id="lastShippmentInfo">
                                    </div>
                                </td>
                            </tr>
                            <!--m values-->
                            <!--
                            <tr>
                                <td class="text"><span><?php echo $lang[$idioma]['mmin']; ?></span></td>
                                <td style="text-align:left;"><input class='entradaTexto'
                                                                    onChange="document.getElementById('guardar2').disabled = false;document.getElementById('nuevoBundles').disabled = false; verificaImportantes('Precio','nuevoBundles');"
                                                                    onKeyUP="document.getElementById('nuevoBundles').disabled = false;document.getElementById('guardar2').disabled = false;"
                                                                    type="number" min="0" max="10000" id="precioBundle"
                                                                    placeholder="<?php echo $lang[$idioma]['cospri']; ?>"
                                                                    value="<?php echo $row['mmin']; ?>"/></td>

                                <td class="text"><span><?php echo $lang[$idioma]['mmax']; ?></span></td>
                                <td style="text-align:left;"><input class='entradaTexto'
                                                                    onChange="document.getElementById('guardar2').disabled = false;document.getElementById('nuevoBundles').disabled = false; verificaImportantes('Precio','nuevoBundles');"
                                                                    onKeyUP="document.getElementById('nuevoBundles').disabled = false;document.getElementById('guardar2').disabled = false;"
                                                                    type="number" min="0" max="10000" id="precioBundle"
                                                                    placeholder="<?php echo $lang[$idioma]['cospri']; ?>"
                                                                    value="<?php echo $row['mmax']; ?>"/></td>
                            </tr>
                            <tr>
                                <td class="text"><span><?php echo $lang[$idioma]['mpro']; ?></span></td>
                                <td style="text-align:left;"><input class='entradaTexto'
                                                                    onChange="document.getElementById('guardar2').disabled = false;document.getElementById('nuevoBundles').disabled = false; verificaImportantes('Precio','nuevoBundles');"
                                                                    onKeyUP="document.getElementById('nuevoBundles').disabled = false;document.getElementById('guardar2').disabled = false;"
                                                                    type="number" min="0" max="10000" id="precioBundle"
                                                                    placeholder="<?php echo $lang[$idioma]['cospri']; ?>"
                                                                    value="<?php echo $row['mpro']; ?>"/></td>
                                <td></td>
                                <td></td>
                            </tr>
                            -->
                            <!--incre values-->
                            <!--
                            <tr>
                                <td class="text"><span><?php echo $lang[$idioma]['incre1']; ?></span></td>
                                <td style="text-align:left;"><input class='entradaTexto'
                                                                    onChange="document.getElementById('guardar2').disabled = false;document.getElementById('nuevoBundles').disabled = false; verificaImportantes('Precio','nuevoBundles');"
                                                                    onKeyUP="document.getElementById('nuevoBundles').disabled = false;document.getElementById('guardar2').disabled = false;"
                                                                    type="number" min="0" max="10000" id="precioBundle"
                                                                    placeholder="<?php echo $lang[$idioma]['cospri']; ?>"
                                                                    value="<?php echo $row['incre1']; ?>"/></td>

                                <td class="text"><span><?php echo $lang[$idioma]['incre2']; ?></span></td>
                                <td style="text-align:left;"><input class='entradaTexto'
                                                                    onChange="document.getElementById('guardar2').disabled = false;document.getElementById('nuevoBundles').disabled = false; verificaImportantes('Precio','nuevoBundles');"
                                                                    onKeyUP="document.getElementById('nuevoBundles').disabled = false;document.getElementById('guardar2').disabled = false;"
                                                                    type="number" min="0" max="10000" id="precioBundle"
                                                                    placeholder="<?php echo $lang[$idioma]['cospri']; ?>"
                                                                    value="<?php echo $row['incre2']; ?>"/></td>
                            </tr>
                            <tr>
                                <td class="text"><span><?php echo $lang[$idioma]['incre3']; ?></span></td>
                                <td style="text-align:left;"><input class='entradaTexto'
                                                                    onChange="document.getElementById('guardar2').disabled = false;document.getElementById('nuevoBundles').disabled = false; verificaImportantes('Precio','nuevoBundles');"
                                                                    onKeyUP="document.getElementById('nuevoBundles').disabled = false;document.getElementById('guardar2').disabled = false;"
                                                                    type="number" min="0" max="10000" id="precioBundle"
                                                                    placeholder="<?php echo $lang[$idioma]['cospri']; ?>"
                                                                    value="<?php echo $row['incre3']; ?>"/></td>

                                <td class="text"><span><?php echo $lang[$idioma]['incre4']; ?></span></td>
                                <td style="text-align:left;"><input class='entradaTexto'
                                                                    onChange="document.getElementById('guardar2').disabled = false;document.getElementById('nuevoBundles').disabled = false; verificaImportantes('Precio','nuevoBundles');"
                                                                    onKeyUP="document.getElementById('nuevoBundles').disabled = false;document.getElementById('guardar2').disabled = false;"
                                                                    type="number" min="0" max="10000" id="precioBundle"
                                                                    placeholder="<?php echo $lang[$idioma]['cospri']; ?>"
                                                                    value="<?php echo $row['incre4']; ?>"/></td>
                            </tr>
                            -->
                            <!--
                            <tr>
                                <td class="text">Cargos de Canal</td>
                                <td><input disabled type="text" id="tCargosCanal" class="entradaTexto"></td>
                                <td class="text">Utilidad</td>
                                <td><input disabled type="text" id="tUtilidad" class="entradaTexto"></td>
                            </tr>
                            -->
                            <tr>
                                <div>

                                </div>
                            </tr>
                            <tr>
                                <td colspan="4" class="" style="position:relative;">
                                    <input type="button"
                                           class='cmd button button-highlight button-pill'
                                           onClick="
                                                   llamarBundleN(
                                                   '<?php echo $row['masterSKU']; ?>',
                                                   '<?php echo $row['codprod']; ?>',
                                                   '<?php echo $row['prodName']; ?>',
                                                   document.getElementById('uniVenta').value,
                                                   document.getElementById('ubundle').value,
                                                   document.getElementById('paquetes').value,
                                                   document.getElementById('canal').value,
                                                   '<?php echo $codigoProveedor; ?>'
                                                   );
                                                   "
                                           disabled value="<?php echo $lang[$idioma]['CrearBundles']; ?>"
                                           id="nuevoBundles">
                                    <input type="button" class='cmd button button-highlight button-pill'
                                           onClick="asignarBundle('bundle','<?php echo $codigoEmpresa; ?>','<?php echo $pais; ?>','<?php echo $row['masterSKU']; ?>','<?php echo $row['prodName']; ?>',document.getElementById('ubundle').value,document.getElementById('uniVenta').value);"
                                           value="<?php echo $lang[$idioma]['CrearBundle']; ?>" id="nuevoBundle">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">

                                    <input class='cmd button button-highlight button-pill' type="button" id="guardar2"
                                           onClick="
                                                   savePublish();
                                                   actualizaProducto(
                                                   'costos',
                                                   document.getElementById('masterSKU').value,
                                                   document.getElementById('prodName').value,
                                                   document.getElementById('itemCode').value,'','','','',
                                                   document.getElementById('size').value,'','','','','','',
                                                   document.getElementById('uniVenta').value,
                                                   document.getElementById('ubundle').value,
                                                   document.getElementById('precioBundle').value,'','',
                                                   document.getElementById('mmax').value);
                                                   producto(4,'<?php echo $_SESSION['codEmpresa']; ?>','<?php echo $_SESSION['pais']; ?>','<?php echo $_SESSION['codprod']; ?>');"
                                           disabled value="<?php echo $lang[$idioma]['Guardar']; ?>"/>

                                    <input type="button" class='cmd button button-highlight button-pill'
                                           onClick="resetAllBundles()"
                                           value="<?php echo $lang[$idioma]['Reset']; ?>" id="nuevoBundle">
                                    <input type="button" class='cmd button button-highlight button-pill'
                                           onClick="markAllPublishBundles()"
                                           value="<?php echo $lang[$idioma]['publicar']; ?>" id="nuevoBundle">

                                    <input type="button" class='cmd button button-highlight button-pill' disabled
                                           id="actualiza"
                                           onClick="actualizarPreciosBundles('<?php echo $row['masterSKU']; ?>','<?php echo $_SESSION['codEmpresa']; ?>');"
                                           value="<?php echo $lang[$idioma]['Actualizar']; ?>"/>


                                </td>
                            </tr>
                        </table>
                        <table id="bundlesTable">
                            <tr>
                                <td colspan="3" class="bundle">
                                    <div id="bundle"></div>
                                </td>
                                <!--<td colspan="2"><div id="detallesBundle" style="overflow-y:auto; overflow-x:hidden; height:300px;"></div></td>-->
                            </tr>
                            <tr>
                                <td colspan="4">

                                </td>
                            </tr>
                            <tr>
                                <td><br></td>
                            </tr>
                        </table>
                    </center>
                    <div id="cargaLoadB"></div>
                </form>
            </div>

            <div id="float" class="float" style="display:none;">
                <div style="width: 100%; text-align: right">
                    <button style="background-color: transparent; border-color: transparent;" onclick="closePopup()">X</button>
                </div>
                <div id="popupContent" style="width: 100%;">

                </div>
            </div>
            <?php
        } else {
            echo "<script>alert(\"" . $lang[$idioma]['NoAprobado'] . "\");producto(1,'" . $_SESSION['codEmpresa'] . "','" . $_SESSION['pais'] . "','" . $itemCode . "'); </script>";
        }
    } else {
        echo "<script>alert(\"Debe guardar primero\");producto(1,'" . $_SESSION['codEmpresa'] . "','" . $_SESSION['pais'] . "','" . $itemCode . "'); </script>";
    }
}


function Desahabilita($dato)
{
    if ($dato == NULL) {
        return "";
    } else {
        return "disabled";
    }
}

function getLastSales($sku){
    $factsQ = "
        SELECT 
            FECHA, CANFACT, PRECIO, TOTAL
        FROM
            tra_factcomenc AS enc
                INNER JOIN
            tra_factcomdet AS det ON enc.codfactcom = det.codfactcom
        WHERE
            codprod = '$sku'
        ORDER BY enc.FECHA DESC
        LIMIT 5;
    ";

    $factsR = mysqli_query(conexion($_SESSION["pais"]), $factsQ);

    while($factsRow = mysqli_fetch_array($factsR)){
        $tFECHA = explode(" ", $factsRow["FECHA"])[0] ;
        $tCANFACT = explode(".", $factsRow["CANFACT"])[0];
        $tPRECIO = "$" . number_format($factsRow["PRECIO"], "2", ".", "");
        $tTOTAL = "$" . number_format($factsRow["TOTAL"], "2", ".", "");
        $data .= "
            <tr>
                <td>$tFECHA</td>
                <td>$tCANFACT</td> 
                <td>$tPRECIO</td>
                <td>$tTOTAL</td>
            </tr>";
    }

    $response = "
        <table>
            <thead>
                <td>FECHA</td>
                <td>CANT</td> 
                <td>PRECIO</td>
                <td>TOTAL</td>
            </thead>
            $data
        </table>
    ";

    return $response;
}

function showDetail(){

    $response = "";
    if($_SESSION["rol"] != "P"){
        $response = "hidden";
    }
    return $response;
}

?>

<script>
    function resetAllBundles() {
        console.log('reseteando');
        $("#tablas > tbody > tr").each(function () {
            if ($(this).find('td:eq(12)').find('#chkbox').is(':checked')) {
//            console.log($(this).find('td:eq(0)').html());
                batchReset($(this).find('td:eq(0)').html());
            }
        })

        $('#bundle').html('refrescando...');
        setTimeout(function () {
            location.reload();
        }, 2000);


    }

    function markAllPublishBundles() {
        $("input:checkbox[class=chkboxPublicar]").each(function () {
            this.checked = true;
        });
        document.getElementById('guardar2').disabled = false;
    }

    function savePublish() {

        $("#tablas > tbody > tr").each(function () {
            //console.log($(this).find('td:eq(0)').html() +' - '+ $(this).find('td:eq(11)').find('#chkboxPublicar').is(':checked'));
            updatePublishStatus(
                $(this).find('td:eq(0)').html(),
                $(this).find('td:eq(11)').find('#chkboxPublicar').is(':checked'));
        })
    }

    function showPopupCargo(event, amazonSKU) {
        event.preventDefault();
        var offset_pop = $("#cellCargo-" + amazonSKU).offset();
        // console.log(offset_pop);
        // $(".float").css({'left':260, 'top':9});
        $(".float").css({'left':offset_pop.left+55, 'top': offset_pop.top+22});
        $(".float").show(250);
        $("#popupContent").html("cargando...");

        $.ajax({
            type: "POST",
            url: "../productos/productosPrecioCostoHelper.php",
            data: {
                method:"getCargoValues",
                amazonSKU: amazonSKU,
            },
            success: function (response) {
                response = JSON.parse(response);
                $("#popupContent").html("<div class='pprow'><div class='ppleft'><b>Order Handling Fee:</b></div><div class='ppright'>"+response.FBAORDHANF+"</div></div>"+
                    "<div class='pprow'><div class='ppleft'><b>Pick and Pack:</b></div><div class='ppright'>"+response.FBAPICPACF+"</div></div>"+
                    "<div class='pprow'><div class='ppleft'><b>Order Weight Handling Fee:</b></div><div class='ppright'>"+response.FBAWEIHANF+"</div></div>"+
                    "<div class='pprow'><div class='ppleft'><b>Shipping to FBA:</b></div><div class='ppright'>"+response.FBAINBSHI+"</div></div>"+
                    "<div class='pprow'><div class='ppleft'><b>Packing Material:</b></div><div class='ppright'>"+response.PACMAT+"</div></div>"+
                    "<div class='pprow'><div class='ppleft'><b>Channel Referal Fee:</b></div><div class='ppright'>"+response.FBAREFOSSP+"</div></div>");
            }
        });
    }

    function showPopupUtilidad(event, amazonSKU) {
        event.preventDefault();
        var offset_pop = $("#cellUtilidad-" + amazonSKU).offset();
        // console.log(offset_pop);
        // $(".float").css({'left':260, 'top':9});
        $(".float").css({'left':offset_pop.left+55, 'top': offset_pop.top+22});
        $(".float").show(250);
        $("#popupContent").html("cargando...");

        $.ajax({
            type: "POST",
            url: "../productos/productosPrecioCostoHelper.php",
            data: {
                method:"getUtilidadValues",
                amazonSKU: amazonSKU,
            },
            success: function (response) {
                response = JSON.parse(response);
                $("#popupContent").html("<div class='pprow'><div class='ppleft'><b>Precio de Venta Sugerido:</b></div><div class='ppright'>"+response.sugsalpric+"</div></div>"+
                    "<div class='pprow'><div class='ppleft'><b>Sub Total Costos:</b></div><div class='ppright'>"+response.subtotfbac+"</div></div>"+
                    "<div class='pprow'><div class='ppleft'><b>Channel Referal Fee:</b></div><div class='ppright'>"+response.fbarefossp+"</div></div>");
            }
        });
    }

    function closePopup() {
        $(".float").hide(250);
        $("#popupContent").html("");
    }

    function lastShippmentInfo(sku) {
        $("#lastShippmentInfo").html("");
        $("#lastShippmentInfo").html("loading...");
        $.ajax({
            url:"../shipping/lastShippmentInfo.php",
            type:"POST",
            data:{
                sku:sku
            },
            success:function (response) {
                $("#lastShippmentInfo").html(response);
            },
            error:function (response) {
                $("#lastShippmentInfo").html("ERROR");
            }
        });
    }

    function cleanLastShippmentInfo() {
        $("#lastShippmentInfo").html("");
    }
</script>

<style>
    .float {
        width: 250px;
        height: 175px;
        display: none;
        position: absolute;
        background-color: #FF571C;
        border-radius: 0px 20px 20px 20px;
        z-index: 10;
        color: white;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 7), 0 6px 20px 0 rgba(0, 0, 0, 0.3);
    }

    .pprow{
        width: 100%;
    }

    .ppleft{
        margin-left: 4%;
        width: 75%;
        float: left;
        text-align: left;
    }

    .ppright{
        width: 20%;
        float: left;
    }
</style>
