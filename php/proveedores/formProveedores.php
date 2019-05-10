<?php
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
?>
<script>
function buscarProveedores()
{
	nombre=document.getElementById('buscaUser').value;
	nit=document.getElementById('buscaNIT').value;
	email=document.getElementById('buscaEmail').value;
	pais=document.getElementById('pais').options[document.getElementById('pais').options.selectedIndex].text;
	codpais=document.getElementById('pais').value;
	
	$.ajax({
			url:'../php/proveedores/llenarProveedores.php',
			type:'POST',
			data:'nombre='+nombre+'&nit='+nit+'&email='+email+'&pais='+pais+'&codpais='+codpais,
					
			success: function(resp)
			{
				$('#datos').html("");
				$('#datos').html(resp);
				
			}
		});
}
</script>
<center><?php echo $lang[$idioma]['Proveedor'];?></center>
<aside><div id="resultado"></div>

        	<table>
            	<tr><tr><td colspan="5"><select class='entradaTexto' id="pais" onChange="buscarProveedores();" style="width:100%;"><?php echo paises(); ?></select></td></tr>
            	<tr>
                	<td><input type="text" class='entradaTexto'  id="buscaUser" name="buscaUser" placeholder="<?php echo $lang[$idioma]['BuscarNombres'];?>" value="" onKeyUp="buscarProveedores();"/></td>
               
                	<td><input type="text" class='entradaTexto'  id="buscaNIT" placeholder="<?php echo $lang[$idioma]['BuscarNit'];?>" value="" onKeyUp="buscarProveedores();"/></td>
                
                	<td><input type="text" class='entradaTexto'  id="buscaEmail" placeholder="<?php echo $lang[$idioma]['BuscarEmail'];?>" value="" onKeyUp="buscarProveedores();"/></td>
                   <!-- <td><div class="guardar"><input type="button"  class='cmd button button-highlight button-pill'  onClick="abrirEmpresa('');" value="<?php echo $lang[$idioma]['NuevaEmpresa']?>"/></div></td>-->
                </tr>
                 </table>
        </aside>
        
        <div id="datos">
        <script> buscarProveedores();</script>
        </div>	
            
        </div>
        
       
       		

