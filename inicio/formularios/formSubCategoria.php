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
?>
<div id="productos">
<form id="formExtra" action="return false" onSubmit="return false" method="POST">
      <center>
      <br>
        <table>
                <tr><div id="resultado"></div></tr>
        	<tr>
            	<td class="text"><span><?php echo $lang[$idioma]['SubCategory'];?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' name="subCategory" id="subCategory" placeholder="<?php echo $lang[$idioma]['SubCategory'];?>"></td>
                
            </tr>
            <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['URL'];?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' name="url" id="url" placeholder="<?php echo $lang[$idioma]['URL'];?>"></td>
                
            </tr>
            
            <tr>
            
            <td colspan='2'>
            <input type="button"  class='cmd button button-highlight button-pill'  onClick="guardarExtra('subCategory','<?php echo $codigoEmpresa;?>',document.getElementById('subCategory').value,document.getElementById('url').value,'','','<?php echo $pais;?>','');actualizarExtras();" value="<?php echo $lang[$idioma]['Guardar'];?>"/>
            	<input type="reset"  class='cmd button button-highlight button-pill'  onClick="" value="<?php echo $lang[$idioma]['Cancelar'];?>"/>
            	
            </td>
			
             </tr>
        </table>
        </center>
                </form>
                
</div>