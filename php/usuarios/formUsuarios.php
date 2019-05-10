
<?php
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');



?>
<script type="text/javascript">

invert=false;
function buscarUsuarioOrdenado(nombre,apellido,email,orden)
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
			url:'../php/usuarios/llenarUsuarioOrdenado.php',
			type:'POST',
			data:'nombre='+nombre+'&apellido='+
					apellido+'&email='+email+'&orden='+orden,
					
			success: function(resp)
			{
				$('#datos').html(resp);
				
				
			}
		});
	}
	

</script>
<center><?php echo $lang[$idioma]['EditarUsuarios']?></center>
<aside><div id="resultado"></div>

        	<table>
            	<tr>
                	<td><input type="text" class='entradaTexto' id="buscaUser" name="buscaUser" placeholder="<?php echo $lang[$idioma]['BuscarNombres']?>" value="" onKeyUp="tabllenar();buscarUsuarioOrdenado(document.getElementById('buscaUser').value,document.getElementById('buscaApel').value,document.getElementById('buscaEmail','').value,'');"/></td>
                
                	<td><input type="text" class='entradaTexto' id="buscaApel" placeholder="<?php echo $lang[$idioma]['BuscarApellido']?>" value="" onKeyUp="buscarUsuarioOrdenado(document.getElementById('buscaUser').value,document.getElementById('buscaApel').value,document.getElementById('buscaEmail').value,'');"/></td>
                
                	<td><input type="text" class='entradaTexto' id="buscaEmail" placeholder="<?php echo $lang[$idioma]['BuscarEmail']?>" value="" onKeyUp="buscarUsuarioOrdenado(document.getElementById('buscaUser').value,document.getElementById('buscaApel').value,document.getElementById('buscaEmail').value,'');"/></td>
                    <td><div class=""><input type="button" class='cmd button button-highlight button-pill' onClick="abrirUsuario('');" value="<?php echo $lang[$idioma]['NuevoUsuario']?>"/></div></td>
                </tr>
                 </table>
        </aside>
        
        <div id="datos">
        <script> buscarUsuarioOrdenado("","","",""); </script>
        </div>	
            
        </div>
        


