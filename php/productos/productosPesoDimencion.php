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
$squery = "select masterSKU,codempresa,descsis,prodName,nombre,nombri,marca,codProLin,keywords,categori,metatitles,descprod,obser,subcate1,subcate2,codPack,upc,codpres,peso,peso_lb,peso_oz,alto,ancho,profun,univenta,itemcode,codprod,palcontenedor,cajcontenedor,nivpalet,cajanivel,(nivpalet*cajanivel) as totalPalets,(cajanivel*nivpalet) as totalCajaPallets,imaurlbase,peso_lbCA,peso_ozCA,alto_CA,ancho_CA,profun_CA,peso_lbPA,peso_ozPA,alto_PA,ancho_PA,profun_PA from cat_prod where codempresa='" . $codigoEmpresa . "' and codprod='" . $_SESSION['codprod'] . "'";
if ($ejecutar = mysqli_query(conexion($_SESSION['pais']), $squery)) {
    if ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
        $_SESSION['codprod'] = $row['codprod'];
        ?>
        <div id="productos">
            <script>seleccion(document.getElementById('TabpesoDimencion'));
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
                            <div id="advertenciacero" style="color:red;"
                                 hidden><?php echo $lang[$idioma]['Nocero']; ?></div>
                        </tr>
                        <tr>
                            <div id="advertenciapre" style="color:red;"
                                 hidden><?php echo $lang[$idioma]['sinpre']; ?></div>
                        </tr>
                        <tr>
                            <td class="text"><span><?php echo $lang[$idioma]['MasterSKU']; ?></span></td>
                            <td colspan="2"><input type="text" class='entradaTexto' name="masterSKU" disabled
                                                   id="masterSKU" value="<?php echo $row['masterSKU']; ?>"></td>
                            <td></td>
                            <td class="text"><span><?php echo $lang[$idioma]['ItemCode']; ?></span></td>
                            <td><input type="text" class='entradaTexto' name="itemCode" disabled id="itemCode" autofocus
                                       value="<?php echo $row['itemcode']; ?>"></td>
                        </tr>
                        <tr>
                            <td class="text"><span><?php echo $lang[$idioma]['ProdName']; ?></span></td>
                            <td colspan="4"><input type="text" class='entradaTexto' name="prodName" disabled
                                                   id="prodName" value="<?php echo $row['prodName']; ?>"></td>
                        </tr>
                        <tr>
                            <td class="text"><span><?php echo $lang[$idioma]['Size1']; ?></span><span
                                    class="validaraster">*&nbsp;&nbsp;</span></td>
                            <td colspan="2" style="text-align:left">
                                <!-- presentacion(this, size)-->
                                <select class='entradaTexto'
                                        onclick="agregarUnidad();"
                                        id="size"><?php echo "<script>sizeLlenar('" . $codigoEmpresa . "','" . $pais . "','" . $_SESSION['codprov'] . "','size','" . $row['codpres'] . "');</script>"/*.comboSize($codigoEmpresa,$pais,$row['codpres'],$_SESSION['codprov'])*/
                                    ; ?>
                                </select>
                                
                                <!--<h1>:   <?php echo $squery ; ?></h1>-->

                                <img src="../../images/document_add.png"
                                     id="subForm"
                                     onClick="asignarExtras('size','<?php echo $codigoEmpresa; ?>','<?php echo $pais; ?>');">

                                <img title="Editar <?php echo $lang[$idioma]['Size1']; ?>"
                                     src="../../images/editar.png"
                                     onClick="ventana('Busqueda',550,800);llenarBusqueda('size','Busqueda');"
                                     style="position: absolute;margin-left: 5px;"
                                     width="21px"
                                     height="21px">
                            </td>
                            <td></td>
                            <!--<td class="text"><span><?php echo $lang[$idioma]['UnidadesCaja']; ?></span></td>
                <td style="text-align:left;"><input type="number" class='entradaTexto' min="0" max="1000" id="uniVenta3" value="<?php echo $row['univenta']; ?>"/></td>-->
                        </tr>
                    </table>
                    <style>
                        .leftElement {
                            width: 50%;
                            float: left;
                            text-align: right;
                        }

                        .rightElement {
                            width: 50%;
                            float: left;
                            text-align: left;
                        }

                        .smallInput {
                            width: 40px !important;
                        }

                        .normalInput {
                            width: 92%;
                        }

                        .block{
                            width: 33%;
                            height: 100%;
                            float: left;
                        }

                        .frame{
                            width: 405px;
                            height: 220px;
                            border: outset;
                            border-width: 1px;
                            border-radius: 10px;
                        }

                        .informationBlock{
                            width: 350px;
                            height: 175px;
                        }
                    </style>
                    <!--contenedor principal-->
                    <div style="
                        width: 100%;
                        height: 225px;
                        margin-top: 25px">

                        <!--bloque unidades-->
                        <div class="block">

                            <!--contenedor con borde-->
                            <div class="frame">

                                <br>
                                <span><strong><?php echo $lang[$idioma]['Dimensiones']; ?></strong></span>
                                <br>
                                <br>
                                <div style="width:10px; height: 30px;"></div>
                                <div class="informationBlock">

                                    <div class="leftElement">
                                        <?php echo $lang[$idioma]['PesoUnidad']; ?>
                                        <span class="validaraster">*</span>
                                    </div>
                                    <div class="rightElement">
                                        <input id="libras"
                                               class='entradaTexto smallInput numberInput'
                                               type="text"
                                               value="<?php echo $row['peso_lb']; ?>"/>

                                        <input id="onzas"
                                               class='entradaTexto smallInput'
                                               type="text"
                                               value="<?php echo $row['peso_oz']; ?>"/>

                                        <input disabled
                                               readonly
                                               id="pesoTotLB"
                                               class='entradaTexto smallInput'
                                               type="text"
                                               value="<?php echo $row['peso']; ?>"/>
                                        <br>
                                    <span><?php echo $lang[$idioma]['Libras']; ?>
                                        + <?php echo $lang[$idioma]['Onzas']; ?>
                                        = <?php echo $lang[$idioma]['PesoTotLB']; ?></span>
                                    </div>


                                    <div class="leftElement">
                                        <?php echo $lang[$idioma]['alto']; ?>
                                        <span class="validaraster">*</span>
                                    </div>
                                    <div class="rightElement">
                                        <input class='entradaTexto normalInput' type="number" step="0.1" min="0" max="1000"
                                               onChange=" verificaImportantes('Peso','guardar25'); "
                                               value="<?php echo $row['alto']; ?>" id="alto"/>
                                    </div>

                                    <div class="leftElement">
                                        <?php echo $lang[$idioma]['ancho']; ?>
                                        <span class="validaraster">*</span>
                                    </div>
                                    <div class="rightElement">
                                        <input class='entradaTexto normalInput' type="number" step="0.1" min="0" max="1000"
                                               onChange="verificaImportantes('Peso','guardar25');"
                                               value="<?php echo $row['ancho']; ?>" id="ancho"/>
                                    </div>

                                    <div class="leftElement">
                                        <?php echo $lang[$idioma]['largo']; ?>
                                        <span class="validaraster">*</span>
                                    </div>
                                    <div class="rightElement">
                                        <input class='entradaTexto normalInput' type="number" step="0.1" min="0" max="1000"
                                               onChange="verificaImportantes('Peso','guardar25');"
                                               value="<?php echo $row['profun']; ?>" id="largo"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--bloque cajas-->
                        <div class="block">

                            <!--contenedor con borde-->
                            <div class="frame">

                                <br>
                                <span><strong><?php echo $lang[$idioma]['DimensionesCaja']; ?></strong></span>
                                <br>
                                <br>
                                <div class="informationBlock">

                                    <div class="leftElement">
                                        <span><?php echo $lang[$idioma]['UnidadesCaja']; ?></span>
                                        <span class="validaraster"></span>
                                    </div>
                                    <div class="rightElement">
                                        <input disabled
                                               id="uniVenta"
                                               class='entradaTexto normalInput'
                                               type="number"
                                               min="0"
                                               value="<?php echo $row['univenta']; ?>"/>
                                    </div>

                                    <div class="leftElement">
                                        <?php echo $lang[$idioma]['PesoCaja']; ?>
                                        <span class="validaraster">*</span>
                                    </div>
                                    <div class="rightElement">
                                        <input id="librasCaja"
                                               class='entradaTexto smallInput numberInput'
                                               value="<?php echo $row['peso_lbCA']; ?>"/>
                                        <input id="onzasCaja"
                                               class='entradaTexto smallInput numberInput'
                                               value="<?php echo $row['peso_ozCA']; ?>"/>

                                        <input disabled
                                               readonly
                                               id="pesoTotLBCaja"
                                               class='entradaTexto smallInput'
                                               value=""/>
                                        <br>
                                    <span><?php echo $lang[$idioma]['Libras']; ?>
                                        + <?php echo $lang[$idioma]['Onzas']; ?>
                                        = <?php echo $lang[$idioma]['PesoTotLB']; ?></span>
                                    </div>

                                    <div class="leftElement">
                                        <?php echo $lang[$idioma]['alto']; ?>
                                        <span class="validaraster"></span>
                                    </div>
                                    <div class="rightElement">
                                        <input class='entradaTexto normalInput' type="number" min="1" max="1000"
                                               value="<?php echo $row['alto_CA']; ?>" id="altoCaja"/>
                                    </div>

                                    <div class="leftElement">
                                        <?php echo $lang[$idioma]['ancho']; ?>
                                        <span class="validaraster"></span>
                                    </div>
                                    <div class="rightElement">
                                        <input class='entradaTexto normalInput' type="number" min="1" max="1000"
                                               value="<?php echo $row['ancho_CA']; ?>" id="anchoCaja"/>
                                    </div>

                                    <div class="leftElement">
                                        <?php echo $lang[$idioma]['largo']; ?>
                                        <span class="validaraster"></span>
                                    </div>
                                    <div class="rightElement">
                                        <input class='entradaTexto normalInput' type="number" min="1" max="1000"
                                               value="<?php echo $row['profun_CA']; ?>" id="largoCaja"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--bloque pallets-->
                        <div class="block">

                            <!--contenedor con borde-->
                            <div class="frame">

                                <br>
                                <span><strong><?php echo $lang[$idioma]['DimensionesPallet']; ?></strong></span>
                                <br>
                                <br>
                                <div class="informationBlock">

                                    <div style="width:10px; height: 15px;"></div>
                                    <div class="leftElement">
                                        <span><?php echo $lang[$idioma]['TotCajaPallet']; ?></span>
                                        <span class="validaraster"></span>
                                    </div>
                                    <div class="rightElement">
                                        <input type="number" class='entradaTexto normalInput' disabled min="0" max="1000"
                                               id="uniVenta2" value="<?php echo $row['totalCajaPallets']; ?>"/>
                                    </div>

                                    <div class="leftElement">
                                        <span><?php echo $lang[$idioma]['Libras']; ?><?php echo $lang[$idioma]['PesoPallet']; ?></span>
                                        <span class="validaraster"></span>
                                    </div>
                                    <div class="rightElement">
                                        <input id="librasPallet" class='entradaTexto normalInput numberInput'
                                               value="<?php echo $row['peso_lbPA']; ?>"/>
                                        <input hidden id="onzasPallet" class='entradaTexto'
                                               value="<?php echo $row['peso_ozPA']; ?>"/>
                                        <input class='entradaTexto ' disabled type="number" hidden value=""
                                               id="pesoTotLBPallet"/>
                                    </div>

                                    <div class="leftElement">
                                        <?php echo $lang[$idioma]['alto']; ?>
                                        <span class="validaraster"></span>
                                    </div>
                                    <div class="rightElement">
                                        <input class='entradaTexto normalInput' type="number" min="1" max="1000"
                                               value="<?php echo $row['alto_PA']; ?>" id="altoPallet"/>
                                    </div>

                                    <div class="leftElement">
                                        <?php echo $lang[$idioma]['ancho']; ?>
                                        <span class="validaraster"></span>
                                    </div>
                                    <div class="rightElement">
                                        <input class='entradaTexto normalInput' type="number" min="1" max="1000"
                                               value="<?php echo $row['ancho_PA']; ?>" id="anchoPallet"/>
                                    </div>

                                    <div class="leftElement">
                                        <?php echo $lang[$idioma]['largo']; ?>
                                        <span class="validaraster"></span>
                                    </div>
                                    <div class="rightElement">
                                        <input class='entradaTexto normalInput' type="number" min="1" max="1000"
                                               value="<?php echo $row['profun_PA']; ?>" id="largoPallet"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--imagenes-->
                    <div style="
                        width: 100%;
                        height: 300px;
                        margin-top: 25px">

                        <div style="
                            width: 33.3%;
                            height: 100%;
                            float: left;">

                            <img src="../../images/silueta.jpg" width="234" height="225">
                        </div>

                        <div style="
                            width: 33.3%;
                            height: 100%;
                            float: left;">

                            <img src="../../images/caja.jpg" width="266" height="225">
                        </div>

                        <div style="
                            width: 33.3%;
                            height: 100%;
                            float: left;">

                            <img src="../../images/pallet.jpg" width="307" height="225">
                        </div>
                    </div>


                    <table>

                        <tr>

                            <td colspan="6">
                                <input type="button" id="guardar25" class='cmd button button-highlight button-pill'
                                       onClick="actualizaProducto(
                                           'dimensiones',
                                           document.getElementById('masterSKU').value,
                                           document.getElementById('prodName').value,
                                           document.getElementById('itemCode').value,
                                           '','','','',
                                           document.getElementById('size').value,
                                           document.getElementById('pesoTotLB').value,
                                           document.getElementById('libras').value,
                                           document.getElementById('onzas').value, //11
                                           document.getElementById('alto').value,
                                           document.getElementById('ancho').value,
                                           document.getElementById('largo').value,
                                           document.getElementById('uniVenta').value,
                                           '','','','');setTimeout(function(){ventana('cargaLoad',300,400);producto(8,'<?php echo $_SESSION['codEmpresa']; ?>','<?php echo $_SESSION['pais']; ?>','<?php echo $_SESSION['codprod']; ?>');},1000);"
                                       value="<?php echo $lang[$idioma]['Guardar']; ?>"/>
                                <input type="reset" class='cmd button button-highlight button-pill'
                                       onClick="producto(3,'<?php echo $_SESSION['codEmpresa']; ?>','<?php echo $_SESSION['pais']; ?>','<?php echo $_SESSION['codprod']; ?>');"
                                       value="<?php echo $lang[$idioma]['Limpiar']; ?>"/>

                            </td>

                        </tr>
                    </table>
                </center>
            </form>

        </div>
        <script>
		setTimeout(function(){
		document.getElementById('size').value='<?php echo $row['codpres']; ?>';
		},1000);
            pesoToLb();
            pesoToLbCaja();
            //pesoToLbPallet();

            $("#libras").on("change keyup", function () {
                cleanNumberInput("libras");
                pesoToLb();
                modCajaValues();
                pesoToLbCaja();
                pesoToLbPallet();
                verificaImportantes('newPeso', 'guardar25');
            })

            $("#onzas").on("change keyup", function () {
                if (this.value > 15) {
                    $("#libras").val(parseInt(parseInt($("#libras").val()) + (this.value / 16)));
                    this.value = this.value % 16;
                }
//                cleanNumberInput("onzas");
                pesoToLb();
                modCajaValues();
                pesoToLbCaja();
                pesoToLbPallet();
                verificaImportantes('newPeso', 'guardar25');
            })

            $("#librasCaja").on("change keyup", function () {
                cleanNumberInput("librasCaja");
                pesoToLbCaja();
                pesoToLbPallet();
                verificaImportantes('newPeso', 'guardar25');
            })

            $("#onzasCaja").on("change keyup", function () {
                if (this.value > 15) {
                    $("#librasCaja").val(parseInt(parseInt($("#librasCaja").val()) + (this.value / 16)));
                    this.value = this.value % 16;
                }
                cleanNumberInput("onzasCaja");
                pesoToLbCaja();
                pesoToLbPallet();
                verificaImportantes('newPeso', 'guardar25');
            })

            $("#librasPallet").on("change keyup", function () {
                //verificaImportantes('newPeso','guardar25');
                cleanNumberInput("librasPallet");
            })

            function pesoToLb() {
                var libras = parseInt($("#libras").val());
                var onzas = parseFloat($("#onzas").val());
                var pesoUnidad = (((libras * 16) + onzas) / 16).toFixed(2);

                $("#pesoTotLB").val(pesoUnidad);
            }

            function pesoToLbCaja() {
                var libras = parseInt($("#librasCaja").val());
                var onzas = parseFloat($("#onzasCaja").val());
                var pesoUnidad = (((libras * 16) + onzas) / 16).toFixed(2);

                $("#pesoTotLBCaja").val(pesoUnidad);
            }

            function pesoToLbPallet() {
                var pesocaja = parseFloat($('#pesoTotLBCaja').val());
                var unidades = parseInt($('#uniVenta2').val());
                var total = Math.ceil(pesocaja * unidades);

                $("#librasPallet").val(total);
            }

            function modCajaValues() {
                var libras = parseInt($("#libras").val());
                var onzas = parseFloat($("#onzas").val());
                var pesoUnidad = (libras * 16) + onzas;
                var unidades = parseInt($("#uniVenta").val());
                var pesoTotal = pesoUnidad * unidades;
                var librasCaja = pesoTotal / 16;
                var onzasCaja = pesoTotal % 16;

                $("#librasCaja").val(parseInt(librasCaja));
                $("#onzasCaja").val(onzasCaja);
            }

            $(".numberInput").keypress(function (event) {
                return $.isNumeric(event.key);
            })

            function cleanNumberInput(tag) {
                var tValue = $("#" + tag).val();
                if (tValue == "") {
                    $("#" + tag).val(0)
                }
                else if (tValue.length > 1) {
                    $("#" + tag).val(parseInt($("#" + tag).val()));
                }
            }
        </script>
        <?php
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

?>