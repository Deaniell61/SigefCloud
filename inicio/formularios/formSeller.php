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
$codprov=$_POST['codprov'];
verTiempo5();
?>
<div id="productos">
<form id="formExtra" action="return false" onSubmit="return false" method="POST">
      <center>
      <br>
        <table>
                <tr><div id="resultado"></div></tr>
        	<tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Seller'];?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' name="Seller" id="Seller" placeholder="<?php echo $lang[$idioma]['Seller'];?>"></td>
                
            </tr>
            <tr>
       
            <td colspan="2">
            <input type="button"  class='cmd button button-highlight button-pill'  onClick="guardarExtra('seller','<?php echo $codigoEmpresa;?>',document.getElementById('Seller').value,'','','','<?php echo $pais;?>','<?php echo $codprov;?>');ventana('cargaLoad',300,400);setTimeout(function(){window.opener.sellerLlenar('<?php echo $codigoEmpresa;?>','<?php echo $pais;?>','<?php echo $_SESSION['codprov'];?>','seller');},800);setTimeout(cerrar,2000);" value="<?php echo $lang[$idioma]['Guardar'];?>"/>
            	
            </td>
			
             </tr>
        </table>
        </center>
                </form>
                
</div>
<div id="cargaLoad"></div>