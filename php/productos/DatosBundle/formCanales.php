
<?php
require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');



?>

<script type="text/javascript">


function buscarCanal(nombre,e)
{
pais=document.getElementById('pais').options[document.getElementById('pais').options.selectedIndex].text;

if(validateEnter(e))
	{
		$.ajax({
			url:'../php/productos/DatosBundle/llenarCanales.php',
			type:'POST',
			data:'nombre='+nombre+'&pais='+pais,
					
			success: function(resp)
			{
				$('#datos').html(resp);
				
				
			}
		});
	}
}
function buscarCanalInicio(nombre)
{
pais=document.getElementById('pais').options[document.getElementById('pais').options.selectedIndex].text;
	
		$.ajax({
			url:'../php/productos/DatosBundle/llenarCanales.php',
			type:'POST',
			data:'nombre='+nombre+'&pais='+pais,
					
			success: function(resp)
			{
				$('#datos').html(resp);
				
				
			}
		});
}
	

</script>
<center><?php echo $lang[$idioma]['Canales']?></center>
<aside><div id="resultado"></div>

        	<table>
            <tr><td colspan="4"><select class='entradaTexto' onChange="buscarCanalInicio(document.getElementById('buscaUser').value);" id="pais" style="width:40%"><?php echo paises();?></select></td></tr>
            <tr><td><br></td></tr>
            	<tr>
                	<td><input type="text"  class='entradaTexto' id="buscaUser" name="buscaUser" placeholder="<?php echo $lang[$idioma]['Buscar']?>" value="" onKeyUp="buscarCanal(document.getElementById('buscaUser').value,event);"/></td>
                
                	<td><div class=""><input type="button"  class='cmd button button-highlight button-pill' onClick="buscarCanalInicio(document.getElementById('buscaUser').value);" value="<?php echo $lang[$idioma]['Buscar']?>"/></div></td>
                    <td><div class=""><input  class='cmd button button-highlight button-pill' type="button" onClick="abrirCanal('');" value="<?php echo $lang[$idioma]['NuevoUsuario']?>"/></div></td>
                </tr>
                
                 </table>
        </aside>
        <br>
        <div id="datos">
        <script> buscarCanalInicio(""); </script>
        </div>	
            
        </div>
        


