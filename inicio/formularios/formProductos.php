<?php
/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
require_once('../../php/fecha.php');
require_once('../../php/sesiones.php');
$idioma = idioma();
include('../../php/idiomas/' . $idioma . '.php');
session_start();
verTiempo3();
$empresa = $_SESSION['codEmpresa'];
?>

<script>
    invert = false;
    function buscarProductos(MasterSKU, Nombre, Marca, Desc, orden, codEmpr, e) {
        filtro = document.getElementById('filtro').value;
        if (validateEnter(e)) {
            $.ajax({
                url: '../php/productos/llenarProductos.php',
                type: 'POST',
                data: 'sku=' + MasterSKU + '&nombre=' + Nombre + '&marca=' + Marca + '&desc=' + Desc + '&orden=' + orden + '&codempresa=' + codEmpr + '&filtro=' + filtro,

                success: function (resp) {
                    $('#datos').html("");
                    $('#datos').html(resp);
                }
            });
        }
    }

    function buscarProductosInicio(MasterSKU, Nombre, Marca, Desc, orden, codEmpr) {
        filtro = document.getElementById('filtro').value;

        $.ajax({
            url: '../php/productos/llenarProductos.php',
            type: 'POST',
            data: 'sku=' + MasterSKU + '&nombre=' + Nombre + '&marca=' + Marca + '&desc=' + Desc + '&orden=' + orden + '&codempresa=' + codEmpr + '&filtro=' + filtro,

            success: function (resp) {
                $('#datos').html("");
                $('#datos').html(resp);
            }
        });
    }

    function filtrarProductosInicio(MasterSKU, Nombre, Marca, Desc, orden, codEmpr, filtro) {
        $.ajax({
            url: '../php/productos/llenarProductos.php',
            type: 'POST',
            data: 'sku=' + MasterSKU + '&nombre=' + Nombre + '&marca=' + Marca + '&desc=' + Desc + '&orden=' + orden + '&codempresa=' + codEmpr + '&filtro=' + filtro,
            success: function (resp) {
                $('#datos').html("");
                $('#datos').html(resp);
            }
        });
    }

    function configuraTabla() {
        $('#tablas').DataTable({
            "scrollY": "500px",
            "scrollX": true,
            "paging": true,
            "info": false,
            "oLanguage": {
                "sLengthMenu": " _MENU_ ",
            }
        });
        ejecutarpie();
    }

</script>
<!-- <center><span class="TituloCatalogo"><strong><?php #echo $lang[$idioma]['Productos'];?></strong></span></center>-->
<aside>
    <div id="resultado"></div>
    <div style="position:absolute; width:97%; top:160px; text-align:left; z-index:0;">
        <div class="guardar">
            <!--<input type="button"   class='cmd button button-highlight button-pill'  onClick="document.getElementById('buscaMasterSKU').value = ''; buscarProductosInicio('','','','','','<?php echo $empresa; ?>');" value="<?php echo $lang[$idioma]['Cancelar']; ?>" />   -->
            <input type="button" class='cmd button button-highlight button-pill'
                   onClick="window.location.href='inicioEmpresa.php'" value="<?php echo $lang[$idioma]['Salir']; ?>"/>
        </div>
    </div>

    <div style="position:absolute; width:97%; top:150px;">
        <img src="../images/excel.png" id="exportExcel" onClick="llamarReporte(11,document.getElementById('filtro'))"
             style="width:20px; height:20px; float:right; margin-left:5px;margin-top:5px; cursor:pointer;">
        <select class='entradaTexto' style="float:right;" id="filtro"
                onChange="filtrarProductosInicio(document.getElementById('buscaMasterSKU').value,'','','','','<?php echo $empresa; ?>',this.value);">
            <option value="" selected><?php echo $lang[$idioma]['SinFiltro']; ?></option>
            <option value="1"><?php echo $lang[$idioma]['FiltroImagenes']; ?></option>
            <option value="2"><?php echo $lang[$idioma]['FiltroAlta']; ?></option>
            <option value="3"><?php echo $lang[$idioma]['FiltroBaja']; ?></option>
            <option value="4"><?php echo $lang[$idioma]['FiltroNoPubli']; ?></option>
        </select>
    </div>
    <br>
    <table>
        <tr>
            <td>
                <input type="text" id="buscaMasterSKU" class='entradaTextoBuscar' name="buscaMasterSKU"
                       placeholder="<?php echo $lang[$idioma]['Buscar']; ?>" value=""
                       onKeyUp="buscarProductos(document.getElementById('buscaMasterSKU').value,'','','','','<?php echo $empresa; ?>',event);"/>
            </td>
            <td class="">
                <input type="button" class='cmd button button-highlight button-pill' id="buscar" name="buscar"
                       value="<?php echo $lang[$idioma]['Buscar']; ?>"
                       onClick="buscarProductosInicio(document.getElementById('buscaMasterSKU').value,'','','','','<?php echo $empresa; ?>');"/>
            </td>

            <td class="">
                <input type="button" class='cmd button button-highlight button-pill' id="buscar" name="buscar"
                       value="<?php echo $lang[$idioma]['Limpiar']; ?>"
                       onClick="document.getElementById('buscaMasterSKU').value = ''; buscarProductosInicio('','','','','','<?php echo $empresa; ?>');"/>
            </td>

            <?php if ($_SESSION['rol'] == 'P') { ?>
                <td class=""><input type="button" class='cmd button button-highlight button-pill' id="nuevo"
                                    value="<?php echo $lang[$idioma]['AgregarProductos']; ?>"
                                    onClick="nuevoProducto('<?php echo $empresa; ?>','<?php echo $_SESSION['pais']; ?>','')"/>
                </td>
            <?php } ?>
        </tr>
    </table>
</aside>

<div id="datos">
    <script> buscarProductosInicio("", "", "", "", "", "<?php echo $empresa;?>");</script>
</div>
</div>

<script>
    $("#bodegajeButton").click(function () {
        selecFormulario("15");
    });
</script>