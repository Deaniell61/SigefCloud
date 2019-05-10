<?php
/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
require_once('../../php/fecha.php');
$idioma=idioma();
include('../../php/idiomas/'.$idioma.'.php');
require_once('../../php/productos/combosProductos.php');
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
<div id="cargaLoad"></div>
<div id="productos">
<form id="formExtra" action="return false" onSubmit="return false" method="POST">
      <center>
      <div>
    	 <br>
    	 <strong>
    	 &nbsp;&nbsp;<?php echo $lang[ $idioma ]['catManufacturador']; ?>
    	 </strong>
			</div>
      <br>
        <table>
                <tr><div id="resultado"></div></tr>
           <tr hidden>
            	<td class="text"><span><?php echo $lang[$idioma]['Codigo'];?></span></td>
                <td class="colo1" style="text-align:left"><input type="text" disabled class='entradaTexto' id="codigo" placeholder="<?php echo $lang[$idioma]['Codigo'];?>"></td>
                
            </tr>
        	<tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Manufacturadores'];?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' id="manufact" placeholder="<?php echo $lang[$idioma]['Manufacturadores'];?>"></td>
                
            </tr>
            
            <tr>
            	<td class="text" ><span><?php echo $lang[$idioma]['FDA'];?></span></td>
                <td class="colo1"><input style="float:left;" type="number" class='entradaTexto' id="FDA" placeholder="<?php echo $lang[$idioma]['FDA'];?>"></td>
                
            </tr>
            <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Direccion'];?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' id="Direccion" placeholder="<?php echo $lang[$idioma]['Direccion'];?>"></td>
                
            </tr>
             
              <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Ciudad'];?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' id="Ciudad" placeholder="<?php echo $lang[$idioma]['Ciudad'];?>"></td>
                
            </tr>
             
              <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Estado'];?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' id="Estado" placeholder="<?php echo $lang[$idioma]['Estado'];?>"></td>
                
            </tr>
             
              <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['CodPos'];?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' id="CodPos" placeholder="<?php echo $lang[$idioma]['CodPos'];?>"></td>
                
            </tr>
            
             <tr>
            	<td class="text"><span><?php echo $lang[$idioma]['Pais'];?></span></td>
                <td class="colo1"><select class='entradaTexto' id="pais"><?php echo comboPaisOrigen2($codigoEmpresa,$pais);?></select></td>
                
            </tr>
           
            
            <tr>

            <td colspan="2">
            <input type="button"  class='cmd button button-highlight button-pill'  onClick="<?php echo $opcion;?>('manufact','<?php echo $codigoEmpresa;?>',document.getElementById('manufact').value,document.getElementById('codigo').value,document.getElementById('FDA').value,document.getElementById('Direccion').value,'<?php echo $pais;?>','<?php echo $_SESSION['codprov'];?>');ventana('cargaLoad',300,400);setTimeout(function(){window.opener.ManufactLlenar('<?php echo $codigoEmpresa;?>','<?php echo $pais;?>','<?php echo $_SESSION['codprov'];?>','manufact');},800);setTimeout(cerrar,2000);" value="<?php echo $lang[$idioma]['Guardar'];?>"/>
            	<input type="reset"  class='cmd button button-highlight button-pill'  onClick="" value="<?php echo $lang[$idioma]['Cancelar'];?>"/>
            	
            </td>
			
             </tr>
        </table>
        </center>
                </form>
                
</div>
