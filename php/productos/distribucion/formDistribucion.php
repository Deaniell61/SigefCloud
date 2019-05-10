
<?php
require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');

session_start();

?>
<script type="text/javascript">

function buscar()
{
	nombre=document.getElementById('busca').value;
	canal='';
	
		$.ajax({
			url:'distribucion/llenarDistribucion.php',
			type:'POST',
			data:'nombre='+nombre+'&canal='+
					canal,
					
			success: function(resp)
			{
				$('#datos').html(resp);
				setTimeout(function(){tabllenar();},500);
			}
        
		});
	}
	

</script>
<aside><div id="resultado"></div>

        	<table cellspacing="10px">
            	<tr>
                	<td style="width:250px;"><input type="text" class='entradaTextoBuscar' id="busca" placeholder="<?php echo $lang[$idioma]['Buscar']?>" value="" onKeyUp="buscar();"/></td>
                
                	
               
                	<td class="" style="width:20%;"><input type="button" style="padding:0px;"  class='cmd button button-highlight button-pill' onClick="nuevoDistribucion('','<?php echo $_SESSION['codEmpresa'];?>','<?php echo $_SESSION['pais'];?>','<?php echo $_SESSION['codprov'];?>','<?php echo $_SESSION['codprod'];?>');" value="<?php echo $lang[$idioma]['NuevaDistribucion']?>"/></td>
                </tr>
                 </table>
        </aside>
        
        <div id="datos">
        <script> buscar(); </script>
        </div>	
            
        </div>
        


