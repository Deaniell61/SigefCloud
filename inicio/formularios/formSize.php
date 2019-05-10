<?php
/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
require_once('../../php/fecha.php');
require_once('../../php/productos/combosProductos.php');
$idioma = idioma();
include('../../php/idiomas/' . $idioma . '.php');
session_start();
$codigoEmpresa = $_SESSION['codEmpresa'];
$pais = $_SESSION['pais'];
if (isset($_SESSION['codExtra'])) {
    if ($_SESSION['codExtra'] == '0') {
        $opcion = "guardarExtra";

    } else {
        $opcion = "actualizarExtra";
    }
}

?>
<script>
    generaDescripcion('unidades', 'peso', 'medida', 'nombre');
</script>
<div id="productos">
    <form id="formExtra" action="return false" onSubmit="return false" method="POST">
        <center>
            <div>
                <br>
                <strong>
                    &nbsp;&nbsp;<?php echo $lang[$idioma]['catPresentacion']; ?>
                </strong>
            </div>
            <br>
            <table>
                <tr>
                    <div id="resultado"></div>
                </tr>
                <tr>
                    <td class="text"><span><?php echo $lang[$idioma]['UnidadesPres']; ?></span></td>
                    <td class="colo1" style="text-align:left"><input type="number"
                                                                     onChange="generaDescripcion('unidades','peso','medida','nombre')"
                                                                     class='entradaTexto' min="1" max="1000"
                                                                     name="unidades" id="unidades"></td>

                </tr>
                <tr>
                    <td class="text"><span><?php echo $lang[$idioma]['PesoUnidad']; ?></span></td>
                    <td class="colo1" style="text-align:left"><input type="number" class='entradaTexto' min="1"
                                                                     onChange="generaDescripcion('unidades','peso','medida','nombre')"
                                                                     max="1000" name="peso" id="peso"></td>

                </tr>
                <tr>
                    <td class="text"><span><?php echo $lang[$idioma]['Medida']; ?></span></td>

                    <td class="colo1" style="text-align:left">
                        <select class='entradaTexto' id="medida"
                                onChange="generaDescripcion('unidades','peso','medida','nombre')">
                            <?php echo comboMedidas($codigoEmpresa, $pais); ?>
                        </select>
                        <br><br><span id="diameter" style="float:left">(Libras, onzas, etc.)</span>
                    </td>

                </tr>
                <tr>
                    <td class="text">
                        <span><?php echo $lang[$idioma]['Descripcion'] . " " . $lang[$idioma]['Pres'];; ?></span></td>
                    <td class="colo1"><input type="text" class='entradaTexto' disabled name="nombre"
                                             id="nombre"><br><br><span id="diameter" style="float:left">(18 x 12 Oz), (Unidad), (1 x 50 lb)</span>
                    </td>

                </tr>
                <!-- <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['PesoLB'] . " " . $lang[$idioma]['Pres']; ?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' name="presentacion" id="presentacion"><br><br><span id="diameter" style="float:left">(18 x 12 Oz), (Unidad), (1 x 50 lb)</span></td>
                
            </tr>
            <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['PesoUnidad']; ?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' value="0" name="pesouni" id="pesouni" placeholder="<?php echo $lang[$idioma]['PesoUnidad']; ?>"></td>
                
            </tr>-->
                <tr>

                    <td colspan="2">
                        <input type="button" class='cmd button button-highlight button-pill'
                               onClick="<?php echo $opcion; ?>('size',
                                        '<?php echo $codigoEmpresa; ?>',
                                        document.getElementById('nombre').value,
                                        document.getElementById('peso').value,
                                        document.getElementById('unidades').value,
                                        '','<?php echo $pais; ?>','<?php echo $_SESSION['codprov']; ?>');
                                   ventana('cargaLoad',300,400);
                                   setTimeout(function(){window.opener.sizeLlenar(
                                   '<?php echo $codigoEmpresa; ?>',
                                   '<?php echo $pais; ?>',
                                   '<?php echo $_SESSION['codprov']; ?>',
                                   'size', document.getElementById('nombre').value);},800);setTimeout(cerrar,2000);"
                               value="<?php echo $lang[$idioma]['Guardar']; ?>"/>
                        <input type="reset" class='cmd button button-highlight button-pill' onClick=""
                               value="<?php echo $lang[$idioma]['Cancelar']; ?>"/>

                    </td>

                </tr>
            </table>
        </center>
    </form>

</div>
<div id="cargaLoad"></div>