<?php
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
?>
<script>
paisGlobal="";
codPaisGlobal="";
function buscar()
{
	nombre=document.getElementById('buscar').value;
	paisGlobal=pais=document.getElementById('pais').options[document.getElementById('pais').options.selectedIndex].text;
	codPaisGlobal=codpais=document.getElementById('pais').value;
	
	$.ajax({
			url:'../php/unidadesMedida/llenarMedida.php',
			type:'POST',
			data:'nombre='+nombre+'&pais='+pais+'&codpais='+codpais,
					
			success: function(resp)
			{
				$('#datos').html("");
				$('#datos').html(resp);
				
			}
		});
}
function buscare(e)
{
	nombre=document.getElementById('buscar').value;
	pais=document.getElementById('pais').options[document.getElementById('pais').options.selectedIndex].text;
	codpais=document.getElementById('pais').value;
	if(validateEnter(e))
	{
			$.ajax({
				url:'../php/unidadesMedida/llenarMedida.php',
				type:'POST',
				data:'nombre='+nombre+'&pais='+pais+'&codpais='+codpais,
						
				success: function(resp)
				{
					$('#datos').html("");
					$('#datos').html(resp);
					
				}
			});
	}
}
</script>
<center><?php echo $lang[$idioma]['Medidas'];?></center>
<aside><div id="resultado"></div>

        	
        	<table>
            <tr><td colspan="4"><select class='entradaTexto' onChange="buscar();" id="pais" style="width:100%"><?php echo paises();?></select></td></tr>
            <tr><td><br></td></tr>
            	<tr>
                	<td><input type="text"  class='entradaTexto' id="buscar" name="buscar" placeholder="<?php echo $lang[$idioma]['Buscar']?>" value="" onKeyUp="buscare(event);"/>
                    </td>
                
                	<td><div class=""><input type="button"  class='cmd button button-highlight button-pill' onClick="buscar();" value="<?php echo $lang[$idioma]['Buscar']?>"/></div>
                    </td>
                    <td><div class=""><input  class='cmd button button-highlight button-pill' type="button" onClick="abrirMedidas('',paisGlobal,codPaisGlobal);" value="<?php echo $lang[$idioma]['Nuevo']?>"/></div>
                    </td>
                </tr>
                
                 </table>
        </aside>
        
        <div id="datos">
        <script> buscar();</script>
        </div>	
            
        </div>
        
       
       		

