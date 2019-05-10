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
$pais=$_SESSION['pais'];
if(isset($_SESSION['codExtra']))
{
	if($_SESSION['codExtra']=='0')
	{
		$opcion="guardarExtra";
	
	}else
	{
		$opcion="actualizarExtra";
	}
}
?>
<div id="productos">
<form id="formExtra" action="return false" onSubmit="return false" method="POST">
      <center>
      <div>
    	 <br>
    	 <strong>
    	 &nbsp;&nbsp;<?php echo $lang[ $idioma ]['catFlavor']; ?>
    	 </strong>
			</div>
      <br>
        <table>
                <tr><div id="resultado"></div></tr>
        	<tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Flavor1'];?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' name="Flavor" id="Flavor" placeholder="<?php echo $lang[$idioma]['Flavor1'];?>"></td>
                
            </tr>
            <tr>

            <td colspan="2">
            <input type="button"  class='cmd button button-highlight button-pill'  onClick="<?php echo $opcion;?>('flavor','<?php echo $codigoEmpresa;?>',document.getElementById('Flavor').value,'<?php echo $_SESSION['codprov'];?>','','','<?php echo $pais;?>','');ventana('cargaLoad',300,400);setTimeout(function(){window.opener.saborLlenar('<?php echo $codigoEmpresa;?>','<?php echo $pais;?>','<?php echo $_SESSION['codprov'];?>','sabor');},800);setTimeout(cerrar,2000);" value="<?php echo $lang[$idioma]['Guardar'];?>"/>
            	<input type="reset"  class='cmd button button-highlight button-pill'  onClick="" value="<?php echo $lang[$idioma]['Cancelar'];?>"/>
            	
            </td>
			
             </tr>
        </table>
        </center>
                </form>
                
</div>
<div id="cargaLoad"></div>