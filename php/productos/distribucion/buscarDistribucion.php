<?php

require_once('../../coneccion.php');
require_once('../../fecha.php');
require_once('../../productos/combosProductos.php');
$idioma = idioma();
include('../../idiomas/' . $idioma . '.php');
session_start();

$codempresa = $_POST['codempresa'];
$pais = $_POST['pais'];
$codpredis = $_POST['codpredis'];
$codprov = $_POST['codprov'];
$codprod = $_POST['codprod'];

function aplica($dato)
{
    if ($dato == "1") {
        return " checked";
    } else {
        return "";
    }
}

$sql="select tp.codtrapre,tp.de,tp.a,tp.precio,tp.codunidades,tp.pdescuento from tra_pre_dis tp where tp.codtrapre='".$codpredis."'";

$ejecutar = mysqli_query(conexion($_SESSION['pais']), $sql);
if ($ejecutar) {
    $row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC);


    ?>

    <form id="sellers" name="sellers" action="return false" onSubmit="return false" method="POST">
        <center>
            <div id="resultado"></div>
            <div id="codigos" hidden><?php echo $row['codpredis']; ?></div>
            <tr>
                <div id="advertencia" style="color:red;" hidden><?php echo $lang[$idioma]['Adevertencia_Rojo']; ?></div>
                <div id="advertenciacero" style="color:red;" hidden><?php echo $lang[$idioma]['Adevertencia_Rojo']; ?></div>
            </tr>
            <table>
                                
                <tr>
                    <td class="text"><?php echo $lang[$idioma]['De']; ?><span id="descSistemaAs"
                                                                                    class="validaraster">*</span></td>
                    <td><input class='entradaTexto' type="text" id="de" onkeypress="return isNumber(event)"
                               onChange="verificaImportantes('Distribucion','guardar30');toNumber(this);"
                               value="<?php echo $row['de']; ?>" autocomplete="off"></td>
                </tr>
                <tr>
                    <td class="text"><?php echo $lang[$idioma]['A']; ?><span id="descSistemaAs"
                                                                                    class="validaraster">*</span></td>
                    <td><input class='entradaTexto' type="text" id="a" onkeypress="return isNumber(event);" onKeyUp=""
                               onChange="verificaImportantes('Distribucion','guardar30');toNumber(this); mayor('a','de');" 
                               value="<?php echo $row['a']; ?>" autocomplete="off"></td>
                </tr>
                <tr>
                    <td class="text"><?php echo $lang[$idioma]['Precio']; ?><span id="descSistemaAs"
                                                                                  class="validaraster">*</span></td>
                    <td><input class='entradaTexto' type="text" id="precio" onkeypress="return isNumber(event)"
                               onChange="verificaImportantes('Distribucion','guardar30');toMoney(this);"
                               value="<?php echo toMoney($row['precio']); ?>" autocomplete="off"  onkeypress="return isNumber(event)"></td>
                </tr>
                <tr>
                    <td class="text"><?php echo $lang[$idioma]['UnidadesTipo']; ?><span id="descSistemaAs"
                                                                                   class="validaraster">*</span></td>
                    <td><select class='entradaTexto' id="unidades"
                                onChange="verificaImportantes('Distribucion','guardar30');"><?php echo comboUnidadesTipo($codempresa, $pais); ?></select>
                    </td>
                </tr>
                <tr>
                    <td class="text"><?php echo $lang[$idioma]['pDescuento']; ?><span id="descSistemaAs"
                                                                                    class="validaraster">*</span></td>
                    <td><input class='entradaTexto' type="text" id="pDescuento" onkeypress="return isNumber(event);" onKeyUp=""
                               onChange="verificaImportantes('Distribucion','guardar30');toNumber(this);" 
                               value="<?php echo $row['pdescuento']; ?>" autocomplete="off"></td>
                </tr>
                
                
                <tr>

                    <td class="" colspan="2">
                        <center>
                            <input id="guardar30" type="button" class='cmd button button-highlight button-pill' disabled
                                   onClick="guardarDistribucion('<?php echo $codempresa; ?>','<?php echo $pais; ?>','<?php echo $codprov; ?>','<?php echo $codprod; ?>','<?php echo $codpredis; ?>');opener.buscar();ventana('cargaLoadS',300,400);setTimeout(function(){window.close();},1000);"
                                   value="<?php echo $lang[$idioma]['Guardar']; ?>"/>
                            <input type="reset" class='cmd button button-highlight button-pill'
                                   onClick="envioDeDataSellersOff('seller');"
                                   value="<?php echo $lang[$idioma]['Limpiar']; ?>"/>
                        </center>
                    </td>

                </tr>
            </table>
        </center>
        <div id="cargaLoadS"></div>
        <div id="contentArchivos">
                    	
                    	
                    </div>
    </form>
    <script>
//        setTimeout(function () {
//            document.getElementById('canal').value = '<?php //echo $row['codchan']; ?>//';
//        }, 500);

        setTimeout(function () {
            document.getElementById('unidades').value = '<?php echo $row['codunidades']; ?>';
        }, 500);
		setTimeout(function () {
            document.getElementById('unidades').value = '<?php echo $row['codunidades']; ?>';
        }, 700);
		setTimeout(function () {
            document.getElementById('unidades').value = '<?php echo $row['codunidades']; ?>';
        }, 1000);

        $("#shipping").on("change keyup", function () {
            cleanNumberInput("shipping");
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
		verificaImportantes('Distribucion','guardar30');
    </script>

    <?php

} else {
    echo "<script>alert(\"Error de base de datos\");</script>";
}

function selectFecha($fecha)
{
    $retorno = "";
    if ($fecha == NULL or $fecha == "") {
        $retorno = date('Y') . "-" . date('m') . "-" . date('d');

    } else {
        $retorno = substr($fecha,0,10);
    }
    return $retorno;
}

?>