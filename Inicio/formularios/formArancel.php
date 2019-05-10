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
<div id="busqueda">
</div>
      <center>
      <div>
    	 <br>
    	 <strong>
    	 &nbsp;&nbsp;<?php echo $lang[ $idioma ]['Arancel']; ?>
    	 </strong>
			</div>
      <br>
        <table>
                <tr><div id="resultado"></div></tr>
                <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Codigo'];?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' name="codigo1" id="codigo1" placeholder="<?php echo $lang[$idioma]['Codigo'];?>"></td>
                
            </tr>
        	<tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Arancel'];?></span></td>
                <td class="colo1" style="text-align:left;"><input type="text" class='entradaTexto' style=" height:50px;width: 500px;" name="Arancel" id="Arancel" placeholder="<?php echo $lang[$idioma]['Arancel'];?>"><!--<img src="../../css/lupa.png" onClick="ventana('busqueda',550,800);llenarBusqueda('Arancel','busqueda');" width="30px" height="30px">--></td>
                
            </tr>
           
            
            <tr>
         
            <td colspan="2">
            <input type="button"   class='cmd button button-highlight button-pill' onClick="guardarExtra('Arancel','<?php echo $codigoEmpresa;?>',document.getElementById('Arancel').value,document.getElementById('codigo1').value,'','','<?php echo $pais;?>','');actualizarExtrasExportacion('<?php echo $codigoEmpresa;?>','<?php echo $pais;?>');" value="<?php echo $lang[$idioma]['Guardar'];?>"/>
            	<input type="reset"   class='cmd button button-highlight button-pill' onClick="" value="<?php echo $lang[$idioma]['Cancelar'];?>"/>
            	
            </td>
			
             </tr>
        </table>
        </center>
    

                </form>
    
                
</div>

