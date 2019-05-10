
<?php
require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');



?>
<script type="text/javascript">

invert=false;
function buscarModulos(nombre,codigo,tipo,orden)
{
		$.ajax({
			url:'../php/menu/modulos/llenarModulos.php',
			type:'POST',
			data:'nombre='+nombre+'&codigo='+
					codigo+'&tipo='+tipo+'&orden='+orden,
					
			success: function(resp)
			{
				$('#datos').html(resp);
				
				
			}
		});
	}
	

</script>
<center><?php echo $lang[$idioma]['Modulos']?></center>
<aside><div id="resultado"></div>

        	<table>
            	<tr>
                	<td><input type="text" class='entradaTexto' id="buscaNombre" placeholder="<?php echo $lang[$idioma]['BuscarNombres']?>" value="" onKeyUp="tabllenar();buscarModulos(document.getElementById('buscaNombre').value,document.getElementById('buscaCodigo').value,document.getElementById('buscaTipo').value,'');"/></td>
                
                	<td><input type="text" class='entradaTexto' id="buscaCodigo" placeholder="<?php echo $lang[$idioma]['BuscarCodigo']?>" value="" onKeyUp="tabllenar();buscarModulos(document.getElementById('buscaNombre').value,document.getElementById('buscaCodigo').value,document.getElementById('buscaTipo').value,'');"/></td>
                
                	<td><input type="text" class='entradaTexto' id="buscaTipo" placeholder="<?php echo $lang[$idioma]['BuscarTipo']?>" value="" onKeyUp="tabllenar();buscarModulos(document.getElementById('buscaNombre').value,document.getElementById('buscaCodigo').value,document.getElementById('buscaTipo').value,'');"/></td>
                    <td><div class=""><input type="button"  class='cmd button button-highlight button-pill' onClick="abrirModulo('');" value="<?php echo $lang[$idioma]['NuevoModulo']?>"/></div></td>
                </tr>
                 </table>
        </aside>
        
        <div id="datos">
        <script> buscarModulos("","","",""); </script>
        </div>	
            
        </div>
        


