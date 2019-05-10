<?php
/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
session_start();
$codigo=$_POST['codigo'];
$tipo=$_POST['tipo'];

if($codigo!="")
{
		echo "
		<script>
		buscarDatosAuxOrdenes('".$tipo."','".$codigo."');
		</script>
		";
}

?>
<script language="JavaScript" type="text/JavaScript">
Full();
</script>
<div id="auxOrde">
<form id="formAux" action="return false" onSubmit="return false" method="POST">
      <center>
      <div class="tituloCatalogo">
    	 <br>
    	 <strong>
    	  &nbsp;&nbsp;<?php echo $lang[ $idioma ]['catshimdo']; ?>
    	 </strong>
			</div>
      <br>
        <table>
                <tr><div id="resultado"></div></tr>
                <tr hidden>
            	<td class="text"><span><?php echo $lang[$idioma]['shimdo'];?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' id="codigo" ></td>
                
            </tr>
        	<tr>
            	<td class="text"><span><?php echo $lang[$idioma]['shimdo'];?></span></td>
                <td class="colo1"><input type="text" class='entradaTexto' id="nombre"></td>
                
            </tr>
            <tr>

            <td colspan="2">
            <input type="button"  class='cmd button button-highlight button-pill'  onClick="ingresoAux('shiMdo');setTimeout(cerrar,2000);" value="<?php echo $lang[$idioma]['Guardar'];?>"/>
            	<input type="reset"  class='cmd button button-highlight button-pill'  onClick="envioDeDataAuxOrdenes('');" value="<?php echo $lang[$idioma]['Cancelar'];?>"/>
            
            </td>
			
             </tr>
        </table>
        </center>
                </form>
                
</div>

