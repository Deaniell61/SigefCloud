<?php
/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
?>
<script>
invert=false;
function buscarEmpresasOrdenadas(nombre,rsocial,nit,email,orden)
{
	
	if(invert)
	{
		orden=orden+" desc";
		invert=false;
	}
	else
	{
		invert=true;
	}
		$.ajax({
			url:'../php/empresas/llenarEmpresasOrdenadas.php',
			type:'POST',
			data:'nombre='+nombre+'&rsocial='+
					rsocial+'&nit='+nit+'&email='+email+'&orden='+orden,
					
			success: function(resp)
			{
				$('#datos').html("");
				$('#datos').html(resp);
				
			}
		});
}
</script>
<center><?php echo $lang[$idioma]['EditarEmpresas'];?></center>
<aside><div id="resultado"></div>
        	<table>
            	<tr>
                	<td><input type="text" class='entradaTexto' id="buscaUser" name="buscaUser" placeholder="<?php echo $lang[$idioma]['BuscarNombres'];?>" value="" onKeyUp="buscarEmpresasOrdenadas(document.getElementById('buscaUser').value,document.getElementById('buscaRsocial').value,document.getElementById('buscaNIT').value,document.getElementById('buscaEmail').value,'');"/></td>
               
                	<td><input type="text" class='entradaTexto' id="buscaNIT" placeholder="<?php echo $lang[$idioma]['BuscarNit'];?>" value="" onKeyUp="buscarEmpresasOrdenadas(document.getElementById('buscaUser').value,document.getElementById('buscaRsocial').value,document.getElementById('buscaNIT').value,document.getElementById('buscaEmail').value,'');"/></td>
                
                	<td><input type="text" class='entradaTexto' id="buscaRsocial" placeholder="<?php echo $lang[$idioma]['BuscarRSocial'];?>" value="" onKeyUp="buscarEmpresasOrdenadas(document.getElementById('buscaUser').value,document.getElementById('buscaRsocial').value,document.getElementById('buscaNIT').value,document.getElementById('buscaEmail').value,'');"/></td>
                
                	<td><input type="text" class='entradaTexto' id="buscaEmail" placeholder="<?php echo $lang[$idioma]['BuscarEmail'];?>" value="" onKeyUp="buscarEmpresasOrdenadas(document.getElementById('buscaUser').value,document.getElementById('buscaRsocial').value,document.getElementById('buscaNIT').value,document.getElementById('buscaEmail').value,'');"/></td>
                    <td><div class=""><input  class='cmd button button-highlight button-pill' type="button" onClick="abrirEmpresa('');" value="<?php echo $lang[$idioma]['NuevaEmpresa']?>"/></div></td>
                </tr>
                 </table>
        </aside>
        
        <div id="datos">
        <script> buscarEmpresasOrdenadas("","","","","");</script>
        </div>	
            
        </div>
        
       
       		

