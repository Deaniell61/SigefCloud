<?php
require_once('../../coneccion.php');
require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');
session_start();
?>

<script type="text/javascript">

function buscarCuentas()
{
	nombre=document.getElementById('busquedas').value;
	
	
		$.ajax({
			url:'formularios/tablapoliza.php',
			type:'POST',
			data:'nombre='+nombre,
					
			success: function(resp)
			{
				$('#tablapolizas').html(resp);
				
			}
        
		});
	}
	

</script>
<center>
<table cellspacing="10px">
	<tr>
    	<td style="width:250px;"><input type="text" class='entradaTextoBuscar' id="busquedas" placeholder="<?php echo $lang[$idioma]['Buscar']?>" value="" onKeyUp="buscarCuentas();"/></td>
    	<td>
        <input type="button"   class='cmd button button-highlight button-pill' onClick="" value="<?php echo $lang[$idioma]['Buscar'];?>"/>
                    </td> 
    </tr>
</table>
</center>
<div id="tablapolizas">
        <script> buscarCuentas(); </script>
        </div>	