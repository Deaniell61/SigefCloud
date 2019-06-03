<?php
header("Content-Type: text/html; charset=utf-8");
require_once('../fecha.php');
require_once('combosProductos.php');
$idioma = idioma();
include('../idiomas/' . $idioma . '.php');
session_start();
verTiempo2();

$codigoEmpresa = $_POST['codEmpresa'];
$pais = $_POST['pais'];
$icode = $_POST['icode'];
$_SESSION['pais'] = $_POST['pais'];
$_SESSION['codEmpresa'] = $_POST['codEmpresa'];
$_SESSION['codprod'] = '';
$_SESSION['mastersku'] = $icode;

if (!$icode == NULL) {
    echo "<script>buscarProducto('" . $_SESSION['mastersku'] . "','" . $_SESSION['codEmpresa'] . "','" . $_SESSION['pais'] . "');
	seleccion(document.getElementById('Tabgeneral'));
	</script>";
}

?>
<script src="../../js/jquery.tabletojson.min.js"></script>
<script>
    function suLlamada1() {
        subCategorias('<?php echo $codigoEmpresa;?>', '<?php echo $pais;?>', document.getElementById('category').value, 'subCategory');
    }

    function suLlamada2() {
        setTimeout(function () {
            subCategorias2('<?php echo $codigoEmpresa;?>', '<?php echo $pais;?>', document.getElementById('subCategory1').value, 'subCategory');
        }, 0);
    }

    setTimeout(function () {
        $("#cargaLoad").dialog("close");
    }, 500);
</script>
<div id="productos">

    <form id="ProductosGeneral" action="return false" onSubmit="return false" method="POST">
        <center>
            <br>
            <table>
                <tr>
                    <div id="resultado"></div>
                </tr>
                <tr>
                    <div id="advertencia" style="color:red;"
                         hidden><?php echo $lang[$idioma]['Adevertencia_Rojo']; ?></div>
                </tr>

                <tr>
                    <td class="text"><span><?php echo $lang[$idioma]['MasterSKU']; ?></span></td>
                    <td><input type="text" name="masterSKU" class='entradaTexto' disabled id="masterSKU"
                               placeholder="<?php echo $lang[$idioma]['MasterSKU']; ?>"></td>
                    <td class="text"><span><?php echo $lang[$idioma]['ItemCode']; ?><span id="SNameAs"
                                                                                          class="validaraster">*</span></span>
                    </td>
                    <td><input type="text" class='entradaTexto'
                               onkeyup="javascript:this.value=this.value.toUpperCase();"
                               style="text-transform:uppercase;" name="itemCode" id="itemCode"
                               onChange="verificaImportantes('General','guardar112');"
                               onblur="buscarProducto(this.value,'<?php echo $_SESSION['codEmpresa']; ?>','<?php echo $_SESSION['pais']; ?>');"
                               autofocus placeholder="<?php echo $lang[$idioma]['ItemCode']; ?>"></td>
                </tr>

                <!--                <tr>-->
                <!--                    <td class="text"><span>-->
                <?php //echo $lang[$idioma]['tipoProd']; ?><!--</span></td>-->
                <!--                    <td>-->
                <!--                        <select id="prodType" class="entradaTexto">-->
                <!--                            <option selected value="PRO">-->
                <?php //echo $lang[$idioma]['pro']; ?><!--</option>-->
                <!--                            <option value="KIT">-->
                <?php //echo $lang[$idioma]['kit']; ?><!--</option>-->
                <!--                        </select>-->
                <!--                        <input disabled id="addKitProdsButton" type="button"-->
                <!--                               class="cmd button button-highlight button-pill"-->
                <!--                               value="--><?php //echo $lang[$idioma]['Agregar']; ?><!--">-->
                <!--                    </td>-->
                <!--                </tr>-->

                <tr>
                    <td class="text"><span><?php echo $lang[$idioma]['DescSis']; ?><span id="descSistemaAs"
                                                                                         class="validaraster">*</span></span>
                    </td>
                    <td colspan="2"><input type="text" class='entradaTexto'
                                           onChange="verificaImportantes('General','guardar112');"
                                           name="descSistema"
                                           id="descSistema" placeholder="<?php echo $lang[$idioma]['DescSis']; ?>">
                    </td>

                </tr>
                <tr>
                    <td class="text"><span><?php echo $lang[$idioma]['EName']; ?><span id="ENameAs"
                                                                                       class="validaraster">*</span></span>
                    </td>
                    <td>
                        <input type="text" class='entradaTexto' name="EName" id="EName"
                               placeholder="<?php echo $lang[$idioma]['EName']; ?>"
                               onChange="verificaImportantes('General','guardar112');"
                               onBlur="prodname(document.getElementById('EName').value,document.getElementById('SName').value);">
                    </td>
                    <td class="text">
                        <span><?php echo $lang[$idioma]['SName']; ?><span id="SNameAs"
                                                                          class="validaraster">*</span></span>
                    </td>
                    <td>
                        <input type="text" class='entradaTexto' name="SName" id="SName"
                               placeholder="<?php echo $lang[$idioma]['SName']; ?>"
                               onChange="verificaImportantes('General','guardar112');"
                               onBlur="prodname(document.getElementById('EName').value,document.getElementById('SName').value);">
                    </td>

                </tr>
                <tr>
                    <td class="text"><span><?php echo $lang[$idioma]['ProdNameESEN']; ?></span></td>
                    <td colspan="2"><input type="text" class='entradaTexto' name="prodName" id="prodName" disabled
                                           placeholder="<?php echo $lang[$idioma]['ProdName']; ?>"></td>
                </tr>
            </table>
            <table>
                <tr>
                    <td class="text"><span><?php echo $lang[$idioma]['Category']; ?><span id="categoryAs"
                                                                                          class="validaraster">*</span></span>
                    </td>
                    <td><select class='entradaTexto' id="category"
                                onChange="parametrosEspecificos('<?php echo $codigoEmpresa; ?>','<?php echo $pais; ?>',this.value);subCategorias('<?php echo $codigoEmpresa; ?>','<?php echo $pais; ?>',this.value,'subCategory');setTimeout(function(){subCategorias2('<?php echo $codigoEmpresa; ?>','<?php echo $pais; ?>',document.getElementById('subCategory1').value,'subCategory');},500);verificaImportantes('General','guardar112');"><?php echo comboCategorias($codigoEmpresa, $pais); ?></select>
                        <!--<img title="Agregar" src="../../images/document_add.png" id="subForm" onClick="asignarExtras('category','<?php echo $codigoEmpresa; ?>','<?php echo $pais; ?>');">-->
                    </td>
                    <td class="text"><span><?php echo $lang[$idioma]['Marca']; ?><span id="marcaAs"
                                                                                       class="validaraster">*</span></span>
                    </td>
                    <td style="text-align: left;"><select class='entradaTexto' id="marca"
                                                          onChange="parametroEspe('marcaEsp',this);verificaImportantes('General','guardar112');"
                                                          autofocus><?php echo "<script>MarcasLlenar('" . $codigoEmpresa . "','" . $pais . "','" . $_SESSION['codprov'] . "','marcas');</script>"/*.comboMarca($codigoEmpresa,$pais,'',$_SESSION['codprov'])*/
                            ; ?></select><img title="Agregar <?php echo $lang[$idioma]['Marca']; ?>"
                                              src="../../images/document_add.png" id="subForm"
                                              onClick="asignarExtras('marca','<?php echo $codigoEmpresa; ?>','<?php echo $pais; ?>');"><img
                                title="Editar <?php echo $lang[$idioma]['Marca']; ?>" src="../../images/editar.png"
                                onClick="ventana('Busqueda',550,800);llenarBusqueda('Marca','Busqueda');"
                                style="position: absolute;margin-left: 5px;" width="21px" height="21px"></td>
                </tr>
                <tr>
                    <td class="text"><span><?php echo $lang[$idioma]['SubCategory1']; ?><span id="subCategory1As"
                                                                                              class="validaraster">*</span></span>
                    </td>
                    <td><select class='entradaTexto' id="subCategory1"
                                onChange="parametrosEspecificos('<?php echo $codigoEmpresa; ?>','<?php echo $pais; ?>',this.value);subCategorias2('<?php echo $codigoEmpresa; ?>','<?php echo $pais; ?>',this.value,'subCategory');verificaImportantes('General','guardar112');"></select>
                        <!--<img title="Agregar" src="../../images/document_add.png" id="subForm" onClick="asignarExtras('subCategory','<?php echo $codigoEmpresa; ?>','<?php echo $pais; ?>');">-->
                    </td>
                    <td class="text"><span><?php echo $lang[$idioma]['Manufacturadores']; ?><span
                                    id="manufacturadoresAs" class="validaraster">*</span></span></td>
                    <td style="text-align: left;"><select class='entradaTexto' onClick="" id="manufacturadores"
                                                          onChange="verificaImportantes('General','guardar112');"><?php echo "<script>ManufactLlenar('" . $codigoEmpresa . "','" . $pais . "','" . $_SESSION['codprov'] . "','manufact');</script>"/*.comboManufacturadores($codigoEmpresa,$pais,$_SESSION['codprov'])*/
                            ; ?></select><img title="Agregar <?php echo $lang[$idioma]['Manufacturadores']; ?>"
                                              src="../../images/document_add.png" id="subForm"
                                              onClick="asignarExtras('manufacturadores','<?php echo $codigoEmpresa; ?>','<?php echo $pais; ?>');"><img
                                title="Editar <?php echo $lang[$idioma]['Manufacturadores']; ?>"
                                src="../../images/editar.png"
                                onClick="ventana('Busqueda',550,800);llenarBusqueda('Manufacturador','Busqueda');"
                                style="position: absolute;margin-left: 5px;" width="21px" height="21px"></td>

                </tr>

                <tr>
                    <td class="text"><span><?php echo $lang[$idioma]['SubCategory2']; ?></span></td>
                    <td><select class='entradaTexto' id="subCategory2"
                                onChange="parametrosEspecificos('<?php echo $codigoEmpresa; ?>','<?php echo $pais; ?>',this.value);verificaImportantes('General','guardar112');"></select>
                        <!--<img title="Agregar" src="../../images/document_add.png" id="subForm" onClick="asignarExtras('subCategory','<?php echo $codigoEmpresa; ?>','<?php echo $pais; ?>');">-->
                    </td>
                    <td class="text"><span><?php echo $lang[$idioma]['ProdLin']; ?></span></td>
                    <td style="text-align: left;"><select class='entradaTexto' id="prodLin" autofocus
                                                          onChange="verificaImportantes('General','guardar112');"><?php echo "<script>prodLinLlenar('" . $codigoEmpresa . "','" . $pais . "','" . $_SESSION['codprov'] . "','prolin');</script>"/*.comboProdLin($codigoEmpresa,$pais,'',$_SESSION['codprov'])*/
                            ; ?></select><img title="Agregar <?php echo $lang[$idioma]['ProdLin']; ?>"
                                              src="../../images/document_add.png" id="subForm"
                                              onClick="asignarExtras('prodLin','<?php echo $codigoEmpresa; ?>','<?php echo $pais; ?>');"><img
                                title="Editar <?php echo $lang[$idioma]['ProdLin']; ?>"
                                src="../../images/editar.png"
                                onClick="ventana('Busqueda',550,800);llenarBusqueda('ProdLin','Busqueda');"
                                style="position: absolute;margin-left: 5px;" width="21px" height="21px"></td>
                </tr>
                <tr>
                    <td class="text"><span><?php echo $lang[$idioma]['Genero']; ?></span></td>
                    <td><select class='entradaTexto' id="genero"
                                onChange="verificaImportantes('General','guardar112');"><?php echo comboGenero($codigoEmpresa, $pais); ?></select>
                    </td>
                    <td class="text"><span><?php echo $lang[$idioma]['Pakage']; ?><span id="pakageAs"
                                                                                        class="validaraster">*</span></span>
                    </td>
                    <td><select class='entradaTexto' onClick="" id="pakage"
                                onChange="verificaImportantes('General','guardar112');"><?php echo comboPaquetes($codigoEmpresa, $pais); ?></select>
                        <!--<img title="Agregar <?php echo $lang[$idioma]['Pakage']; ?>" src="../../images/document_add.png" id="subForm" onClick="asignarExtras('pakage','<?php echo $codigoEmpresa; ?>','<?php echo $pais; ?>');">-->
                    </td>

                </tr>
                <tr>
                    <td class="text"><span><?php echo $lang[$idioma]['AgeSegment']; ?></span></td>
                    <td style="text-align:left;"><input type="text" id="age"
                                                        onChange="verificaImportantes('General','guardar112');"
                                                        hidden>
                        <?php echo comboAgeSegment($codigoEmpresa, $pais); ?><!--<img title="Agregar <?php echo $lang[$idioma]['AgeSegment']; ?>" src="../../images/document_add.png" id="subForm" onClick="asignarExtras('ageSegment','<?php echo $codigoEmpresa; ?>','<?php echo $pais; ?>');">-->
                    </td>
                    <td class="text"><span><?php echo $lang[$idioma]['Flavor1']; ?></span></td>
                    <td style="text-align: left;"><select class='entradaTexto' id="flavor"
                                                          onChange="verificaImportantes('General','guardar112');"><?php echo "<script>saborLlenar('" . $codigoEmpresa . "','" . $pais . "','" . $_SESSION['codprov'] . "','sabor');</script>"/*.comboFlavor($codigoEmpresa,$pais,$_SESSION['codprov'])*/
                            ; ?></select><img title="Agregar <?php echo $lang[$idioma]['Flavor1']; ?>"
                                              src="../../images/document_add.png" id="subForm"
                                              onClick="asignarExtras('flavor','<?php echo $codigoEmpresa; ?>','<?php echo $pais; ?>');"><img
                                title="Editar <?php echo $lang[$idioma]['Flavor1']; ?>"
                                src="../../images/editar.png"
                                onClick="ventana('Busqueda',550,800);llenarBusqueda('Flavor','Busqueda');"
                                style="position: absolute;margin-left: 5px;" width="21px" height="21px"></td>
                </tr>
                <tr>
                    <td class="text"><span><?php echo $lang[$idioma]['PaisOrigen']; ?><span
                                    class="validaraster">*</span></span></td>
                    <td><select class='entradaTexto'
                                onChange="parametroEspe('ciudadEsp',this);verificaImportantes('General','guardar112');"
                                id="paisOrigen"><?php echo comboPaisOrigen($codigoEmpresa, $pais); ?></select>
                        <!--<img title="Agregar <?php echo $lang[$idioma]['PaisOrigen']; ?>" src="../../images/document_add.png" id="subForm" onClick="asignarExtras('paisOrigen','<?php echo $codigoEmpresa; ?>','<?php echo $pais; ?>');">-->
                    </td>
                    <td class="text"><span><?php echo $lang[$idioma]['Concerns']; ?></span></td>
                    <td><select class='entradaTexto'
                                id="concerns"><?php echo comboConcerns($codigoEmpresa, $pais); ?></select>
                        <!--<img title="Agregar <?php echo $lang[$idioma]['Concerns']; ?>" src="../../images/document_add.png" id="subForm" onClick="asignarExtras('concerns','<?php echo $codigoEmpresa; ?>','<?php echo $pais; ?>');">-->
                    </td>


                </tr>
                <tr>
                    <td class="text"><span><?php echo $lang[$idioma]['Cocina']; ?></span></td>
                    <td style="text-align: left;"><select class='entradaTexto' id="cocina"
                                                          onChange="verificaImportantes('General','guardar112');"><?php echo "<script>CocinaLlenar('" . $codigoEmpresa . "','" . $pais . "','" . $_SESSION['codprov'] . "','cocina');</script>"/*.comboCocina($codigoEmpresa,$pais,$_SESSION['codprov'])*/
                            ; ?></select><img title="Agregar <?php echo $lang[$idioma]['Cocina']; ?>"
                                              src="../../images/document_add.png" id="subForm"
                                              onClick="asignarExtras('cocina','<?php echo $codigoEmpresa; ?>','<?php echo $pais; ?>');"><img
                                title="Editar <?php echo $lang[$idioma]['Cocina']; ?>" src="../../images/editar.png"
                                onClick="ventana('Busqueda',550,800);llenarBusqueda('Cocina','Busqueda');"
                                style="position: absolute;margin-left: 5px;" width="21px" height="21px"></td>
                    <td class="text"><span><?php echo $lang[$idioma]['Formula']; ?></span></td>
                    <td style="text-align: left;"><select class='entradaTexto' id="formula"
                                                          onChange="verificaImportantes('General','guardar112');"><?php echo "<script>formulaLlenar('" . $codigoEmpresa . "','" . $pais . "','" . $_SESSION['codprov'] . "','formula');</script>"/*.comboFormulas($codigoEmpresa,$pais,$_SESSION['codprov'])*/
                            ; ?></select><img title="Agregar <?php echo $lang[$idioma]['Formula']; ?>"
                                              src="../../images/document_add.png" id="subForm"
                                              onClick="asignarExtras('formulas','<?php echo $codigoEmpresa; ?>','<?php echo $pais; ?>');"><img
                                title="Editar <?php echo $lang[$idioma]['Formula']; ?>"
                                src="../../images/editar.png"
                                onClick="ventana('Busqueda',550,800);llenarBusqueda('Formula','Busqueda');"
                                style="position: absolute;margin-left: 5px;" width="21px"
                                height="21px"><br><br><span
                                style="float:left;"
                                id="diameter"><?php echo $lang[$idioma]['EjemploFormula']; ?></span>
                    </td>

                </tr>
                <tr>
                    <td class="text"><span><?php echo $lang[$idioma]['UPC']; ?></span></td>
                    <td><input type="text" class='entradaTexto' name="UPC" id="UPC"
                               onChange="verificaImportantes('General','guardar112');"
                               onBlur="generateBarcode(document.getElementById('UPC').value);"
                               placeholder="<?php echo $lang[$idioma]['UPC']; ?>"></td>

                    <td class="text"><span><?php echo $lang[$idioma]['FCE']; ?></span></td>
                    <td><input type="text" class='entradaTexto' name="FCE" id="FCE"
                               onChange="verificaImportantes('General','guardar112');"
                               onkeypress="return isNumber(event)"></td>
                </tr>
                <tr>
                    <td class="text"><span><?php echo $lang[$idioma]['grados']; ?></span></td>
                    <td><input type="text" class='entradaTexto' name="grados" id="grados" disabled
                                           placeholder="<?php echo $lang[$idioma]['grados']; ?>">
                    </td>
                    <td class="text"><span><?php echo $lang[$idioma]['SID']; ?></span></td>
                    <td><input type="text" class='entradaTexto' name="SID" id="SID"
                               onChange="verificaImportantes('General','guardar112');"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div id="codigo">
                        </div>
                    </td>
                    <td class="text"><span><?php echo $lang[$idioma]['SizeCount']; ?></span></td>
                    <td style="text-align:left"><input type="text" class='entradaTexto' name="SizeCount"
                                                       id="SizeCount"
                                                       onChange="verificaImportantes('General','guardar112');"><br><br><span
                                id="diameter">1/DIAMETER:### HEIGTH: ###:VOLUME:### FL OZ.</span></td>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" id="paramEspecific">
                    </td>
                </tr>
                <tr>
                    <td colspan="4"><br><br></td>
                </tr>
                <tr>
                    <td class="" colspan="4">
                        <input type="button" class='cmd button button-highlight button-pill' id="guardar112"
                               onClick="verificaEspeciales();guardarProducto();"
                               value="<?php echo $lang[$idioma]['Guardar']; ?>"/>
                        <!--onClick="verificaEspeciales();guardarProducto();window.opener.formulario('1');"-->
                        <input type="reset" class='cmd button button-highlight button-pill'
                               onClick="envioDeDataProductos('productos');document.getElementById('itemCode').disabled = false;document.getElementById('itemCode').focus();"
                               value="<?php echo $lang[$idioma]['Limpiar']; ?>"/>
                    </td>
                </tr>
            </table>
        </center>
    </form>

</div>

<div hidden id="kitModal">
    <div class="row">
        <div class="leftSide">
            <?= $lang[$idioma]['MasterSKU'] ?>
        </div>
        <div class="rightSide">
            <input type="text"
                   id="autocompleteProductInput"
                   class='entradaTextoBuscar fullInput'
                   placeholder=""
                   value=""/>
        </div>
    </div>
    <div class="row">
        <div id="prodInfo"></div>
    </div>
    <div class="row">
        <input id="addToKit" type="button" value="<?= $lang[$idioma]['Agregar'] ?>"
               class="cmd button button-highlight button-pill"/>
        <input id="saveKit" type="button" value="dummySave"
               class="cmd button button-highlight button-pill"/>
    </div>
    <div ID="kitProductsDataContainer" class="row">
        <table id="kitProductsData" class="dataTable">
            <thead>
            <tr>
                <th width=\"20%\"><?= $lang[$idioma]['MasterSKU'] ?></th>
                <th width=\"70%\"><?= $lang[$idioma]['ProdName'] ?></th>
                <th width=\"10%\"><?= $lang[$idioma]['Controls'] ?></th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<div hidden id="upcToItemCode" title="UPC - Item Code">
    <p>Usar UPC como Item Code?</p>
</div>

<script>
    setTimeout(com, 1000);

    var oSKU = "";
    var oName = "";

    function com() {

        bueno1(document.getElementById('EName'));
        bueno1(document.getElementById('SName'));
        bueno1(document.getElementById('descSistema'));
        bueno1(document.getElementById('marca'));
        bueno1(document.getElementById('manufacturadores'));
        bueno1(document.getElementById('category'));
        if (cat1 == 1) {
            bueno1(document.getElementById('subCategory1'));
        }
        bueno1(document.getElementById('pakage'));

        //alert(<?=$_SESSION['isCopy']?> +' - ' + <?=$_SESSION['origSKU']?>);
        //document.getElementById('itemCode')
    }

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    $("#prodType").change(function (event) {
        var currentType = event.target.value;
        if (currentType == "PRO") {
            $("#addKitProdsButton").prop("disabled", true);
        }
        else if (currentType == "KIT") {
            $("#addKitProdsButton").prop("disabled", false);
        }
    });

    $("#addKitProdsButton").click(function () {
        $("#kitModal").dialog({
            width: 600,
            height: 350,
            modal: true
        });
    });
    $("#autocompleteProductInput").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "../objects/productsRequests.php",
                dataType: "json",
                data: {
                    method: "searchProduct",
                    term: request.term
                },
                success: function (data) {
                    response(data);
//                    console.log("S" + data);
                },
                error: function (response) {
//                    console.log("E" + response);
                }
            });
        },
        select: function (event, ui) {
            var d = ui.item.label.split(" - ");
            $("#autocompleteProductInput").val(d[0]);
            getProduct(getProductCallback)
            return false;
        },
        minLength: 3,
        maxShowItems: 10,
    });

    function getProduct(callback) {

        var tSKU = $("#autocompleteProductInput").val();
        console.log(tSKU);
        var tQuant = $("#quant").val();
        //console.log('<?//= $_SESSION['codprov']?>//');
        //console.log(tSKU);
        oSKU = tSKU;
        document.getElementById('prodInfo').innerHTML = "";
        if (tSKU != "") {
//            products.getProduct(callback, tSKU, 1);
            $.ajax({
                url: '../objects/productsRequests.php',
                type: 'POST',
                data: {
                    method: 'getProduct',
                    masterSKU: tSKU,
                },
                success: function (response) {
                    var tResponse = JSON.parse(response);
                    console.log("D1:" + tResponse);
                    getProductCallback(tResponse);
                },
                error: function (response) {
                    console.log('E' + JSON.stringify(response));
                }
            });
        }
    };


    function getProductCallback(response) {

        if (response != 0) {

            curProd = response;
            document.getElementById('prodInfo').innerHTML = response['PRODNAME'];
            $("#validProduct").val("1");
//            var tResponse = JSON.parse(response);
            oName = response['PRODNAME'];
            if (response.PVENTA = '0.00000') {
                $("#nPrice").prop("hidden", false);
            } else {
                $("#nPrice").prop("hidden", true);
            }
        }

        else {
            console.log('no existe');
            document.getElementById('prodInfo').innerHTML = "Producto no existe";
            $("#validProduct").val("0");
        }
    };

    function delRow(del) {
        console.log(del);
        del.closest('tr').remove();
    };

    $("#addToKit").click(function () {

        if (oSKU !== "" && oName != "") {

            var table = document.getElementById('kitProductsData').getElementsByTagName('tbody')[0];
            var row = table.insertRow(0);

            var cel1 = row.insertCell(0);
            var cel2 = row.insertCell(1);
            var cel3 = row.insertCell(2);

            cel1.innerHTML = oSKU;
            cel2.innerHTML = oName;
            cel3.innerHTML = "<image class='delProdKit' src='../../images/document_delete.png' onClick='delRow(this)'></image>";

            oName = "";
            oSKU = "";
            $("#prodInfo").html("");
            $("#autocompleteProductInput").val("");
            $("#autocompleteProductInput").focus();
        }
    });

    $("#saveKit").click(function () {
        var data = $("#kitProductsData").tableToJSON();
        console.log(data);
    });

    setTimeout(function () {
        if ($("#UPC").val() == "" && $("#masterSKU").val() != "") {
            $("#codigo").html("<input type='button' class='cmd button button-highlight button-pill' value='UPC' onclick='asignUPC()'/>");
        }

        if ($("#UPC").val() != "" && $("#masterSKU").val() != "" && $("#itemCode") == "") {
            $(function () {
                $("#upcToItemCode").dialog({
                    resizable: false,
                    height: "auto",
                    width: 400,
                    modal: true,
                    buttons: {
                        "Si": function () {
                            $("#itemCode").val($("#UPC").val());
                            $(this).dialog("close");
                        },
                        "No": function () {
                            $(this).dialog("close");
                        }
                    }
                });
            });
        }
    }, 1500);


    function asignUPC() {
        var tSKU = $("#masterSKU").val();

        $.ajax({
            url: 'asignUPC.php',
            type: 'POST',
            data: {
                tipo: "assignUPC",
                SKU: tSKU
            },
            success: function (resp) {
//                console.log(resp);
                $("#Tabgeneral").click();
            },
            error: function (resp) {
                console.log('ERROR ' + JSON.stringify(resp));
            }
        })
    }

    setTimeout(com, 1000);

    function com() {

        bueno1(document.getElementById('EName'));
        bueno1(document.getElementById('SName'));
        bueno1(document.getElementById('descSistema'));
        bueno1(document.getElementById('marca'));
        bueno1(document.getElementById('manufacturadores'));
        bueno1(document.getElementById('category'));
        if (cat1 == 1) {
            bueno1(document.getElementById('subCategory1'));
        }
        bueno1(document.getElementById('pakage'));
    }


</script>

<?php

if ($_SESSION['isCopy'] == '1') {
    echo "
    <script>
    setTimeout(function() {
    document.getElementById('masterSKU').value = '';  
    document.getElementById('itemCode').disabled = false;  
    document.getElementById('itemCode').value = '';  
    document.getElementById('UPC').value = '';  
    }, 1000)
    </script>";
} ?>

<style>

    .fullInput {
        width: 100%;
    }

    .row {
        width: 100%;
        text-align: center;
    }

    .leftSide {
        float: left;
        width: 25%;
    }

    .rightSide {
        float: left;
        width: 75%;
    }

    #kitModal {
        width: 500px;
        height: 500px;
    }

    .ui-autocomplete {
        z-index: 1000;
        z-index: 1000;
    }

    .dataTable {
        width: 100%;
    }
</style>
