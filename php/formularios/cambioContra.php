<?php
/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
require_once('../coneccion.php');
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
session_start();
?>

<br><br>
<center>
<table id="contra" cellspacing="30px" cellpadding="15px">
	
	<tr>
    	
    	<td colspan="2">
        <center>
        <strong><?php echo $lang[$idioma]['CambioContra']?></strong>
        </center>
        </td>
    </tr>
    <tr id="advertenciacontra" hidden>
    	
    	<td colspan="2">
        <center>
        <?php echo $lang[$idioma]['CaracterNo']?>
        </center>
        </td>
    </tr>
    <tr>
    	
    	<td colspan="2" style="color:red;" id="resultado1contra">
        <center>
        <?php echo $lang[$idioma]['InsctruccionContra']?>
        </center>
        </td>
    </tr>
    <tr>
    	
    	<td class="text">
        <?php echo $lang[$idioma]['Contra']?>
                    </td> 
       	<td style="width:250px; padding:10px;">
        <input type="password" class='entradaTextoBuscar' autofocus id="contra1" onKeyUp="comprobarContra(event,'contra1','confirma1');" placeholder="*********"/>
        </td><td><img src="../images/ojo-cerrado.png" style="cursor:pointer;" width="32px" height="32px" onMouseOver="comprobarTypoContra('contra1',this);" onMouseOut="comprobarTypoContra('contra1',this);" >
        </td>
    </tr>
    <tr>
    	
    	<td class="text">
        <?php echo $lang[$idioma]['Contra2']?>
                    </td> 
       	<td style="width:250px; padding:10px;">
        <input type="password" class='entradaTextoBuscar' id="confirma1" onKeyUp="comprobarContra(event,'confirma1','contra1');" placeholder="*********"/>
        </td>
    </tr>
    <tr>
    	
    	<td colspan="2">
        <center>
        <input type="button" class='cmd button button-highlight button-pill' onClick="cambioContra();" value="<?php echo $lang[$idioma]['Guardar']?>"/>
        </center>
        </td>
    </tr>
</table>
</center>
<div id="cargaLoadC"></div>