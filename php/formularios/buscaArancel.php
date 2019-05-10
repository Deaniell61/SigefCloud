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

function buscarArancel(e)
{
	nombre=document.getElementById('buscaArancel').value;
	var key=e.keyCode || e.which;
	//if(key==13)
	{
	
		$.ajax({
			url:'../tablas/tablaArancel.php',
			type:'POST',
			data:'nombre='+nombre,
					
			success: function(resp)
			{
				$('#arancel').html(resp);
				
			}
        
		});
	}
}
function buscarArancel1()
{
	nombre=document.getElementById('buscaArancel').value;
	{
	
		$.ajax({
			url:'../tablas/tablaArancel.php',
			type:'POST',
			data:'nombre='+nombre,
					
			success: function(resp)
			{
				$('#arancel').html(resp);
				
			}
        
		});
	}
}	

</script>
<center>
<table cellspacing="10px">
	<tr>
    	<td style="width:250px;"><input type="text" class='entradaTextoBuscar' id="buscaArancel" placeholder="<?php echo $lang[$idioma]['Buscar']?>" value="" onKeyUp="buscarArancel(event);"/></td>
    	<td>
        <input type="button"   class='cmd button button-highlight button-pill' onClick="buscarArancel1();" value="<?php echo $lang[$idioma]['Buscar'];?>"/>
                    </td> 
    </tr>
</table>
<br><br>
</center>
<div id="arancel">
        <script>//buscarArancel(); </script>
        </div>	