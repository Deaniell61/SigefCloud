<?php
/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
require_once('../../php/fecha.php');
$idioma=idioma();
include('../../php/idiomas/'.$idioma.'.php');
session_start();
$codigoEmpresa=$_SESSION['codEmpresa'];
$pais=$_SESSION['pais'];?>
<div id="productos">
<form id="formExtra" action="return false" onSubmit="return false" method="POST">
      <center>
      <br>
        <table>
                <tr><div id="resultado"></div></tr>
        	<tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Pakage'];?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' name="package" id="package" placeholder="<?php echo $lang[$idioma]['Pakage'];?>"></td>
                
            </tr>
            <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['alto'];?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' name="alto" id="alto" placeholder="<?php echo $lang[$idioma]['alto'];?>"></td>
                
            </tr>
            <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['ancho'];?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' name="ancho" id="ancho" placeholder="<?php echo $lang[$idioma]['ancho'];?>"></td>
                
            </tr>
            <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['largo'];?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' name="largo" id="largo" placeholder="<?php echo $lang[$idioma]['largo'];?>"></td>
                
            </tr>
            <tr>

            <td colspan="2">
            <input type="button"  class='cmd button button-highlight button-pill'  onClick="guardarExtra('pakage','<?php echo $codigoEmpresa;?>',document.getElementById('package').value,document.getElementById('alto').value,document.getElementById('ancho').value,document.getElementById('largo').value,'<?php echo $pais;?>','<?php echo $_SESSION['codprov'];?>');actualizarExtras();" value="<?php echo $lang[$idioma]['Guardar'];?>"/>
            	<input type="reset"  class='cmd button button-highlight button-pill'  onClick="" value="<?php echo $lang[$idioma]['Cancelar'];?>"/>
            	
            </td>
			
             </tr>
        </table>
        </center>
                </form>
                
</div>
