<?php
/**
 * Created by Eduardo de Jesus
 * 
 * Unique creator
 */
require_once('../coneccion.php');
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
session_start();
?>

<script type="text/javascript">

function buscarMarca(e)
{
	nombre=document.getElementById('buscaMarca').value;
	var key=e.keyCode || e.which;
	//if(key==13)
	{
	
		$.ajax({
			url:'../tablas/tablaMarcas.php',
			type:'POST',
			data:'nombre='+nombre,
					
			success: function(resp)
			{
				$('#Marcas').html(resp);
				
			}
        
		});
	}
}
function buscarMarca1()
{
	nombre=document.getElementById('buscaMarca').value;
	{
	
		$.ajax({
			url:'../tablas/tablaMarcas.php',
			type:'POST',
			data:'nombre='+nombre,
					
			success: function(resp)
			{
				$('#Marcas').html(resp);
				
			}
        
		});
	}
}	

</script>
<center>
<table cellspacing="10px">
	<tr><td colspan="2"><center><strong><?php echo $lang[$idioma]['EdicionDe']." ".$lang[$idioma]['Marca']?></strong></center></td></tr>
	<tr>
    	<td style="width:250px;"><input type="text" class='entradaTextoBuscar' id="buscaMarca" placeholder="<?php echo $lang[$idioma]['Buscar']?>" value="" onKeyUp="buscarMarca(event);"/></td>
    	<td>
        <input type="button"   class='cmd button button-highlight button-pill' onClick="buscarMarca1();" value="<?php echo $lang[$idioma]['Buscar'];?>"/>
                    </td> 
    </tr>
</table>
<br><br>
</center>
<div id="Marcas">
        <script>buscarMarca1(); </script>
        </div>	