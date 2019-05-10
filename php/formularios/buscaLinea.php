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

function buscar(e)
{
	nombre=document.getElementById('buscar').value;
	var key=e.keyCode || e.which;
	//if(key==13)
	{
	
		$.ajax({
			url:'../tablas/tablaLinea.php',
			type:'POST',
			data:'nombre='+nombre,
					
			success: function(resp)
			{
				$('#ProdLin1').html(resp);
				
			}
        
		});
	}
}
function buscar1()
{
	nombre=document.getElementById('buscar').value;
	{
	
		$.ajax({
			url:'../tablas/tablaLinea.php',
			type:'POST',
			data:'nombre='+nombre,
					
			success: function(resp)
			{
				$('#ProdLin1').html(resp);
				
			}
        
		});
	}
}	

</script>
<center>
<table cellspacing="10px">
	<tr><td colspan="2"><center><strong><?php echo $lang[$idioma]['EdicionDe']." ".$lang[$idioma]['ProdLin']?></strong></center></td></tr>
	<tr>
    	<td style="width:250px;"><input type="text" class='entradaTextoBuscar' id="buscar" placeholder="<?php echo $lang[$idioma]['Buscar']?>" value="" onKeyUp="buscar(event);"/></td>
    	<td>
        <input type="button"   class='cmd button button-highlight button-pill' onClick="buscar1();" value="<?php echo $lang[$idioma]['Buscar'];?>"/>
                    </td> 
    </tr>
</table>
<br><br>
</center>
<div id="ProdLin1">
        <script>buscar1(); </script>
        </div>	