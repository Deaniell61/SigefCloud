<?php

require_once('../../coneccion.php');
require_once('../../fecha.php');
require_once('../../productos/combosProductos.php');
$idioma = idioma();
include('../../idiomas/'.$idioma.'.php');
session_start();
$codempresa = $_POST['codempresa'];
$pais = $_POST['pais'];
$codprecom = $_POST['codseller'];
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

$sql = "select ts.codprecom as codseller,ts.codcompe,s.nombre as nombre,ts.fecha,ts.unidades,ts.preciomin as pmin,ts.preciomax as pmax,ts.shipping,ts.aplica,ts.asin,ts.azsku,ts.azname, ts.upc,ts.codprecom from tra_pre_com ts inner join cat_sellers s on s.codseller=ts.codcompe where ts.codempresa='" . $_SESSION['codEmpresa'] . "' and ts.codprov='" . @$_SESSION['codprov'] . "' and ts.codprod='" . $_SESSION['codprod'] . "' and codprecom='" . $codprecom . "' ";

$ejecutar = mysqli_query(conexion($_SESSION['pais']), $sql);
if ($ejecutar) {
    $row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC);


    ?>

    <form id="sellers" name="sellers" action="return false" onSubmit="return false" method="POST">
        <center>
            <div id="resultado"></div>
            <div id="codigos" hidden><?php echo $row['codprecom']; ?></div>
            <tr>
                <div id="advertencia" style="color:red;" hidden><?php echo $lang[$idioma]['Adevertencia_Rojo']; ?></div>
                <div id="advertenciacero" style="color:red;" hidden><?php echo $lang[$idioma]['Adevertencia_Rojo']; ?></div>
            </tr>
            <table>
                <tr>

                    <td><?php echo $lang[$idioma]['Fecha']; ?><span id="descSistemaAs" class="validaraster">*</span>
                    </td>

                    <td><input type="date" class='entradaTexto' id="fecha"
                               onChange="verificaImportantes('competencia','guardar30');"
                               value="<?php echo selectFecha($row['fecha']); ?>"></td>

                </tr>
                <tr>
                    <td class="text"><?php echo $lang[$idioma]['Seller']; ?><span id="descSistemaAs"
                                                                                  class="validaraster">*</span></td>
                    <td><select class='entradaTexto' id="competencia"
                                onChange="verificaImportantes('competencia','guardar30');"><?php echo "<script>sellerLlenar('" . $codempresa . "','" . $pais . "','" . $_SESSION['codprov'] . "','seller');</script>"/*.comboSeller($codempresa,$pais,$codprov)*/
                            ; ?></select><img src="../../../images/document_add.png"
                                              style="position:absolute; margin-left:0.3%; height:2.5%;"
                                              onClick="asignarSellers('seller','<?php echo $codempresa; ?>','<?php echo $pais; ?>','<?php echo $codprov; ?>');">
                    </td>
                </tr>
                <tr hidden>
                    <td class="text"><?php echo $lang[$idioma]['Canales']; ?><span id="descSistemaAs"
                                                                                   class="validaraster">*</span></td>
                    <td><select class='entradaTexto' id="canal"
                                onChange="verificaImportantes('competencia','guardar30');">
                               <option value="LOCAL" selected><?php echo $lang[$idioma]['Local']; ?></option>
                                </select>
                    </td>
                </tr>
                <tr>
                    <td class="text"><?php echo $lang[$idioma]['Unidades']; ?><span id="descSistemaAs"
                                                                                    class="validaraster">*</span></td>
                    <td><input class='entradaTexto' type="number" id="unidades"
                               onChange="verificaImportantes('competencia','guardar30');"
                               value="<?php echo $row['unidades']; ?>" autocomplete="off"></td>
                </tr>
                <tr>
                    <td class="text"><?php echo $lang[$idioma]['Precio']; ?><span id="descSistemaAs"
                                                                                  class="validaraster">*</span></td>
                    <td><input class='entradaTexto' type="text" id="precio"
                               onChange="verificaImportantes('competencia','guardar30');toMoney(this);"
                               value="<?php echo toMoney($row['pmin']); ?>" autocomplete="off"  onkeypress="return isNumber(event)"></td>
                </tr>
                <tr>
                    <td class="text"><?php echo $lang[$idioma]['shipping']; ?><span id="descSistemaAs"
                                                                                    class="validaraster"></span></td>
                    <td><input class='entradaTexto' type="text" id="shipping1" value="<?php echo toMoney($row['shipping']); ?>" autocomplete="off" onChange="toMoney(this);" onkeypress="return isNumber(event)"></td>
                </tr>
                <!--onChange="verificaImportantes('competencia','guardar30');"-->

                <tr hidden>
                    <td class="text"><?php echo $lang[$idioma]['amazonName']; ?></td>
                    <td><input class='entradaTexto' type="text" id="amname" value="<?php echo $row['azname']; ?>"
                               autocomplete="off"></td>
  x              </tr>
                <tr hidden>
                    <td class="text"><?php echo $lang[$idioma]['Asin']; ?></td>
                    <td><input class='entradaTexto textoGrande'
                               onkeyup="javascript:this.value=this.value.toUpperCase();"
                               style="text-transform:uppercase;" type="text" id="asin"
                               value="<?php echo $row['asin']; ?>" autocomplete="off"></td>
                </tr>
                <tr hidden>
                    <td class="text"><?php echo $lang[$idioma]['amazonSKU']; ?></td>
                    <td><input class='entradaTexto' type="number" id="amsku" value="<?php echo $row['azsku']; ?>"
                               autocomplete="off"></td>
                </tr>
                <tr>
                    <td class="text"><?php echo $lang[$idioma]['UPC']; ?></td>
                    <td><input class='entradaTexto' type="number" id="upc" value="<?php echo $row['upc']; ?>"
                               autocomplete="off"></td>
                </tr>
                <tr <?php if($row['codprecom']==""){echo "hidden";}else{}?>>
                	<td class="text"></td>
                    <td><a onClick="imagenesSeller('<?php echo $row['codprecom']; ?>','contentArchivos')" class="imagenCompetencia"><?php echo $lang[$idioma]['ArchivosCompe']; ?></a></td>
                </tr>
                
                
                
                <tr>

                    <td class="" colspan="2">
                        <center>
                            <input id="guardar30" type="button" class='cmd button button-highlight button-pill' disabled
                                   onClick="guardarSellerOff('<?php echo $codempresa; ?>','<?php echo $pais; ?>','<?php echo $codprov; ?>','<?php echo $codprod; ?>','<?php echo $codprecom; ?>');opener.buscarSellers();ventana('cargaLoadS',300,400);setTimeout(function(){window.close();},1000);"
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
        /*setTimeout(function () {
            document.getElementById('canal').value = '<?php echo $row['codchan']; ?>';
        }, 500);*/

        setTimeout(function () {
            document.getElementById('competencia').value = '<?php echo $row['codcompe']; ?>';
        }, 500);
		setTimeout(function () {
            document.getElementById('competencia').value = '<?php echo $row['codcompe']; ?>';
        }, 700);
		setTimeout(function () {
            document.getElementById('competencia').value = '<?php echo $row['codcompe']; ?>';
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
		setTimeout(function () {
		verificaImportantes('competencia','guardar30');
		}, 700);
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