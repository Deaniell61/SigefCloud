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

$squery = "select codprod,masterSKU,codempresa,descsis,prodName,nombre,nombri,itemcode,palcontenedor,cajcontenedor,estiva,nivpalet,cajanivel,(cajanivel*nivpalet) as totalCajaPallets from cat_prod where codempresa='" . $codigoEmpresa . "' and codprod='" . $_SESSION['codprod'] . "'";

if ($ejecutar = mysqli_query(conexion($_SESSION['pais']), $squery)) {

    if ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {

        $_SESSION['codprod'] = $row['codprod'];

        ?>

        <div id="productos">

            <script>seleccion(document.getElementById('TabEstibar'));

                formaDeEstibar(document.getElementById('FormaDeEstibarH'), document.getElementById('FormaDeEstibarV'), document.getElementById('FormaDeEstibarCA'), document.getElementById('NivelesPallet'));

                setTimeout(function () {

                    $("#cargaLoad").dialog("close");

                }, 500);</script>

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

                        </tr>

                        <td colspan="2">

                            <div class="dimensiones entradaTexto">

                                <center><span><?php echo $lang[$idioma]['Estibar']; ?></span></center>

                                <center>

                                    <table class="tabprueva">

                                        <tr>

                                            <td class="text">

<!--                                                --><?php //echo $lang[$idioma]['horizontal']; ?>

<!--                                                <span class="validaraster">*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>-->

                                            </td>

                                            <td>

                                                <!--<input class='entradaTexto' type="number" min="0" max="20"

                                                       autocomplete="off"

                                                       onChange="formaDeEstibar(this,document.getElementById('FormaDeEstibarV'),document.getElementById('FormaDeEstibarCA'),document.getElementById('NivelesPallet'));calcular(document.getElementById('CajasNivel'),document.getElementById('NivelesPallet'),document.getElementById('TotCajaPallet'));calcular(document.getElementById('TotCajaPallet'),document.getElementById('PaletsPorContenedor'),document.getElementById('CajasPorContenedor'));verificaImportantes('Estibar','guardar24');"

                                                       id="FormaDeEstibarH"

                                                       value="<?php echo substr($row['estiva'], 0, 1); ?>"/></td>

                                                       -->

                                        </tr>

                                        <tr>

                                            <td class="text">

<!--                                                --><?php //echo $lang[$idioma]['vertical']; ?>

<!--                                                <span class="validaraster">*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>-->

                                            </td>

                                            <td>

                                                <!--<input class='entradaTexto' type="number" min="0" max="20"

                                                       autocomplete="off"

                                                       onChange="formaDeEstibar(document.getElementById('FormaDeEstibarH'),this,document.getElementById('FormaDeEstibarCA'),document.getElementById('NivelesPallet'));calcular(document.getElementById('CajasNivel'),document.getElementById('NivelesPallet'),document.getElementById('TotCajaPallet'));calcular(document.getElementById('TotCajaPallet'),document.getElementById('PaletsPorContenedor'),document.getElementById('CajasPorContenedor'));verificaImportantes('Estibar','guardar24');"

                                                       id="FormaDeEstibarV"

                                                       value="<?php echo substr($row['estiva'], 1, 1); ?>"/></td>-->

                                        </tr>

                                        <tr>

                                            <td class="text">

<!--                                                --><?php //echo $lang[$idioma]['cabecera']; ?>

<!--                                                <span class="validaraster">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>-->

                                            </td>

                                            <td>

                                                <!--<input class='entradaTexto' type="number" min="0" max="20"

                                                       autocomplete="off"

                                                       onChange="formaDeEstibar(document.getElementById('FormaDeEstibarH'),document.getElementById('FormaDeEstibarV'),this,document.getElementById('NivelesPallet'));calcular(document.getElementById('CajasNivel'),document.getElementById('NivelesPallet'),document.getElementById('TotCajaPallet'));calcular(document.getElementById('TotCajaPallet'),document.getElementById('PaletsPorContenedor'),document.getElementById('CajasPorContenedor'));verificaImportantes('Estibar','guardar24');"

                                                       id="FormaDeEstibarCA"

                                                       value="<?php echo substr($row['estiva'], 2, 3); ?>"/></td>-->

                                        </tr>

                                        <tr>

                                            <td class="text"><?php echo $lang[$idioma]['NivelesPallet']; ?><span

                                                    class="validaraster">*

                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>

                                            <td><input class='entradaTexto' type="number" min="0" max="20"

                                                       autocomplete="off"

                                                       onChange="formaDeEstibar(document.getElementById('FormaDeEstibarH'),document.getElementById('FormaDeEstibarV'),document.getElementById('FormaDeEstibarCA'),this);

                                                       calcular(document.getElementById('CajasNivel'),document.getElementById('NivelesPallet'),document.getElementById('TotCajaPallet'));

                                                       calcular(document.getElementById('TotCajaPallet'),document.getElementById('PaletsPorContenedor'),document.getElementById('CajasPorContenedor'));

                                                       verificaImportantes('Estibar','guardar24');"

                                                       id="NivelesPallet" value="<?php echo $row['nivpalet']; ?>"/></td>

                                        </tr>

                                        <tr>

                                            <td class="text"><?php echo $lang[$idioma]['CajasNivel']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

                                            <td><input class='entradaTexto' type="number" min="0" max="1000"

                                                       onChange="

                                                       calcular(document.getElementById('CajasNivel'),document.getElementById('NivelesPallet'),document.getElementById('TotCajaPallet'));

                                                       calcular(document.getElementById('TotCajaPallet'),document.getElementById('PaletsPorContenedor'),document.getElementById('CajasPorContenedor'));"

                                                       id="CajasNivel" value="<?php echo $row['cajanivel']; ?>"/></td>

                                        </tr>

                                        <tr>

                                            <td class="text"><?php echo $lang[$idioma]['TotCajaPallet']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

                                            <td><input class='entradaTexto' disabled type="number" min="0" max="1000"

                                                       autocomplete="off" id="TotCajaPallet"

                                                       onChange="calcular(document.getElementById('TotCajaPallet'),document.getElementById('PaletsPorContenedor'),document.getElementById('CajasPorContenedor'));calcular(document.getElementById('TotCajaPallet'),document.getElementById('PaletsPorContenedor'),document.getElementById('CajasPorContenedor'));"

                                                       value="<?php echo $row['totalCajaPallets']; ?>"/></td>

                                        </tr>

                                        <tr>

                                            <td id="palletc"

                                                class="text"><?php echo $lang[$idioma]['PaletsPorContenedor']; ?><span

                                                    class="validaraster">*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>

                                            </td>

                                            <td><input class='entradaTexto' type="number" min="0" max="1000"

                                                       onChange="calcular(document.getElementById('TotCajaPallet'),document.getElementById('PaletsPorContenedor'),document.getElementById('CajasPorContenedor'));verificaImportantes('Estibar','guardar24');"

                                                       value="<?php echo $row['palcontenedor']; ?>"

                                                       id="PaletsPorContenedor"/></td>

                                        </tr>

                                        <tr>

                                            <td class="text"><?php echo $lang[$idioma]['CajasPorContenedor']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

                                            <td><input onChange="verificaImportantes('Estibar','guardar24');"

                                                       class='entradaTexto' type="number" disabled min="0" max="1000"

                                                       onChange="agregarPesoTotal();"

                                                       value="<?php echo $row['cajcontenedor']; ?>"

                                                       id="CajasPorContenedor"/></td>

                                        </tr>

                                    </table>

                                </center>

                            </div>

                        </td>

                        <td colspan="2">

                            <div

                                style="width: 300px; height: 300px; position: relative; text-align: center; float: left;">

                                <p id="estibarMessage" style="position: absolute; left: 0; width: 100%; top: 25px;"></p>

                                <img id="formaEstibar" width="300px" height="300px">

                            </div>

                        </td>

                        </tr>

                        <tr>

                            <td colspan="4"><br><br></td>

                        </tr>

                        <tr>

                            <td colspan="4">

                                <input id="guardar24" disabled type="button"

                                       class='cmd button button-highlight button-pill' onClick="actualizaProducto(

                                    'estibar', //1

                                    document.getElementById('masterSKU').value, //2

                                    document.getElementById('prodName').value, //3

                                    document.getElementById('itemCode').value, //4

                                    '', //5

                                    '', //6

                                    '', //7

                                    '', //8

                                    document.getElementById('PaletsPorContenedor').value,//9

                                    document.getElementById('CajasPorContenedor').value,//10

                                    '',//11

                                    document.getElementById('CajasNivel').value,//12

                                    document.getElementById('NivelesPallet').value,//13

                                    document.getElementById('TotCajaPallet').value,//14

                                    '',//15

                                    '',//16

                                    '',//17

                                    '',//18

                                    '',//19

                                    ''

                                    );

                                    "

                                       value="<?php echo $lang[$idioma]['Guardar']; ?>"/>

                                <input type="reset" class='cmd button button-highlight button-pill'

                                       onClick="producto(9,'<?php echo $_SESSION['codEmpresa']; ?>','<?php echo $_SESSION['pais']; ?>','<?php echo $_SESSION['codprod']; ?>');"

                                       value="<?php echo $lang[$idioma]['Limpiar']; ?>"/>

                            </td>

                        </tr>

                    </table>

                </center>

            </form>

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

}

?>



<script>

    $("#FormaDeEstibarCA").on("change keyup", function () {

        cleanNumberInput("FormaDeEstibarCA");

    })



    function cleanNumberInput(tag) {

        var tValue = $("#" + tag).val();

        if (tValue == "") {

            $("#" + tag).val(0)

        }

        else if (tValue.length > 1) {

            $("#" + tag).val(parseInt($("#" + tag).val()));

        }

        verificaImportantes('Estibar','guardar24')

    }

</script>