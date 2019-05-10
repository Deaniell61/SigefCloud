<?php
require_once('../fecha.php');
$idioma = idioma();
include('../idiomas/' . $idioma . '.php');
@session_start();
?>
<script  src="../js/funcionesScriptNotificaciones.js" type="text/javascript"></script>
<script>
    paisGlobal = "";
    codPaisGlobal = "";
    <?php
    if(!isset($_SESSION['CodPaisCod']))
    {
    ?>
    function buscar() {
        nombre = document.getElementById('buscar').value;
        paisGlobal = pais = document.getElementById('pais').options[document.getElementById('pais').options.selectedIndex].text;
        codPaisGlobal = codpais = document.getElementById('pais').value;
        $.ajax({
            url: '../php/soporte/llenarSoporte.php',
            type: 'POST',
            data: 'nombre=' + nombre + '&pais=' + pais + '&codpais=' + codpais,
            success: function (resp) {
                $('#datos').html("");
                $('#datos').html(resp);
            }
        });
    }

    function buscare(e) {
        nombre = document.getElementById('buscar').value;
        pais = document.getElementById('pais').options[document.getElementById('pais').options.selectedIndex].text;
        codpais = document.getElementById('pais').value;
        if (validateEnter(e)) {
            $.ajax({
                url: '../php/soporte/llenarSoporte.php',
                type: 'POST',
                data: 'nombre=' + nombre + '&pais=' + pais + '&codpais=' + codpais,
                success: function (resp) {
                    $('#datos').html("");
                    $('#datos').html(resp);
                }
            });
        }
    }

    <?php }

    else

    if(isset($_SESSION['pais']) && isset($_SESSION['CodPaisCod']))
    {
    ?>
    function buscar() {
        nombre = document.getElementById('buscar').value;
        paisGlobal = pais = document.getElementById('pais').options[document.getElementById('pais').options.selectedIndex].text;
        codPaisGlobal = codpais = document.getElementById('pais').value;
        coduser = '<?php echo $_SESSION['codigo'];?>';
        $.ajax({
            url: '../php/soporte/llenarSoporte.php',
            type: 'POST',
            data: 'nombre=' + nombre + '&pais=' + pais + '&codpais=' + codpais + '&coduser=' + coduser,
            success: function (resp) {
                $('#datos').html("");
                $('#datos').html(resp);
            }
        });
    }

    function buscare(e) {
        nombre = document.getElementById('buscar').value;
        pais = document.getElementById('pais').options[document.getElementById('pais').options.selectedIndex].text;
        codpais = document.getElementById('pais').value;
        coduser = '<?php echo $_SESSION['codigo'];?>';

        if (validateEnter(e)) {
            $.ajax({
                url: '../php/soporte/llenarSoporte.php',
                type: 'POST',
                data: 'nombre=' + nombre + '&pais=' + pais + '&codpais=' + codpais + '&coduser=' + coduser,
                success: function (resp) {
                    $('#datos').html("");
                    $('#datos').html(resp);
                }
            });
        }
    }
    <?php } ?>

</script>
<center><?php echo $lang[$idioma]['Contacto2']; ?></center>
<aside>
    <div id="resultado"></div>
    <table>
        <?php
        if (!isset($_SESSION['CodPaisCod'])) {
            ?>
            <tr>
                <td colspan="4"><select class='entradaTexto' onChange="buscar();" id="pais"
                                        style="width:100%"><?php echo paises(); ?></select></td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
        <?php }
        else
        if (isset($_SESSION['CodPaisCod']))
        {
        ?>
            <tr id="paisRow">
                <td colspan="4"><select class='entradaTexto' onChange="buscar();" id="pais"
                                        style="width:100%"><?php echo paises(); ?></select></td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <script>__('pais').value = '<?php echo $_SESSION['CodPaisCod'];?>';
                __('paisRow').hidden = true;</script>
        <?php } ?>
        <tr>
            <td><input type="text" class='entradaTexto' id="buscar" name="buscar"
                       placeholder="<?php echo $lang[$idioma]['Buscar'] ?>" value="" onKeyUp="buscare(event);"/>
            </td>
            <td><div class=""><input type="button" class='cmd button button-highlight button-pill' onClick="buscar();"
                                     value="<?php echo $lang[$idioma]['Buscar'] ?>"/></div>
            </td>
            <td>
                <div class=""><input class='cmd button button-highlight button-pill' type="button"
                                     onClick="abrirNotificacion('',paisGlobal,codPaisGlobal);"
                                     value="<?php echo $lang[$idioma]['Nuevo'] ?>"/></div>
            </td>
        </tr>
    </table>
</aside>
<div id="datos">
    <script> buscar();</script>
</div>
</div>

        

       

       		



