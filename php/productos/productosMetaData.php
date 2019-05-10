<?php
require_once('../coneccion.php');
require_once('../fecha.php');
require_once('combosProductos.php');
$idioma = idioma();
include('../idiomas/' . $idioma . '.php');
$codigoEmpresa = $_POST['codEmpresa'];
$pais = $_POST['pais'];
$itemCode = limpiar_caracteres_sql($_POST['icode']);
session_start();
verTiempo2();

$squery = "select masterSKU,codempresa,descsis,prodName,nombre,nombri,marca,codProLin,keywords,categori,metatitles,descprod,obser,subcate1,subcate2,codPack,upc,itemcode,codprod,descshort,descshor1,descshor2,descshor3,descshor4 from cat_prod where codempresa='" . $codigoEmpresa . "' and mastersku='" . $_SESSION['mastersku'] . "'";
//echo '<script> console.log("' . $squery . '"); <script>';
if ($ejecutar = mysqli_query(conexion($_SESSION['pais']), $squery)) {

    if ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
        $_SESSION['codprod'] = $row['codprod'];

        ?>
        <div id="productos">
            <script>                    seleccion(document.getElementById('TabmetaData'));


                setTimeout(function () {
                    $("#cargaLoad").dialog("close");
                }, 500);
            </script>
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
                            <td><input type="text" class='entradaTexto' name="masterSKU" disabled id="masterSKU"
                                       value="<?php echo $row['masterSKU']; ?>"></td>
                            <td class="text"><span><?php echo $lang[$idioma]['ItemCode']; ?></span></td>
                            <td><input type="text" class='entradaTexto' name="itemCode" disabled id="itemCode" autofocus
                                       value="<?php echo $row['itemcode']; ?>"></td>
                        </tr>
                        <tr>
                            <td class="text"><span><?php echo $lang[$idioma]['ProdName']; ?></span></td>
                            <td colspan="2"><input type="text" class='entradaTexto' name="prodName" disabled
                                                   id="prodName" value="<?php echo $row['prodName']; ?>"></td>
                            <!--onKeyUp="contarCaracteres(this,5000,document.getElementById('caracteresProdDesc'));"-->
                        </tr>
                        <tr>
                            <td class="text"><span><?php echo $lang[$idioma]['KeyWords']; ?><span
                                        class="validaraster">*</span></span></td>
                            <td colspan="2"><textarea class='entradaTexto' id="keyWords"
                                                      onKeyUp="verificaImportantes('MetaData','guardar23');"
                                                      rows="7"><?php echo $row['keywords']; ?></textarea>
                                <div id="caracteresKeyWords" class="caracteres"></div>
                            </td>
                        </tr>
                        <tr hidden>
                            <td class="text"><span><?php echo $lang[$idioma]['MetaTitle']; ?></span></td>
                            <td colspan="2"><textarea class='entradaTexto' id="metaTitle" rows="4"
                                                      disabled><?php echo $row['metatitles']; ?></textarea></td>
                        </tr>
                        <tr>
                            <td class="text"><span><?php echo $lang[$idioma]['ProdDesc']; ?><span
                                        class="validaraster">*</span></span></td>
                            <td colspan="2"><textarea class='entradaTexto' id="prodDesc"
                                                      onKeyUp="verificaImportantes('MetaData','guardar23');"
                                                      rows="8"><?php echo str_replace('@amp;','&',str_replace('"','\"',str_replace("\n","",$row['descprod']))); ?></textarea>
                                <div id="caracteresProdDesc" class="caracteres"></div>
                            </td>
                        </tr>
                        <tr hidden>
                            <td class="text"><span><?php echo $lang[$idioma]['ProdDesc']; ?><span
                                        class="validaraster">*</span></span></td>
                            <td colspan="2"><textarea class='entradaTexto' id="prodDescH"
                                                      onKeyUp="verificaImportantes('MetaData','guardar23');"
                                                      rows="8"><?php echo str_replace('@amp;','&',str_replace('"','\"',str_replace("\n","",$row['descprod']))); ?></textarea>
                                <div id="caracteresProdDesc" class="caracteres"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text"><span><?php echo $lang[$idioma]['ProdDescShort']; ?><!--<span
                                        class="validaraster">*</span>--></span></td>
                            <td colspan="2"><textarea class='entradaTexto' id="prodDescShort"
                                                      onKeyUp="contarCaracteres(this,255,document.getElementById('caracteresShortProdDesc'));verificaImportantes('MetaData','guardar23');"
                                                      rows="7"><?php echo ((($row['descshort']))); ?></textarea>
                                <div id="caracteresShortProdDesc" class="caracteres">255</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text"><span><span
                                        class="validaraster"></span></span></td>
                            <td colspan="2"><textarea class='entradaTexto' id="prodDescShort1"
                                                      onKeyUp="contarCaracteres(this,255,document.getElementById('caracteresShortProdDesc1'));verificaImportantes('MetaData','guardar23');"
                                                      rows="7"><?php echo ((($row['descshor1']))); ?></textarea>
                                <div id="caracteresShortProdDesc1" class="caracteres">255</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text"><span><span
                                        class="validaraster"></span></span></td>
                            <td colspan="2"><textarea class='entradaTexto' id="prodDescShort2"
                                                      onKeyUp="contarCaracteres(this,255,document.getElementById('caracteresShortProdDesc2'));verificaImportantes('MetaData','guardar23');"
                                                      rows="7"><?php echo ((($row['descshor2']))); ?></textarea>
                                <div id="caracteresShortProdDesc2" class="caracteres">255</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text"><span><span
                                        class="validaraster"></span></span></td>
                            <td colspan="2"><textarea class='entradaTexto' id="prodDescShort3"
                                                      onKeyUp="contarCaracteres(this,255,document.getElementById('caracteresShortProdDesc3'));verificaImportantes('MetaData','guardar23');"
                                                      rows="7"><?php echo ((($row['descshor3']))); ?></textarea>
                                <div id="caracteresShortProdDesc3" class="caracteres">255</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text"><span><span
                                        class="validaraster"></span></span></td>
                            <td colspan="2"><textarea class='entradaTexto' id="prodDescShort4"
                                                      onKeyUp="contarCaracteres(this,255,document.getElementById('caracteresShortProdDesc4'));verificaImportantes('MetaData','guardar23');"
                                                      rows="7"><?php echo ((($row['descshor4']))); ?></textarea>
                                <div id="caracteresShortProdDesc4" class="caracteres">255</div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4"><br><br></td>
                        </tr>
                        <tr>

                            <td colspan="4">
                                <center>
                                    <input type="button" id="guardar23" class='cmd button button-highlight button-pill'
                                           onClick="actualizaProducto('metaData',document.getElementById('masterSKU').value,document.getElementById('prodName').value,document.getElementById('itemCode').value,document.getElementById('keyWords').value,'',document.getElementById('metaTitle').value,CKEDITOR.instances.prodDesc.getData(),'','','','','','','','','','','','');setTimeout(function(){ventana('cargaLoad',300,400);},0);"
                                           value="<?php echo $lang[$idioma]['Guardar']; ?>"/>
                                    <input type="reset" class='cmd button button-highlight button-pill'
                                           onClick="producto(2,'<?php echo $_SESSION['codEmpresa']; ?>','<?php echo $_SESSION['pais']; ?>','<?php echo $_SESSION['codprod']; ?>');"
                                           value="<?php echo $lang[$idioma]['Limpiar']; ?>"/>
                                </center>
                            </td>

                        </tr>
                    </table>
                </center>
            </form>
            <script>
                if (document.getElementById('keyWords').value == "") {
                    verificaImportantes('MetaData', 'guardar23');
                }
                CKEDITOR.replace( 'prodDesc' , {
												on: {
													key: function() {
														setTimeout(function(){
														document.getElementById('prodDescH').value=CKEDITOR.instances.prodDesc.getData(); 
														verificaImportantes('MetaData','guardar23');
														},00);
													}
												
												}
											});
											
				/*CKEDITOR.on("prodDesc", function(event) {
											event.editor.on("change", function () {
											$("#prodDesc").html(event.editor.getData());
											});
											});*/
				//CKEDITOR.replace( 'prodDescShort' );
                </script>
                
        </div>
    <?php } else {
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
} ?>